<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'item_id',
        'transaction_code',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'reference_no',
        'notes',
        'pic',
        'transaction_date'
    ];

    protected $casts = [
        'transaction_date' => 'date'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }
}