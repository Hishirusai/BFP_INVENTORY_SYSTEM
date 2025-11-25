<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Item::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $items = $query->latest()->get();

        $stations = Station::where('is_active', true)->get();
        $units = Item::select('unit')->distinct()->pluck('unit');

        return view('items.edit-form', compact('stations', 'units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $stations = Station::where('is_active', true)->get();
        $units = Item::select('unit')->distinct()->pluck('unit');
        $selectedStationId = $request->get('station_id');

        return view('items.create', compact('stations', 'units', 'selectedStationId'));
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

        // Calculate total_cost server-side
        $data = $request->all();
        $quantity = $request->quantity_on_hand ?? 0;
        $unitCost = $request->unit_cost ?? 0;
        $data['total_cost'] = $quantity * $unitCost;

        Item::create($data);

        return redirect()->route('dashboard')->with('success', 'Item created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
 * Display the specified resource as JSON for modal details.
 */
public function showJson(Item $item)
{
    return response()->json([
        'id' => $item->id,
        'name' => $item->name,
        'sku' => $item->sku,
        'description' => $item->description,
        'station_id' => $item->station_id,
        'unit' => $item->unit,
        'unit_cost' => $item->unit_cost,
        'total_cost' => $item->total_cost,
        'quantity_on_hand' => $item->quantity_on_hand,
        'reorder_level' => $item->reorder_level,
        'condition' => $item->condition,
        'life_span_years' => $item->life_span_years,
        'date_acquired' => $item->date_acquired,
        'status' => $item->status ?? 'active',
        'created_at' => $item->created_at,
        'updated_at' => $item->updated_at,
        'station' => $item->station ? [
            'id' => $item->station->id,
            'name' => $item->station->name,
            'code' => $item->station->code
        ] : null
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $stations = Station::where('is_active', true)->get();
        $units = Item::select('unit')->distinct()->pluck('unit');

        return view('items.edit', compact('item', 'stations', 'units'));
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

        // Calculate total_cost server-side to ensure accuracy
        $data = $request->all();
        $quantity = $request->quantity_on_hand ?? 0;
        $unitCost = $request->unit_cost ?? 0;
        $data['total_cost'] = $quantity * $unitCost;

        $item->update($data);

        if ($request->has('redirect_to') && $request->redirect_to) {
            return redirect($request->redirect_to)->with('success', 'Item updated successfully!');
        }

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
     * Export items to XLSX file.
     */
    public function export(Request $request)
    {
        $stationId = $request->get('station_id');

        if ($stationId) {
            $items = Item::where('station_id', $stationId)->get();
            $stationName = Station::find($stationId)?->name ?? 'station';
        } else {
            $items = Item::whereNull('station_id')->get();
            $stationName = 'main_dashboard';
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'No.', 'Name', 'Reference No.', 'Unit', 'Unit Cost', 'Total Cost',
            'Quantity', 'Condition', 'Date Acquired (YYYY-MM-DD)', 'Date Expiry (YYYY-MM-DD)'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('A1:J1')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row = 2;
        $count = 1;

        foreach ($items as $item) {
            $dateAcquired = $item->date_acquired ? Carbon::parse($item->date_acquired)->format('Y-m-d') : 'N/A';
            $dateExpiry = ($item->life_span_years && $item->date_acquired)
                ? Carbon::parse($item->date_acquired)->addYears($item->life_span_years)->format('Y-m-d')
                : 'N/A';

            $sheet->setCellValue("A$row", $count)
                ->setCellValue("B$row", $item->name)
                ->setCellValue("C$row", $item->sku)
                ->setCellValue("D$row", $item->unit)
                ->setCellValue("E$row", $item->unit_cost)
                ->setCellValue("F$row", $item->total_cost)
                ->setCellValue("G$row", $item->quantity_on_hand ?? 0)
                ->setCellValue("H$row", $item->condition ?? 'N/A')
                ->setCellValue("I$row", $dateAcquired)
                ->setCellValue("J$row", $dateExpiry);

            $sheet->getStyle("E$row:F$row")->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $sheet->getStyle("A$row")->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B$row:C$row")->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D$row")->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E$row:F$row")->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("G$row:J$row")->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $row++;
            $count++;
        }

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getStyle($col)->getAlignment()
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        }

        $filename = 'inventory_' . str_replace(' ', '_', $stationName) . '_' . date('Y-m-d_h-i-s_A') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename);
    }

    /**
     * Show the form for editing the specified resource as a partial for modal.
     */
    public function editForm(Item $item)
    {
        $stations = Station::where('is_active', true)->get();
        $units = Item::select('unit')->distinct()->pluck('unit');

        return view('items.edit-form', compact('item', 'stations', 'units'));
    }
}