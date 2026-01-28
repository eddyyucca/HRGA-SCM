@extends('layouts.app')

@section('title', 'Laporan Travel & Visitor')

@push('styles')
<style>
    .stat-card {
        border-left: 4px solid;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .stat-card.travel {
        border-left-color: #17a2b8;
    }
    .stat-card.visitor {
        border-left-color: #ffc107;
    }
    .stat-card.approved {
        border-left-color: #28a745;
    }
    .stat-card.pending {
        border-left-color: #6c757d;
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
    .filter-btn-group .btn {
        border-radius: 20px;
        padding: 8px 20px;
        font-size: 0.9rem;
    }
    .filter-btn-group .btn.active {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
    }
</style>
@endpush

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0"><i class="bi bi-graph-up"></i> Laporan Travel & Visitor</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Laporan</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
@php
// Data dummy untuk statistik
$stats = [
    'daily' => [
        'travel' => 3,
        'visitor' => 5,
        'approved' => 7,
        'pending' => 1,
        'total' => 8
    ],
    'weekly' => [
        'travel' => 15,
        'visitor' => 28,
        'approved' => 38,
        'pending' => 5,
        'total' => 43
    ],
    'monthly' => [
        'travel' => 45,
        'visitor' => 89,
        'approved' => 120,
        'pending' => 14,
        'total' => 134
    ]
];

// Data untuk chart (default: harian)
$chartData = [
    'daily' => [
        'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        'travel' => [2, 3, 1, 4, 3, 0, 0],
        'visitor' => [4, 6, 5, 7, 6, 0, 0]
    ],
    'weekly' => [
        'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        'travel' => [8, 12, 10, 15],
        'visitor' => [15, 20, 18, 28]
    ],
    'monthly' => [
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ago', 'Sep', 'Okt', 'Nov', 'Des'],
        'travel' => [30, 35, 40, 38, 45, 42, 48, 50, 45, 52, 48, 45],
        'visitor' => [60, 70, 75, 80, 89, 85, 90, 95, 92, 98, 94, 89]
    ]
];

// Data tabel
$recentData = [
    ['date' => '27 Jan 2025', 'name' => 'Budi Santoso', 'type' => 'Visitor', 'company' => 'PT Maju Jaya', 'purpose' => 'Meeting HRD', 'status' => 'Approved'],
    ['date' => '27 Jan 2025', 'name' => 'Siti Nurhaliza', 'type' => 'Visitor', 'company' => 'CV Berkah Abadi', 'purpose' => 'Presentasi', 'status' => 'Approved'],
    ['date' => '27 Jan 2025', 'name' => 'Ahmad Fauzi', 'type' => 'Travel', 'company' => '-', 'purpose' => 'Dinas Jakarta', 'status' => 'Approved'],
    ['date' => '26 Jan 2025', 'name' => 'Ratna Sari', 'type' => 'Visitor', 'company' => 'PT Digital Indonesia', 'purpose' => 'Audit Internal', 'status' => 'Approved'],
    ['date' => '26 Jan 2025', 'name' => 'Hendra Gunawan', 'type' => 'Travel', 'company' => '-', 'purpose' => 'Site Visit', 'status' => 'Approved'],
];
@endphp

<!-- Filter Periode -->
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h5 class="mb-0">Filter Periode</h5>
                <small class="text-muted">Pilih periode untuk melihat data</small>
            </div>
            <div class="filter-btn-group btn-group" role="group">
                <button type="button" class="btn btn-outline-primary active" onclick="changePeriod('daily')">
                    <i class="bi bi-calendar-day"></i> Harian
                </button>
                <button type="button" class="btn btn-outline-primary" onclick="changePeriod('weekly')">
                    <i class="bi bi-calendar-week"></i> Mingguan
                </button>
                <button type="button" class="btn btn-outline-primary" onclick="changePeriod('monthly')">
                    <i class="bi bi-calendar-month"></i> Bulanan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cards Statistik -->
<div class="row" id="statsCards">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card travel">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Travel</h6>
                        <h3 class="mb-0" id="stat-travel">{{ $stats['daily']['travel'] }}</h3>
                        <small class="text-muted">Perjalanan Dinas</small>
                    </div>
                    <div class="text-info" style="font-size: 2.5rem;">
                        <i class="bi bi-airplane"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card visitor">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Visitor</h6>
                        <h3 class="mb-0" id="stat-visitor">{{ $stats['daily']['visitor'] }}</h3>
                        <small class="text-muted">Tamu/Pengunjung</small>
                    </div>
                    <div class="text-warning" style="font-size: 2.5rem;">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card approved">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Approved</h6>
                        <h3 class="mb-0" id="stat-approved">{{ $stats['daily']['approved'] }}</h3>
                        <small class="text-muted">Disetujui</small>
                    </div>
                    <div class="text-success" style="font-size: 2.5rem;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card pending">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Pending</h6>
                        <h3 class="mb-0" id="stat-pending">{{ $stats['daily']['pending'] }}</h3>
                        <small class="text-muted">Menunggu</small>
                    </div>
                    <div class="text-secondary" style="font-size: 2.5rem;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row">
    <div class="col-lg-8 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-bar-chart-line"></i> Grafik Travel & Visitor</h5>
                <small class="text-muted" id="chartPeriodLabel">Periode: Harian (Minggu Ini)</small>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="travelVisitorChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Perbandingan Tipe</h5>
                <small class="text-muted" id="piePeriodLabel">Periode: Harian</small>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data Terbaru -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0"><i class="bi bi-table"></i> Data Terbaru</h5>
                <small class="text-muted">5 data terakhir</small>
            </div>
            <a href="{{ url('travel_visitor') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-eye"></i> Lihat Semua
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Perusahaan</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentData as $item)
                    <tr>
                        <td>{{ $item['date'] }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>
                            <span class="badge {{ $item['type'] == 'Travel' ? 'bg-info' : 'bg-warning' }}">
                                {{ $item['type'] }}
                            </span>
                        </td>
                        <td>{{ $item['company'] }}</td>
                        <td>{{ $item['purpose'] }}</td>
                        <td>
                            <span class="badge bg-success">{{ $item['status'] }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Data dari PHP
const statsData = @json($stats);
const chartDataAll = @json($chartData);
let currentPeriod = 'daily';

// Chart instances
let travelVisitorChart;
let pieChart;

// Initialize charts
document.addEventListener('DOMContentLoaded', function() {
    initTravelVisitorChart();
    initPieChart();
});

// Initialize Travel & Visitor Chart (Bar Chart)
function initTravelVisitorChart() {
    const ctx = document.getElementById('travelVisitorChart');
    const data = chartDataAll[currentPeriod];
    
    travelVisitorChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: 'Travel',
                    data: data.travel,
                    backgroundColor: 'rgba(23, 162, 184, 0.7)',
                    borderColor: 'rgba(23, 162, 184, 1)',
                    borderWidth: 2
                },
                {
                    label: 'Visitor',
                    data: data.visitor,
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

// Initialize Pie Chart
function initPieChart() {
    const ctx = document.getElementById('pieChart');
    const stats = statsData[currentPeriod];
    
    pieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Travel', 'Visitor'],
            datasets: [{
                data: [stats.travel, stats.visitor],
                backgroundColor: [
                    'rgba(23, 162, 184, 0.8)',
                    'rgba(255, 193, 7, 0.8)'
                ],
                borderColor: [
                    'rgba(23, 162, 184, 1)',
                    'rgba(255, 193, 7, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
}

// Change period function
function changePeriod(period) {
    currentPeriod = period;
    
    // Update active button
    document.querySelectorAll('.filter-btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.closest('button').classList.add('active');
    
    // Update statistics cards
    updateStats(period);
    
    // Update charts
    updateCharts(period);
    
    // Update period labels
    updatePeriodLabels(period);
}

// Update statistics cards
function updateStats(period) {
    const stats = statsData[period];
    document.getElementById('stat-travel').textContent = stats.travel;
    document.getElementById('stat-visitor').textContent = stats.visitor;
    document.getElementById('stat-approved').textContent = stats.approved;
    document.getElementById('stat-pending').textContent = stats.pending;
}

// Update charts
function updateCharts(period) {
    const data = chartDataAll[period];
    const stats = statsData[period];
    
    // Update bar chart
    travelVisitorChart.data.labels = data.labels;
    travelVisitorChart.data.datasets[0].data = data.travel;
    travelVisitorChart.data.datasets[1].data = data.visitor;
    travelVisitorChart.update();
    
    // Update pie chart
    pieChart.data.datasets[0].data = [stats.travel, stats.visitor];
    pieChart.update();
}

// Update period labels
function updatePeriodLabels(period) {
    const labels = {
        'daily': 'Harian (Minggu Ini)',
        'weekly': 'Mingguan (Bulan Ini)',
        'monthly': 'Bulanan (Tahun Ini)'
    };
    
    const periodText = {
        'daily': 'Harian',
        'weekly': 'Mingguan',
        'monthly': 'Bulanan'
    };
    
    document.getElementById('chartPeriodLabel').textContent = 'Periode: ' + labels[period];
    document.getElementById('piePeriodLabel').textContent = 'Periode: ' + periodText[period];
}
</script>
@endpush
