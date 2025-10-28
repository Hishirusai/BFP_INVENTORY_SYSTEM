<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Report;

class InitialReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create initial reports for all existing items
        Item::all()->each(function ($item) {
            Report::create([
                'type' => 'addition',
                'item_id' => $item->id,
                'user_id' => 1, // Default user
                'quantity_change' => $item->quantity_on_hand,
                'cost_change' => $item->total_cost,
                'reason' => 'Initial report for existing item',
            ]);
        });
    }
}
