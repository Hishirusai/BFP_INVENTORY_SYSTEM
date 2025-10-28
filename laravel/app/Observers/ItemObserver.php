<?php

namespace App\Observers;

use App\Models\Item;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     */
    public function created(Item $item): void
    {
        // Create a report for item creation
        Report::create([
            'type' => 'addition',
            'item_id' => $item->id,
            'user_id' => Auth::check() ? Auth::id() : 1, // Use default user if not authenticated
            'quantity_change' => $item->quantity_on_hand,
            'cost_change' => $item->total_cost,
            'reason' => 'Item created',
        ]);
    }

    /**
     * Handle the Item "updated" event.
     */
    public function updated(Item $item): void
    {
        // Only create a report if the quantity has changed
        if ($item->isDirty('quantity_on_hand')) {
            $oldQuantity = $item->getOriginal('quantity_on_hand');
            $newQuantity = $item->quantity_on_hand;
            $quantityChange = $newQuantity - $oldQuantity;

            // Determine report type based on quantity change
            $type = $quantityChange > 0 ? 'addition' : 'decrease';
            $quantityChange = abs($quantityChange);

            // Calculate cost change
            $costChange = $quantityChange * $item->unit_cost;
            if ($type === 'decrease') {
                $costChange = -$costChange;
            }

            Report::create([
                'type' => $type,
                'item_id' => $item->id,
                'user_id' => Auth::check() ? Auth::id() : 1, // Use default user if not authenticated
                'quantity_change' => $quantityChange,
                'cost_change' => $costChange,
                'reason' => 'Quantity updated from ' . $oldQuantity . ' to ' . $newQuantity,
            ]);
        }
    }

    /**
     * Handle the Item "deleted" event.
     */
    public function deleted(Item $item): void
    {
        // Create a report for item deletion
        Report::create([
            'type' => 'decrease',
            'item_id' => $item->id,
            'user_id' => Auth::check() ? Auth::id() : 1, // Use default user if not authenticated
            'quantity_change' => $item->quantity_on_hand,
            'cost_change' => -$item->total_cost,
            'reason' => 'Item deleted',
        ]);
    }

    /**
     * Handle the Item "restored" event.
     */
    public function restored(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "force deleted" event.
     */
    public function forceDeleted(Item $item): void
    {
        //
    }
}
