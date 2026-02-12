<?php

namespace App\Models\Mess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Building extends Model
{
    protected $table = 'mst_buildings';

    protected $fillable = [
        'area_id', 'code', 'name', 'building_type', 'total_floors', 'description', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class, 'building_id');
    }

    public function rooms(): HasManyThrough
    {
        return $this->hasManyThrough(Room::class, Floor::class, 'building_id', 'floor_id');
    }

    public function isMess(): bool
    {
        return $this->building_type === 'MESS';
    }

    public function scopeMess($query)
    {
        return $query->where('building_type', 'MESS');
    }

    public function scopeNonMess($query)
    {
        return $query->where('building_type', '!=', 'MESS');
    }
}
