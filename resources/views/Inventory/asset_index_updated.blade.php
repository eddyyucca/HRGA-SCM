@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card mb-3">
        <div class="card-header"><h5>Filter & Pencarian</h5></div>
        <div class="card-body">
            <form method="GET" class="row g-2" id="filterForm">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="area" class="form-select">
                        <option value="">Semua Area</option>
                        @foreach($areas as $area)
                        <option value="{{ $area }}" {{ request('area') == $area ? 'selected' : '' }}>{{ $area }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="building" class="form-select">
                        <option value="">Semua Building</option>
                        @foreach($buildings as $building)
                        <option value="{{ $building }}" {{ request('building') == $building ? 'selected' : '' }}>{{ $building }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="room" class="form-select">
                        <option value="">Semua Room</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room }}" {{ request('room') == $room ? 'selected' : '' }}>{{ $room }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="condition" class="form-select">
                        <option value="">Kondisi</option>
                        <option value="BAIK" {{ request('condition') == 'BAIK' ? 'selected' : '' }}>Baik</option>
                        <option value="RUSAK" {{ request('condition') == 'RUSAK' ? 'selected' : '' }}>Rusak</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Daftar Asset ({{ $assets->total() }})</h5>
                <div>
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-success btn-sm" onclick="exportExcel()">
                            <i class="bi bi-file-excel"></i> Excel
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="exportPdf()">
                            <i class="bi bi-file-pdf"></i> PDF
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="printData()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                    <a href="{{ route('inventory.asset.withdrawal.list') }}" class="btn btn-warning btn-sm me-2">
                        <i class="bi bi-exclamation-triangle"></i> Barang Rusak
                    </a>
                    <a href="{{ route('inventory.asset.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Asset
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nomor Asset</th>
                        <th>Nama</th>
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
                        <td><strong>{{ $asset->asset_number }}</strong></td>
                        <td>
                            {{ $asset->asset_name }}
                            @if($asset->photo)
                            <br><small><i class="bi bi-image text-primary"></i> Ada foto</small>
                            @endif
                        </td>
                        <td>{{ $asset->category->name ?? '-' }}</td>
                        <td>
                            <small>{{ $asset->location->area ?? '-' }}</small><br>
                            <strong>{{ $asset->location->building ?? '-' }} - {{ $asset->location->room ?? '-' }}</strong>
                        </td>
                        <td><span class="badge bg-{{ $asset->condition_status == 'BAIK' ? 'success' : 'danger' }}">{{ $asset->condition_status }}</span></td>
                        <td><span class="badge bg-info">{{ $asset->operational_status }}</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('inventory.asset.show', $asset->id) }}" class="btn btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('inventory.asset.edit', $asset->id) }}" class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('inventory.asset.destroy', $asset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $assets->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
function exportExcel() {
    const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
    window.location.href = "{{ route('inventory.asset.export.excel') }}?" + params.toString();
}

function exportPdf() {
    const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
    window.location.href = "{{ route('inventory.asset.export.pdf') }}?" + params.toString();
}

function printData() {
    const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
    window.open("{{ route('inventory.asset.print') }}?" + params.toString(), '_blank');
}
</script>
@endsection
