<?php

namespace App\Http\Controllers\SpaceOps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomingController extends Controller
{
    public function index(Request $request)
    {
        $q = DB::table('databases_view_rooming_active');

        if ($request->filled('area_code')) $q->where('area_code', $request->area_code);
        if ($request->filled('building_code')) $q->where('building_code', $request->building_code);
        if ($request->filled('space_no')) $q->where('space_no', $request->space_no);
        if ($request->filled('stay_type')) $q->where('stay_type', $request->stay_type);

        $rows = $q->orderBy('area_code')->orderBy('building_code')->orderBy('space_no')->paginate(20);

        // map asset per space
        $assetsBySpace = DB::table('databases_view_space_asset')
            ->where('inout_status', 'IN')
            ->get()
            ->groupBy(fn($x) => $x->area_code.'|'.$x->building_code.'|'.$x->space_no);

        return view('spaceops.rooming.index', compact('rows','assetsBySpace'));
    }

    public function vacant(Request $request)
    {
        $q = DB::table('databases_view_vacant_bed');

        if ($request->filled('area_code')) $q->where('area_code', $request->area_code);
        if ($request->filled('building_code')) $q->where('building_code', $request->building_code);
        if ($request->filled('bed_type')) $q->where('bed_type', $request->bed_type);

        $rows = $q->orderBy('area_code')->orderBy('building_code')->orderBy('space_no')->orderBy('bed_no')->paginate(20);

        return view('spaceops.rooming.vacant', compact('rows'));
    }
}
