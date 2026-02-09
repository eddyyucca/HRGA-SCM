@extends('layouts.app')

@section('title', 'Inventory Dashboard')

@push('styles')
<style>
    .filter-card .form-label { font-size: 0.85rem; margin-bottom: 0.25rem; }
    .filter-card .form-select, .filter-card .btn { font-size: 0.85rem; }
    
    @media (max-width: 767.98px) {
        .filter-card .col-md-3 { margin-bottom: 0.5rem; }
    }
</style>
@endpush

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Inventory Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <!-- Filter -->
    <div class="card shadow-sm filter-card mb-3">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('inventory.dashboard') }}" id="filterForm">
                <div class="row g-2 align-items-end">
                    <div class="col-6 col-md-3">
                        <label class="form-label">Tipe Periode</label>
                        <select name="period_type" class="form-select form-select-sm" id="periodType" onchange="updatePeriodInput()">
                            <option value="weekly" {{ $periodType == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $periodType == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ $periodType == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label">Periode</label>
                        @if($periodType == 'weekly')
                            <input type="week" name="period" class="form-control form-control-sm" value="{{ $period }}" id="periodInput">
                        @elseif($periodType == 'yearly')
                            <input type="number" name="period" class="form-control form-control-sm" value="{{ $period }}" placeholder="2025" min="2020" max="2030" id="periodInput">
                        @else
                            <input type="month" name="period" class="form-control form-control-sm" value="{{ $period }}" id="periodInput">
                        @endif
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-select form-select-sm">
                            <option value="all" {{ $category == 'all' ? 'selected' : '' }}>Semua</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-filter me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ $totalItems }}</h3>
                    <p>Total Items</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-box-seam-fill"></i></div>
                <a href="{{ route('inventory.items.index') }}" class="small-box-footer link-light">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ number_format($barangMasuk) }}</h3>
                    <p>Barang Masuk</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-arrow-down-circle-fill"></i></div>
                <a href="{{ route('inventory.transactions.index', ['type' => 'in']) }}" class="small-box-footer link-light">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ number_format($barangKeluar) }}</h3>
                    <p>Barang Keluar</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-arrow-up-circle-fill"></i></div>
                <a href="{{ route('inventory.transactions.index', ['type' => 'out']) }}" class="small-box-footer link-dark">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box text-bg-danger">
                <div class="inner">
                    <h3>{{ $needReorder }}</h3>
                    <p>Need Reorder</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-cart-plus"></i></div>
                <a href="{{ route('inventory.items.index') }}" class="small-box-footer link-light">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="bi bi-bar-chart-fill me-2 text-primary"></i>Barang Masuk & Keluar 
                        @if($periodType == 'weekly')
                            (8 Minggu)
                        @elseif($periodType == 'yearly')
                            (5 Tahun)
                        @else
                            (6 Bulan)
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    <div id="chartMasukKeluar" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="bi bi-pie-chart-fill me-2 text-success"></i>Stock Per Kategori
                    </h3>
                </div>
                <div class="card-body">
                    <div id="chartKategori" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="bi bi-trophy me-2 text-warning"></i>Top 5 Barang Digunakan (3 Bulan)
                    </h3>
                </div>
                <div class="card-body">
                    <div id="chartTopUsed" style="height: 250px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="bi bi-graph-up me-2 text-info"></i>Trend Pengeluaran 
                        @if($periodType == 'weekly')
                            (8 Minggu)
                        @elseif($periodType == 'yearly')
                            (5 Tahun)
                        @else
                            (6 Bulan)
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    <div id="chartTrend" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Need Reorder & Recent Transactions -->
    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>Items Need Reorder
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Stock</th>
                                    <th>Reorder Point</th>
                                    <th>Days Left</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reorderItems as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->item_name }}</strong>
                                            <br><small class="text-muted">{{ $item->item_code }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">{{ $item->current_stock }}</span>
                                        </td>
                                        <td>{{ $item->reorder_point }}</td>
                                        <td>
                                            @if($item->daysUntilStockOut())
                                                <span class="badge bg-warning">{{ $item->daysUntilStockOut() }} days</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">
                                            <span class="text-success"><i class="bi bi-check-circle"></i> All items stock are safe</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Recent Transactions
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Item</th>
                                    <th>Type</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $trans)
                                    <tr>
                                        <td><small>{{ $trans->transaction_date->format('d M Y') }}</small></td>
                                        <td>
                                            <strong>{{ $trans->item->item_name }}</strong>
                                            <br><small class="text-muted">{{ $trans->transaction_code }}</small>
                                        </td>
                                        <td>
                                            @if($trans->type === 'in')
                                                <span class="badge bg-success">IN</span>
                                            @else
                                                <span class="badge bg-warning">OUT</span>
                                            @endif
                                        </td>
                                        <td>{{ $trans->quantity }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">No transactions yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
<script>
// Function to update period input based on type
function updatePeriodInput() {
    const periodType = document.getElementById('periodType').value;
    const periodInput = document.getElementById('periodInput');
    
    if (periodType === 'weekly') {
        periodInput.type = 'week';
        periodInput.value = '{{ now()->format("Y-\WW") }}';
    } else if (periodType === 'yearly') {
        periodInput.type = 'number';
        periodInput.value = '{{ now()->format("Y") }}';
        periodInput.min = '2020';
        periodInput.max = '2030';
        periodInput.placeholder = '2025';
    } else {
        periodInput.type = 'month';
        periodInput.value = '{{ now()->format("Y-m") }}';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var isMobile = window.innerWidth < 768;
    
    // Chart Masuk Keluar
    new ApexCharts(document.querySelector("#chartMasukKeluar"), {
        series: [
            { name: 'Masuk', data: @json($chartMasukKeluar['dataIn']) },
            { name: 'Keluar', data: @json($chartMasukKeluar['dataOut']) }
        ],
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        plotOptions: { bar: { columnWidth: '55%', borderRadius: 4 } },
        colors: ['#198754', '#ffc107'],
        dataLabels: { enabled: false },
        xaxis: { categories: @json($chartMasukKeluar['categories']) },
        legend: { position: 'top' },
        yaxis: { title: { text: 'Quantity' } },
        responsive: [{ breakpoint: 576, options: { chart: { height: 250 }, legend: { position: 'bottom' } } }]
    }).render();

    // Chart Kategori - FIXED
    const chartKategoriData = @json($chartKategori);
    
    if (chartKategoriData.series && chartKategoriData.series.length > 0) {
        new ApexCharts(document.querySelector("#chartKategori"), {
            series: chartKategoriData.series,
            chart: { type: 'donut', height: 300 },
            labels: chartKategoriData.labels,
            colors: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d', '#0dcaf0', '#d63384'],
            legend: { position: 'bottom', fontSize: isMobile ? '10px' : '12px' },
            plotOptions: { 
                pie: { 
                    donut: { 
                        size: '60%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Stock'
                            }
                        }
                    } 
                } 
            },
            dataLabels: { 
                enabled: true,
                formatter: function (val, opts) {
                    return opts.w.config.series[opts.seriesIndex]
                }
            },
            responsive: [{ breakpoint: 576, options: { chart: { height: 250 } } }]
        }).render();
    } else {
        document.querySelector("#chartKategori").innerHTML = '<div class="text-center py-5 text-muted">No data available</div>';
    }

    // Chart Top Used
    const chartTopUsedData = @json($chartTopUsed);
    
    if (chartTopUsedData.quantities && chartTopUsedData.quantities.length > 0) {
        new ApexCharts(document.querySelector("#chartTopUsed"), {
            series: [{ name: 'Quantity', data: chartTopUsedData.quantities }],
            chart: { type: 'bar', height: 250, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 4, horizontal: true } },
            colors: ['#0d6efd'],
            dataLabels: { enabled: !isMobile },
            xaxis: { 
                categories: chartTopUsedData.items,
                title: { text: 'Quantity Used' }
            },
            responsive: [{ breakpoint: 576, options: { chart: { height: 200 } } }]
        }).render();
    } else {
        document.querySelector("#chartTopUsed").innerHTML = '<div class="text-center py-5 text-muted">No data available</div>';
    }

    // Chart Trend
    new ApexCharts(document.querySelector("#chartTrend"), {
        series: [{ name: 'Pengeluaran', data: @json($chartTrend['data']) }],
        chart: { type: 'area', height: 250, toolbar: { show: false } },
        colors: ['#198754'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.5, opacityTo: 0.1 } },
        xaxis: { categories: @json($chartTrend['categories']) },
        yaxis: { title: { text: 'Quantity' } },
        responsive: [{ breakpoint: 576, options: { chart: { height: 200 } } }]
    }).render();
});
</script>
@endpush