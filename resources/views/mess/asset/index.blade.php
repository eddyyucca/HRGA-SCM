@extends('layouts.app')

@section('title', 'Data Inventaris Asset')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i>Data Inventaris Asset</h4>
        </div>
    </div>

    <!-- Summary Cards per Building Type -->
    <div class="row mb-4">
        @foreach($assetSummary->groupBy('building_type') as $type => $buildings)
        <div class="col-md-4 col-lg-2 mb-2">
            <div class="card {{ $type == 'MESS' ? 'bg-primary' : ($type == 'OFFICE' ? 'bg-info' : ($type == 'KANTIN' ? 'bg-warning' : 'bg-secondary')) }} text-white">
                <div class="card-body py-2">
                    <h6 class="mb-1">{{ $type }}</h6>
                    <small>{{ $buildings->sum('total_assets') }} items</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Tipe Building</label>
                    <select name="building_type" class="form-select">
                        <option value="">Semua Tipe</option>
                        @foreach($buildingTypes as $type)
                            <option value="{{ $type }}" {{ request('building_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kondisi</label>
                    <select name="condition" class="form-select">
                        <option value="">Semua Kondisi</option>
                        <option value="BAIK" {{ request('condition') == 'BAIK' ? 'selected' : '' }}>BAIK</option>
                        <option value="RUSAK_RINGAN" {{ request('condition') == 'RUSAK_RINGAN' ? 'selected' : '' }}>RUSAK RINGAN</option>
                        <option value="RUSAK_BERAT" {{ request('condition') == 'RUSAK_BERAT' ? 'selected' : '' }}>RUSAK BERAT</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Item / Category / Code" value="{{ request('search') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search"></i> Filter</button>
                    <a href="{{ route('mess.assets.index') }}" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Detail Inventaris</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Tipe</th>
                            <th>Building</th>
                            <th>Room</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Qty</th>
                            <th>Condition</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                        <tr>
                            <td>
                                <span class="badge {{ $asset->building_type == 'MESS' ? 'bg-primary' : ($asset->building_type == 'OFFICE' ? 'bg-info' : ($asset->building_type == 'KANTIN' ? 'bg-warning' : 'bg-secondary')) }}">
                                    {{ $asset->building_type }}
                                </span>
                            </td>
                            <td>{{ $asset->building_name }}</td>
                            <td>
                                <strong>{{ $asset->room_no }}</strong>
                                @if($asset->room_name)
                                    <br><small class="text-muted">{{ $asset->room_name }}</small>
                                @endif
                            </td>
                            <td>{{ $asset->item_name }}</td>
                            <td>{{ $asset->category }}</td>
                            <td class="text-center">{{ $asset->qty }}</td>
                            <td>
                                @if($asset->condition == 'BAIK')
                                    <span class="badge bg-success">BAIK</span>
                                @elseif($asset->condition == 'RUSAK_RINGAN')
                                    <span class="badge bg-warning">RUSAK RINGAN</span>
                                @elseif($asset->condition == 'RUSAK_BERAT')
                                    <span class="badge bg-danger">RUSAK BERAT</span>
                                @else
                                    <span class="badge bg-dark">{{ $asset->condition }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $assets->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
