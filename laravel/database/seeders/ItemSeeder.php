<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplier = Supplier::create([
            'name' => 'Fire Safety Supply Co.',
            'contact_person' => 'John Doe',
            'phone' => '123-456-7890',
            'email' => 'john@firesafety.com',
            'address' => '123 Fire Safety St, Metro Manila'
        ]);

        Item::create([
            'name' => 'Fire Extinguisher Type A',
            'sku' => 'FE-A-001',
            'description' => 'Dry chemical fire extinguisher',
            'supplier_id' => $supplier->id,
            'unit' => 'pcs',
            'unit_cost' => 150.00,
            'total_cost' => 3750.00,
            'quantity_on_hand' => 25,
            'reorder_level' => 5,
            'status' => 'active',
            'date_acquired' => '2024-01-15'
        ]);

        Item::create([
            'name' => 'Fire Hose 50ft',
            'sku' => 'FH-50-001',
            'description' => '50 feet fire hose',
            'supplier_id' => $supplier->id,
            'unit' => 'pcs',
            'unit_cost' => 200.00,
            'total_cost' => 600.00,
            'quantity_on_hand' => 3,
            'reorder_level' => 5,
            'status' => 'low_stock',
            'date_acquired' => '2024-02-10'
        ]);

        Item::create([
            'name' => 'Safety Helmet',
            'sku' => 'SH-001',
            'description' => 'Firefighter safety helmet',
            'supplier_id' => $supplier->id,
            'unit' => 'pcs',
            'unit_cost' => 75.00,
            'total_cost' => 1125.00,
            'quantity_on_hand' => 15,
            'reorder_level' => 3,
            'status' => 'active',
            'date_acquired' => '2024-03-05'
        ]);

        Item::create([
            'name' => 'Fire Axe',
            'sku' => 'FA-001',
            'description' => 'Standard fire axe',
            'supplier_id' => $supplier->id,
            'unit' => 'pcs',
            'unit_cost' => 120.00,
            'total_cost' => 960.00,
            'quantity_on_hand' => 8,
            'reorder_level' => 2,
            'status' => 'active',
            'date_acquired' => '2024-01-20'
        ]);

        Item::create([
            'name' => 'Emergency Blanket',
            'sku' => 'EB-001',
            'description' => 'Emergency thermal blanket',
            'supplier_id' => $supplier->id,
            'unit' => 'pcs',
            'unit_cost' => 25.00,
            'total_cost' => 25.00,
            'quantity_on_hand' => 1,
            'reorder_level' => 10,
            'status' => 'low_stock',
            'date_acquired' => '2024-02-28'
        ]);
    }
}
