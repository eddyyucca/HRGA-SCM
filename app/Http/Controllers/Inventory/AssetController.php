<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvAsset;
use App\Models\Inventory\InvCategory;
use App\Models\Inventory\InvLocation;
use App\Models\Inventory\InvMovement;
use App\Models\Inventory\InvWithdrawal;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = InvAsset::with(['category', 'location']);

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('area')) {
            $query->byArea($request->area);
        }
        if ($request->filled('building')) {
            $query->byBuilding($request->building);
        }
        if ($request->filled('room')) {
            $query->byRoom($request->room);
        }
        if ($request->filled('condition')) {
            $query->byCondition($request->condition);
        }
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        $assets = $query->latest()->paginate(20);
        $areas = InvLocation::distinct()->pluck('area');
        $buildings = InvLocation::distinct()->pluck('building');
        $rooms = InvLocation::distinct()->pluck('room');

        return view('Inventory.asset_index', compact('assets', 'areas', 'buildings', 'rooms'));
    }

    public function create()
    {
        $categories = InvCategory::all();
        $locations = InvLocation::where('is_active', 1)->get();
        return view('Inventory.asset_form', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_name' => 'required|max:200',
            'category_id' => 'required|exists:inv_categories,id',
            'location_id' => 'required|exists:inv_locations,id',
            'condition_status' => 'required|in:BAIK,RUSAK,DALAM_PERBAIKAN',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $data = $request->except(['photo', '_token']);
        $data['asset_number'] = InvAsset::generateAssetNumber($request->category_id);
        $data['created_by'] = 'EDDY ADHA SAPUTRA';

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/assets'), $filename);
            $data['photo'] = $filename;
        }

        InvAsset::create($data);

        return redirect()->route('inventory.asset.index')
            ->with('success', 'Asset berhasil ditambahkan: ' . $data['asset_number']);
    }

    public function show($id)
    {
        $asset = InvAsset::with(['category', 'location', 'movements.fromLocation', 'movements.toLocation', 'withdrawals'])
                         ->findOrFail($id);
        return view('Inventory.asset_show', compact('asset'));
    }

    public function edit($id)
    {
        $asset = InvAsset::findOrFail($id);
        $categories = InvCategory::all();
        $locations = InvLocation::where('is_active', 1)->get();
        return view('Inventory.asset_form', compact('asset', 'categories', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $asset = InvAsset::findOrFail($id);

        $request->validate([
            'asset_name' => 'required|max:200',
            'category_id' => 'required|exists:inv_categories,id',
            'location_id' => 'required|exists:inv_locations,id',
            'condition_status' => 'required|in:BAIK,RUSAK,DALAM_PERBAIKAN',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $data = $request->except(['photo', '_token', '_method']);

        if ($request->hasFile('photo')) {
            if ($asset->photo && file_exists(public_path('uploads/assets/' . $asset->photo))) {
                @unlink(public_path('uploads/assets/' . $asset->photo));
            }
            $file = $request->file('photo');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/assets'), $filename);
            $data['photo'] = $filename;
        }

        $asset->update($data);

        return redirect()->route('inventory.asset.index')->with('success', 'Asset berhasil diupdate');
    }

    public function destroy($id)
    {
        $asset = InvAsset::findOrFail($id);
        if ($asset->photo && file_exists(public_path('uploads/assets/' . $asset->photo))) {
            @unlink(public_path('uploads/assets/' . $asset->photo));
        }
        $asset->delete();

        return redirect()->route('inventory.asset.index')->with('success', 'Asset berhasil dihapus');
    }

    // EXPORT EXCEL - Simple CSV
    public function exportExcel(Request $request)
    {
        $query = InvAsset::with(['category', 'location']);

        if ($request->filled('search')) $query->search($request->search);
        if ($request->filled('area')) $query->byArea($request->area);
        if ($request->filled('building')) $query->byBuilding($request->building);
        if ($request->filled('room')) $query->byRoom($request->room);
        if ($request->filled('condition')) $query->byCondition($request->condition);
        if ($request->filled('status')) $query->byStatus($request->status);

        $assets = $query->latest()->get();

        $filename = 'Asset_Report_' . date('YmdHis') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // BOM untuk Excel UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header
        fputcsv($output, ['No', 'Nomor Asset', 'Nama Asset', 'Kategori', 'Brand', 'Lokasi', 'Kondisi', 'Status', 'Harga', 'Tanggal Beli']);
        
        // Data
        $no = 1;
        foreach ($assets as $asset) {
            fputcsv($output, [
                $no++,
                $asset->asset_number,
                $asset->asset_name,
                $asset->category->name ?? '-',
                $asset->brand ?? '-',
                $asset->location->full_location ?? '-',
                $asset->condition_status,
                $asset->operational_status,
                $asset->purchase_price ?? 0,
                $asset->purchase_date ? $asset->purchase_date->format('d/m/Y') : '-'
            ]);
        }
        
        fclose($output);
        exit();
    }

    // EXPORT PDF - HTML to PDF simple
    public function exportPdf(Request $request)
    {
        $query = InvAsset::with(['category', 'location']);

        if ($request->filled('search')) $query->search($request->search);
        if ($request->filled('area')) $query->byArea($request->area);
        if ($request->filled('building')) $query->byBuilding($request->building);
        if ($request->filled('room')) $query->byRoom($request->room);
        if ($request->filled('condition')) $query->byCondition($request->condition);
        if ($request->filled('status')) $query->byStatus($request->status);

        $assets = $query->latest()->get();

        return view('Inventory.asset_pdf', compact('assets'));
    }

    // PRINT
    public function print(Request $request)
    {
        $query = InvAsset::with(['category', 'location']);

        if ($request->filled('search')) $query->search($request->search);
        if ($request->filled('area')) $query->byArea($request->area);
        if ($request->filled('building')) $query->byBuilding($request->building);
        if ($request->filled('room')) $query->byRoom($request->room);
        if ($request->filled('condition')) $query->byCondition($request->condition);
        if ($request->filled('status')) $query->byStatus($request->status);

        $assets = $query->latest()->get();

        return view('Inventory.asset_print', compact('assets'));
    }

    public function movementForm($id)
    {
        $asset = InvAsset::with('location')->findOrFail($id);
        $locations = InvLocation::where('is_active', 1)->get();
        return view('Inventory.asset_movement_form', compact('asset', 'locations'));
    }

    public function movementStore(Request $request, $id)
    {
        $asset = InvAsset::findOrFail($id);

        $request->validate([
            'to_location_id' => 'required|exists:inv_locations,id',
            'movement_date' => 'required|date',
            'reason' => 'required'
        ]);

        InvMovement::create([
            'asset_id' => $asset->id,
            'from_location_id' => $asset->location_id,
            'to_location_id' => $request->to_location_id,
            'movement_date' => $request->movement_date,
            'reason' => $request->reason,
            'pic_name' => $request->pic_name ?? 'EDDY ADHA SAPUTRA',
            'received_by' => $request->received_by,
            'notes' => $request->notes
        ]);

        $asset->update(['location_id' => $request->to_location_id]);

        return redirect()->route('inventory.asset.show', $id)->with('success', 'Asset berhasil dipindahkan');
    }

    public function withdrawalList()
    {
        $damaged_assets = InvAsset::with('location')
            ->where('condition_status', 'RUSAK')
            ->where('operational_status', 'AKTIF')
            ->get();

        $withdrawn_assets = InvAsset::with(['location', 'withdrawals'])
            ->where('operational_status', 'DITARIK')
            ->get();

        return view('Inventory.asset_withdrawal_list', compact('damaged_assets', 'withdrawn_assets'));
    }

    public function withdrawalStore(Request $request, $id)
    {
        $asset = InvAsset::findOrFail($id);

        $request->validate([
            'withdrawal_date' => 'required|date',
            'reason' => 'required'
        ]);

        InvWithdrawal::create([
            'asset_id' => $asset->id,
            'withdrawal_date' => $request->withdrawal_date,
            'reason' => $request->reason,
            'condition_notes' => $request->condition_notes,
            'pic_name' => $request->pic_name ?? 'EDDY ADHA SAPUTRA',
            'approved_by' => $request->approved_by,
            'status' => 'DITARIK'
        ]);

        $asset->update(['operational_status' => 'DITARIK']);

        return redirect()->route('inventory.asset.withdrawal.list')->with('success', 'Asset berhasil ditarik');
    }
}
