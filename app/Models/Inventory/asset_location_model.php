<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class asset_location_model extends Model
{
    protected $table = 'asset_locations';
    
    protected $fillable = [
        'location_name',
        'location_code',
        'detail_location',
        'sub_location',
        'department',
        'address',
        'pic_name',
        'pic_contact',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function assets()
    {
        return $this->hasMany(asset_model::class, 'current_location_id');
    }

    public function getFullLocationAttribute()
    {
        $parts = array_filter([
            $this->location_name,
            $this->detail_location,
            $this->sub_location
        ]);
        return implode(' - ', $parts);
    }
}