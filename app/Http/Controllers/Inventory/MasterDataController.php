<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\InvCategory;
use App\Models\Inventory\InvLocation;

class MasterDataController extends Controller
{
    // ==========================================
    // CATEGORY MASTER
    // ==========================================
    public function categoryIndex()
    {
        $categories = InvCategory::withCount('assets')->paginate(20);
        return view('Inventory.master_category', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:inv_categories,code|max:20',
            'name' => 'required|max:100'
        ]);

        InvCategory::create($request->all());

        return redirect()->route('inventory.master.category')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = InvCategory::findOrFail($id);

        $request->validate([
            'code' => 'required|max:20|unique:inv_categories,code,'.$id,
            'name' => 'required|max:100'
        ]);

        $category->update($request->all());

        return redirect()->route('inventory.master.category')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function categoryDestroy($id)
    {
        $category = InvCategory::findOrFail($id);

        if ($category->assets()->count() > 0) {
            return redirect()->route('inventory.master.category')
                ->with('error', 'Kategori tidak bisa dihapus karena masih ada asset yang menggunakan');
        }

        $category->delete();

        return redirect()->route('inventory.master.category')
            ->with('success', 'Kategori berhasil dihapus');
    }

    // ==========================================
    // LOCATION MASTER
    // ==========================================
    public function locationIndex()
    {
        $locations = InvLocation::withCount('assets')->paginate(20);
        return view('Inventory.master_location', compact('locations'));
    }

    public function locationStore(Request $request)
    {
        $request->validate([
            'area' => 'required|max:100',
            'building' => 'required|max:100',
            'room' => 'required|max:100'
        ]);

        InvLocation::create($request->all());

        return redirect()->route('inventory.master.location')
            ->with('success', 'Lokasi berhasil ditambahkan');
    }

    public function locationUpdate(Request $request, $id)
    {
        $location = InvLocation::findOrFail($id);

        $request->validate([
            'area' => 'required|max:100',
            'building' => 'required|max:100',
            'room' => 'required|max:100'
        ]);

        $location->update($request->all());

        return redirect()->route('inventory.master.location')
            ->with('success', 'Lokasi berhasil diupdate');
    }

    public function locationDestroy($id)
    {
        $location = InvLocation::findOrFail($id);

        if ($location->assets()->count() > 0) {
            return redirect()->route('inventory.master.location')
                ->with('error', 'Lokasi tidak bisa dihapus karena masih ada asset yang menggunakan');
        }

        $location->delete();

        return redirect()->route('inventory.master.location')
            ->with('success', 'Lokasi berhasil dihapus');
    }
}
