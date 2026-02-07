<?php

namespace App\Models\Mess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    protected $table = 'mst_buildings';

    protected $fillable = [
        'area_id', 'code', 'name', 'total_floors', 'description', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'building_id');
    }
}
