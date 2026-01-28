@extends('layouts.app')

@section('title', 'Edit Travel & Visitor')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0">Edit Data</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('travel_visitor') }}">Travel & Visitor</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
@php
// Data dummy untuk edit (seolah-olah data dengan ID tertentu)
$editData = [
    'id' => 1,
    'name' => 'Budi Santoso',
    'company' => 'PT Maju Jaya',
    'type' => 'Visitor',
    'visit_date' => '2025-01-27',
    'check_in' => '09:00',
    'check_out' => '11:30',
    'purpose' => 'Meeting dengan Manager HRD',
    'contact' => '08123456789',
    'pic_name' => 'Andi Wijaya',
    'status' => 'Approved',
    'notes' => 'Membawa proposal kerjasama'
];
@endphp

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Travel & Visitor</h5>
    </div>
    <form id="formEditTravelVisitor" onsubmit="handleUpdate(event)">
        <input type="hidden" name="id" value="{{ $editData['id'] }}">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ $editData['name'] }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Perusahaan</label>
                    <input type="text" name="company" class="form-control" value="{{ $editData['company'] }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipe <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Travel" {{ $editData['type'] == 'Travel' ? 'selected' : '' }}>Travel</option>
                        <option value="Visitor" {{ $editData['type'] == 'Visitor' ? 'selected' : '' }}>Visitor</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                    <input type="date" name="visit_date" class="form-control" value="{{ $editData['visit_date'] }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Check In</label>
                    <input type="time" name="check_in" class="form-control" value="{{ $editData['check_in'] }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Check Out</label>
                    <input type="time" name="check_out" class="form-control" value="{{ $editData['check_out'] }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Keperluan <span class="text-danger">*</span></label>
                    <input type="text" name="purpose" class="form-control" value="{{ $editData['purpose'] }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" name="contact" class="form-control" value="{{ $editData['contact'] }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">PIC</label>
                    <input type="text" name="pic_name" class="form-control" value="{{ $editData['pic_name'] }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required onchange="handleStatusChange(this)">
                        <option value="Pending" {{ $editData['status'] == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ $editData['status'] == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ $editData['status'] == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" rows="3" class="form-control">{{ $editData['notes'] }}</textarea>
                </div>
            </div>

            <!-- Status Info -->
            <div class="alert alert-warning" id="statusInfo">
                <strong><i class="bi bi-exclamation-triangle"></i> Status:</strong>
                <span id="statusText">
                    @if($editData['status'] == 'Approved')
                        Data ini sudah disetujui
                    @elseif($editData['status'] == 'Rejected')
                        Data ini ditolak
                    @else
                        Data ini menunggu persetujuan
                    @endif
                </span>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="{{ url('travel_visitor') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
function handleStatusChange(select) {
    const statusInfo = document.getElementById('statusText');
    const alertBox = document.getElementById('statusInfo');
    
    switch(select.value) {
        case 'Approved':
            statusInfo.textContent = 'Data ini akan disetujui';
            alertBox.className = 'alert alert-success';
            break;
        case 'Rejected':
            statusInfo.textContent = 'Data ini akan ditolak';
            alertBox.className = 'alert alert-danger';
            break;
        default:
            statusInfo.textContent = 'Data ini menunggu persetujuan';
            alertBox.className = 'alert alert-warning';
    }
}

function handleUpdate(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData);
    
    console.log('Data yang akan diupdate:', data);
    
    alert('Data berhasil diupdate!\n\nID: ' + data.id + '\nNama: ' + data.name + '\nStatus: ' + data.status);
    
    // Redirect ke index
    window.location.href = '{{ url("travel_visitor") }}';
}
</script>
@endsection
