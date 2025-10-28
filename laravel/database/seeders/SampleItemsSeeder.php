<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Supplier;

class SampleItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a supplier for the items
        $supplier = Supplier::first() ?? Supplier::create([
            'name' => 'Fire Safety Equipment Co.',
            'contact_person' => 'John Smith',
            'phone' => '123-456-7890',
            'email' => 'info@fsec.com',
            'address' => '123 Fire Safety Blvd, Safety City',
        ]);

        // Create sample items
        $items = [
            [
                'name' => 'Self-Contained Breathing Apparatus (SCBA)',
                'sku' => 'SCBA-001',
                'description' => 'High-pressure breathing apparatus for firefighters',
                'supplier_id' => $supplier->id,
                'unit' => 'unit',
                'unit_cost' => 3500.00,
                'total_cost' => 3500.00,
                'quantity_on_hand' => 15,
                'reorder_level' => 5,
                'date_acquired' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Fire-Resistant Gloves',
                'sku' => 'FRG-002',
                'description' => 'Heat-resistant gloves for firefighter protection',
                'supplier_id' => $supplier->id,
                'unit' => 'pair',
                'unit_cost' => 120.00,
                'total_cost' => 1200.00,
                'quantity_on_hand' => 10,
                'reorder_level' => 20,
                'date_acquired' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Fire Extinguisher (ABC Type)',
                'sku' => 'FE-003',
                'description' => 'Multi-purpose fire extinguisher',
                'supplier_id' => $supplier->id,
                'unit' => 'unit',
                'unit_cost' => 250.00,
                'total_cost' => 1250.00,
                'quantity_on_hand' => 5,
                'reorder_level' => 10,
                'date_acquired' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Fire Hose (2.5-inch)',
                'sku' => 'FH-004',
                'description' => 'Standard fire hose for fire trucks',
                'supplier_id' => $supplier->id,
                'unit' => 'roll',
                'unit_cost' => 450.00,
                'total_cost' => 2250.00,
                'quantity_on_hand' => 5,
                'reorder_level' => 8,
                'date_acquired' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Fire Helmet',
                'sku' => 'FH-005',
                'description' => 'Protective helmet for firefighters',
                'supplier_id' => $supplier->id,
                'unit' => 'unit',
                'unit_cost' => 300.00,
                'total_cost' => 1500.00,
                'quantity_on_hand' => 25,
                'reorder_level' => 10,
                'date_acquired' => now(),
                'is_active' => true,
            ],
        ];

        foreach ($items as $itemData) {
            Item::create($itemData);
        }
    }
}
