@extends('layouts.app')

@section('title', 'Laporan Inventory')

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
    <div class="row align-items-center">
        <div class="col-sm-6 col-12">
            <h3 class="mb-0">Laporan Inventory</h3>
        </div>
        <div class="col-sm-6 col-12">
            <ol class="breadcrumb float-sm-end mb-0 mt-2 mt-sm-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Inventory</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <!-- Filter -->
    <div class="card shadow-sm filter-card">
        <div class="card-body py-3">
            <div class="row g-2 align-items-end">
                <div class="col-6 col-md-3">
                    <label class="form-label">Periode</label>
                    <select class="form-select form-select-sm">
                        <option>Januari 2025</option>
                        <option>Desember 2024</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select form-select-sm">
                        <option>Semua</option>
                        <option>ATK</option>
                        <option>Cleaning</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label">Jenis</label>
                    <select class="form-select form-select-sm">
                        <option>Stok Barang</option>
                        <option>Barang Masuk</option>
                        <option>Barang Keluar</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <button class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-filter me-1"></i>Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-2 g-md-3">
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-primary">
                    <i class="bi bi-box-seam-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Item</span>
                    <span class="info-box-number">156</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-success">
                    <i class="bi bi-arrow-down-circle-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Barang Masuk</span>
                    <span class="info-box-number">Rp 45,2 Jt</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-warning">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Barang Keluar</span>
                    <span class="info-box-number">Rp 38,7 Jt</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Stok Menipis</span>
                    <span class="info-box-number">15 Item</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-2 g-md-3 mt-1">
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2">
                    <h3 class="card-title">
                        <i class="bi bi-bar-chart-fill me-2 text-primary"></i>Barang Masuk & Keluar
                    </h3>
                </div>
                <div class="card-body py-2">
                    <div id="chartMasukKeluar" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2">
                    <h3 class="card-title">
                        <i class="bi bi-pie-chart-fill me-2 text-success"></i>Per Kategori
                    </h3>
                </div>
                <div class="card-body py-2">
                    <div id="chartKategori" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Charts Row -->
    <div class="row g-2 g-md-3 mt-1">
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2">
                    <h3 class="card-title">
                        <i class="bi bi-trophy me-2 text-warning"></i>Top 5 Barang Digunakan
                    </h3>
                </div>
                <div class="card-body py-2">
                    <div id="chartTopUsed" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2">
                    <h3 class="card-title">
                        <i class="bi bi-graph-up me-2 text-info"></i>Trend Pengeluaran
                    </h3>
                </div>
                <div class="card-body py-2">
                    <div id="chartTrendInventory" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Table -->
    <div class="row g-2 g-md-3 mt-1 mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header border-0 py-2 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-table me-2"></i>Detail Stok
                    </h3>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success">
                            <i class="bi bi-file-earmark-excel me-1"></i><span class="d-none d-sm-inline">Excel</span>
                        </button>
                        <button class="btn btn-sm btn-danger">
                            <i class="bi bi-file-earmark-pdf me-1"></i><span class="d-none d-sm-inline">PDF</span>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th class="d-none d-md-table-cell">Min</th>
                                    <th class="d-none d-sm-table-cell">Nilai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Kertas A4 70gr</td>
                                    <td><span class="badge text-bg-primary">ATK</span></td>
                                    <td>5</td>
                                    <td class="d-none d-md-table-cell">20</td>
                                    <td class="d-none d-sm-table-cell">Rp 225.000</td>
                                    <td><span class="badge text-bg-danger">Menipis</span></td>
                                </tr>
                                <tr>
                                    <td>Pulpen Pilot</td>
                                    <td><span class="badge text-bg-primary">ATK</span></td>
                                    <td>150</td>
                                    <td class="d-none d-md-table-cell">50</td>
                                    <td class="d-none d-sm-table-cell">Rp 750.000</td>
                                    <td><span class="badge text-bg-success">Aman</span></td>
                                </tr>
                                <tr>
                                    <td>Hand Sanitizer</td>
                                    <td><span class="badge text-bg-success">Cleaning</span></td>
                                    <td>8</td>
                                    <td class="d-none d-md-table-cell">15</td>
                                    <td class="d-none d-sm-table-cell">Rp 280.000</td>
                                    <td><span class="badge text-bg-warning">Warning</span></td>
                                </tr>
                                <tr>
                                    <td>Kopi Sachet</td>
                                    <td><span class="badge text-bg-warning">Pantry</span></td>
                                    <td>200</td>
                                    <td class="d-none d-md-table-cell">100</td>
                                    <td class="d-none d-sm-table-cell">Rp 500.000</td>
                                    <td><span class="badge text-bg-success">Aman</span></td>
                                </tr>
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
document.addEventListener('DOMContentLoaded', function() {
    var isMobile = window.innerWidth < 768;
    
    // Chart Masuk Keluar
    new ApexCharts(document.querySelector("#chartMasukKeluar"), {
        series: [
            { name: 'Masuk', data: [35, 42, 38, 45, 50, 45.2] },
            { name: 'Keluar', data: [28, 35, 32, 40, 42, 38.7] }
        ],
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        plotOptions: { bar: { columnWidth: '55%', borderRadius: 4 } },
        colors: ['#198754', '#ffc107'],
        dataLabels: { enabled: false },
        xaxis: { categories: ['Agt', 'Sep', 'Okt', 'Nov', 'Des', 'Jan'] },
        legend: { position: 'top' },
        responsive: [{ breakpoint: 576, options: { chart: { height: 250 }, legend: { position: 'bottom' } } }]
    }).render();

    // Chart Kategori
    new ApexCharts(document.querySelector("#chartKategori"), {
        series: [45, 28, 22, 18, 12],
        chart: { type: 'donut', height: 300 },
        labels: ['ATK', 'Cleaning', 'Pantry', 'Elektronik', 'Lainnya'],
        colors: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d'],
        legend: { position: 'bottom', fontSize: isMobile ? '10px' : '12px' },
        plotOptions: { pie: { donut: { size: '60%' } } },
        responsive: [{ breakpoint: 576, options: { chart: { height: 250 } } }]
    }).render();

    // Chart Top Used
    new ApexCharts(document.querySelector("#chartTopUsed"), {
        series: [{ data: [320, 280, 245, 210, 185] }],
        chart: { type: 'bar', height: 250, toolbar: { show: false } },
        plotOptions: { bar: { borderRadius: 4, horizontal: true } },
        colors: ['#0d6efd'],
        dataLabels: { enabled: !isMobile },
        xaxis: { categories: ['Kertas A4', 'Tisu Meja', 'Kopi Sachet', 'Pulpen', 'Sanitizer'] },
        responsive: [{ breakpoint: 576, options: { chart: { height: 200 } } }]
    }).render();

    // Chart Trend
    new ApexCharts(document.querySelector("#chartTrendInventory"), {
        series: [{ name: 'Pengeluaran', data: [32, 38, 35, 42, 45, 38.7] }],
        chart: { type: 'area', height: 250, toolbar: { show: false } },
        colors: ['#198754'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.5, opacityTo: 0.1 } },
        xaxis: { categories: ['Agt', 'Sep', 'Okt', 'Nov', 'Des', 'Jan'] },
        responsive: [{ breakpoint: 576, options: { chart: { height: 200 } } }]
    }).render();
});
</script>
@endpush