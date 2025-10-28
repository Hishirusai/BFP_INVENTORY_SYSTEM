<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('supplier');

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
        $suppliersCount = Supplier::count();
        $itemsCount = Item::count();
        $lowStockItems = Item::whereColumn('quantity_on_hand', '<=', 'reorder_level')->count();
        $totalInventoryValue = Item::sum('total_cost');
        $recentReports = Report::with(['item', 'user'])->latest()->limit(4)->get();

        // Get all unique units for filter dropdown
        $units = Item::select('unit')->distinct()->pluck('unit');

        return view('dashboard', compact('items', 'suppliersCount', 'itemsCount', 'lowStockItems', 'totalInventoryValue', 'recentReports', 'units'));
    }
}
