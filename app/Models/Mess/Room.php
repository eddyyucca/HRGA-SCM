<?php

namespace App\Models\Mess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $table = 'mst_rooms';

    protected $fillable = [
        'building_id', 'room_no', 'name', 'floor', 'capacity', 
        'room_type', 'status', 'description', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'room_id');
    }

    public function occupancies(): HasMany
    {
        return $this->hasMany(Occupancy::class, 'room_id');
    }

    public function activeOccupancies(): HasMany
    {
        return $this->hasMany(Occupancy::class, 'room_id')->where('status', 'ACTIVE');
    }

    public function getFullCodeAttribute(): string
    {
        return $this->building->area->code . '-' . $this->building->code . '-' . $this->room_no;
    }

    public function getAvailableBedsAttribute(): int
    {
        return $this->capacity - $this->activeOccupancies->count();
    }
}
