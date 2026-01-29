<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InvAsset extends Model
{
    protected $table = 'inv_assets';
    
    protected $fillable = [
        'asset_number', 'asset_name', 'category_id', 'brand', 'model',
        'serial_number', 'specifications', 'location_id', 'purchase_date',
        'purchase_price', 'supplier', 'condition_status', 'operational_status',
        'photo', 'notes', 'created_by'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(InvCategory::class, 'category_id');
    }

    public function location()
    {
        return $this->belongsTo(InvLocation::class, 'location_id');
    }

    public function movements()
    {
        return $this->hasMany(InvMovement::class, 'asset_id')->latest('movement_date');
    }

    public function withdrawals()
    {
        return $this->hasMany(InvWithdrawal::class, 'asset_id')->latest();
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('asset_number', 'like', "%{$search}%")
              ->orWhere('asset_name', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%");
        });
    }

    public function scopeByArea($query, $area)
    {
        return $query->whereHas('location', function($q) use ($area) {
            $q->where('area', $area);
        });
    }

    public function scopeByBuilding($query, $building)
    {
        return $query->whereHas('location', function($q) use ($building) {
            $q->where('building', $building);
        });
    }

    public function scopeByRoom($query, $room)
    {
        return $query->whereHas('location', function($q) use ($room) {
            $q->where('room', $room);
        });
    }

    public function scopeByCondition($query, $condition)
    {
        return $query->where('condition_status', $condition);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('operational_status', $status);
    }

    public static function generateAssetNumber($categoryId)
    {
        $category = InvCategory::find($categoryId);
        if (!$category) return null;

        $year = date('Y');
        $prefix = "MIM-{$category->code}-{$year}-";

        $lastAsset = self::where('asset_number', 'like', "{$prefix}%")
                         ->orderBy('id', 'desc')
                         ->first();

        if ($lastAsset) {
            $parts = explode('-', $lastAsset->asset_number);
            $lastNumber = intval(end($parts));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}
