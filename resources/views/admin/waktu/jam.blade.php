@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Jam</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Jam</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="invoices-create-btn">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addjamModal"
                            class="btn save-invoice-btn">
                            Add Hour
                        </button>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-12">
                        <div class="card card-table">
                            <div class="card-header">
                                <h4 class="card-title">List of Hours</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0 datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center">Jam Ke</th>
                                                <th class="text-center">Waktu</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jams as $jam)
                                                <tr>
                                                    <td class="text-center">{{ $jam->jam }}</td>
                                                    <td class="text-center">{{ $jam->waktu }} </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-white text-success me-2 edit-btn"
                                                            data-id="{{ $jam->id }}"><i class="far fa-edit me-1"></i>
                                                            Edit</button>
                                                        <button type="button"
                                                            class="btn btn-sm btn-white text-danger me-2 delete-btn"
                                                            data-id="{{ $jam->id }}">
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

                {{-- Add Hours Modal --}}
                <div class="modal fade" id="addjamModal" tabindex="-1" aria-labelledby="addjamModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addjamModalLabel">Add Hour</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="add-jam-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="jam" class="form-label">Jam ke</label>
                                        <input type="text" class="form-control" id="jam" name="jam" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu" class="form-label">Waktu</label>
                                        <input type="text" class="form-control" id="waktu" name="waktu" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save-jam-button">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--  Edit jam Modal --}}
                <div class="modal fade" id="editjamModal" tabindex="-1" aria-labelledby="editjamModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editjamModalLabel">Edit Jam</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="edit-jam-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="edit-jam" class="form-label">Jam Ke</label>
                                        <input type="text" class="form-control" id="edit-jam" name="edit-jam" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-waktu" class="form-label">Waktu</label>
                                        <input type="text" class="form-control" id="edit-waktu" name="edit-waktu"
                                            required>
                                    </div>

                                    <input type="hidden" id="edit-id" name="id">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="update-jam-button">Update</button>
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
            $('#save-jam-button').click(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('jam.store') }}',
                    data: $('#add-jam-form').serialize(),
                    success: function(response) {
                        if (response.success) {
                            swal.fire.fire({
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
            // edit jam
            $('.edit-btn').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: '/jam/' + id + '/edit',
                    success: function(response) {
                        $('#edit-jam').val(response.jam);
                        $('#edit-waktu').val(response.waktu);
                        $('#edit-id').val(response.id);
                        $('#editjamModal').modal('show');
                    }
                });
            });
            // update jam
            $('#update-jam-button').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'PUT',
                    url: '/jam/' + $('#edit-id').val(),
                    data: $('#edit-jam-form').serialize(),
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
                        if (response.responseJSON.errors && response.responseJSON.errors
                            .email) {
                            swal.fire({
                                title: "Error!",
                                text: response.responseJSON.errors.email[0],
                                icon: "error",
                                button: "OK",
                            });
                        } else if (response.responseJSON.errors) {
                            const firstErrorKey = Object.keys(response.responseJSON.errors)[0];
                            swal.fire({
                                title: "Error!",
                                text: response.responseJSON.errors[firstErrorKey][0],
                                icon: "error",
                                button: "OK",
                            });
                        }
                    }
                });
            });

            // delete jam
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this user!",
                    icon: "warning",
                    showCancelButton: true, // This needs to be true to show the cancel button.
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: 'DELETE',
                                url: '/jam/' + id,
                                data: {
                                    '_token': $('input[name=_token]').val(),
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
                                    if (response.responseJSON.error) {
                                        swal.fire({
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
        });
    </script>

@endpush