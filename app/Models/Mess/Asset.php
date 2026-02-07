<?php

namespace App\Models\Mess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    protected $table = 'mst_assets';

    protected $fillable = [
        'room_id', 'asset_code', 'item_name', 'category', 'qty', 'unit',
        'condition', 'description', 'purchase_date', 'purchase_price', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function getFullLocationAttribute(): string
    {
        $room = $this->room;
        return $room->building->area->code . '-' . $room->building->code . '-' . $room->room_no;
    }
}
