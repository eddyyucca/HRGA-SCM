<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\InventoryItem;
use App\Models\Inventory\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryTransaction::with('item')->orderBy('transaction_date', 'desc');
        
        if ($request->type) {
            $query->where('type', $request->type);
        }
        
        if ($request->item_id) {
            $query->where('item_id', $request->item_id);
        }
        
        if ($request->date_from) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        
        if ($request->date_to) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }
        
        $transactions = $query->paginate(20);
        $items = InventoryItem::where('status', 'active')->orderBy('item_name')->get();
        
        return view('inventory.transactions.index', compact('transactions', 'items'));
    }

    public function create()
    {
        $items = InventoryItem::where('status', 'active')->orderBy('item_name')->get();
        return view('inventory.transactions.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:inventory_items,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'reference_no' => 'nullable',
            'notes' => 'nullable',
            'pic' => 'required',
            'transaction_date' => 'required|date'
        ]);

        DB::beginTransaction();
        try {
            $item = InventoryItem::findOrFail($validated['item_id']);
            
            // Validasi stock untuk transaksi OUT
            if ($validated['type'] === 'out' && $item->current_stock < $validated['quantity']) {
                return back()->withErrors(['quantity' => 'Stock tidak mencukupi'])->withInput();
            }
            
            $stockBefore = $item->current_stock;
            
            // Update stock
            if ($validated['type'] === 'in') {
                $item->current_stock += $validated['quantity'];
            } else {
                $item->current_stock -= $validated['quantity'];
            }
            
            $stockAfter = $item->current_stock;
            
            // Generate transaction code
            $transactionCode = $this->generateTransactionCode($validated['type']);
            
            // Create transaction
            InventoryTransaction::create([
                'item_id' => $validated['item_id'],
                'transaction_code' => $transactionCode,
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reference_no' => $validated['reference_no'],
                'notes' => $validated['notes'],
                'pic' => $validated['pic'],
                'transaction_date' => $validated['transaction_date']
            ]);
            
            // Update average usage (untuk transaksi OUT)
            if ($validated['type'] === 'out') {
                $this->updateAverageUsage($item);
            }
            
            $item->save();
            
            DB::commit();
            
            return redirect()->route('inventory.transactions.index')
                ->with('success', 'Transaksi berhasil disimpan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    private function generateTransactionCode($type)
    {
        $prefix = $type === 'in' ? 'IN' : 'OUT';
        $date = date('Ymd');
        $count = InventoryTransaction::where('type', $type)
            ->whereDate('created_at', today())
            ->count() + 1;
        
        return sprintf('%s-%s-%04d', $prefix, $date, $count);
    }

    private function updateAverageUsage(InventoryItem $item)
    {
        // Ambil data transaksi OUT 3 bulan terakhir
        $threeMonthsAgo = now()->subMonths(3);
        $totalOut = InventoryTransaction::where('item_id', $item->id)
            ->where('type', 'out')
            ->where('transaction_date', '>=', $threeMonthsAgo)
            ->sum('quantity');
        
        // Hitung rata-rata per bulan
        $item->average_usage_per_month = $totalOut / 3;
        $item->reorder_point = $item->calculateReorderPoint();
    }

    public function show(InventoryTransaction $transaction)
    {
        $transaction->load('item');
        return view('inventory.transactions.show', compact('transaction'));
    }
}