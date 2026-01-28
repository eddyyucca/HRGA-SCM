<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class asset_category_model extends Model
{
    protected $table = 'asset_categories';
    
    protected $fillable = [
        'name',
        'description'
    ];
    
    public function assets()
    {
        return $this->hasMany(asset_model::class, 'category_id');
    }
}