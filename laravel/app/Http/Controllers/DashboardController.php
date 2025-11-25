<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use App\Models\Report;
use App\Models\Station;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Main Central Station - only show items where station_id is null
        $query = Item::with(['supplier', 'station'])
            ->whereNull('station_id');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter by unit if provided
        if ($request->has('unit') && $request->unit) {
            $query->where('unit', $request->unit);
        }

        // Paginate items (10 per page)
        $items = $query->with(['supplier', 'station'])->latest()->paginate(10);
        
        // Stats for Main Central Station only
        $suppliersCount = Supplier::count();
        $itemsCount = Item::whereNull('station_id')->count();
        $lowStockItems = Item::whereNull('station_id')
            ->whereColumn('quantity_on_hand', '<=', 'reorder_level')
            ->count();
        $totalInventoryValue = Item::whereNull('station_id')->sum('total_cost');
        // Count unserviceable items (condition = unserviceable or expired by life span)

$totalInventoryValue = Item::whereNull('station_id')->sum('total_cost');

        // NEW CORRECTED CODE:
        $unserviceableItems = \App\Models\Item::whereNull('station_id') // Filters for Main Station
            ->where(function ($group) {
                $group->where('condition', 'unserviceable')
                      ->orWhere(function ($query) {
                          $query->whereNotNull('expiry_date')
                                ->whereDate('expiry_date', '<', now());
                      });
            })
            ->count();

        $recentReports = Report::with(['item', 'user'])->latest()->limit(4)->get();

        // Get all unique units for filter dropdown (Main Central Station only)
        $units = Item::whereNull('station_id')
            ->select('unit')
            ->distinct()
            ->pluck('unit');

        $stations = Station::all();

        $items = $query->with(['supplier', 'station'])->latest()->paginate(10);

        $allItemsForTransfer = Item::with('station')->get();

        return view('dashboard', compact('items', 'suppliersCount', 'itemsCount', 'lowStockItems', 'totalInventoryValue', 'unserviceableItems', 'recentReports', 'units', 'stations', 'allItemsForTransfer'));
    }
}
