@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="invoices-create-btn">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addUserModal"
                            class="btn save-invoice-btn">
                            Add User
                        </button>
                    </div>
                </div>
            </div>
        </div>



        <div class="row mt-4">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead class="thead-light">
                                    <tr>
                                        {{-- <th>ID</th> --}}
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            {{-- <td>{{ $user->id }}</td> --}}
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td class="text-center">{{$user->role}}</td>
                                            <td class="text-center"><span
                                                    class="badge badge-pill bg-success-light">Active</span></td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-success me-2 edit-btn"
                                                    data-id="{{ $user->id }}"><i class="far fa-edit me-1"></i>
                                                    Edit</button>
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger me-2 delete-btn"
                                                    data-id="{{ $user->id }}">
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

        {{-- Add User Modal --}}
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add-user-form">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" disabled>
                                    <option value="admin">Select Role</option>
                                </select>
                                <input type="hidden" name="role" value="admin">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save-user-button">Save User</button>
                    </div>
                </div>
            </div>
        </div>
        {{--  Edit User Modal --}}
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-user-form">
                            @csrf
                            <div class="mb-3">
                                <label for="edit-name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="edit-name" name="edit-name">
                            </div>
                            <div class="mb-3">
                                <label for="edit-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit-email" name="edit-email">
                            </div>
                            <div class="mb-3">
                                <label for="edit-password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="edit-password" name="edit-password"
                                    placeholder="Kosongkan Jika tidak Merubah Password">
                            </div>
                            <div class="mb-3">
                                <label for="edit-role" class="form-label">Role</label>
                                <select class="form-select" id="edit-role" name="edit-role">
                                    <option selected disabled>Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="mahasiswa">Mahasiswa</option>
                                </select>
                            </div>
                            <input type="hidden" id="edit-id" name="id">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="update-user-button">Update
                            User</button>
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
            $('#save-user-button').click(function(e) {
                e.preventDefault();
                if (!$('#email').val() || !$('#password').val()) {
                    swal.fire({
                        title: "Error!",
                        text: "Email and password are required.",
                        icon: "error",
                        button: "OK",
                    });
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.store') }}',
                    data: $('#add-user-form').serialize(),
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

            $('.edit-btn').click(function() {
                var userId = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: '/user/' + userId,
                    success: function(response) {
                        // Populate the form fields in the edit user modal
                        $('#edit-name').val(response.name);
                        $('#edit-email').val(response.email);
                        $('#edit-id').val(response.id);
                        $('#edit-password').val(response.password);
                        $('#edit-role').val(response.role)
                        $('#editUserModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        console.error('Error fetching user data: ' + error);
                    }
                });
            });
            // user update
            $('#update-user-button').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'PUT',
                    url: '/user/' + $('#edit-id').val(),
                    data: $('#edit-user-form').serialize(),
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

            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var userId = $(this).data('id');
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this user!",
                    icon: "warning",
                    showCancelButton: true, // This needs to be true to show the cancel button.
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    // dangerMode: true,
                }).then((result) => {
                    if (result
                        .isConfirmed) { // Changed from willDelete to isConfirmed for SweetAlert2
                        $.ajax({
                            type: 'DELETE',
                            url: '/user/' + userId,
                            data: {
                                '_token': $('input[name=_token]').val(),
                            },
                            success: function(response) {
                                if (response.success) {
                                    swal.fire({
                                        title: "Deleted!",
                                        text: response.success,
                                        icon: "success",
                                        confirmButtonText: "OK"
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
                                        confirmButtonText: "OK"
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
