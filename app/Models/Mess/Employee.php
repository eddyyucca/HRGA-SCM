<?php

namespace App\Models\Mess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $table = 'mst_employees';

    protected $fillable = [
        'employee_id', 'name', 'position', 'department', 'company',
        'employee_type', 'phone', 'email', 'status', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function occupancies(): HasMany
    {
        return $this->hasMany(Occupancy::class, 'employee_id');
    }

    public function activeOccupancy()
    {
        return $this->hasOne(Occupancy::class, 'employee_id')->where('status', 'ACTIVE');
    }
}
