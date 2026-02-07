@extends('layouts.app')

@section('title', 'Data Hunian Mess')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-0"><i class="bi bi-people me-2"></i>Data Hunian Mess</h4>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Area</label>
                    <select name="area" class="form-select">
                        <option value="">Semua Area</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->code }}" {{ request('area') == $area->code ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama / ID / Room" value="{{ request('search') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search"></i> Filter</button>
                    <a href="{{ route('mess.occupancy.index') }}" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Room</th>
                            <th>Bed</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Company</th>
                            <th>Type</th>
                            <th>Check In</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($occupancies as $occ)
                        <tr>
                            <td>
                                <a href="{{ route('mess.occupancy.room', $occ->room_id) }}">
                                    <strong>{{ $occ->full_room_code }}</strong>
                                </a>
                            </td>
                            <td>{{ $occ->bed_no }}</td>
                            <td>{{ $occ->emp_code }}</td>
                            <td>{{ $occ->employee_name }}</td>
                            <td>{{ $occ->position }}</td>
                            <td><span class="badge bg-info">{{ $occ->company }}</span></td>
                            <td>
                                @if($occ->occupancy_type == 'VISITOR')
                                    <span class="badge bg-warning">VISITOR</span>
                                @elseif($occ->occupancy_type == 'HOTBED')
                                    <span class="badge bg-secondary">HOTBED</span>
                                @else
                                    <span class="badge bg-primary">PERMANENT</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($occ->check_in_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($occ->employee_status == 'CUTI')
                                    <span class="badge bg-warning">CUTI</span>
                                @else
                                    <span class="badge bg-success">ON</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $occupancies->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
