@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Mata Kuliah</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Mata Kuliah</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="invoices-create-btn">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addmatkulModal"
                            class="btn save-invoice-btn">
                            Tambah Mata Kuliah
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Mata Kuliah</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Nama Mata Kuliah</th>
                                        <th class="text-center">Kode Mata Kuliah</th>
                                        <th class="text-center">SKS</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matkuls as $matkul)
                                        <tr>
                                            <td class="text-center">{{ $matkul->nama_matkul }}</td>
                                            <td class="text-center">{{ $matkul->kode_matkul }}</td>
                                            <td class="text-center">{{ $matkul->sks }}</td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-success me-2 edit-btn"
                                                    data-id="{{ $matkul->id }}">
                                                    <i class="far fa-edit me-1"></i> Edit
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger me-2 delete-btn"
                                                    data-id="{{ $matkul->id }}">
                                                    <i class="far fa-trash-alt me-1"></i> Delete
                                                </button>
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

        {{-- Add matkul Modal --}}
        <div class="modal fade" id="addmatkulModal" tabindex="-1" aria-labelledby="addmatkulModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addmatkulModalLabel">Tambah Mata Kuliah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add-matkul-form">
                            @csrf
                            <div class="mb-3">
                                <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
                                <input type="text" class="form-control" id="nama_matkul" name="nama_matkul" required>
                            </div>
                            <div class="mb-3">
                                <label for="kode_matkul" class="form-label">Kode Mata Kuliah</label>
                                <input type="text" class="form-control" id="kode_matkul" name="kode_matkul" required>
                            </div>
                            <div class="mb-3">
                                <label for="sks" class="form-label">SKS</label>
                                <input type="number" class="form-control" id="sks" name="sks" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save-matkul-button">Save</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit matkul Modal --}}
        <div class="modal fade" id="editmatkulModal" tabindex="-1" aria-labelledby="editmatkulModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editmatkulModalLabel">Edit Mata Kuliah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-matkul-form">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="edit-nama_matkul" class="form-label">Nama Mata Kuliah</label>
                                <input type="text" class="form-control" id="edit-nama_matkul" name="nama_matkul"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-kode_matkul" class="form-label">Kode Mata Kuliah</label>
                                <input type="text" class="form-control" id="edit-kode_matkul" name="kode_matkul"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-sks" class="form-label">SKS</label>
                                <input type="number" class="form-control" id="edit-sks" name="sks" required>
                            </div>
                            <input type="hidden" id="edit-id" name="id">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="update-matkul-button">Update Mata
                            Kuliah</button>
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
                        url: '/matkul/' + id + '/edit',
                        success: function(response) {
                            $('#edit-nama_matkul').val(response.nama_matkul);
                            $('#edit-kode_matkul').val(response.kode_matkul);
                            $('#edit-sks').val(response.sks);
                            $('#edit-id').val(response.id);
                            $('#editmatkulModal').modal('show');
                        },
                    });
                });

                // Delete button click event
                $('.delete-btn').click(function() {
                    var id = $(this).data('id');
                    swal.fire({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this Mata Kuliah!",
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
                                url: '/matkul/' + id,
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

            $('#save-matkul-button').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('matkul.store') }}',
                    data: $('#add-matkul-form').serialize(),
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
                    error: function(response) {
                        if (response.responseJSON.errors) {
                            let errorMsg = '';
                            $.each(response.responseJSON.errors, function(key, value) {
                                errorMsg += value[0] + '\n';
                            });
                            swal.fire({
                                title: "Error!",
                                text: errorMsg,
                                icon: "error",
                                button: "OK",
                            });
                        }
                    }
                });
            });

            $('#update-matkul-button').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'PUT',
                    url: '/matkul/' + $('#edit-id').val(),
                    data: $('#edit-matkul-form').serialize(),
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
                    error: function(response) {
                        if (response.responseJSON.errors) {
                            let errorMsg = '';
                            $.each(response.responseJSON.errors, function(key, value) {
                                errorMsg += value[0] + '\n';
                            });
                            swal.fire({
                                title: "Error!",
                                text: errorMsg,
                                icon: "error",
                                button: "OK",
                            });
                        }
                    }
                });
            });

            bindEditAndDeleteButtons();
            // Rebind edit and delete buttons on table draw event
            table.on('draw', function() {
                bindEditAndDeleteButtons();
            });
        });
    </script>
@endpush
