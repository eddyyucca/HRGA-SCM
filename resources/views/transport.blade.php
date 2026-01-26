@extends('layouts.app')

@section('title', 'Laporan Transport')

@push('styles')
<style>
    .filter-card .form-label { font-size: 0.85rem; margin-bottom: 0.25rem; }
    .filter-card .form-select, .filter-card .btn { font-size: 0.85rem; }
    
    @media (max-width: 767.98px) {
        .filter-card .col-md-3 { margin-bottom: 0.5rem; }
        .export-buttons .btn { width: 100%; margin-bottom: 0.5rem; }
        .export-buttons .btn:last-child { margin-bottom: 0; }
    }
</style>
@endpush

@section('content-header')
    <div class="row align-items-center">
        <div class="col-sm-6 col-12">
            <h3 class="mb-0">Laporan Transport</h3>
        </div>
        <div class="col-sm-6 col-12">
            <ol class="breadcrumb float-sm-end mb-0 mt-2 mt-sm-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Transport</li>
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
                    <label class="form-label">Kendaraan</label>
                    <select class="form-select form-select-sm">
                        <option>Semua</option>
                        <option>B 1234 ABC</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label">Jenis</label>
                    <select class="form-select form-select-sm">
                        <option>BBM</option>
                        <option>Maintenance</option>
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
                    <i class="bi bi-fuel-pump-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total BBM</span>
                    <span class="info-box-number">2,450 L</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-success">
                    <i class="bi bi-cash-stack"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Biaya BBM</span>
                    <span class="info-box-number">Rp 32,5 Jt</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-warning">
                    <i class="bi bi-speedometer2"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total KM</span>
                    <span class="info-box-number">18,520</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-info">
                    <i class="bi bi-wrench-adjustable"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Maintenance</span>
                    <span class="info-box-number">Rp 15,8 Jt</span>
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
                        <i class="bi bi-bar-chart-fill me-2 text-primary"></i>BBM per Kendaraan
                    </h3>
                </div>
                <div class="card-body py-2">
                    <div id="chartBBM" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2">
                    <h3 class="card-title">
                        <i class="bi bi-pie-chart-fill me-2 text-success"></i>Distribusi Biaya
                    </h3>
                </div>
                <div class="card-body py-2">
                    <div id="chartBiaya" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trend Chart -->
    <div class="row g-2 g-md-3 mt-1">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header border-0 py-2">
                    <h3 class="card-title">
                        <i class="bi bi-graph-up me-2 text-info"></i>Trend 6 Bulan Terakhir
                    </h3>
                </div>
                <div class="card-body py-2">
                    <div id="chartTrend" style="height: 250px;"></div>
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
                        <i class="bi bi-table me-2"></i>Detail BBM
                    </h3>
                    <div class="export-buttons d-flex gap-2">
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
                                    <th>Tanggal</th>
                                    <th>Kendaraan</th>
                                    <th class="d-none d-md-table-cell">Driver</th>
                                    <th>Liter</th>
                                    <th class="d-none d-sm-table-cell">Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>26 Jan</td>
                                    <td>B 1234 ABC</td>
                                    <td class="d-none d-md-table-cell">Supardi</td>
                                    <td>45 L</td>
                                    <td class="d-none d-sm-table-cell">Rp 13.500</td>
                                    <td>Rp 607.500</td>
                                </tr>
                                <tr>
                                    <td>25 Jan</td>
                                    <td>B 5678 DEF</td>
                                    <td class="d-none d-md-table-cell">Joko</td>
                                    <td>50 L</td>
                                    <td class="d-none d-sm-table-cell">Rp 13.500</td>
                                    <td>Rp 675.000</td>
                                </tr>
                                <tr>
                                    <td>24 Jan</td>
                                    <td>B 9012 GHI</td>
                                    <td class="d-none d-md-table-cell">Ahmad</td>
                                    <td>60 L</td>
                                    <td class="d-none d-sm-table-cell">Rp 13.500</td>
                                    <td>Rp 810.000</td>
                                </tr>
                                <tr>
                                    <td>23 Jan</td>
                                    <td>B 3456 JKL</td>
                                    <td class="d-none d-md-table-cell">Budi</td>
                                    <td>40 L</td>
                                    <td class="d-none d-sm-table-cell">Rp 13.500</td>
                                    <td>Rp 540.000</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold table-light">
                                    <td colspan="3">Total</td>
                                    <td>195 L</td>
                                    <td class="d-none d-sm-table-cell">-</td>
                                    <td>Rp 2.632.500</td>
                                </tr>
                            </tfoot>
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
    
    // Chart BBM
    new ApexCharts(document.querySelector("#chartBBM"), {
        series: [{ name: 'Liter', data: [450, 380, 520, 290, 410, 350] }],
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        plotOptions: { bar: { borderRadius: 4, horizontal: true } },
        colors: ['#0d6efd'],
        dataLabels: { enabled: !isMobile, formatter: val => val + ' L' },
        xaxis: { categories: ['B 1234 ABC', 'B 5678 DEF', 'B 9012 GHI', 'B 3456 JKL', 'B 7890 MNO', 'B 2345 PQR'] },
        responsive: [{ breakpoint: 576, options: { chart: { height: 250 } } }]
    }).render();

    // Chart Biaya
    new ApexCharts(document.querySelector("#chartBiaya"), {
        series: [32.5, 15.8, 8.2, 3.5],
        chart: { type: 'pie', height: 300 },
        labels: ['BBM', 'Maintenance', 'Service', 'Lainnya'],
        colors: ['#0d6efd', '#198754', '#ffc107', '#6c757d'],
        legend: { position: 'bottom', fontSize: isMobile ? '10px' : '12px' },
        dataLabels: { enabled: !isMobile },
        responsive: [{ breakpoint: 576, options: { chart: { height: 250 } } }]
    }).render();

    // Chart Trend
    new ApexCharts(document.querySelector("#chartTrend"), {
        series: [
            { name: 'BBM', data: [28, 32, 30, 35, 33, 32.5] },
            { name: 'Maintenance', data: [12, 8, 15, 10, 18, 15.8] }
        ],
        chart: { type: 'area', height: 250, toolbar: { show: false } },
        colors: ['#0d6efd', '#198754'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.1 } },
        xaxis: { categories: ['Agt', 'Sep', 'Okt', 'Nov', 'Des', 'Jan'] },
        yaxis: { title: { text: isMobile ? '' : 'Juta (Rp)' } },
        legend: { position: 'top' },
        responsive: [{ breakpoint: 576, options: { chart: { height: 200 }, legend: { position: 'bottom' } } }]
    }).render();
});
</script>
@endpush