<?php

namespace App\Http\Controllers\SpaceOps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpaceMasterController extends Controller
{
    public function spaces(Request $request)
    {
        $q = DB::table('databases_view_space');

        if ($request->filled('area_code')) $q->where('area_code', $request->area_code);
        if ($request->filled('building_code')) $q->where('building_code', $request->building_code);
        if ($request->filled('space_no')) $q->where('space_no', $request->space_no);

        $rows = $q->orderBy('area_code')->orderBy('building_code')->orderBy('space_no')->paginate(20);

        return view('spaceops.master.spaces', compact('rows'));
    }
}
