<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Item::with('supplier');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $items = $query->latest()->get();
        $stations = \App\Models\Station::where('is_active', true)->get();
    $units = Item::select('unit')->distinct()->pluck('unit');
    return view('items.edit-form', compact('item', 'suppliers', 'stations', 'units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $suppliers = Supplier::all();
        $stations = \App\Models\Station::where('is_active', true)->get();
        $units = Item::select('unit')->distinct()->pluck('unit');
        $selectedStationId = $request->get('station_id');
        return view('items.create', compact('suppliers', 'stations', 'units', 'selectedStationId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:items,sku',
            'description' => 'nullable|string',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'station_id' => 'nullable|exists:stations,id',
            'unit' => 'required|string|max:50',
            'unit_cost' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'quantity_on_hand' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'condition' => 'nullable|in:serviceable,unserviceable',
            'life_span_years' => 'nullable|integer|min:0',
            'date_acquired' => 'nullable|date',
        ]);

        $item = Item::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Item created successfully!');
    }

    /**
     * Display the specified resource as JSON for API requests.
     */
    public function showJson(Item $item)
    {
        $item->load('supplier');
        return response()->json($item);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $item->load('supplier');
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $suppliers = Supplier::all();
        $stations = \App\Models\Station::where('is_active', true)->get();
        $units = Item::select('unit')->distinct()->pluck('unit');
        return view('items.edit', compact('item', 'suppliers', 'stations', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:items,sku,' . $item->id,
            'description' => 'nullable|string',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'station_id' => 'nullable|exists:stations,id',
            'unit' => 'required|string|max:50',
            'unit_cost' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'quantity_on_hand' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'condition' => 'nullable|in:serviceable,unserviceable',
            'life_span_years' => 'nullable|integer|min:0',
            'date_acquired' => 'nullable|date',
        ]);

        $item->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('dashboard')->with('success', 'Item deleted successfully!');
    }

    /**
     * Export items to CSV
     */
    public function export()
    {
        $items = Item::with('supplier')->get();

        $filename = 'bfp_inventory_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($items) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, ['ID', 'Name', 'SKU', 'Description', 'Supplier', 'Unit', 'Unit Cost', 'Total Cost', 'Quantity', 'Reorder Level', 'Status', 'Date Acquired']);

            // CSV data
            foreach ($items as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->name,
                    $item->sku,
                    $item->description,
                    $item->supplier ? $item->supplier->name : 'N/A',
                    $item->unit,
                    $item->unit_cost,
                    $item->total_cost,
                    $item->quantity_on_hand,
                    $item->reorder_level,
                    $item->status,
                    $item->date_acquired ? $item->date_acquired->format('Y-m-d') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

   /**
 * Show the form for editing the specified resource as a partial for modal.
 */
public function editForm(Item $item)
{
    $suppliers = Supplier::all();
    $stations = \App\Models\Station::where('is_active', true)->get();
    $units = Item::select('unit')->distinct()->pluck('unit');
    return view('items.edit-form', compact('item', 'suppliers', 'stations', 'units'));
}

}
