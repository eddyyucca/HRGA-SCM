<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\asset_model;
use App\Models\Inventory\asset_movement_log_model;

class asset_movement_controller extends Controller
{
    public function index()
    {
        $movements = asset_movement_log_model::with(['asset', 'fromLocation', 'toLocation'])
            ->orderBy('movement_date', 'desc')
            ->paginate(20);
            
        return view('Inventory.asset_movement_index', compact('movements'));
    }

    public function history($assetId)
    {
        $asset = asset_model::with('location')->findOrFail($assetId);
        $movements = asset_movement_log_model::with(['fromLocation', 'toLocation'])
            ->where('asset_id', $assetId)
            ->orderBy('movement_date', 'desc')
            ->get();
            
        return view('Inventory.asset_movement_history', compact('asset', 'movements'));
    }
}
