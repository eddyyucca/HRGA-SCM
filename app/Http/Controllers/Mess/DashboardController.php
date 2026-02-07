<?php

namespace App\Http\Controllers\Mess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $summary = [
            'total_rooms' => DB::table('mst_rooms')->where('is_active', true)->count(),
            'total_beds' => DB::table('mst_rooms')->where('is_active', true)->sum('capacity'),
            'occupied_beds' => DB::table('trx_occupancies')->where('status', 'ACTIVE')->count(),
            'total_assets' => DB::table('mst_assets')->where('is_active', true)->count(),
            'total_employees' => DB::table('mst_employees')->where('is_active', true)->count(),
        ];
        
        $summary['available_beds'] = $summary['total_beds'] - $summary['occupied_beds'];
        $summary['occupancy_rate'] = $summary['total_beds'] > 0 
            ? round(($summary['occupied_beds'] / $summary['total_beds']) * 100, 1) 
            : 0;

        $roomAvailability = DB::table('vw_room_availability')
            ->select('area_name', 'building_name', 'room_no', 'capacity', 'occupied_beds', 'available_beds', 'room_type')
            ->get();

        return view('mess.dashboard.index', compact('summary', 'roomAvailability'));
    }
}
