@extends('layouts.app')

@section('title', 'Mess Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-0"><i class="bi bi-house-door me-2"></i>Mess Management Dashboard</h4>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ $summary['total_rooms'] }}</h3>
                    <p>Total Kamar</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-door-open"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ $summary['occupied_beds'] }}/{{ $summary['total_beds'] }}</h3>
                    <p>Bed Terisi</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-person-check"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ $summary['available_beds'] }}</h3>
                    <p>Bed Tersedia</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>{{ $summary['occupancy_rate'] }}%</h3>
                    <p>Occupancy Rate</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-graph-up"></i></div>
            </div>
        </div>
    </div>

    <!-- Room Availability Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-table me-2"></i>Room Availability Overview</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Area</th>
                                    <th>Building</th>
                                    <th>Lantai</th>
                                    <th>Room No</th>
                                    <th>Type</th>
                                    <th>Capacity</th>
                                    <th>Occupied</th>
                                    <th>Available</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roomAvailability as $room)
                                <tr>
                                    <td>{{ $room->area_name }}</td>
                                    <td>{{ $room->building_name }}</td>
                                    <td>{{ $room->floor_number }}</td>
                                    <td><strong>{{ $room->room_no }}</strong></td>
                                    <td><span class="badge bg-secondary">{{ $room->room_type }}</span></td>
                                    <td>{{ $room->capacity }}</td>
                                    <td>{{ $room->occupied_beds }}</td>
                                    <td>
                                        @if($room->available_beds > 0)
                                            <span class="badge bg-success">{{ $room->available_beds }}</span>
                                        @else
                                            <span class="badge bg-danger">Full</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $percent = $room->capacity > 0 ? ($room->occupied_beds / $room->capacity) * 100 : 0;
                                        @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar {{ $percent >= 100 ? 'bg-danger' : ($percent >= 75 ? 'bg-warning' : 'bg-success') }}" 
                                                 style="width: {{ $percent }}%">{{ round($percent) }}%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('mess.occupancy.room', $room->room_id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">No data available</td>
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
