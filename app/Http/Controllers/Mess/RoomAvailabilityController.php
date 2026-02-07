<?php

namespace App\Http\Controllers\Mess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mess\Area;

class RoomAvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::where('is_active', true)->where('type', 'MESS')->get();
        
        $query = DB::table('vw_room_availability')
            ->where('room_type', '!=', 'OFFICE');

        if ($request->filled('area')) {
            $query->where('area_code', $request->area);
        }
        if ($request->filled('only_available')) {
            $query->where('available_beds', '>', 0);
        }

        $rooms = $query->orderBy('area_code')
            ->orderBy('building_code')
            ->orderBy('room_no')
            ->get();

        $summary = [
            'total_rooms' => $rooms->count(),
            'total_capacity' => $rooms->sum('capacity'),
            'total_occupied' => $rooms->sum('occupied_beds'),
            'total_available' => $rooms->sum('available_beds'),
        ];

        return view('mess.room-availability.index', compact('rooms', 'areas', 'summary'));
    }

    public function forNewHire()
    {
        $rooms = DB::table('vw_room_availability')
            ->where('room_type', 'PERMANENT')
            ->where('available_beds', '>', 0)
            ->orderBy('available_beds', 'desc')
            ->get();

        return view('mess.room-availability.new-hire', compact('rooms'));
    }

    public function forVisitor()
    {
        $rooms = DB::table('vw_room_availability')
            ->whereIn('room_type', ['VISITOR', 'HOTBED'])
            ->where('available_beds', '>', 0)
            ->orderBy('available_beds', 'desc')
            ->get();

        return view('mess.room-availability.visitor', compact('rooms'));
    }
}
