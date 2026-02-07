@extends('layouts.app')

@section('title', 'Hotbed Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-0"><i class="bi bi-arrow-left-right me-2"></i>Hotbed Management</h4>
            <small class="text-muted">Kelola bed untuk karyawan cuti yang bisa digunakan sementara</small>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('mess.hotbed.available') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Lihat Bed Tersedia untuk Hotbed
            </a>
        </div>
    </div>

    <!-- Active Hotbeds -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0"><i class="bi bi-person-fill-exclamation me-2"></i>Hotbed Aktif</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Room</th>
                            <th>Bed</th>
                            <th>Original Occupant</th>
                            <th>Temporary Occupant</th>
                            <th>Period</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hotbeds as $hb)
                        <tr>
                            <td>{{ $hb->room->building->area->code }}-{{ $hb->room->building->code }}-{{ $hb->room->room_no }}</td>
                            <td>{{ $hb->bed_no }}</td>
                            <td>{{ $hb->originalOccupancy->employee->name }}</td>
                            <td>{{ $hb->tempEmployee->name }}</td>
                            <td>{{ $hb->start_date->format('d/m/Y') }} - {{ $hb->end_date->format('d/m/Y') }}</td>
                            <td>
                                @if($hb->status == 'ACTIVE')
                                    <span class="badge bg-success">ACTIVE</span>
                                @elseif($hb->status == 'COMPLETED')
                                    <span class="badge bg-secondary">COMPLETED</span>
                                @else
                                    <span class="badge bg-danger">{{ $hb->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada hotbed aktif</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $hotbeds->links() }}
        </div>
    </div>

    <!-- Employees on Leave -->
    <div class="card">
        <div class="card-header bg-warning text-dark">
            <h5 class="card-title mb-0"><i class="bi bi-calendar-x me-2"></i>Karyawan Cuti (Bed bisa dijadikan Hotbed)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Employee</th>
                            <th>Position</th>
                            <th>Company</th>
                            <th>Room</th>
                            <th>Bed</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cutiEmployees as $occ)
                        <tr>
                            <td>{{ $occ->employee->name }}</td>
                            <td>{{ $occ->employee->position }}</td>
                            <td><span class="badge bg-info">{{ $occ->employee->company }}</span></td>
                            <td>{{ $occ->room->building->area->code }}-{{ $occ->room->building->code }}-{{ $occ->room->room_no }}</td>
                            <td>{{ $occ->bed_no }}</td>
                            <td>
                                <button class="btn btn-sm btn-success" disabled title="Coming soon">
                                    <i class="bi bi-plus"></i> Assign Hotbed
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada karyawan yang sedang cuti</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
