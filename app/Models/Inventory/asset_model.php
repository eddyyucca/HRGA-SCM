<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class asset_model extends Model
{
    protected $table = 'asset_assets';
    
    protected $fillable = [
        'asset_code',
        'asset_name',
        'category_id',
        'brand',
        'detail_spec',
        'current_location_id',
        'purchase_date',
        'purchase_price',
        'supplier',
        'warranty_until',
        'condition_status',
        'operational_status',
        'notes'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_until' => 'date',
        'purchase_price' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(asset_category_model::class, 'category_id');
    }

    public function location()
    {
        return $this->belongsTo(asset_location_model::class, 'current_location_id');
    }

    public function movementLogs()
    {
        return $this->hasMany(asset_movement_log_model::class, 'asset_id')->latest('movement_date');
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(asset_maintenance_log_model::class, 'asset_id')->latest('start_date');
    }

    public function conditionLogs()
    {
        return $this->hasMany(asset_condition_log_model::class, 'asset_id')->latest('changed_date');
    }

    public function auditLogs()
    {
        return $this->hasMany(asset_audit_log_model::class, 'asset_id')->latest('audit_date');
    }

    public function activityLogs()
    {
        return $this->hasMany(asset_activity_log_model::class, 'asset_id')->latest();
    }

    public function getWarrantyStatusAttribute()
    {
        if (!$this->warranty_until) return null;
        return $this->warranty_until >= now() ? 'ACTIVE' : 'EXPIRED';
    }

    public function getAgeInYearsAttribute()
    {
        if (!$this->purchase_date) return null;
        return $this->purchase_date->diffInYears(now());
    }
}