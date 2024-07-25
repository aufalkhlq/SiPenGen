@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Hari</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Hari</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="invoices-create-btn">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addhariModal"
                            class="btn save-invoice-btn">
                            Tambah Hari
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Hari</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">No </th>
                                        <th class="text-center">Nama Hari</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($haris as $hari)
                                        <tr>
                                            <td class="text-center">{{ $hari->id }}</td>
                                            <td class="text-center">{{ $hari->hari }} </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-success me-2 edit-btn"
                                                    data-id="{{ $hari->id }}">
                                                    <i class="far fa-edit me-1"></i>Edit
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger me-2 delete-btn"
                                                    data-id="{{ $hari->id }}">
                                                    <i class="far fa-trash-alt me-1"></i>Delete
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
    </div>

    {{-- Add hari Modal --}}
    <div class="modal fade" id="addhariModal" tabindex="-1" aria-labelledby="addhariModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addhariModalLabel">Tambah Hari</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-hari-form">
                        @csrf
                        <div class="mb-3">
                            <label for="hari" class="form-label">Nama Hari</label>
                            <input type="text" class="form-control" id="hari" name="hari" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-hari-button">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit hari Modal --}}
    <div class="modal fade" id="edithariModal" tabindex="-1" aria-labelledby="edithariModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edithariModalLabel">Edit Hari</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-hari-form">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit-nama_hari" class="form-label">Nama Hari</label>
                            <input type="text" class="form-control" id="edit-nama_hari" name="hari" required>
                        </div>
                        <input type="hidden" id="edit-id" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-hari-button">Update</button>
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
                    url: '/hari/' + id + '/edit',
                    success: function(response) {
                        $('#edit-nama_hari').val(response.hari);
                        $('#edit-id').val(response.id);
                        $('#edithariModal').modal('show');
                    },
                });
            });

            // Delete button click event
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
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
                            url: '/hari/' + id,
                            data: {
                                '_token': '{{ csrf_token() }}'
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
                            error: function(response) {
                                swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete data.",
                                    icon: "error",
                                    button: "OK",
                                });
                            }
                        });
                    }
                });
            });
        }

        $('#save-hari-button').click(function(e) {
            e.preventDefault();
            $('#add-hari-form').submit();
        });

        $('#add-hari-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route('hari.store') }}',
                data: $(this).serialize(),
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
                    swal.fire({
                        title: "Error!",
                        text: "Failed to add data.",
                        icon: "error",
                        button: "OK",
                    });
                }
            });
        });

        $('#update-hari-button').click(function(e) {
            e.preventDefault();
            $('#edit-hari-form').submit();
        });

        $('#edit-hari-form').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit-id').val();
            $.ajax({
                type: 'PUT',
                url: '/hari/' + id,
                data: $(this).serialize(),
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
                    swal.fire({
                        title: "Error!",
                        text: "Failed to update data.",
                        icon: "error",
                        button: "OK",
                    });
                }
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
