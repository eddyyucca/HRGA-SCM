@extends('layouts.app')

@section('title', 'Room Availability')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-0"><i class="bi bi-door-open me-2"></i>Room Availability</h4>
        </div>
    </div>

    <!-- Summary -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3>{{ $summary['total_rooms'] }}</h3>
                    <p class="mb-0">Total Rooms</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3>{{ $summary['total_capacity'] }}</h3>
                    <p class="mb-0">Total Capacity</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h3>{{ $summary['total_occupied'] }}</h3>
                    <p class="mb-0">Occupied</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3>{{ $summary['total_available'] }}</h3>
                    <p class="mb-0">Available</p>
                </div>
            </div>
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
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="only_available" value="1" id="onlyAvailable"
                            {{ request('only_available') ? 'checked' : '' }}>
                        <label class="form-check-label" for="onlyAvailable">
                            Hanya yang tersedia
                        </label>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search"></i> Filter</button>
                    <a href="{{ route('mess.rooms.index') }}" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('mess.rooms.newhire') }}" class="btn btn-success me-2">
                <i class="bi bi-person-plus"></i> Kamar untuk New Hire
            </a>
            <a href="{{ route('mess.rooms.visitor') }}" class="btn btn-warning">
                <i class="bi bi-person-badge"></i> Kamar untuk Visitor
            </a>
        </div>
    </div>

    <!-- Room Cards -->
    <div class="row">
        @forelse($rooms as $room)
        <div class="col-md-4 col-lg-3 mb-3">
            <div class="card h-100 {{ $room->available_beds > 0 ? 'border-success' : 'border-danger' }}">
                <div class="card-header {{ $room->available_beds > 0 ? 'bg-success' : 'bg-danger' }} text-white">
                    <strong>{{ $room->full_room_code }}</strong>
                </div>
                <div class="card-body">
                    <p class="mb-1"><small class="text-muted">{{ $room->area_name }}</small></p>
                    <p class="mb-2"><small>{{ $room->building_name }}</small></p>
                    
                    <div class="d-flex justify-content-between">
                        <span>Capacity:</span>
                        <strong>{{ $room->capacity }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Occupied:</span>
                        <strong>{{ $room->occupied_beds }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Available:</span>
                        <strong class="{{ $room->available_beds > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $room->available_beds }}
                        </strong>
                    </div>

                    <div class="progress mt-2" style="height: 10px;">
                        @php $pct = $room->capacity > 0 ? ($room->occupied_beds / $room->capacity) * 100 : 0; @endphp
                        <div class="progress-bar {{ $pct >= 100 ? 'bg-danger' : 'bg-success' }}" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('mess.occupancy.room', $room->room_id) }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">No rooms found</div>
        </div>
        @endforelse
    </div>
</div>
@endsection
