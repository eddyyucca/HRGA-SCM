<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\asset_model;
use App\Models\Inventory\asset_location_model;
use App\Models\Inventory\asset_category_model;
use Illuminate\Http\Request;

class asset_index_controller extends Controller
{
    public function index(Request $request)
    {
        $query = asset_model::with(['category', 'location']);

        if ($request->location_id) {
            $query->where('current_location_id', $request->location_id);
        }
        
        if ($request->condition) {
            $query->where('condition_status', $request->condition);
        }
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('asset_name', 'like', '%' . $request->search . '%')
                  ->orWhere('asset_code', 'like', '%' . $request->search . '%');
            });
        }

        $assets = $query->orderBy('updated_at', 'desc')->paginate(20);
        $locations = asset_location_model::where('is_active', true)->get();
        
        return view('Inventory.asset_index', compact('assets', 'locations'));
    }

    public function show($id)
    {
        $asset = asset_model::with([
            'category', 
            'location',
            'movementLogs.fromLocation',
            'movementLogs.toLocation',
            'maintenanceLogs',
            'conditionLogs',
            'auditLogs'
        ])->findOrFail($id);
        
        return view('Inventory.asset_show', compact('asset'));
    }
}
