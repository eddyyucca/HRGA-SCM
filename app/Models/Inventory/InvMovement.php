<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InvMovement extends Model
{
    protected $table = 'inv_asset_movements';
    
    protected $fillable = [
        'asset_id', 'from_location_id', 'to_location_id', 'movement_date',
        'reason', 'pic_name', 'received_by', 'notes'
    ];

    protected $casts = ['movement_date' => 'date'];
    
    public $timestamps = false;

    public function asset()
    {
        return $this->belongsTo(InvAsset::class, 'asset_id');
    }

    public function fromLocation()
    {
        return $this->belongsTo(InvLocation::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(InvLocation::class, 'to_location_id');
    }
}
