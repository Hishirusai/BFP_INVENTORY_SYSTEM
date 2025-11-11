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
        'station_id',
        'unit',
        'unit_cost',
        'total_cost',
        'quantity_on_hand',
        'reorder_level',
        'status',
        'condition',
        'life_span_years',
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

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * Check if item is unserviceable based on life span
     */
    public function isUnserviceableByLifespan(): bool
    {
        if (!$this->date_acquired || !$this->life_span_years) {
            return false;
        }

        $yearsSinceAcquired = $this->date_acquired->diffInYears(now());
        return $yearsSinceAcquired >= $this->life_span_years;
    }
}
