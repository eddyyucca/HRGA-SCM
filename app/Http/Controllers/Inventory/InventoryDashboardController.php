<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\InventoryItem;
use App\Models\Inventory\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filter parameters
        $periodType = $request->get('period_type', 'monthly'); // weekly, monthly, yearly
        $period = $request->get('period', now()->format('Y-m'));
        $category = $request->get('category', 'all');
        
        // Parse period based on type
        if ($periodType === 'weekly') {
            // Format: 2025-W06
            $startDate = date('Y-m-d', strtotime($period));
            $endDate = date('Y-m-d', strtotime($period . ' +6 days'));
        } elseif ($periodType === 'yearly') {
            // Format: 2025
            $startDate = $period . '-01-01';
            $endDate = $period . '-12-31';
        } else {
            // Monthly (default) - Format: 2025-02
            $startDate = date('Y-m-01', strtotime($period));
            $endDate = date('Y-m-t', strtotime($period));
        }
        
        // Summary statistics
        $totalItems = InventoryItem::count();
        $totalStock = InventoryItem::sum('current_stock');
        
        $items = InventoryItem::all();
        $criticalStock = $items->filter(fn($item) => $item->getStockStatus() === 'critical')->count();
        $needReorder = $items->filter(fn($item) => $item->needsReorder())->count();
        
        // Barang masuk & keluar berdasarkan periode
        $barangMasuk = InventoryTransaction::where('type', 'in')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('quantity');
        
        $barangKeluar = InventoryTransaction::where('type', 'out')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('quantity');
        
        // Items need reorder
        $reorderItems = $items->filter(fn($item) => $item->needsReorder())
            ->sortBy(function($item) {
                return $item->daysUntilStockOut();
            })
            ->take(10);
        
        // Recent transactions
        $recentTransactions = InventoryTransaction::with('item')
            ->orderBy('transaction_date', 'desc')
            ->take(10)
            ->get();
        
        // Stock by category
        $stockByCategory = InventoryItem::select('category', DB::raw('SUM(current_stock) as total'))
            ->groupBy('category')
            ->get();
        
        // Charts data
        $chartMasukKeluar = $this->getInOutChart($periodType);
        $chartKategori = $this->getCategoryChart();
        $chartTopUsed = $this->getTopUsedChart();
        $chartTrend = $this->getTrendChart($periodType);
        
        // Kategori untuk filter
        $categories = InventoryItem::select('category')
            ->distinct()
            ->pluck('category');
        
        return view('inventory.dashboard', compact(
            'totalItems',
            'totalStock',
            'criticalStock',
            'needReorder',
            'barangMasuk',
            'barangKeluar',
            'reorderItems',
            'recentTransactions',
            'stockByCategory',
            'chartMasukKeluar',
            'chartKategori',
            'chartTopUsed',
            'chartTrend',
            'categories',
            'periodType',
            'period',
            'category'
        ));
    }
    
    private function getInOutChart($periodType = 'monthly')
    {
        $months = [];
        $dataIn = [];
        $dataOut = [];
        
        if ($periodType === 'weekly') {
            // Last 8 weeks
            for ($i = 7; $i >= 0; $i--) {
                $startDate = now()->subWeeks($i)->startOfWeek()->format('Y-m-d');
                $endDate = now()->subWeeks($i)->endOfWeek()->format('Y-m-d');
                
                $months[] = 'W' . now()->subWeeks($i)->format('W');
                
                $in = InventoryTransaction::where('type', 'in')
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->sum('quantity');
                
                $out = InventoryTransaction::where('type', 'out')
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->sum('quantity');
                
                $dataIn[] = $in;
                $dataOut[] = $out;
            }
        } elseif ($periodType === 'yearly') {
            // Last 5 years
            for ($i = 4; $i >= 0; $i--) {
                $year = now()->subYears($i)->format('Y');
                $startDate = $year . '-01-01';
                $endDate = $year . '-12-31';
                
                $months[] = $year;
                
                $in = InventoryTransaction::where('type', 'in')
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->sum('quantity');
                
                $out = InventoryTransaction::where('type', 'out')
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->sum('quantity');
                
                $dataIn[] = $in;
                $dataOut[] = $out;
            }
        } else {
            // Monthly - Last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $startDate = $date->copy()->startOfMonth()->format('Y-m-d');
                $endDate = $date->copy()->endOfMonth()->format('Y-m-d');
                
                $months[] = $date->format('M Y');
                
                $in = InventoryTransaction::where('type', 'in')
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->sum('quantity');
                
                $out = InventoryTransaction::where('type', 'out')
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->sum('quantity');
                
                $dataIn[] = $in;
                $dataOut[] = $out;
            }
        }
        
        return [
            'categories' => $months,
            'dataIn' => $dataIn,
            'dataOut' => $dataOut,
        ];
    }
    
    private function getCategoryChart()
    {
        $data = InventoryItem::select('category', DB::raw('SUM(current_stock) as total'))
            ->where('current_stock', '>', 0)
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();
        
        $labels = [];
        $series = [];
        
        foreach ($data as $item) {
            $labels[] = $item->category;
            $series[] = (int) $item->total;
        }
        
        return [
            'labels' => $labels,
            'series' => $series,
        ];
    }
    
    private function getTopUsedChart()
    {
        $threeMonthsAgo = now()->subMonths(3)->format('Y-m-d');
        
        $topUsed = InventoryTransaction::select('item_id', DB::raw('SUM(quantity) as total'))
            ->where('type', 'out')
            ->where('transaction_date', '>=', $threeMonthsAgo)
            ->groupBy('item_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        $items = [];
        $quantities = [];
        
        foreach ($topUsed as $record) {
            $item = InventoryItem::find($record->item_id);
            if ($item) {
                $items[] = $item->item_name;
                $quantities[] = $record->total;
            }
        }
        
        return [
            'items' => $items,
            'quantities' => $quantities,
        ];
    }
    
    private function getTrendChart($periodType = 'monthly')
    {
        $months = [];
        $dataOut = [];
        
        if ($periodType === 'weekly') {
            // Last 8 weeks
            for ($i = 7; $i >= 0; $i--) {
                $startDate = now()->subWeeks($i)->startOfWeek()->format('Y-m-d');
                $endDate = now()->subWeeks($i)->endOfWeek()->format('Y-m-d');
                
                $months[] = 'W' . now()->subWeeks($i)->format('W');
                
                $out = InventoryTransaction::where('type', 'out')
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->sum('quantity');
                
                $dataOut[] = $out;
            }
        } elseif ($periodType === 'yearly') {
            // Last 5 years
            for ($i = 4; $i >= 0; $i--) {
                $year = now()->subYears($i)->format('Y');
                $startDate = $year . '-01-01';
                $endDate = $year . '-12-31';
                
                $months[] = $year;
                
                $out = InventoryTransaction::where('type', 'out')
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->sum('quantity');
                
                $dataOut[] = $out;
            }
        } else {
            // Monthly - Last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $startDate = $date->copy()->startOfMonth()->format('Y-m-d');
                $endDate = $date->copy()->endOfMonth()->format('Y-m-d');
                
                $months[] = $date->format('M Y');
                
                $out = InventoryTransaction::where('type', 'out')
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->sum('quantity');
                
                $dataOut[] = $out;
            }
        }
        
        return [
            'categories' => $months,
            'data' => $dataOut,
        ];
    }
}