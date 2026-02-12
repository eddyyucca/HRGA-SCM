<?php

namespace App\Http\Controllers\Mess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary hanya untuk MESS
        $summary = [
            'total_rooms' => DB::table('mst_rooms')
                ->join('mst_floors', 'mst_rooms.floor_id', '=', 'mst_floors.id')
                ->join('mst_buildings', 'mst_floors.building_id', '=', 'mst_buildings.id')
                ->where('mst_buildings.building_type', 'MESS')
                ->where('mst_rooms.is_active', true)
                ->count(),
            'total_beds' => DB::table('mst_rooms')
                ->join('mst_floors', 'mst_rooms.floor_id', '=', 'mst_floors.id')
                ->join('mst_buildings', 'mst_floors.building_id', '=', 'mst_buildings.id')
                ->where('mst_buildings.building_type', 'MESS')
                ->where('mst_rooms.is_active', true)
                ->sum('mst_rooms.capacity'),
            'occupied_beds' => DB::table('trx_occupancies')->where('status', 'ACTIVE')->count(),
            'total_assets' => DB::table('mst_assets')->where('is_active', true)->count(),
            'total_employees' => DB::table('mst_employees')->where('is_active', true)->count(),
        ];
        
        $summary['available_beds'] = $summary['total_beds'] - $summary['occupied_beds'];
        $summary['occupancy_rate'] = $summary['total_beds'] > 0 
            ? round(($summary['occupied_beds'] / $summary['total_beds']) * 100, 1) 
            : 0;

        // Room availability hanya untuk MESS
        $roomAvailability = DB::table('vw_room_availability')
            ->select('room_id', 'area_name', 'building_name', 'floor_number', 'room_no', 'capacity', 'occupied_beds', 'available_beds', 'room_type', 'full_room_code')
            ->get();

        // Summary Building per Type
        $buildingSummary = DB::table('vw_asset_summary')->get();

        return view('mess.dashboard.index', compact('summary', 'roomAvailability', 'buildingSummary'));
    }
}
