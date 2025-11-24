<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StationController extends Controller
{
    /**
     * Display a listing of stations
     */
    public function index(): View
{
    $stations = Station::where('is_active', true)->get();

    // Add total quantity for each station
    $stations->map(function($station) {
        $station->total_quantity = $station->items()->sum('quantity_on_hand');
        return $station;
    });

    return view('stations.index', compact('stations'));
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
        if ($station->items()->count() > 0) {
            return redirect()->route('stations.index')
                ->with('error', 'Cannot remove station. It still has items assigned. Please transfer or remove items first.');
        }

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
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by unit
        if ($request->has('unit') && $request->unit) {
            $query->where('unit', $request->unit);
        }

        $items = $query->latest()->paginate(10);

        // Counts based on filtered query
        $itemsCount = $query->count();
        $lowStockItems = $query->whereColumn('quantity_on_hand', '<=', 'reorder_level')->count();
        $totalInventoryValue = $query->sum('total_cost');
        $unserviceableItems = $query->where('condition', 'unserviceable')->count();

        // Units for filter dropdown
        $units = $station->items()->select('unit')->distinct()->pluck('unit');

        return view('stations.show', compact(
            'station', 'items', 'itemsCount', 'lowStockItems', 'totalInventoryValue', 'unserviceableItems', 'units'
        ));
    }

    /**
     * Export station items to CSV
     */
    public function export(Station $station)
    {
        $items = $station->items()->get();
        $stationName = str_replace(' ', '_', $station->name);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['No.', 'Name', 'Reference No.', 'Unit', 'Unit Cost', 'Total Cost', 'Quantity', 'Condition', 'Life Span (Years)', 'Date Acquired', 'Date Expiry'];
        $sheet->fromArray($headers, null, 'A1');
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $row = 2;
        $count = 1;

        foreach ($items as $item) {
            $dateAcquired = $item->date_acquired ? $item->date_acquired->format('Y-m-d') : 'N/A';
            $dateExpiry = ($item->life_span_years && $item->date_acquired)
                ? $item->date_acquired->copy()->addYears($item->life_span_years)->format('Y-m-d')
                : 'N/A';

            $sheet->setCellValue("A$row", $count)
                ->setCellValue("B$row", $item->name)
                ->setCellValue("C$row", $item->sku)
                ->setCellValue("D$row", $item->unit)
                ->setCellValue("E$row", $item->unit_cost)
                ->setCellValue("F$row", $item->total_cost)
                ->setCellValue("G$row", $item->quantity_on_hand)
                ->setCellValue("H$row", $item->condition ?? 'serviceable')
                ->setCellValue("I$row", $item->life_span_years ?? 'N/A')
                ->setCellValue("J$row", $dateAcquired)
                ->setCellValue("K$row", $dateExpiry);

            $row++;
            $count++;
        }

        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getStyle($col)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        }

        $filename = 'station_' . $stationName . '_inventory_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename);
    }
}
