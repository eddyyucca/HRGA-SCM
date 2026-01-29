<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InvWithdrawal extends Model
{
    protected $table = 'inv_asset_withdrawals';
    
    protected $fillable = [
        'asset_id', 'withdrawal_date', 'reason', 'condition_notes',
        'pic_name', 'approved_by', 'status'
    ];

    protected $casts = ['withdrawal_date' => 'date'];

    public function asset()
    {
        return $this->belongsTo(InvAsset::class, 'asset_id');
    }
}
