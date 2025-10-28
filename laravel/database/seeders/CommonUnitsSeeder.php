<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class CommonUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Common units that should always be available
        $commonUnits = ['pcs', 'box', 'liter', 'kg', 'meter', 'roll', 'pair', 'set'];

        // Check if we have any items in the database
        if (Item::count() == 0) {
            // If no items exist, create sample items with common units
            foreach ($commonUnits as $unit) {
                Item::create([
                    'name' => 'Sample Item (' . ucfirst($unit) . ')',
                    'sku' => 'SAMPLE-' . strtoupper($unit),
                    'description' => 'Sample item measured in ' . $unit,
                    'unit' => $unit,
                    'unit_cost' => 100.00,
                    'total_cost' => 100.00,
                    'quantity_on_hand' => 10,
                    'reorder_level' => 5,
                    'is_active' => true,
                ]);
            }
        }
    }
}
