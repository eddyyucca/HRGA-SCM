<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\asset_model;
use App\Models\Inventory\asset_location_model;
use Illuminate\Support\Facades\DB;

class asset_report_controller extends Controller
{
    public function same_assets()
    {
        $assets = asset_model::select('asset_name')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN condition_status = "BAIK" THEN 1 ELSE 0 END) as qty_baik')
            ->selectRaw('SUM(CASE WHEN condition_status = "RUSAK" THEN 1 ELSE 0 END) as qty_rusak')
            ->selectRaw('SUM(CASE WHEN condition_status = "TIDAK_LAYAK" THEN 1 ELSE 0 END) as qty_tidak_layak')
            ->selectRaw('SUM(CASE WHEN condition_status = "DALAM_PERBAIKAN" THEN 1 ELSE 0 END) as qty_dalam_perbaikan')
            ->groupBy('asset_name')
            ->orderBy('total', 'desc')
            ->get();
            
        return view('Inventory.asset_same', compact('assets'));
    }

    public function summary_by_location()
    {
        $summary = asset_location_model::where('is_active', true)
            ->withCount(['assets as total_assets'])
            ->with(['assets' => function($query) {
                $query->select('current_location_id', 'condition_status', DB::raw('count(*) as count'))
                      ->groupBy('current_location_id', 'condition_status');
            }])
            ->get()
            ->map(function($location) {
                $location->qty_baik = $location->assets->where('condition_status', 'BAIK')->sum('count');
                $location->qty_rusak = $location->assets->where('condition_status', 'RUSAK')->sum('count');
                $location->qty_tidak_layak = $location->assets->where('condition_status', 'TIDAK_LAYAK')->sum('count');
                $location->qty_dalam_perbaikan = $location->assets->where('condition_status', 'DALAM_PERBAIKAN')->sum('count');
                return $location;
            });
            
        return view('Inventory.asset_summary', compact('summary'));
    }

    public function by_location($locationId)
    {
        $location = asset_location_model::findOrFail($locationId);
        $assets = asset_model::with('category')
            ->where('current_location_id', $locationId)
            ->orderBy('asset_name')
            ->get();
            
        return view('Inventory.asset_by_location', compact('location', 'assets'));
    }
}
