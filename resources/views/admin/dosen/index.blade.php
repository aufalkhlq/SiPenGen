@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Dosen</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dosen</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="invoices-create-btn">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addDosenModal"
                            class="btn save-invoice-btn">
                            Add Dosen
                        </button>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-12">
                        <div class="card card-table">
                            <div class="card-header">
                                <h4 class="card-title">List of Dosen</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0 datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center">Nama Dosen</th>
                                                <th class="text-center">NIP</th>
                                                <th class="text-center">Prodi</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dosens as $dosen)
                                                <tr>
                                                    <td>{{ $dosen->nama_dosen }}</td>
                                                    <td>{{ $dosen->nip }}</td>
                                                    <td>{{ $dosen->prodi }}</td>
                                                    <td class="text-center"><span
                                                            class="badge badge-pill bg-success-light">Active</span></td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-white text-success me-2 edit-btn"
                                                            data-id="{{ $dosen->id }}"><i class="far fa-edit me-1"></i>
                                                            Edit</button>
                                                        <button type="button"
                                                            class="btn btn-sm btn-white text-danger me-2 delete-btn"
                                                            data-id="{{ $dosen->id }}">
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

                {{-- Add dosen Modal --}}
                <div class="modal fade" id="addDosenModal" tabindex="-1" aria-labelledby="addDosenModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addDosenModalLabel">Add Dosen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="add-dosen-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                        <input type="text" class="form-control" id="nama_dosen" name="nama_dosen"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NIP</label>
                                        <input type="number" class="form-control" id="nip" name="nip" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prodi" class="form-label">Prodi</label>
                                        <select class="form-select" id="prodi" name="prodi" required>
                                            <option selected disabled>Select Prodi</option>
                                            <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
                                            <option value="D4 Teknologi Rekayasa Komputer">D4 Teknologi Rekayasa Komputer
                                            </option>
                                            <option value="D3 Teknik Elektro">D3 Teknik Elektro</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save-dosen-button">Save dosen</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  Edit Dosen Modal --}}
                <div class="modal fade" id="editDosenModal" tabindex="-1" aria-labelledby="editDosenModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editDosenModalLabel">Edit Dosen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="edit-dosen-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="edit-nama_dosen" class="form-label">Nama Dosen</label>
                                        <input type="text" class="form-control" id="edit-nama_dosen"
                                            name="edit-nama_dosen" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-nip" class="form-label">NIP</label>
                                        <input type="number" class="form-control" id="edit-nip" name="edit-nip"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-prodi" class="form-label">Prodi</label>
                                        <select class="form-select" id="edit-prodi" name="edit-prodi" required>
                                            <option selected disabled>Select Prodi</option>
                                            <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
                                            <option value="D4 Teknologi Rekayasa Komputer">D4 Teknologi Rekayasa Komputer
                                            </option>
                                            <option value="D3 Teknik Elektro">D3 Teknik Elektro</option>
                                    </div>
                                    <input type="hidden" id="edit-id" name="id">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="update-dosen-button">Update
                                    Dosen</button>
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
        function bindActions() {
            $('.edit-btn').off('click').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: '/dosen/' + id + '/edit',
                    success: function(response) {
                        $('#edit-nama_dosen').val(response.nama_dosen);
                        $('#edit-nip').val(response.nip);
                        $('#edit-prodi').val(response.prodi);
                        $('#edit-id').val(response.id);
                        $('#editDosenModal').modal('show');
                    }
                });
            });

            $('.delete-btn').off('click').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this user!",
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
                            url: '/dosen/' + id,
                            data: {
                                '_token': $('input[name=_token]').val(),
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: response.success,
                                        icon: "success",
                                        button: "OK",
                                    }).then((value) => {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(response) {
                                if (response.responseJSON.error) {
                                    Swal.fire({
                                        title: "Error!",
                                        text: response.responseJSON.error,
                                        icon: "error",
                                        button: "OK",
                                    });
                                }
                            }
                        });
                    }
                });
            });
        }

        // Bind save dosen button
        $('#save-dosen-button').off('click').on('click', function(e) {
            e.preventDefault();
            if (!$('#nama_dosen').val() || !$('#nip').val()) {
                Swal.fire({
                    title: "Error!",
                    text: "Nama Dosen and NIP are required.",
                    icon: "error",
                    button: "OK",
                });
                return;
            }
            if (!$('#prodi').val()) {
                Swal.fire({
                    title: "Error!",
                    text: "Silahkan Pilih Salah Satu Prodi.",
                    icon: "error",
                    button: "OK",
                });
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('dosen.store') }}',
                data: $('#add-dosen-form').serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
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

        // Bind update dosen button
        $('#update-dosen-button').off('click').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'PUT',
                url: '/dosen/' + $('#edit-id').val(),
                data: $('#edit-dosen-form').serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
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
                        const firstErrorKey = Object.keys(response.responseJSON.errors)[0];
                        Swal.fire({
                            title: "Error!",
                            text: response.responseJSON.errors[firstErrorKey][0],
                            icon: "error",
                            button: "OK",
                        });
                    }
                }
            });
        });

        // Re-bind actions on page change
        $('.datatable').on('draw.dt', function() {
            bindActions();
        });

        // Initial call to bind actions
        bindActions();
    });
</script>
@endpush

