<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class asset_maintenance_log_model extends Model
{
    protected $table = 'asset_maintenance_logs';
    
    protected $fillable = [
        'asset_id',
        'maintenance_type',
        'condition_before',
        'condition_after',
        'problem_description',
        'action_taken',
        'spare_parts_used',
        'cost',
        'technician_name',
        'vendor_name',
        'start_date',
        'completion_date',
        'next_maintenance_date',
        'notes'
    ];
    
    protected $casts = [
        'start_date' => 'datetime',
        'completion_date' => 'datetime',
        'next_maintenance_date' => 'date',
        'cost' => 'decimal:2'
    ];
    
    public function asset()
    {
        return $this->belongsTo(asset_model::class, 'asset_id');
    }
}