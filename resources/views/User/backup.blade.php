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
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addUserModal"
                            class="btn save-invoice-btn">
                            Add User
                        </a>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-12">
                        <div class="card card-table">
                            <div class="card-header">
                                <h4 class="card-title">List of Users</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0 datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td class="text-center"><span
                                                            class="badge badge-pill bg-success-light">Active</span></td>
                                                    <td class="text-center">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal" id="edit-btn"
                                                            class="btn btn-sm btn-white text-success me-2"><i
                                                                class="far fa-edit me-1"></i> Edit</a>
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-sm btn-white text-danger me-2"><i
                                                                class="far fa-trash-alt me-1"></i>Delete</a>
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
                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="edit-user-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="edit-name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="edit-name" name="edit_name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="edit-email" name="edit_email"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="edit-password"
                                            name="edit_password" required>
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
                    swal({
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
                            swal({
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
                            swal({
                                title: "Error!",
                                text: response.responseJSON.errors.email[0],
                                icon: "error",
                                button: "OK",
                            });
                        } else if (response.responseJSON.errors) {
                            const firstErrorKey = Object.keys(response.responseJSON.errors)[0];
                            swal({
                                title: "Error!",
                                text: response.responseJSON.errors[firstErrorKey][0],
                                icon: "error",
                                button: "OK",
                            });
                        }
                    }
                });

                $('.edit-btn').click(function() {
                    var userId = $(this).closest('tr').find('td:first-child').text();

                    // Fetch the user data for the specified ID
                    $.ajax({
                        type: 'GET',
                        url: '/user/' + userId,
                        success: function(response) {
                            // Populate the form fields in the edit user modal
                            $('#edit-name').val(response.name);
                            $('#edit-email').val(response.email);
                            $('#edit-id').val(response.id);
                            $('#editUserModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            // Handle AJAX error
                            console.error('Error fetching user data: ' + error);
                        }
                    });
                });
                // When the update button is clicked
                $('#update-user-button').click(function() {
                    var userId = $('#edit-id').val();

                    // Send an AJAX request to update the user data on the server
                    $.ajax({
                        type: 'PUT',
                        url: '/user/' + userId,
                        data: $('#edit-user-form').serialize(),
                        success: function(response) {
                            // Handle success
                            $('#editUserModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle AJAX error
                            console.error('Error updating user data: ' + error);
                        }
                    });
                });
            });

        });
    </script>
@endpush
