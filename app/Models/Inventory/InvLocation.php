<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InvLocation extends Model
{
    protected $table = 'inv_locations';
    
    protected $fillable = [
        'area', 'building', 'room', 'floor', 'department',
        'pic_name', 'pic_contact', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function assets()
    {
        return $this->hasMany(InvAsset::class, 'location_id');
    }

    public function getFullLocationAttribute()
    {
        return "{$this->area} - {$this->building} - {$this->room}";
    }
}
