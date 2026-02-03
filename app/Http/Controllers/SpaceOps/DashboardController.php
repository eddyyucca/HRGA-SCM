<?php

namespace App\Http\Controllers\SpaceOps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'active_rooming' => DB::table('databases_view_rooming_active')->count(),
            'vacant_beds'    => DB::table('databases_view_vacant_bed')->count(),
            'assets_in'      => DB::table('databases_view_space_asset')->where('inout_status', 'IN')->count(),
            'spaces_total'   => DB::table('databases_view_space')->count(),
        ];

        // ringkas per area (biar enak diliat)
        $byArea = DB::table('databases_view_space')
            ->select('area_code', DB::raw('COUNT(*) as total_spaces'))
            ->groupBy('area_code')
            ->orderBy('area_code')
            ->get();

        return view('spaceops.dashboard', compact('stats', 'byArea'));
    }
}
