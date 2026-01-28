@extends('layouts.app')

@section('title', 'Laporan Kontrak')

@push('styles')
<style>
    .filter-card .form-label { font-size: 0.85rem; margin-bottom: 0.25rem; }
    .filter-card .form-select, .filter-card .btn { font-size: 0.85rem; }
</style>
@endpush

@section('content-header')
    <div class="row align-items-center">
        <div class="col-sm-6 col-12"><h3 class="mb-0">Laporan Kontrak</h3></div>
        <div class="col-sm-6 col-12">
            <ol class="breadcrumb float-sm-end mb-0 mt-2 mt-sm-0">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Kontrak</li>
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
                    <label class="form-label">Tahun</label>
                    <select class="form-select form-select-sm"><option>2025</option><option>2024</option></select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select form-select-sm"><option>Semua</option><option>Aktif</option></select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label">Jenis</label>
                    <select class="form-select form-select-sm"><option>Semua</option><option>Jasa</option></select>
                </div>
                <div class="col-6 col-md-3">
                    <button class="btn btn-primary btn-sm w-100"><i class="bi bi-filter me-1"></i>Filter</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="row g-2 g-md-3">
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-primary"><i class="bi bi-file-earmark-text-fill"></i></span>
                <div class="info-box-content"><span class="info-box-text">Total</span><span class="info-box-number">32</span></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-success"><i class="bi bi-check-circle-fill"></i></span>
                <div class="info-box-content"><span class="info-box-text">Aktif</span><span class="info-box-number">24</span></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-warning"><i class="bi bi-clock-fill"></i></span>
                <div class="info-box-content"><span class="info-box-text">Akan Exp</span><span class="info-box-number">5</span></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-danger"><i class="bi bi-x-circle-fill"></i></span>
                <div class="info-box-content"><span class="info-box-text">Expired</span><span class="info-box-number">3</span></div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-2 g-md-3 mt-1">
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm"><div class="card-header border-0 py-2"><h3 class="card-title"><i class="bi bi-graph-up me-2 text-primary"></i>Nilai per Bulan</h3></div>
            <div class="card-body py-2"><div id="chartNilai" style="height:280px;"></div></div></div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm"><div class="card-header border-0 py-2"><h3 class="card-title"><i class="bi bi-pie-chart-fill me-2 text-success"></i>Per Jenis</h3></div>
            <div class="card-body py-2"><div id="chartJenis" style="height:280px;"></div></div></div>
        </div>
    </div>

    <!-- Table -->
    <div class="row g-2 g-md-3 mt-1 mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header border-0 py-2 d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="bi bi-table me-2"></i>Detail</h3>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success"><i class="bi bi-file-earmark-excel"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-file-earmark-pdf"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead><tr><th>Vendor</th><th class="d-none d-sm-table-cell">Jenis</th><th>Nilai</th><th>Status</th></tr></thead>
                            <tbody>
                                <tr><td>PT. Cleaning</td><td class="d-none d-sm-table-cell"><span class="badge text-bg-info">Jasa</span></td><td>Rp 240Jt</td><td><span class="badge text-bg-danger">3 Hari</span></td></tr>
                                <tr><td>CV. Security</td><td class="d-none d-sm-table-cell"><span class="badge text-bg-info">Jasa</span></td><td>Rp 360Jt</td><td><span class="badge text-bg-success">Aktif</span></td></tr>
                                <tr><td>PT. Catering</td><td class="d-none d-sm-table-cell"><span class="badge text-bg-info">Jasa</span></td><td>Rp 480Jt</td><td><span class="badge text-bg-success">Aktif</span></td></tr>
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
    new ApexCharts(document.querySelector("#chartNilai"), {
        series: [{ name: 'Pembayaran', data: [165, 172, 180, 175, 185, 180] }],
        chart: { type: 'area', height: 280, toolbar: { show: false } },
        colors: ['#0d6efd'], stroke: { curve: 'smooth', width: 2 },
        xaxis: { categories: ['Agt', 'Sep', 'Okt', 'Nov', 'Des', 'Jan'] }
    }).render();
    
    new ApexCharts(document.querySelector("#chartJenis"), {
        series: [15, 8, 9], chart: { type: 'donut', height: 280 },
        labels: ['Jasa', 'Sewa', 'Pengadaan'], colors: ['#0d6efd', '#198754', '#ffc107'],
        legend: { position: 'bottom' }
    }).render();
});
</script>
@endpush