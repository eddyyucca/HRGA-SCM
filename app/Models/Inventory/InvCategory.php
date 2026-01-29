<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InvCategory extends Model
{
    protected $table = 'inv_categories';
    protected $fillable = ['code', 'name', 'description'];

    public function assets()
    {
        return $this->hasMany(InvAsset::class, 'category_id');
    }
}
