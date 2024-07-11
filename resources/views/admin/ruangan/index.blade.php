@extends('components.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Ruangan</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Ruangan</li>
                </ul>
            </div>
            <div class="col-auto">
                <div class="invoices-create-btn">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addruanganModal"
                        class="btn save-invoice-btn">
                        Add Ruangan
                </button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">
                            <h4 class="card-title">List of Ruangan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">Nama Ruangan</th>
                                            <th class="text-center">Kode Ruangan</th>
                                            <th class="text-center">Lantai</th>
                                            <th class="text-center">Kapasitas</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ruangans as $ruangan)
                                        <tr>
                                            <td>{{$ruangan->nama_ruangan}}</td>
                                            <td>{{$ruangan->kode_ruangan}} </td>
                                            <td>{{$ruangan->lantai}} </td>
                                            <td>{{$ruangan->kapasitas}}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-white text-success me-2 edit-btn" data-id="{{$ruangan->id}}"
                                                 ><i class="far fa-edit me-1"></i>Edit</button>
                                                <button type="button" class="btn btn-sm btn-white text-danger me-2 delete-btn" data-id="{{$ruangan->id}}"
                                                 ><i class="far fa-trash-alt me-1"></i>Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Add ruangan Modal --}}
            <div class="modal fade" id="addruanganModal" tabindex="-1" aria-labelledby="addruanganModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addruanganModalLabel">Add ruangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="add-ruangan-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                                    <input type="text" class="form-control" id="nama_ruangan" name="nama_ruangan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_ruangan" class="form-label">Kode Ruangan</label>
                                    <input type="text" class="form-control" id="kode_ruangan" name="kode_ruangan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lantai" class="form-label">Lantai</label>
                                    <input type="number" class="form-control" id="lantai" name="lantai" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kapasitas" class="form-label">Kapasitas</label>
                                    <input type="number" class="form-control" id="kapasitas" name="kapasitas" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="save-ruangan-button">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            {{--  Edit ruangan Modal --}}
            <div class="modal fade" id="editruanganModal" tabindex="-1" aria-labelledby="editruanganModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editruanganModalLabel">Edit ruangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="edit-ruangan-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="edit-nama_ruangan" class="form-label">Nama Ruangan</label>
                                    <input type="text" class="form-control" id="edit-nama_ruangan" name="nama_ruangan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-kode_ruangan" class="form-label">Kode Ruangan</label>
                                    <input type="text" class="form-control" id="edit-kode_ruangan" name="kode_ruangan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-lantai" class="form-label">Lantai</label>
                                    <input type="number" class="form-control" id="edit-lantai" name="lantai" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-kapasitas" class="form-label">Kapasitas</label>
                                    <input type="number" class="form-control" id="edit-kapasitas" name="kapasitas" required>
                                </div>

                                <input type="hidden" id="edit-id" name="id">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="update-ruangan-button">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#save-ruangan-button').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ruangan.store') }}',
                    data: $('#add-ruangan-form').serialize(),
                    success: function(response) {
                        if (response.success) {
                            swal.fire({
                                title: "Success!",
                                text: response.success,
                                icon: "success",
                                button: "OK",
                            }).then((value) => {
                                location.reload();
                            });
                        }
                    },
                });
            });

            $('.edit-btn').click(function() {
                var id = $(this).data('id');
                $.get('/ruangan/' + id, function(data) {
                    $('#edit-nama_ruangan').val(data.nama_ruangan);
                    $('#edit-kode_ruangan').val(data.kode_ruangan);
                    $('#edit-lantai').val(data.lantai);
                    $('#edit-kapasitas').val(data.kapasitas);
                    $('#edit-id').val(data.id);
                    $('#editruanganModal').modal('show');
                });
            });

            $('#update-ruangan-button').click(function(e) {
                e.preventDefault();
                var id = $('#edit-id').val();
                $.ajax({
                    type: 'PUT',
                    url: '/ruangan/' + id,
                    data: $('#edit-ruangan-form').serialize(),
                    success: function(response) {
                        if (response.success) {
                            swal.fire({
                                title: "Success!",
                                text: response.success,
                                icon: "success",
                                button: "OK",
                            }).then((value) => {
                                location.reload();
                            });
                        }
                    },
                });
            });

            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '/ruangan/' + id,
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    swal.fire({
                                        title: "Deleted!",
                                        text: response.success,
                                        icon: "success",
                                        button: "OK",
                                    }).then((value) => {
                                        location.reload();
                                    });
                                }
                            },
                        });
                    }
                });
            });
        });
    </script>
@endpush
