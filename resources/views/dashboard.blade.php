@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* Base Styles */
    .info-box { min-height: 80px; }
    .info-box .info-box-icon { 
        width: 70px; 
        height: 70px; 
        font-size: 1.6rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .info-box-content { 
        padding: 8px 10px;
        overflow: hidden;
    }
    .info-box-text {
        font-size: 0.85rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .info-box-number {
        font-size: 1.4rem;
        font-weight: 700;
    }
    
    .small-box { min-height: 120px; }
    .small-box .inner h3 { 
        font-size: 2rem; 
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .small-box .inner p {
        font-size: 0.9rem;
        margin-bottom: 0;
    }
    .small-box .small-box-icon {
        font-size: 4rem;
        opacity: 0.3;
    }
    
    .card { margin-bottom: 1rem; }
    .card-title { 
        font-weight: 600; 
        font-size: 0.95rem;
        margin-bottom: 0;
    }
    
    .table th { 
        font-weight: 600; 
        background: #f8f9fa; 
        font-size: 0.85rem;
        white-space: nowrap;
    }
    .table td {
        font-size: 0.85rem;
        vertical-align: middle;
    }
    
    .badge { font-weight: 500; }
    
    .list-group-item {
        padding: 0.75rem 1rem;
    }
    
    /* Responsive Styles */
    @media (max-width: 991.98px) {
        .small-box .inner h3 { font-size: 1.6rem; }
        .small-box .small-box-icon { font-size: 3rem; }
        .info-box .info-box-icon { width: 60px; height: 60px; font-size: 1.4rem; }
        .info-box-number { font-size: 1.2rem; }
    }
    
    @media (max-width: 767.98px) {
        .small-box { min-height: 100px; }
        .small-box .inner h3 { font-size: 1.4rem; }
        .small-box .inner p { font-size: 0.8rem; }
        .small-box .small-box-icon { font-size: 2.5rem; }
        
        .info-box { min-height: 70px; }
        .info-box .info-box-icon { width: 50px; height: 50px; font-size: 1.2rem; }
        .info-box-text { font-size: 0.75rem; }
        .info-box-number { font-size: 1rem; }
        
        .card-title { font-size: 0.85rem; }
        .table th, .table td { font-size: 0.75rem; padding: 0.5rem; }
        
        /* Horizontal scroll untuk tabel di mobile */
        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table-responsive-custom table {
            min-width: 500px;
        }
        
        .list-group-item { padding: 0.5rem 0.75rem; }
        .list-group-item .small { font-size: 0.7rem; }
    }
    
    @media (max-width: 575.98px) {
        .content-header h3 { font-size: 1.2rem; }
        .breadcrumb { font-size: 0.75rem; }
        
        .small-box .inner h3 { font-size: 1.2rem; }
        .small-box .small-box-footer { font-size: 0.75rem; padding: 3px 0; }
        
        .btn-sm { font-size: 0.7rem; padding: 0.2rem 0.5rem; }
        .badge { font-size: 0.65rem; }
        
        .card-tools .badge { display: none; }
    }
</style>
@endpush

@section('content-header')
    <div class="row align-items-center">
        <div class="col-sm-6 col-12">
            <h3 class="mb-0">Dashboard General Affairs</h3>
        </div>
        <div class="col-sm-6 col-12">
            <ol class="breadcrumb float-sm-end mb-0 mt-2 mt-sm-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <!-- Summary Cards -->
    <div class="row g-2 g-md-3">
        <div class="col-6 col-lg-3">
            <div class="small-box text-bg-primary shadow-sm">
                <div class="inner">
                    <h3>12</h3>
                    <p>Total Kendaraan</p>
                </div>
                <i class="small-box-icon bi bi-car-front-fill"></i>
                <a href="{{ url('/transport/kendaraan') }}" class="small-box-footer">
                    Detail <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="small-box text-bg-success shadow-sm">
                <div class="inner">
                    <h3>24</h3>
                    <p>Kontrak Aktif</p>
                </div>
                <i class="small-box-icon bi bi-file-earmark-check-fill"></i>
                <a href="{{ url('/kontrak') }}" class="small-box-footer">
                    Detail <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="small-box text-bg-warning shadow-sm">
                <div class="inner">
                    <h3>156</h3>
                    <p>Item Inventory</p>
                </div>
                <i class="small-box-icon bi bi-box-seam-fill"></i>
                <a href="{{ url('/inventory/barang') }}" class="small-box-footer">
                    Detail <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="small-box text-bg-info shadow-sm">
                <div class="inner">
                    <h3>5</h3>
                    <p>Visitor Hari Ini</p>
                </div>
                <i class="small-box-icon bi bi-people-fill"></i>
                <a href="{{ url('/travel/visitor/log') }}" class="small-box-footer">
                    Detail <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Cards -->
    <div class="row g-2 g-md-3 mt-1">
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Kontrak Exp.</span>
                    <span class="info-box-number">3</span>
                    <small class="text-danger d-none d-sm-block">Bulan ini</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-warning">
                    <i class="bi bi-arrow-repeat"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Kendaraan Dipinjam</span>
                    <span class="info-box-number">4 <small class="fw-normal text-muted">/ 12</small></span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-info">
                    <i class="bi bi-ticket-detailed-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Tiket Pending</span>
                    <span class="info-box-number">8</span>
                    <small class="text-muted d-none d-sm-block">Menunggu</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-box shadow-sm mb-0">
                <span class="info-box-icon text-bg-secondary">
                    <i class="bi bi-archive-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Stok Menipis</span>
                    <span class="info-box-number">15</span>
                    <small class="text-danger d-none d-sm-block">Restock</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-2 g-md-3 mt-1">
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2">
                    <h3 class="card-title">
                        <i class="bi bi-graph-up me-2 text-primary"></i>Pengeluaran Bulanan
                    </h3>
                </div>
                <div class="card-body py-2">
                    <div id="chartPengeluaran" style="height: 280px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2">
                    <h3 class="card-title">
                        <i class="bi bi-pie-chart-fill me-2 text-success"></i>Kategori Inventory
                    </h3>
                </div>
                <div class="card-body py-2">
                    <div id="chartInventory" style="height: 280px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row g-2 g-md-3 mt-1">
        <!-- Peminjaman Kendaraan -->
        <div class="col-12 col-xl-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2 d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-car-front me-2 text-primary"></i>
                        <span class="d-none d-sm-inline">Peminjaman Kendaraan</span>
                        <span class="d-sm-none">Kendaraan</span>
                    </h3>
                    <span class="badge text-bg-primary">4 Aktif</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-custom">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No. Polisi</th>
                                    <th>Peminjam</th>
                                    <th class="d-none d-md-table-cell">Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="bi bi-car-front text-muted me-1 d-none d-sm-inline"></i>B 1234 ABC</td>
                                    <td>Ahmad Fauzi</td>
                                    <td class="d-none d-md-table-cell">28 Jan 2025</td>
                                    <td><span class="badge text-bg-success">On Time</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-car-front text-muted me-1 d-none d-sm-inline"></i>B 5678 DEF</td>
                                    <td>Siti Rahayu</td>
                                    <td class="d-none d-md-table-cell">27 Jan 2025</td>
                                    <td><span class="badge text-bg-danger">Terlambat</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-truck text-muted me-1 d-none d-sm-inline"></i>B 9012 GHI</td>
                                    <td>Budi Santoso</td>
                                    <td class="d-none d-md-table-cell">30 Jan 2025</td>
                                    <td><span class="badge text-bg-success">On Time</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-car-front text-muted me-1 d-none d-sm-inline"></i>B 3456 JKL</td>
                                    <td>Dewi Lestari</td>
                                    <td class="d-none d-md-table-cell">29 Jan 2025</td>
                                    <td><span class="badge text-bg-success">On Time</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center py-2">
                    <a href="{{ url('/transport/kendaraan/peminjaman') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Request Tiket -->
        <div class="col-12 col-xl-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2 d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-airplane me-2 text-info"></i>
                        <span class="d-none d-sm-inline">Request Tiket Pending</span>
                        <span class="d-sm-none">Tiket</span>
                    </h3>
                    <span class="badge text-bg-info">8 Pending</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-custom">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Pemohon</th>
                                    <th>Rute</th>
                                    <th class="d-none d-md-table-cell">Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Rina Wati</td>
                                    <td><i class="bi bi-geo-alt text-muted me-1 d-none d-sm-inline"></i>JKT - SUB</td>
                                    <td class="d-none d-md-table-cell">01 Feb 2025</td>
                                    <td><span class="badge text-bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>Hendra W.</td>
                                    <td><i class="bi bi-geo-alt text-muted me-1 d-none d-sm-inline"></i>JKT - DPS</td>
                                    <td class="d-none d-md-table-cell">03 Feb 2025</td>
                                    <td><span class="badge text-bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>Maya Sari</td>
                                    <td><i class="bi bi-geo-alt text-muted me-1 d-none d-sm-inline"></i>JKT - KNO</td>
                                    <td class="d-none d-md-table-cell">05 Feb 2025</td>
                                    <td><span class="badge text-bg-info">Diproses</span></td>
                                </tr>
                                <tr>
                                    <td>Agus P.</td>
                                    <td><i class="bi bi-geo-alt text-muted me-1 d-none d-sm-inline"></i>JKT - UPG</td>
                                    <td class="d-none d-md-table-cell">02 Feb 2025</td>
                                    <td><span class="badge text-bg-warning">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center py-2">
                    <a href="{{ url('/travel/ticketing/request') }}" class="btn btn-sm btn-outline-info">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Lists Row -->
    <div class="row g-2 g-md-3 mt-1">
        <!-- Kontrak Akan Expired -->
        <div class="col-12 col-xl-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 bg-danger text-white py-2">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2"></i>Kontrak Akan Expired
                    </h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-1">
                            <div class="text-truncate" style="max-width: 70%;">
                                <i class="bi bi-building text-primary me-1 d-none d-sm-inline"></i>
                                <strong>PT. Cleaning Service Bersih</strong>
                                <div class="text-muted small text-truncate">Jasa Kebersihan Gedung</div>
                            </div>
                            <span class="badge text-bg-danger rounded-pill">3 Hari</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-1">
                            <div class="text-truncate" style="max-width: 70%;">
                                <i class="bi bi-shield-check text-success me-1 d-none d-sm-inline"></i>
                                <strong>CV. Security Prima</strong>
                                <div class="text-muted small text-truncate">Jasa Keamanan</div>
                            </div>
                            <span class="badge text-bg-warning rounded-pill">15 Hari</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-1">
                            <div class="text-truncate" style="max-width: 70%;">
                                <i class="bi bi-cup-hot text-warning me-1 d-none d-sm-inline"></i>
                                <strong>PT. Catering Sehat</strong>
                                <div class="text-muted small text-truncate">Jasa Katering Kantor</div>
                            </div>
                            <span class="badge text-bg-secondary rounded-pill">25 Hari</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-transparent text-center py-2">
                    <a href="{{ url('/kontrak/reminder') }}" class="btn btn-sm btn-outline-danger">
                        Lihat Reminder <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="col-12 col-xl-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 bg-warning py-2">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-exclamation-diamond me-2"></i>Stok Inventory Menipis
                    </h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-1">
                            <div class="text-truncate" style="max-width: 70%;">
                                <i class="bi bi-file-earmark text-secondary me-1 d-none d-sm-inline"></i>
                                <strong>Kertas A4 70gr</strong>
                                <div class="text-muted small">ATK</div>
                            </div>
                            <span class="badge text-bg-danger rounded-pill">5 Rim</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-1">
                            <div class="text-truncate" style="max-width: 70%;">
                                <i class="bi bi-printer text-info me-1 d-none d-sm-inline"></i>
                                <strong>Tinta Printer HP 680</strong>
                                <div class="text-muted small">ATK</div>
                            </div>
                            <span class="badge text-bg-danger rounded-pill">2 Pcs</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-1">
                            <div class="text-truncate" style="max-width: 70%;">
                                <i class="bi bi-droplet text-primary me-1 d-none d-sm-inline"></i>
                                <strong>Hand Sanitizer 500ml</strong>
                                <div class="text-muted small">Cleaning</div>
                            </div>
                            <span class="badge text-bg-warning rounded-pill">8 Btl</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-transparent text-center py-2">
                    <a href="{{ url('/inventory/barang') }}" class="btn btn-sm btn-outline-warning">
                        Lihat Barang <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="row g-2 g-md-3 mt-1 mb-3">
        <!-- Visitor Hari Ini -->
        <div class="col-12 col-xl-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2 d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-person-badge me-2 text-success"></i>Visitor Hari Ini
                    </h3>
                    <span class="badge text-bg-success">5 Orang</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-custom">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th class="d-none d-sm-table-cell">Instansi</th>
                                    <th>Keperluan</th>
                                    <th>Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="bi bi-person-circle text-muted me-1 d-none d-md-inline"></i>John Doe</td>
                                    <td class="d-none d-sm-table-cell">PT. Vendor ABC</td>
                                    <td>Meeting</td>
                                    <td><span class="badge bg-light text-dark">08:30</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-person-circle text-muted me-1 d-none d-md-inline"></i>Jane Smith</td>
                                    <td class="d-none d-sm-table-cell">CV. Supplier XYZ</td>
                                    <td>Delivery</td>
                                    <td><span class="badge bg-light text-dark">09:15</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-person-circle text-muted me-1 d-none d-md-inline"></i>Robert Lee</td>
                                    <td class="d-none d-sm-table-cell">PT. Konsultan</td>
                                    <td>Audit</td>
                                    <td><span class="badge bg-light text-dark">10:00</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center py-2">
                    <a href="{{ url('/travel/visitor/log') }}" class="btn btn-sm btn-outline-success">
                        Lihat Log <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Jadwal Maintenance -->
        <div class="col-12 col-xl-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 py-2 d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-wrench-adjustable me-2 text-secondary"></i>Jadwal Maintenance
                    </h3>
                    <span class="badge text-bg-secondary">Minggu Ini</span>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                            <div class="text-truncate">
                                <i class="bi bi-car-front text-primary me-1"></i>
                                <strong>B 1234 ABC</strong>
                                <span class="text-muted d-none d-sm-inline">- Service Rutin</span>
                            </div>
                            <span class="badge bg-light text-dark">Sen, 27</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                            <div class="text-truncate">
                                <i class="bi bi-snow text-info me-1"></i>
                                <strong>AC Lt.3</strong>
                                <span class="text-muted d-none d-sm-inline">- Cleaning</span>
                            </div>
                            <span class="badge bg-light text-dark">Sel, 28</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                            <div class="text-truncate">
                                <i class="bi bi-car-front text-primary me-1"></i>
                                <strong>B 5678 DEF</strong>
                                <span class="text-muted d-none d-sm-inline">- Ganti Oli</span>
                            </div>
                            <span class="badge bg-light text-dark">Rab, 29</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                            <div class="text-truncate">
                                <i class="bi bi-building text-success me-1"></i>
                                <strong>Lift Gedung A</strong>
                                <span class="text-muted d-none d-sm-inline">- Inspeksi</span>
                            </div>
                            <span class="badge bg-light text-dark">Kam, 30</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-transparent text-center py-2">
                    <a href="{{ url('/transport/kendaraan/maintenance') }}" class="btn btn-sm btn-outline-secondary">
                        Lihat Jadwal <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Responsive chart options
    var isMobile = window.innerWidth < 768;
    
    // Chart Pengeluaran Bulanan
    var optionsPengeluaran = {
        series: [{
            name: 'Transport',
            data: [28, 35, 32, 45, 40, 52]
        }, {
            name: 'Inventory',
            data: [15, 22, 18, 25, 20, 28]
        }, {
            name: 'Kontrak',
            data: [45, 45, 50, 50, 55, 55]
        }],
        chart: {
            type: 'bar',
            height: 280,
            toolbar: { show: false },
            fontFamily: 'Source Sans 3, sans-serif'
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: isMobile ? '70%' : '55%',
                borderRadius: 4
            },
        },
        dataLabels: { enabled: false },
        colors: ['#0d6efd', '#198754', '#ffc107'],
        xaxis: {
            categories: ['Agt', 'Sep', 'Okt', 'Nov', 'Des', 'Jan'],
            labels: { style: { fontSize: isMobile ? '10px' : '12px' } }
        },
        yaxis: {
            title: { 
                text: isMobile ? '' : 'Juta (Rp)',
                style: { fontSize: '11px' }
            },
            labels: { style: { fontSize: isMobile ? '10px' : '12px' } }
        },
        legend: {
            position: 'top',
            fontSize: isMobile ? '10px' : '12px',
            itemMargin: { horizontal: 8 }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "Rp " + val + " Jt"
                }
            }
        },
        responsive: [{
            breakpoint: 576,
            options: {
                legend: { position: 'bottom' }
            }
        }]
    };
    var chartPengeluaran = new ApexCharts(document.querySelector("#chartPengeluaran"), optionsPengeluaran);
    chartPengeluaran.render();

    // Chart Kategori Inventory
    var optionsInventory = {
        series: [45, 30, 25, 20, 15],
        chart: {
            type: 'donut',
            height: 280,
            fontFamily: 'Source Sans 3, sans-serif'
        },
        labels: ['ATK', 'Cleaning', 'Pantry', 'Elektronik', 'Lainnya'],
        colors: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d'],
        legend: {
            position: 'bottom',
            fontSize: isMobile ? '10px' : '12px'
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '60%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: isMobile ? '12px' : '14px',
                            formatter: function() {
                                return '156'
                            }
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: !isMobile,
            formatter: function(val) {
                return Math.round(val) + '%'
            },
            style: { fontSize: '11px' }
        },
        responsive: [{
            breakpoint: 576,
            options: {
                chart: { height: 250 },
                legend: { fontSize: '10px' }
            }
        }]
    };
    var chartInventory = new ApexCharts(document.querySelector("#chartInventory"), optionsInventory);
    chartInventory.render();
    
    // Resize charts on window resize
    window.addEventListener('resize', function() {
        chartPengeluaran.updateOptions({
            plotOptions: {
                bar: { columnWidth: window.innerWidth < 768 ? '70%' : '55%' }
            }
        });
    });
});
</script>
@endpush