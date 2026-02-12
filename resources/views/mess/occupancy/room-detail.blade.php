@extends('layouts.app')

@section('title', 'Detail Room - ' . $room->full_code)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mess.dashboard') }}">Mess</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mess.occupancy.index') }}">Hunian</a></li>
                    <li class="breadcrumb-item active">{{ $room->full_code }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Room Info -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4><i class="bi bi-door-open me-2"></i>{{ $room->full_code }}</h4>
                    <p class="mb-1"><strong>Area:</strong> {{ $room->floor->building->area->name }}</p>
                    <p class="mb-1"><strong>Building:</strong> {{ $room->floor->building->name }}</p>
                    <p class="mb-1"><strong>Lantai:</strong> {{ $room->floor->display_name }}</p>
                    <p class="mb-0"><strong>Type:</strong> {{ $room->room_type }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4><i class="bi bi-people me-2"></i>Kapasitas</h4>
                    <div class="row text-center">
                        <div class="col-4">
                            <h2>{{ $room->capacity }}</h2>
                            <small>Total Bed</small>
                        </div>
                        <div class="col-4">
                            <h2>{{ $room->activeOccupancies->count() }}</h2>
                            <small>Terisi</small>
                        </div>
                        <div class="col-4">
                            <h2>{{ $room->available_beds }}</h2>
                            <small>Tersedia</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Penghuni -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-person-lines-fill me-2"></i>Data Penghuni</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Bed</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 1; $i <= $room->capacity; $i++)
                                    @php
                                        $occupant = $room->activeOccupancies->firstWhere('bed_no', $i);
                                    @endphp
                                    <tr>
                                        <td class="text-center"><strong>{{ $i }}</strong></td>
                                        @if($occupant)
                                            <td>{{ $occupant->employee->name }}</td>
                                            <td>{{ $occupant->employee->position }}</td>
                                            <td><span class="badge bg-info">{{ $occupant->employee->company }}</span></td>
                                            <td>
                                                @if($occupant->employee->status == 'CUTI')
                                                    <span class="badge bg-warning">CUTI</span>
                                                @else
                                                    <span class="badge bg-success">ON</span>
                                                @endif
                                            </td>
                                        @else
                                            <td colspan="4" class="text-center text-muted">
                                                <i class="bi bi-check-circle text-success"></i> Available
                                            </td>
                                        @endif
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assets -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-box-seam me-2"></i>Data Asset</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Item</th>
                                    <th>Category</th>
                                    <th>Qty</th>
                                    <th>Condition</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($room->assets as $asset)
                                <tr>
                                    <td>{{ $asset->item_name }}</td>
                                    <td>{{ $asset->category }}</td>
                                    <td class="text-center">{{ $asset->qty }}</td>
                                    <td>
                                        @if($asset->condition == 'BAIK')
                                            <span class="badge bg-success">BAIK</span>
                                        @elseif($asset->condition == 'RUSAK_RINGAN')
                                            <span class="badge bg-warning">RUSAK RINGAN</span>
                                        @else
                                            <span class="badge bg-danger">{{ $asset->condition }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No assets recorded</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
