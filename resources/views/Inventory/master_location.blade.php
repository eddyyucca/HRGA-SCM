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
                <h5>Master Lokasi</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus"></i> Tambah Lokasi
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Area</th>
                        <th>Building</th>
                        <th>Room</th>
                        <th>Floor</th>
                        <th>PIC</th>
                        <th>Jumlah Asset</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $index => $loc)
                    <tr>
                        <td>{{ $locations->firstItem() + $index }}</td>
                        <td><strong>{{ $loc->area }}</strong></td>
                        <td>{{ $loc->building }}</td>
                        <td>{{ $loc->room }}</td>
                        <td>{{ $loc->floor }}</td>
                        <td>{{ $loc->pic_name }}</td>
                        <td><span class="badge bg-info">{{ $loc->assets_count }}</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editLocation({{ $loc->id }}, '{{ $loc->area }}', '{{ $loc->building }}', '{{ $loc->room }}', '{{ $loc->floor }}', '{{ $loc->department }}', '{{ $loc->pic_name }}', '{{ $loc->pic_contact }}', {{ $loc->is_active }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('inventory.master.location.destroy', $loc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $locations->links() }}
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('inventory.master.location.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Lokasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Area <span class="text-danger">*</span></label>
                        <input type="text" name="area" class="form-control" required maxlength="100" placeholder="MIM, Indonesia">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Building <span class="text-danger">*</span></label>
                        <input type="text" name="building" class="form-control" required maxlength="100" placeholder="Y-A栋">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Room <span class="text-danger">*</span></label>
                        <input type="text" name="room" class="form-control" required maxlength="100" placeholder="A01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Floor</label>
                        <input type="text" name="floor" class="form-control" maxlength="50" placeholder="Floor-1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" maxlength="100" placeholder="GA">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PIC Name</label>
                        <input type="text" name="pic_name" class="form-control" maxlength="100" value="EDDY ADHA SAPUTRA">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PIC Contact</label>
                        <input type="text" name="pic_contact" class="form-control" maxlength="50">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
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
                    <h5 class="modal-title">Edit Lokasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Area <span class="text-danger">*</span></label>
                        <input type="text" name="area" id="edit_area" class="form-control" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Building <span class="text-danger">*</span></label>
                        <input type="text" name="building" id="edit_building" class="form-control" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Room <span class="text-danger">*</span></label>
                        <input type="text" name="room" id="edit_room" class="form-control" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Floor</label>
                        <input type="text" name="floor" id="edit_floor" class="form-control" maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" id="edit_department" class="form-control" maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PIC Name</label>
                        <input type="text" name="pic_name" id="edit_pic_name" class="form-control" maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PIC Contact</label>
                        <input type="text" name="pic_contact" id="edit_pic_contact" class="form-control" maxlength="50">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="edit_is_active">
                            <label class="form-check-label" for="edit_is_active">Aktif</label>
                        </div>
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
function editLocation(id, area, building, room, floor, department, pic_name, pic_contact, is_active) {
    document.getElementById('editForm').action = "{{ url('inventory/asset/master/location') }}/" + id;
    document.getElementById('edit_area').value = area;
    document.getElementById('edit_building').value = building;
    document.getElementById('edit_room').value = room;
    document.getElementById('edit_floor').value = floor;
    document.getElementById('edit_department').value = department;
    document.getElementById('edit_pic_name').value = pic_name;
    document.getElementById('edit_pic_contact').value = pic_contact;
    document.getElementById('edit_is_active').checked = is_active == 1;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endsection
