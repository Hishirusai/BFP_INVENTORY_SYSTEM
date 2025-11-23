<?php
// Simple check script to verify reports snapshot column and deletion behavior
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Item;
use App\Models\Report;
use Illuminate\Support\Facades\Schema;

try {
    echo "HAS_ITEM_NAME: " . (Schema::hasColumn('reports', 'item_name') ? 'YES' : 'NO') . PHP_EOL;

    $item = Item::first();
    if (! $item) {
        echo "NO_ITEM\n";
        exit(0);
    }

    $id = $item->id;
    echo "DELETING ITEM ID: {$id}\n";
    $item->delete();

    $r = Report::latest()->first();
    if ($r) {
        printf(
            "REPORT: type=%s item_id=%s item_name=%s item_sku=%s from_station=%s\n",
            $r->type,
            $r->item_id ?? 'null',
            $r->item_name ?? 'null',
            $r->item_sku ?? 'null',
            $r->from_station_id ?? 'null'
        );
    } else {
        echo "REPORT: NONE\n";
    }
    
    echo "\nLast 5 reports:\n";
    $last = Report::orderBy('created_at','desc')->take(5)->get();
    foreach($last as $rep) {
        printf("%s | id:%s | item_id:%s | reason:%s | item_name:%s | item_sku:%s | from:%s\n",
            $rep->created_at, $rep->id, $rep->item_id ?? 'null', $rep->reason, $rep->item_name ?? 'null', $rep->item_sku ?? 'null', $rep->from_station_id ?? 'null');
    }

    echo "\nDeletion reports (recent):\n";
    $dels = Report::where('reason','like','%Item deleted%')->orderBy('created_at','desc')->take(10)->get();
    foreach($dels as $rep) {
        printf("%s | id:%s | item_id:%s | reason:%s | item_name:%s | item_sku:%s | from:%s\n",
            $rep->created_at, $rep->id, $rep->item_id ?? 'null', $rep->reason, $rep->item_name ?? 'null', $rep->item_sku ?? 'null', $rep->from_station_id ?? 'null');
    }
} catch (Throwable $e) {
    echo "ERR: " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}
