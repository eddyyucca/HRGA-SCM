<?php

namespace App\Models\Mess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $table = 'mst_rooms';

    protected $fillable = [
        'floor_id', 'room_no', 'name', 'capacity', 
        'room_type', 'status', 'description', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }

    public function building()
    {
        return $this->floor->building;
    }

    public function area()
    {
        return $this->floor->building->area;
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
        $floor = $this->floor;
        $building = $floor->building;
        $area = $building->area;
        return $area->code . '-' . $building->code . '-L' . $floor->floor_number . '-' . $this->room_no;
    }

    public function getAvailableBedsAttribute(): int
    {
        return $this->capacity - $this->activeOccupancies->count();
    }
}
