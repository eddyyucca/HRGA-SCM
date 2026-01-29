@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5>Master Kategori</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus"></i> Tambah Kategori
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Asset</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $cat)
                    <tr>
                        <td>{{ $categories->firstItem() + $index }}</td>
                        <td><strong>{{ $cat->code }}</strong></td>
                        <td>{{ $cat->name }}</td>
                        <td>{{ $cat->description }}</td>
                        <td><span class="badge bg-info">{{ $cat->assets_count }}</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editCategory({{ $cat->id }}, '{{ $cat->code }}', '{{ $cat->name }}', '{{ $cat->description }}')">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('inventory.master.category.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('inventory.master.category.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" required maxlength="20">
                        <small class="text-muted">Contoh: FRN, ELC, OFF</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="edit_code" class="form-control" required maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function editCategory(id, code, name, description) {
    document.getElementById('editForm').action = "{{ url('inventory/asset/master/category') }}/" + id;
    document.getElementById('edit_code').value = code;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endsection
