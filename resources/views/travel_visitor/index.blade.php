@extends('layouts.app')

@section('title', 'Travel & Visitor')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0">Travel & Visitor Management</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Travel & Visitor</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="alert alert-success alert-dismissible fade show d-none" id="successAlert">
    <span id="successMessage"></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Travel & Visitor</h5>
            <a href="{{ url('travel_visitor/create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Data
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Perusahaan</th>
                        <th>Tipe</th>
                        <th>Tanggal</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $dummyData = [
                        [
                            'id' => 1,
                            'name' => 'Budi Santoso',
                            'company' => 'PT Maju Jaya',
                            'type' => 'Visitor',
                            'visit_date' => '27 Jan 2025',
                            'check_in' => '09:00',
                            'check_out' => '11:30',
                            'purpose' => 'Meeting dengan Manager HRD',
                            'contact' => '08123456789',
                            'pic_name' => 'Andi Wijaya',
                            'status' => 'Approved',
                            'notes' => 'Membawa proposal kerjasama'
                        ],
                        [
                            'id' => 2,
                            'name' => 'Siti Nurhaliza',
                            'company' => 'CV Berkah Abadi',
                            'type' => 'Visitor',
                            'visit_date' => '26 Jan 2025',
                            'check_in' => '10:30',
                            'check_out' => '12:00',
                            'purpose' => 'Presentasi Produk',
                            'contact' => '08234567890',
                            'pic_name' => 'Dewi Lestari',
                            'status' => 'Approved',
                            'notes' => 'Presentasi produk IT solution'
                        ],
                        [
                            'id' => 3,
                            'name' => 'Ahmad Fauzi',
                            'company' => '-',
                            'type' => 'Travel',
                            'visit_date' => '25 Jan 2025',
                            'check_in' => '08:00',
                            'check_out' => '-',
                            'purpose' => 'Perjalanan Dinas ke Jakarta',
                            'contact' => '08345678901',
                            'pic_name' => 'Rudi Hartono',
                            'status' => 'Approved',
                            'notes' => 'Kunjungan ke kantor pusat, estimasi kembali 2 hari'
                        ],
                        [
                            'id' => 4,
                            'name' => 'Ratna Sari',
                            'company' => 'PT Digital Indonesia',
                            'type' => 'Visitor',
                            'visit_date' => '24 Jan 2025',
                            'check_in' => '13:00',
                            'check_out' => '15:30',
                            'purpose' => 'Audit Internal',
                            'contact' => '08456789012',
                            'pic_name' => 'Bambang Susilo',
                            'status' => 'Approved',
                            'notes' => 'Audit sistem IT'
                        ],
                        [
                            'id' => 5,
                            'name' => 'Hendra Gunawan',
                            'company' => '-',
                            'type' => 'Travel',
                            'visit_date' => '23 Jan 2025',
                            'check_in' => '07:00',
                            'check_out' => '18:00',
                            'purpose' => 'Site Visit Project',
                            'contact' => '08567890123',
                            'pic_name' => 'Eko Prasetyo',
                            'status' => 'Approved',
                            'notes' => 'Monitoring project konstruksi'
                        ],
                        [
                            'id' => 6,
                            'name' => 'Lisa Permata',
                            'company' => 'PT Sejahtera Makmur',
                            'type' => 'Visitor',
                            'visit_date' => '22 Jan 2025',
                            'check_in' => '09:30',
                            'check_out' => '10:30',
                            'purpose' => 'Interview Kandidat',
                            'contact' => '08678901234',
                            'pic_name' => 'Dini Astuti',
                            'status' => 'Approved',
                            'notes' => 'Interview posisi Software Engineer'
                        ],
                        [
                            'id' => 7,
                            'name' => 'Yusuf Rahman',
                            'company' => 'CV Karya Mandiri',
                            'type' => 'Visitor',
                            'visit_date' => '21 Jan 2025',
                            'check_in' => '14:00',
                            'check_out' => '16:00',
                            'purpose' => 'Diskusi Partnership',
                            'contact' => '08789012345',
                            'pic_name' => 'Fitri Handayani',
                            'status' => 'Pending',
                            'notes' => 'Menunggu konfirmasi jadwal'
                        ],
                        [
                            'id' => 8,
                            'name' => 'Diana Kusuma',
                            'company' => '-',
                            'type' => 'Travel',
                            'visit_date' => '20 Jan 2025',
                            'check_in' => '06:30',
                            'check_out' => '-',
                            'purpose' => 'Training di Surabaya',
                            'contact' => '08890123456',
                            'pic_name' => 'Agus Salim',
                            'status' => 'Approved',
                            'notes' => 'Training manajemen project 3 hari'
                        ],
                        [
                            'id' => 9,
                            'name' => 'Ridwan Kamil',
                            'company' => 'PT Solusi Prima',
                            'type' => 'Visitor',
                            'visit_date' => '19 Jan 2025',
                            'check_in' => '11:00',
                            'check_out' => '13:00',
                            'purpose' => 'Technical Support',
                            'contact' => '08901234567',
                            'pic_name' => 'Indra Gunawan',
                            'status' => 'Approved',
                            'notes' => 'Maintenance server'
                        ],
                        [
                            'id' => 10,
                            'name' => 'Maya Anggraini',
                            'company' => 'PT Teknologi Nusantara',
                            'type' => 'Visitor',
                            'visit_date' => '18 Jan 2025',
                            'check_in' => '10:00',
                            'check_out' => '11:00',
                            'purpose' => 'Demo Software',
                            'contact' => '08012345678',
                            'pic_name' => 'Rina Wahyuni',
                            'status' => 'Rejected',
                            'notes' => 'Jadwal bentrok, reschedule'
                        ]
                    ];
                    @endphp

                    @foreach($dummyData as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['company'] }}</td>
                        <td>
                            <span class="badge {{ $item['type'] == 'Travel' ? 'bg-info' : 'bg-warning' }}">
                                {{ $item['type'] }}
                            </span>
                        </td>
                        <td>{{ $item['visit_date'] }}</td>
                        <td>{{ $item['purpose'] }}</td>
                        <td>
                            <span class="badge {{ $item['status'] == 'Approved' ? 'bg-success' : ($item['status'] == 'Rejected' ? 'bg-danger' : 'bg-secondary') }}">
                                {{ $item['status'] }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ url('travel_visitor/edit') }}" class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $item['id'] }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div>Menampilkan 1 - 10 dari 10 data</div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if(confirm('Yakin hapus data ini?')) {
        alert('Data dengan ID ' + id + ' berhasil dihapus!');
        document.getElementById('successMessage').textContent = 'Data berhasil dihapus';
        document.getElementById('successAlert').classList.remove('d-none');
    }
}
</script>
@endsection
