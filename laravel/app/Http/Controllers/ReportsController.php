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

        $reports = $query->latest()->paginate(15);
        $items = Item::all();

        return view('reports.index', compact('reports', 'items'));
    }

    /**
     * Store a newly created report
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => 'required|in:addition,decrease',
            'item_id' => 'required|exists:items,id',
            'quantity_change' => 'required|integer',
            'reason' => 'nullable|string|max:255',
        ]);

        $item = Item::findOrFail($request->item_id);

        // Calculate cost change
        $costChange = $request->quantity_change * $item->unit_cost;

        // Adjust for decrease (negative values)
        if ($request->type === 'decrease') {
            $costChange = -$costChange;
        }

        Report::create([
            'type' => $request->type,
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'quantity_change' => $request->quantity_change,
            'cost_change' => $costChange,
            'reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Report created successfully!');
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
