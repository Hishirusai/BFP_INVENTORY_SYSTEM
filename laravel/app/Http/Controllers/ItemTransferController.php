<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Station;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemTransferController extends Controller
{
    /**
     * Show the form for transferring an item
     */
    public function create(Request $request): View
    {
        $fromStationId = $request->get('from_station_id');
        
        // Get all stations (including Main Central Station option)
        $stations = Station::where('is_active', true)->get();
        
        // Get items based on from_station filter
        $itemsQuery = Item::with('station');
        if ($fromStationId === 'main' || $fromStationId === '') {
            // Show Main Central Station items (station_id is null)
            $itemsQuery->whereNull('station_id');
        } elseif ($fromStationId) {
            // Show items from specific station
            $itemsQuery->where('station_id', $fromStationId);
        }
        // If no filter, show all items
        
        $items = $itemsQuery->get();
        $selectedItemId = $request->get('item_id');
        
        return view('items.transfer', compact('items', 'stations', 'selectedItemId', 'fromStationId'));
    }

    /**
     * Store a transfer
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'to_station_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
        ]);

        $sourceItem = Item::findOrFail($request->item_id);
        
        // Check if item has enough quantity
        if ($sourceItem->quantity_on_hand < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient quantity available for transfer.');
        }

        $fromStationId = $sourceItem->station_id;
        $toStationId = $request->to_station_id === 'main' ? null : $request->to_station_id;

        // Validate to_station_id if not main
        if ($toStationId !== null && !Station::where('id', $toStationId)->exists()) {
            return redirect()->back()->with('error', 'Invalid destination station.');
        }

        // Prevent transferring to the same station
        if ($fromStationId == $toStationId) {
            return redirect()->back()->with('error', 'Cannot transfer to the same station.');
        }

        $transferQuantity = $request->quantity;
        $unitCost = $sourceItem->unit_cost;

        // Check if item already exists at destination station (by name and station)
        // We check by name instead of SKU since SKU is globally unique
        $destinationItem = Item::where('name', $sourceItem->name)
            ->where(function($q) use ($toStationId) {
                if ($toStationId === null) {
                    $q->whereNull('station_id');
                } else {
                    $q->where('station_id', $toStationId);
                }
            })
            ->where('unit', $sourceItem->unit)
            ->first();

        if ($destinationItem) {
            // Item exists at destination - add to its quantity (save quietly to avoid observer reports)
            $destinationItem->quantity_on_hand += $transferQuantity;
            $destinationItem->total_cost = $destinationItem->quantity_on_hand * $destinationItem->unit_cost;
            $destinationItem->saveQuietly();
        } else {
            // Item doesn't exist at destination - create new item entry with unique SKU
            $baseSku = $sourceItem->sku;
            if ($toStationId === null) {
                $newSku = $baseSku . '-MAIN';
            } else {
                $newSku = $baseSku . '-ST' . $toStationId;
            }
            
            // Ensure SKU is unique
            $skuCounter = 1;
            while (Item::where('sku', $newSku)->exists()) {
                if ($toStationId === null) {
                    $newSku = $baseSku . '-MAIN-' . $skuCounter;
                } else {
                    $newSku = $baseSku . '-ST' . $toStationId . '-' . $skuCounter;
                }
                $skuCounter++;
            }
            
            // Create the destination item without firing model events (prevents observer reports)
            $destinationItem = \Illuminate\Database\Eloquent\Model::withoutEvents(function() use ($sourceItem, $unitCost, $transferQuantity, $toStationId, $newSku) {
                return Item::create([
                    'name' => $sourceItem->name,
                    'sku' => $newSku,
                    'description' => $sourceItem->description,
                    'supplier_id' => $sourceItem->supplier_id,
                    'station_id' => $toStationId,
                    'unit' => $sourceItem->unit,
                    'unit_cost' => $unitCost,
                    'total_cost' => $transferQuantity * $unitCost,
                    'quantity_on_hand' => $transferQuantity,
                    'status' => $sourceItem->status,
                    'condition' => $sourceItem->condition ?? 'serviceable',
                    'life_span_years' => $sourceItem->life_span_years,
                    'date_acquired' => $sourceItem->date_acquired,
                    'is_active' => $sourceItem->is_active,
                ]);
            });
        }

        // Reduce quantity from source item
        $sourceItem->quantity_on_hand -= $transferQuantity;
        $sourceItem->total_cost = $sourceItem->quantity_on_hand * $sourceItem->unit_cost;
        
        // Update source item status: treat zero as low stock. Save quietly to avoid duplicate reports.
        if ($sourceItem->quantity_on_hand == 0) {
            $sourceItem->status = 'low_stock';
        }

        $sourceItem->saveQuietly();

        // Create a transfer report
        $fromStationName = $fromStationId ? \App\Models\Station::find($fromStationId)->name : 'Main Central Station';
        $toStationName = $toStationId ? \App\Models\Station::find($toStationId)->name : 'Main Central Station';

        // Create a single authoritative transfer report with explicit station names
        Report::create([
            'type' => 'transfer',
            'item_id' => $sourceItem->id,
            'user_id' => auth()->id(),
            'quantity_change' => $transferQuantity,
            'cost_change' => $transferQuantity * $unitCost,
            'reason' => $request->reason ?? "Transfer from {$fromStationName} to {$toStationName}",
            'from_station_id' => $fromStationId,
            'to_station_id' => $toStationId,
        ]);

        return redirect()->route('dashboard')->with('success', 
            "Successfully transferred {$transferQuantity} {$sourceItem->unit} of {$sourceItem->name} from {$fromStationName} to {$toStationName}!");
    }
}
