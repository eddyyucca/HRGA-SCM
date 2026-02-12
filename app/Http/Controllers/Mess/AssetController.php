<?php

namespace App\Http\Controllers\Mess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mess\Asset;
use App\Models\Mess\Area;
use App\Models\Mess\Building;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::where('is_active', true)->get();
        $buildingTypes = ['MESS', 'OFFICE', 'KANTIN', 'WORKSHOP', 'GUDANG', 'LAINNYA'];
        
        $query = DB::table('vw_asset_details');

        if ($request->filled('area')) {
            $query->where('area_code', $request->area);
        }
        if ($request->filled('building_type')) {
            $query->where('building_type', $request->building_type);
        }
        if ($request->filled('building')) {
            $query->where('building_code', $request->building);
        }
        if ($request->filled('room')) {
            $query->where('room_no', $request->room);
        }
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('item_name', 'like', '%'.$request->search.'%')
                  ->orWhere('category', 'like', '%'.$request->search.'%')
                  ->orWhere('asset_code', 'like', '%'.$request->search.'%');
            });
        }

        $assets = $query->orderBy('building_type')
            ->orderBy('area_code')
            ->orderBy('building_code')
            ->orderBy('room_no')
            ->paginate(20);

        // Summary per building type
        $assetSummary = DB::table('vw_asset_summary')->get();

        return view('mess.asset.index', compact('assets', 'areas', 'buildingTypes', 'assetSummary'));
    }

    public function byBuilding($buildingType = null)
    {
        $query = DB::table('vw_asset_summary');
        
        if ($buildingType) {
            $query->where('building_type', $buildingType);
        }

        $buildings = $query->get();
        
        return view('mess.asset.by-building', compact('buildings', 'buildingType'));
    }

    public function byLocation($areaCode, $buildingCode = null, $roomNo = null)
    {
        $query = DB::table('vw_asset_details')
            ->where('area_code', $areaCode);

        if ($buildingCode) {
            $query->where('building_code', $buildingCode);
        }
        if ($roomNo) {
            $query->where('room_no', $roomNo);
        }

        $assets = $query->get();
        $location = compact('areaCode', 'buildingCode', 'roomNo');

        return view('mess.asset.by-location', compact('assets', 'location'));
    }
}
