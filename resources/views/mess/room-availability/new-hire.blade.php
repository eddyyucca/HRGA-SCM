@extends('layouts.app')

@section('title', 'Kamar Tersedia untuk New Hire')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mess.rooms.index') }}">Room Availability</a></li>
                    <li class="breadcrumb-item active">New Hire</li>
                </ol>
            </nav>
            <h4 class="mb-0"><i class="bi bi-person-plus me-2"></i>Kamar Tersedia untuk New Hire</h4>
            <small class="text-muted">Menampilkan kamar PERMANENT yang masih tersedia</small>
        </div>
    </div>

    @if($rooms->count() > 0)
    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        Ditemukan <strong>{{ $rooms->count() }}</strong> kamar dengan total <strong>{{ $rooms->sum('available_beds') }}</strong> bed tersedia
    </div>
    @else
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Tidak ada kamar tersedia untuk New Hire saat ini
    </div>
    @endif

    <div class="row">
        @foreach($rooms as $room)
        <div class="col-md-4 col-lg-3 mb-3">
            <div class="card h-100 border-success">
                <div class="card-header bg-success text-white">
                    <strong>{{ $room->full_room_code }}</strong>
                    <span class="badge bg-light text-success float-end">{{ $room->available_beds }} bed</span>
                </div>
                <div class="card-body">
                    <p class="mb-1"><small class="text-muted">{{ $room->area_name }}</small></p>
                    <p class="mb-2">{{ $room->building_name }}</p>
                    
                    <div class="d-flex justify-content-between mb-1">
                        <span>Capacity:</span>
                        <strong>{{ $room->capacity }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Terisi:</span>
                        <span>{{ $room->occupied_beds }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tersedia:</span>
                        <strong class="text-success">{{ $room->available_beds }}</strong>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('mess.occupancy.room', $room->room_id) }}" class="btn btn-sm btn-success w-100">
                        <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
