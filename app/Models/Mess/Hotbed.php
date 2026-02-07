<?php

namespace App\Models\Mess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hotbed extends Model
{
    protected $table = 'trx_hotbeds';

    protected $fillable = [
        'room_id', 'original_occupancy_id', 'temp_employee_id', 'bed_no',
        'start_date', 'end_date', 'status', 'reason'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function originalOccupancy(): BelongsTo
    {
        return $this->belongsTo(Occupancy::class, 'original_occupancy_id');
    }

    public function tempEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'temp_employee_id');
    }
}
