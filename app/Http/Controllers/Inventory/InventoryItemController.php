<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryItemController extends Controller
{
    public function index()
    {
        $items = InventoryItem::orderBy('item_name')->get();
        
        $stats = [
            'total_items' => $items->count(),
            'critical_stock' => $items->filter(fn($item) => $item->getStockStatus() === 'critical')->count(),
            'low_stock' => $items->filter(fn($item) => $item->getStockStatus() === 'low')->count(),
            'need_reorder' => $items->filter(fn($item) => $item->needsReorder())->count()
        ];
        
        return view('inventory.items.index', compact('items', 'stats'));
    }

    public function create()
    {
        return view('inventory.items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_code' => 'required|unique:inventory_items',
            'item_name' => 'required',
            'category' => 'required',
            'unit' => 'required',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'average_usage_per_month' => 'required|numeric|min:0',
            'lead_time_days' => 'required|integer|min:1',
            'description' => 'nullable',
            'location' => 'nullable'
        ]);

        $item = InventoryItem::create($validated);
        $item->reorder_point = $item->calculateReorderPoint();
        $item->save();

        return redirect()->route('inventory.items.index')
            ->with('success', 'Item berhasil ditambahkan');
    }

    public function show(InventoryItem $item)
    {
        $transactions = $item->transactions()
            ->orderBy('transaction_date', 'desc')
            ->paginate(20);
            
        return view('inventory.items.show', compact('item', 'transactions'));
    }

    public function edit(InventoryItem $item)
    {
        return view('inventory.items.edit', compact('item'));
    }

    public function update(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'item_code' => 'required|unique:inventory_items,item_code,' . $item->id,
            'item_name' => 'required',
            'category' => 'required',
            'unit' => 'required',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'average_usage_per_month' => 'required|numeric|min:0',
            'lead_time_days' => 'required|integer|min:1',
            'description' => 'nullable',
            'location' => 'nullable',
            'status' => 'required|in:active,inactive'
        ]);

        $item->update($validated);
        $item->reorder_point = $item->calculateReorderPoint();
        $item->save();

        return redirect()->route('inventory.items.index')
            ->with('success', 'Item berhasil diupdate');
    }

    public function destroy(InventoryItem $item)
    {
        $item->delete();
        return redirect()->route('inventory.items.index')
            ->with('success', 'Item berhasil dihapus');
    }
}