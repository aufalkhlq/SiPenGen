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
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addDosenModal"
                            class="btn save-invoice-btn">
                            Add Dosen
                        </a>
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
                                                <td>{{$dosen->nama_dosen}}</td>
                                                <td>{{$dosen->nip}}</td>
                                                <td>{{$dosen->prodi}}</td>
                                                <td class="text-center"><span
                                                        class="badge badge-pill bg-success-light">Active</span></td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-white text-success me-2 edit-btn"><i
                                                            class="far fa-edit me-1"></i>
                                                        Edit</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-white text-danger me-2 delete-btn">
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
                                            <option value="D4 Teknologi Rekayasa Komputer">D4 Teknologi Rekayasa Komputer</option>
                                            <option value="D3 Teknik Elektro">D3 Teknik Elektro</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save-dosen-button">Save User</button>
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
                                        <input type="email" class="form-control" id="edit-email" name="edit_email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="edit-password"
                                            name="edit_password">
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
            $('#save-dosen-button').click(function(e) {
                e.preventDefault();
                if (!$('#nama_dosen').val() || !$('#nip').val()) {
                    swal({
                        title: "Error!",
                        text: "Nama Dosen and NIP are required.",
                        icon: "error",
                        button: "OK",
                    });
                    return;
                }
                if (!$('#prodi').val()){
                    swal({
                        title: "Error!",
                        text:"Silahkan Pilih Salah Satu Prodi.",
                        icon:"error",
                        button: "OK",
                    })
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('dosen.store') }}',
                    data: $('#add-dosen-form').serialize(),
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
                });
            });
        });
    </script>
@endpush
