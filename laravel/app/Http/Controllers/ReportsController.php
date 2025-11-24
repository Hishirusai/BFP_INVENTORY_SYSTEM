<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReportsController extends Controller
{
    /**
     * Display a listing of reports
     */
    public function index(Request $request): View
{
    $query = Report::with(['item', 'user']);

    // Filter by type if provided
    if ($request->has('type') && $request->type) {
        $query->where('type', $request->type);
    }

    // Filter by item if provided
    if ($request->has('item_id') && $request->item_id) {
        $query->where('item_id', $request->item_id);
    }

    // Get reports in descending order (latest first)
    $reportsCollection = $query->latest()->get();

    // Track running quantities per item to calculate prev_quantity
    $runningQuantities = [];
    $reportsCollection->each(function ($report) use (&$runningQuantities) {
        $itemId = $report->item_id;

        if (!isset($runningQuantities[$itemId])) {
            // Start from current quantity_on_hand
            $runningQuantities[$itemId] = $report->item->quantity_on_hand ?? 0;
        }

        if ($report->type === 'addition') {
            $report->prev_quantity = $runningQuantities[$itemId] - $report->quantity_change;
            $runningQuantities[$itemId] -= $report->quantity_change;
        } elseif ($report->type === 'decrease') {
            $report->prev_quantity = $runningQuantities[$itemId] + $report->quantity_change;
            $runningQuantities[$itemId] += $report->quantity_change;
        } else {
            $report->prev_quantity = null;
        }
    });

    // Paginate manually after prev_quantity calculation
    $perPage = 15;
    $currentPage = request()->get('page', 1);
    $reports = new \Illuminate\Pagination\LengthAwarePaginator(
        $reportsCollection->forPage($currentPage, $perPage),
        $reportsCollection->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $items = Item::all();
    return view('reports.index', compact('reports', 'items'));
}

    /**
     * Store a newly created report
     */
    public function store(Request $request) { 
    $request->validate([ 
        'name' => 'required|string|max:255', 
        'quantity_on_hand' => 'required|integer|min:0', 
        'unit_cost' => 'required|numeric|min:0', 
        // other validations 
    ]); 

    // 1. Create the item 
    $item = Item::create([ 
        'name' => $request->name, 
        'quantity_on_hand' => $request->quantity_on_hand, 
        'unit_cost' => $request->unit_cost, 
        // other fields 
    ]); 

    // 2. Create a report for the new item 
    Report::create([ 
        'type' => 'created', // mark as created 
        'item_id' => $item->id, 
        'user_id' => auth()->id(), 
        'quantity_change' => $item->quantity_on_hand, // initial quantity 
        'cost_change' => $item->quantity_on_hand * $item->unit_cost, // initial cost 
        'reason' => 'New item created', 
    ]); 

    return redirect()->back()->with('success', 'Item created successfully!'); 
}

    /**
     * Display the specified report
     */
    public function show(Report $report): View
    {
        $report->load(['item', 'user']);
        return view('reports.show', compact('report'));
    }

    /**
     * Remove the specified report
     */
    public function destroy(Report $report): RedirectResponse
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully!');
    }
}
