@extends('layouts.app')

@section('title', 'Asset Management')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="mb-0"><i class="bi bi-box-seam"></i> Asset Management</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Asset</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
{{-- Filter --}}
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('inventory.asset.index') }}" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari asset..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="location_id" class="form-select">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $loc)
                    <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>
                        {{ $loc->location_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="condition" class="form-select">
                    <option value="">Semua Kondisi</option>
                    <option value="BAIK" {{ request('condition') == 'BAIK' ? 'selected' : '' }}>Baik</option>
                    <option value="RUSAK" {{ request('condition') == 'RUSAK' ? 'selected' : '' }}>Rusak</option>
                    <option value="TIDAK_LAYAK" {{ request('condition') == 'TIDAK_LAYAK' ? 'selected' : '' }}>Tidak Layak</option>
                    <option value="DALAM_PERBAIKAN" {{ request('condition') == 'DALAM_PERBAIKAN' ? 'selected' : '' }}>Dalam Perbaikan</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('inventory.asset.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Stats --}}
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6>Total Asset</h6>
                <h3>{{ $assets->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6>Kondisi Baik</h6>
                <h3>{{ \App\Models\Inventory\asset_model::where('condition_status', 'BAIK')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h6>Rusak</h6>
                <h3>{{ \App\Models\Inventory\asset_model::where('condition_status', 'RUSAK')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6>Dalam Perbaikan</h6>
                <h3>{{ \App\Models\Inventory\asset_model::where('condition_status', 'DALAM_PERBAIKAN')->count() }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Asset</h5>
            <div>
                <a href="{{ route('inventory.asset.same') }}" class="btn btn-info btn-sm me-2">
                    <i class="bi bi-collection"></i> Asset Yang Sama
                </a>
                <a href="{{ route('inventory.asset.summary') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-geo-alt"></i> Summary Lokasi
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Asset</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                    <tr>
                        <td><strong>{{ $asset->asset_code }}</strong></td>
                        <td>
                            {{ $asset->asset_name }}
                            @if($asset->brand)
                            <br><small class="text-muted">{{ $asset->brand }}</small>
                            @endif
                        </td>
                        <td>{{ $asset->category->name ?? '-' }}</td>
                        <td>
                            <strong>{{ $asset->location->location_name ?? '-' }}</strong>
                            @if($asset->location)
                            <br><small class="text-muted">{{ $asset->location->detail_location }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                            $badgeClass = match($asset->condition_status) {
                                'BAIK' => 'bg-success',
                                'RUSAK' => 'bg-danger',
                                'TIDAK_LAYAK' => 'bg-dark',
                                'DALAM_PERBAIKAN' => 'bg-warning',
                                default => 'bg-secondary'
                            };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $asset->condition_status }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $asset->operational_status == 'AKTIF' ? 'bg-info' : 'bg-secondary' }}">
                                {{ $asset->operational_status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('inventory.asset.show', $asset->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $assets->links() }}
    </div>
</div>
@endsection
