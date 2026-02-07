<?php

namespace App\Models\Mess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    protected $table = 'mst_areas';

    protected $fillable = [
        'code', 'name', 'type', 'description', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class, 'area_id');
    }
}
