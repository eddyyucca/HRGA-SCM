<?php

namespace App\Models\Mess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Occupancy extends Model
{
    protected $table = 'trx_occupancies';

    protected $fillable = [
        'room_id', 'employee_id', 'bed_no', 'occupancy_type',
        'check_in_date', 'check_out_date', 'status', 'remarks'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function hotbeds(): HasMany
    {
        return $this->hasMany(Hotbed::class, 'original_occupancy_id');
    }
}
