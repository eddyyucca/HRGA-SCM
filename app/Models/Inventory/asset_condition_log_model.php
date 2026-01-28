<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class asset_condition_log_model extends Model
{
    protected $table = 'asset_condition_logs';
    
    protected $fillable = [
        'asset_id',
        'old_condition',
        'new_condition',
        'changed_date',
        'changed_by',
        'reason',
        'notes',
        'photo_url'
    ];
    
    protected $casts = [
        'changed_date' => 'datetime'
    ];
    
    public function asset()
    {
        return $this->belongsTo(asset_model::class, 'asset_id');
    }
}