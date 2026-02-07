<?php

namespace App\Http\Controllers\Mess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mess\Hotbed;
use App\Models\Mess\Occupancy;
use App\Models\Mess\Employee;

class HotbedController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotbed::with(['room.building.area', 'originalOccupancy.employee', 'tempEmployee']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'ACTIVE');
        }

        $hotbeds = $query->orderBy('start_date', 'desc')->paginate(20);

        // Karyawan yang sedang cuti (bisa dijadikan hotbed)
        $cutiEmployees = Occupancy::with(['employee', 'room.building.area'])
            ->whereHas('employee', function($q) {
                $q->where('status', 'CUTI');
            })
            ->where('status', 'ACTIVE')
            ->get();

        return view('mess.hotbed.index', compact('hotbeds', 'cutiEmployees'));
    }

    public function available()
    {
        // Bed dari karyawan yang cuti dan belum di-hotbed-kan
        $availableHotbeds = Occupancy::with(['employee', 'room.building.area'])
            ->whereHas('employee', function($q) {
                $q->where('status', 'CUTI');
            })
            ->where('status', 'ACTIVE')
            ->whereDoesntHave('hotbeds', function($q) {
                $q->where('status', 'ACTIVE');
            })
            ->get();

        return view('mess.hotbed.available', compact('availableHotbeds'));
    }
}
