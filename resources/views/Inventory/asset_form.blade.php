@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>{{ isset($asset) ? 'Edit' : 'Tambah' }} Asset</h5>
        </div>
        <form action="{{ isset($asset) ? route('inventory.asset.update', $asset->id) : route('inventory.asset.store') }}" 
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($asset))
                @method('PUT')
            @endif

            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Asset <span class="text-danger">*</span></label>
                        <input type="text" name="asset_name" class="form-control" 
                               value="{{ old('asset_name', $asset->asset_name ?? '') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">- Pilih Kategori -</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $asset->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->code }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" class="form-control" 
                               value="{{ old('brand', $asset->brand ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Model</label>
                        <input type="text" name="model" class="form-control" 
                               value="{{ old('model', $asset->model ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Serial Number</label>
                        <input type="text" name="serial_number" class="form-control" 
                               value="{{ old('serial_number', $asset->serial_number ?? '') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Spesifikasi</label>
                        <textarea name="specifications" class="form-control" rows="2">{{ old('specifications', $asset->specifications ?? '') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                        <select name="location_id" class="form-select" required>
                            <option value="">- Pilih Lokasi -</option>
                            @foreach($locations as $location)
                            <option value="{{ $location->id }}" 
                                {{ old('location_id', $asset->location_id ?? '') == $location->id ? 'selected' : '' }}>
                                {{ $location->full_location }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pembelian</label>
                        <input type="date" name="purchase_date" class="form-control" 
                               value="{{ old('purchase_date', isset($asset) && $asset->purchase_date ? $asset->purchase_date->format('Y-m-d') : '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Pembelian (Rp)</label>
                        <input type="number" name="purchase_price" class="form-control" 
                               value="{{ old('purchase_price', $asset->purchase_price ?? '') }}" step="0.01">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Supplier</label>
                        <input type="text" name="supplier" class="form-control" 
                               value="{{ old('supplier', $asset->supplier ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                        <select name="condition_status" class="form-select" required>
                            <option value="">- Pilih Kondisi -</option>
                            <option value="BAIK" {{ old('condition_status', $asset->condition_status ?? '') == 'BAIK' ? 'selected' : '' }}>Baik</option>
                            <option value="RUSAK" {{ old('condition_status', $asset->condition_status ?? '') == 'RUSAK' ? 'selected' : '' }}>Rusak</option>
                            <option value="DALAM_PERBAIKAN" {{ old('condition_status', $asset->condition_status ?? '') == 'DALAM_PERBAIKAN' ? 'selected' : '' }}>Dalam Perbaikan</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status Operasional</label>
                        <select name="operational_status" class="form-select">
                            <option value="AKTIF" {{ old('operational_status', $asset->operational_status ?? 'AKTIF') == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                            <option value="DITARIK" {{ old('operational_status', $asset->operational_status ?? '') == 'DITARIK' ? 'selected' : '' }}>Ditarik</option>
                            <option value="DIMUSNAHKAN" {{ old('operational_status', $asset->operational_status ?? '') == 'DIMUSNAHKAN' ? 'selected' : '' }}>Dimusnahkan</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Foto Asset (Optional - Max 2MB)</label>
                        <input type="file" name="photo" class="form-control" accept="image/*" 
                               onchange="previewImage(event)">
                        <small class="text-muted">Format: JPG, PNG. Max 2MB</small>
                        
                        <div class="mt-2" id="imagePreview">
                            @if(isset($asset) && $asset->photo)
                            <img src="{{ asset('uploads/assets/' . $asset->photo) }}" 
                                 class="img-thumbnail" style="max-width: 200px;">
                            <p class="text-muted small">Foto saat ini</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $asset->notes ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('inventory.asset.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '<img src="' + reader.result + '" class="img-thumbnail mt-2" style="max-width: 200px;"><p class="text-muted small">Preview foto baru</p>';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
