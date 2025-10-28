<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'description',
        'supplier_id',
        'unit',
        'unit_cost',
        'total_cost',
        'quantity_on_hand',
        'reorder_level',
        'status',
        'date_acquired',
        'is_active',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'date_acquired' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($item) {
            // Set initial status based on quantity
            if ($item->quantity_on_hand <= $item->reorder_level) {
                $item->status = 'low_stock';
            } else {
                $item->status = 'active';
            }
        });

        static::updating(function ($item) {
            // Update status based on quantity
            if ($item->quantity_on_hand <= $item->reorder_level) {
                $item->status = 'low_stock';
            } else {
                $item->status = 'active';
            }
        });
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
