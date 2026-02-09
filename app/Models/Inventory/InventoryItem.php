<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    protected $fillable = [
        'item_code',
        'item_name',
        'category',
        'unit',
        'current_stock',
        'min_stock',
        'max_stock',
        'average_usage_per_month',
        'lead_time_days',
        'reorder_point',
        'description',
        'location',
        'status'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'item_id');
    }

    // Calculate reorder point: (Average usage per day × Lead time) + Safety stock
    public function calculateReorderPoint(): int
    {
        $dailyUsage = $this->average_usage_per_month / 30;
        $leadTimeStock = $dailyUsage * $this->lead_time_days;
        $safetyStock = $this->min_stock;
        return (int) ceil($leadTimeStock + $safetyStock);
    }

    // Check if need to reorder
    public function needsReorder(): bool
    {
        return $this->current_stock <= $this->reorder_point;
    }

    // Get stock status
    public function getStockStatus(): string
    {
        if ($this->current_stock <= $this->reorder_point) {
            return 'critical';
        } elseif ($this->current_stock <= $this->min_stock) {
            return 'low';
        } elseif ($this->current_stock >= $this->max_stock) {
            return 'overstock';
        }
        return 'normal';
    }

    // Calculate days until stock out
    public function daysUntilStockOut(): ?int
    {
        if ($this->average_usage_per_month <= 0) {
            return null;
        }
        $dailyUsage = $this->average_usage_per_month / 30;
        return (int) floor($this->current_stock / $dailyUsage);
    }
}