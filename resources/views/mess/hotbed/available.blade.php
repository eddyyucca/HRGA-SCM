@extends('layouts.app')

@section('title', 'Available Hotbed')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mess.hotbed.index') }}">Hotbed</a></li>
                    <li class="breadcrumb-item active">Available</li>
                </ol>
            </nav>
            <h4 class="mb-0"><i class="bi bi-check-circle me-2"></i>Bed Tersedia untuk Hotbed</h4>
            <small class="text-muted">Bed dari karyawan cuti yang belum di-assign ke temporary occupant</small>
        </div>
    </div>

    @if($availableHotbeds->count() > 0)
    <div class="alert alert-success">
        <i class="bi bi-info-circle me-2"></i>
        Ditemukan <strong>{{ $availableHotbeds->count() }}</strong> bed yang tersedia untuk hotbed
    </div>
    @else
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        Tidak ada bed tersedia untuk hotbed saat ini
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Room</th>
                            <th>Bed No</th>
                            <th>Original Occupant</th>
                            <th>Position</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availableHotbeds as $occ)
                        <tr>
                            <td>
                                <strong>{{ $occ->room->building->area->code }}-{{ $occ->room->building->code }}-{{ $occ->room->room_no }}</strong>
                            </td>
                            <td>{{ $occ->bed_no }}</td>
                            <td>{{ $occ->employee->name }}</td>
                            <td>{{ $occ->employee->position }}</td>
                            <td><span class="badge bg-info">{{ $occ->employee->company }}</span></td>
                            <td><span class="badge bg-warning">CUTI</span></td>
                            <td>
                                <button class="btn btn-sm btn-success" disabled title="Coming soon">
                                    <i class="bi bi-person-plus"></i> Assign
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No available hotbeds</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
