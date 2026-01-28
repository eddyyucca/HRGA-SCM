<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class asset_movement_log_model extends Model
{
    protected $table = 'asset_movement_logs';
    
    protected $fillable = [
        'asset_id',
        'from_location_id',
        'to_location_id',
        'movement_date',
        'movement_type',
        'quantity',
        'pic_name',
        'received_by',
        'reason',
        'notes'
    ];
    
    protected $casts = [
        'movement_date' => 'datetime'
    ];
    
    public function asset()
    {
        return $this->belongsTo(asset_model::class, 'asset_id');
    }
    
    public function fromLocation()
    {
        return $this->belongsTo(asset_location_model::class, 'from_location_id');
    }
    
    public function toLocation()
    {
        return $this->belongsTo(asset_location_model::class, 'to_location_id');
    }
}

