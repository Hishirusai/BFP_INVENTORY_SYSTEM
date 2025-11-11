<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StationController extends Controller
{
    /**
     * Display a listing of stations
     */
    public function index(): View
    {
        $stations = Station::where('is_active', true)->withCount('items')->get();
        return view('stations.index', compact('stations'));
    }

    /**
     * Show the form for creating a new station
     */
    public function create(): View
    {
        return view('stations.create');
    }

    /**
     * Store a newly created station
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:stations,code',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        Station::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'location' => $request->location,
            'is_active' => true,
        ]);

        return redirect()->route('stations.index')->with('success', 'Station created successfully!');
    }

    /**
     * Remove (deactivate) a station
     */
    public function destroy(Station $station): RedirectResponse
    {
        // Check if station has items
        if ($station->items()->count() > 0) {
            return redirect()->route('stations.index')
                ->with('error', 'Cannot remove station. It still has items assigned. Please transfer or remove items first.');
        }

        // Deactivate instead of deleting
        $station->is_active = false;
        $station->save();

        return redirect()->route('stations.index')->with('success', 'Station removed successfully!');
    }

    /**
     * Display items for a specific station
     */
    public function show(Request $request, Station $station): View
    {
        $query = $station->items()->with('supplier');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by unit if provided
        if ($request->has('unit') && $request->unit) {
            $query->where('unit', $request->unit);
        }

        // Paginate items (10 per page)
        $items = $query->latest()->paginate(10);
        $itemsCount = $station->items()->count();
        $lowStockItems = $station->items()->whereColumn('quantity_on_hand', '<=', 'reorder_level')->count();
        $totalInventoryValue = $station->items()->sum('total_cost');
        $unserviceableItems = $station->items()->where('condition', 'unserviceable')->count();

        // Get all unique units for filter dropdown
        $units = $station->items()->select('unit')->distinct()->pluck('unit');

        return view('stations.show', compact('station', 'items', 'itemsCount', 'lowStockItems', 'totalInventoryValue', 'unserviceableItems', 'units'));
    }

    /**
     * Export station items to CSV
     */
    public function export(Station $station)
    {
        $items = $station->items()->with('supplier')->get();

        $filename = 'station_' . str_replace(' ', '_', $station->name) . '_inventory_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($items) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, ['ID', 'Name', 'SKU', 'Description', 'Supplier', 'Unit', 'Unit Cost', 'Total Cost', 'Quantity', 'Reorder Level', 'Status', 'Condition', 'Life Span (Years)', 'Date Acquired']);

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
                    $item->condition ?? 'serviceable',
                    $item->life_span_years ?? 'N/A',
                    $item->date_acquired ? $item->date_acquired->format('Y-m-d') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
