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
    // ----------------------------
    // Get station ID from request
    // ----------------------------
    $stationId = $request->get('station_id');

    // ----------------------------
    // Get items based on station
    // ----------------------------
    if ($stationId) {
        $items = Item::where('station_id', $stationId)->get();
        $stationName = Station::find($stationId)?->name ?? 'station';
    } else {
        $items = Item::whereNull('station_id')->get();
        $stationName = 'main_dashboard';
    }

    // ----------------------------
    // Create new spreadsheet
    // ----------------------------
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // ----------------------------
    // Set header row values
    // ----------------------------
    $headers = [
        'No.', 'Name', 'Reference No.', 'Quantity', 'Unit', 'Unit Cost', 'Total Cost',
        'Condition', 'Date Acquired (YYYY-MM-DD)', 'Date Expiry (YYYY-MM-DD)'
    ];
    $sheet->fromArray($headers, null, 'A1');

    // ----------------------------
    // Style header row (bold + center)
    // ----------------------------
    $sheet->getStyle('A1:J1')->getFont()->setBold(true);
    $sheet->getStyle('A1:J1')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // ----------------------------
    // Initialize row and count
    // ----------------------------
    $row = 2;
    $count = 1;

    // ----------------------------
    // Fill data rows
    // ----------------------------
    foreach ($items as $item) {
        // Format dates
        $dateAcquired = $item->date_acquired ? Carbon::parse($item->date_acquired)->format('Y-m-d') : 'N/A';
        $dateExpiry = ($item->life_span_years && $item->date_acquired)
            ? Carbon::parse($item->date_acquired)->addYears($item->life_span_years)->format('Y-m-d')
            : 'N/A';

        // Fill each cell
        $sheet->setCellValue("A$row", $count)
            ->setCellValue("B$row", $item->name)
            ->setCellValue("C$row", $item->sku)
            ->setCellValue("D$row", $item->quantity_on_hand ?? 0) // moved Quantity here
            ->setCellValue("E$row", $item->unit)
            ->setCellValue("F$row", $item->unit_cost)
            ->setCellValue("G$row", $item->total_cost)
            ->setCellValue("H$row", $item->condition ?? 'N/A')
            ->setCellValue("I$row", $dateAcquired)
            ->setCellValue("J$row", $dateExpiry);

        // Format currency columns
        $sheet->getStyle("F$row:G$row")->getNumberFormat()
        ->setFormatCode('"₱"#,##0.00'); // PHP Peso format

        // Alignment for each cell
        $sheet->getStyle("A$row")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$row:C$row")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("D$row:E$row")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("F$row:G$row")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("H$row:J$row")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row++;
        $count++;
    }

    /* ===========================
       COLUMN WIDTHS AND ROW HEIGHT
       =========================== */

    // ----------------------------
    // Fixed width columns
    // ----------------------------
    $sheet->getColumnDimension('E')->setWidth(10);  // Unit
    $sheet->getColumnDimension('F')->setWidth(15);  // Unit Cost
    $sheet->getColumnDimension('H')->setWidth(15);  // Condition

    // ----------------------------
    // Autofit columns based on content
    // ----------------------------
    $maxA = strlen('No.'); // start with header length
    foreach ($sheet->getRowIterator() as $r) {
        $len = strlen($sheet->getCell('A' . $r->getRowIndex())->getValue());
        if ($len > $maxA) $maxA = $len;
    }
    $sheet->getColumnDimension('A')->setWidth($maxA + 2);

    $maxB = 0;
    foreach ($sheet->getRowIterator() as $r) {
        $len = strlen($sheet->getCell('B' . $r->getRowIndex())->getValue());
        if ($len > $maxB) $maxB = $len;
    }
    $sheet->getColumnDimension('B')->setWidth($maxB + 5);

    $maxC = 0;
    foreach ($sheet->getRowIterator() as $r) {
        $len = strlen($sheet->getCell('C' . $r->getRowIndex())->getValue());
        if ($len > $maxC) $maxC = $len;
    }
    $sheet->getColumnDimension('C')->setWidth($maxC + 5);

    $maxC = 0;
    foreach ($sheet->getRowIterator() as $r) {
        $len = strlen($sheet->getCell('D' . $r->getRowIndex())->getValue());
        if ($len > $maxC) $maxC = $len;
    }
    $sheet->getColumnDimension('D')->setWidth($maxC + 5);

    $maxF = 0;
    foreach ($sheet->getRowIterator() as $r) {
        $len = strlen($sheet->getCell('G' . $r->getRowIndex())->getValue());
        if ($len > $maxF) $maxF = $len;
    }
    $sheet->getColumnDimension('G')->setWidth($maxF + 5);

    // ----------------------------
    // Date columns width based on header only
    // ----------------------------
    $sheet->getColumnDimension('I')->setWidth(strlen($sheet->getCell('I1')->getValue()) + 10);
    $sheet->getColumnDimension('J')->setWidth(strlen($sheet->getCell('J1')->getValue()) + 8);

    // ----------------------------
    // Header font bigger and bold
    // ----------------------------
    $sheet->getStyle('A1:J1')->getFont()->setSize(14)->setBold(true);

    // ----------------------------
    // Normal rows font
    // ----------------------------
    $sheet->getStyle('A2:J' . ($row - 1))->getFont()->setSize(12);

    // ----------------------------
    // Row height for top/bottom spacing
    // ----------------------------
    $fixedRowHeight = 30;
    for ($r = 1; $r < $row; $r++) {
        $sheet->getRowDimension($r)->setRowHeight($fixedRowHeight);
        $sheet->getStyle("A$r:J$r")->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
    }

    /* ===========================
       END COLUMN + ROW FORMATTING
       =========================== */

    // ----------------------------
    // Prepare filename and writer
    // ----------------------------
    $filename = 'inventory_' . str_replace(' ', '_', $stationName) . '_' . date('Y-m-d_h-i-s_A') . '.xlsx';
    $writer = new Xlsx($spreadsheet);

    // ----------------------------
    // Return response to download file
    // ----------------------------
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