@extends('components.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Kelas</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kelas</li>
                </ul>
            </div>
            <div class="col-auto">
                <div class="invoices-create-btn">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addkelasModal"
                        class="btn save-invoice-btn">
                        Tambah Kelas
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-header">
                    <h4 class="card-title">Daftar kelas</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0 datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">Nama Kelas</th>
                                    <th class="text-center">Tahun Angkatan</th>
                                    <th class="text-center">Prodi</th>
                                    {{-- <th class="text-center">Status</th> --}}
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $item)
                                <tr>
                                    <td class="text-center">{{$item->nama_kelas}}</td>
                                    <td class="text-center">{{$item->tahun_angkatan}} </td>
                                    <td class="text-center">{{$item->prodi}}</td>
                                    {{-- <td class="text-center"><span
                                            class="badge badge-pill bg-success-light">Active</span></td> --}}
                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-sm btn-white text-success me-2 edit-btn"
                                            data-id="{{$item->id}}"><i class="far fa-edit me-1"></i>
                                            Edit</button>
                                        <button type="button"
                                            class="btn btn-sm btn-white text-danger me-2 delete-btn"
                                            data-id="{{$item->id}}">
                                            <i class="far fa-trash-alt me-1"></i>Delete</button>
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

    {{-- Add kelas Modal --}}
    <div class="modal fade" id="addkelasModal" tabindex="-1" aria-labelledby="addkelasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addkelasModalLabel">Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-kelas-form">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_angkatan" class="form-label">Tahun Angkatan</label>
                            <input type="number" class="form-control" id="tahun_angkatan" name="tahun_angkatan"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="prodi" class="form-label">Prodi</label>
                            <select class="form-select" id="prodi" name="prodi" required>
                                <option selected disabled>Select Prodi</option>
                                <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
                                <option value="D4 Teknologi Rekayasa Komputer">D4 Teknologi Rekayasa Komputer</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-kelas-button">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit kelas Modal --}}
    <div class="modal fade" id="editkelasModal" tabindex="-1" aria-labelledby="editkelasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editkelasModalLabel">Edit kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-kelas-form">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit-nama_kelas" class="form-label">Nama kelas</label>
                            <input type="text" class="form-control" id="edit-nama_kelas" name="nama_kelas"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-tahun_angkatan" class="form-label">Tahun Angkatan</label>
                            <input type="number" class="form-control" id="edit-tahun_angkatan" name="tahun_angkatan"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-prodi" class="form-label">Prodi</label>
                            <select class="form-select" id="edit-prodi" name="prodi" required>
                                <option selected disabled>Select Prodi</option>
                                <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
                                <option value="D4 Teknologi Rekayasa Komputer">D4 Teknologi Rekayasa Komputer</option>
                            </select>
                        </div>
                        <input type="hidden" id="edit-id" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-kelas-button">Update kelas</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {
        var table = $('.datatable').DataTable();

        function bindEditAndDeleteButtons() {
            // Edit button click event
            $('.edit-btn').click(function() {
                var id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: '/kelas/' + id + '/edit',
                    success: function(response) {
                        $('#edit-nama_kelas').val(response.nama_kelas);
                        $('#edit-tahun_angkatan').val(response.tahun_angkatan);
                        $('#edit-prodi').val(response.prodi);
                        $('#edit-id').val(response.id);
                        $('#editkelasModal').modal('show');
                    },
                });
            });

            // Delete button click event
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this class!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '/kelas/' + id,
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
        }

        $('#save-kelas-button').click(function(e) {
            e.preventDefault();
            if (!$('#nama_kelas').val() || !$('#tahun_angkatan').val() || !$('#prodi').val()) {
                swal.fire({
                    title: "Error!",
                    text: "All fields are required.",
                    icon: "error",
                    button: "OK",
                });
                return;
            }
            $.ajax({
                type: 'POST',
                url: '{{ route('kelas.store') }}',
                data: $('#add-kelas-form').serialize(),
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

        // Update button click event
        $('#update-kelas-button').click(function(e) {
            e.preventDefault();
            if (!$('#edit-nama_kelas').val() || !$('#edit-tahun_angkatan').val() || !$('#edit-prodi').val()) {
                swal.fire({
                    title: "Error!",
                    text: "All fields are required.",
                    icon: "error",
                    button: "OK",
                });
                return;
            }
            $.ajax({
                type: 'PUT',
                url: '/kelas/' + $('#edit-id').val(),
                data: $('#edit-kelas-form').serialize(),
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

        // Initial binding of edit and delete buttons
        bindEditAndDeleteButtons();

        // Rebind edit and delete buttons on table draw event
        table.on('draw', function() {
            bindEditAndDeleteButtons();
        });
    });
</script>
@endpush


