@extends('layouts.app')

@section('title', 'Tambah Travel & Visitor')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0">Tambah Data</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('travel_visitor') }}">Travel & Visitor</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Travel & Visitor</h5>
    </div>
    <form id="formTravelVisitor" onsubmit="handleSubmit(event)">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="Masukkan nama">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Perusahaan</label>
                    <input type="text" name="company" class="form-control" placeholder="Masukkan perusahaan (opsional)">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipe <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required onchange="handleTypeChange(this)">
                        <option value="">Pilih Tipe</option>
                        <option value="Travel">Travel</option>
                        <option value="Visitor">Visitor</option>
                    </select>
                    <small class="text-muted">Travel = Perjalanan Dinas, Visitor = Tamu/Pengunjung</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                    <input type="date" name="visit_date" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Check In</label>
                    <input type="time" name="check_in" class="form-control">
                    <small class="text-muted">Waktu kedatangan (opsional)</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Check Out</label>
                    <input type="time" name="check_out" class="form-control">
                    <small class="text-muted">Waktu kepulangan (opsional)</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Keperluan <span class="text-danger">*</span></label>
                    <input type="text" name="purpose" class="form-control" required placeholder="Tujuan kunjungan">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" name="contact" class="form-control" placeholder="No HP / Email">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">PIC</label>
                    <input type="text" name="pic_name" class="form-control" placeholder="Nama PIC yang bertanggung jawab">
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" rows="3" class="form-control" placeholder="Catatan tambahan (opsional)"></textarea>
                </div>
            </div>

            <!-- Info Box -->
            <div class="alert alert-info">
                <strong><i class="bi bi-info-circle"></i> Tips Pengisian:</strong>
                <ul class="mb-0 mt-2">
                    <li><strong>Travel:</strong> Digunakan untuk perjalanan dinas karyawan</li>
                    <li><strong>Visitor:</strong> Digunakan untuk tamu dari luar perusahaan</li>
                    <li>Field bertanda <span class="text-danger">*</span> wajib diisi</li>
                    <li>Check In/Out bisa diisi nanti saat kedatangan/kepulangan</li>
                </ul>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ url('travel_visitor') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
function handleTypeChange(select) {
    const companyInput = document.querySelector('input[name="company"]');
    if(select.value === 'Travel') {
        companyInput.value = '';
        companyInput.placeholder = 'Tidak perlu diisi untuk Travel';
        companyInput.disabled = true;
    } else {
        companyInput.disabled = false;
        companyInput.placeholder = 'Masukkan perusahaan (opsional)';
    }
}

function handleSubmit(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData);
    
    console.log('Data yang akan disimpan:', data);
    
    alert('Data berhasil disimpan!\n\nNama: ' + data.name + '\nTipe: ' + data.type + '\nKeperluan: ' + data.purpose);
    
    // Redirect ke index
    window.location.href = '{{ url("travel_visitor") }}';
}

// Set tanggal hari ini sebagai default
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="visit_date"]').value = today;
});
</script>
@endsection
