<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class asset_audit_log_model extends Model
{
    protected $table = 'asset_audit_logs';
    
    protected $fillable = [
        'audit_date',
        'location_id',
        'asset_id',
        'expected_qty',
        'actual_qty',
        'difference',
        'condition_check',
        'auditor_name',
        'status',
        'notes'
    ];
    
    protected $casts = [
        'audit_date' => 'date'
    ];
    
    public function location()
    {
        return $this->belongsTo(asset_location_model::class, 'location_id');
    }
    
    public function asset()
    {
        return $this->belongsTo(asset_model::class, 'asset_id');
    }
}