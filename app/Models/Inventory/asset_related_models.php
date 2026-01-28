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

class asset_category_model extends Model
{
    protected $table = 'asset_categories';
    protected $fillable = ['name', 'description'];
    
    public function assets()
    {
        return $this->hasMany(asset_model::class, 'category_id');
    }
}

class asset_movement_log_model extends Model
{
    protected $table = 'asset_movement_logs';
    protected $fillable = [
        'asset_id', 'from_location_id', 'to_location_id',
        'movement_date', 'movement_type', 'quantity',
        'pic_name', 'received_by', 'reason', 'notes'
    ];
    protected $casts = ['movement_date' => 'datetime'];
    
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

class asset_maintenance_log_model extends Model
{
    protected $table = 'asset_maintenance_logs';
    protected $fillable = [
        'asset_id', 'maintenance_type', 'condition_before', 'condition_after',
        'problem_description', 'action_taken', 'spare_parts_used',
        'cost', 'technician_name', 'vendor_name',
        'start_date', 'completion_date', 'next_maintenance_date', 'notes'
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

class asset_condition_log_model extends Model
{
    protected $table = 'asset_condition_logs';
    protected $fillable = [
        'asset_id', 'old_condition', 'new_condition',
        'changed_date', 'changed_by', 'reason', 'notes', 'photo_url'
    ];
    protected $casts = ['changed_date' => 'datetime'];
    
    public function asset()
    {
        return $this->belongsTo(asset_model::class, 'asset_id');
    }
}

class asset_audit_log_model extends Model
{
    protected $table = 'asset_audit_logs';
    protected $fillable = [
        'audit_date', 'location_id', 'asset_id',
        'expected_qty', 'actual_qty', 'difference',
        'condition_check', 'auditor_name', 'status', 'notes'
    ];
    protected $casts = ['audit_date' => 'date'];
    
    public function location()
    {
        return $this->belongsTo(asset_location_model::class, 'location_id');
    }
    
    public function asset()
    {
        return $this->belongsTo(asset_model::class, 'asset_id');
    }
}

class asset_activity_log_model extends Model
{
    protected $table = 'asset_activity_logs';
    protected $fillable = [
        'asset_id', 'activity_type', 'activity_description',
        'old_value', 'new_value', 'performed_by',
        'ip_address', 'user_agent'
    ];
    
    public function asset()
    {
        return $this->belongsTo(asset_model::class, 'asset_id');
    }
}
