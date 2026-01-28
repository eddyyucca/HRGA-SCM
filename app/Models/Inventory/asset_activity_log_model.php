<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class asset_activity_log_model extends Model
{
    protected $table = 'asset_activity_logs';
    
    protected $fillable = [
        'asset_id',
        'activity_type',
        'activity_description',
        'old_value',
        'new_value',
        'performed_by',
        'ip_address',
        'user_agent'
    ];
    
    public function asset()
    {
        return $this->belongsTo(asset_model::class, 'asset_id');
    }
}