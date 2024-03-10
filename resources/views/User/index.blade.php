@extends('components.app')
@section('content')
    <script src="https://unpkg.com/sweetalert@2"></script>
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
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th
                                                    class="text-right
                                                    d-print-none">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->status }}</td>
                                                    <td class="text-right   d-print-none">
                                                        {{-- <div class="actions">
                                                            <a href="{{ route('user.edit', $user->id) }}"
                                                                class="btn btn-sm bg-success-light">
                                                                <i class="fe fe-pencil"></i> Edit
                                                            </a>
                                                            <a href="{{ route('user.delete', $user->id) }}"
                                                                class="btn btn-sm bg-danger-light">
                                                                <i class="fe fe-trash"></i> Delete
                                                            </a>
                                                        </div> --}}
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
            </div>
            <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
            <script>
                $(document).ready(function() {
                    $('#save-user-button').click(function(e) {
                        e.preventDefault();

                        // Check if any required fields are empty
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
                                    // If there are other errors, show the first one
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
                    });
                });
            </script>
        @endsection
