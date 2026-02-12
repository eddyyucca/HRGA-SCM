<?php

namespace App\Http\Controllers\Mess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mess\Occupancy;
use App\Models\Mess\Room;
use App\Models\Mess\Employee;
use App\Models\Mess\Area;
use App\Models\Mess\Building;

class OccupancyController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::where('is_active', true)->get();
        
        // Building MESS untuk filter
        $messBuildings = Building::where('is_active', true)
            ->where('building_type', 'MESS')
            ->get();
        
        $query = DB::table('vw_occupancy_details')
            ->where('occupancy_status', 'ACTIVE');

        if ($request->filled('area')) {
            $query->where('area_code', $request->area);
        }
        if ($request->filled('building')) {
            $query->where('building_code', $request->building);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('employee_name', 'like', '%'.$request->search.'%')
                  ->orWhere('emp_code', 'like', '%'.$request->search.'%')
                  ->orWhere('room_no', 'like', '%'.$request->search.'%');
            });
        }

        $occupancies = $query->orderBy('area_code')
            ->orderBy('building_code')
            ->orderBy('room_no')
            ->orderBy('bed_no')
            ->paginate(20);

        return view('mess.occupancy.index', compact('occupancies', 'areas', 'messBuildings'));
    }

    public function byRoom($roomId)
    {
        $room = Room::with(['floor.building.area', 'activeOccupancies.employee', 'assets'])->findOrFail($roomId);
        
        return view('mess.occupancy.room-detail', compact('room'));
    }
}
