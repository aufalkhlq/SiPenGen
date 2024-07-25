@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Mahasiswa</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Mahasiswa</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="invoices-create-btn">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addmahasiswaModal"
                            class="btn save-invoice-btn">
                            Tambah Mahasiswa
                        </button>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-12">
                        <div class="card card-table">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0 datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center">Nama Mahasiswa</th>
                                                <th class="text-center">NIM</th>
                                                <th class="text-center">Kelas</th>
                                                <th class="text-center">Prodi</th>
                                                {{-- <th class="text-center">Status</th> --}}
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mahasiswas as $mahasiswa)
                                                <tr>
                                                    <td>{{ $mahasiswa->nama_mahasiswa }}</td>
                                                    <td class="text-center">{{ $mahasiswa->nim }}</td>
                                                    <td class="text-center">{{ $mahasiswa->kelas->nama_kelas }}</td>
                                                    <td class="text-center">{{ $mahasiswa->prodi }}</td>
                                                    {{-- <td class="text-center"><span
                                                            class="badge badge-pill bg-success-light">Active</span></td> --}}
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-white text-success me-2 edit-btn"
                                                            data-id="{{ $mahasiswa->id }}"><i class="far fa-edit me-1"></i>
                                                            Edit</button>
                                                        <button type="button"
                                                            class="btn btn-sm btn-white text-danger me-2 delete-btn"
                                                            data-id="{{ $mahasiswa->id }}">
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

                {{-- Add mahasiswa Modal --}}
                <div class="modal fade" id="addmahasiswaModal" tabindex="-1" aria-labelledby="addmahasiswaModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addmahasiswaModalLabel">Tambah Mahasiswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="add-mahasiswa-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                        <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nim" class="form-label">NIM</label>
                                        <input type="number" class="form-control" id="nim" name="nim" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelas_id" class="form-label">Kelas</label>
                                        <select class="form-select" id="kelas_id" name="kelas_id" required>
                                            <option selected disabled>Select Kelas</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prodi" class="form-label">Prodi</label>
                                        <select class="form-select" id="prodi" name="prodi" required>
                                            <option selected disabled>Select Prodi</option>
                                            <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
                                            <option value="D4 Teknologi Rekayasa Komputer">D4 Teknologi Rekayasa Komputer
                                            </option>
                                        </select>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save-mahasiswa-button">Save
                                    mahasiswa</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Edit mahasiswa Modal --}}
                <div class="modal fade" id="editmahasiswaModal" tabindex="-1" aria-labelledby="editmahasiswaModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editmahasiswaModalLabel">Edit Mahasiswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="edit-mahasiswa-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="edit-nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                        <input type="text" class="form-control" id="edit-nama_mahasiswa"
                                            name="edit-nama_mahasiswa" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-nim" class="form-label">NIM</label>
                                        <input type="number" class="form-control" id="edit-nim" name="edit-nim"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-kelas_id" class="form-label">Kelas</label>
                                        <select class="form-select" id="edit-kelas_id" name="edit-kelas_id" required>
                                            <option selected disabled>Select Kelas</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-prodi" class="form-label">Prodi</label>
                                        <select class="form-select" id="edit-prodi" name="edit-prodi" required>
                                            <option selected disabled>Select Prodi</option>
                                            <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
                                            <option value="D4 Teknologi Rekayasa Komputer">D4 Teknologi Rekayasa Komputer
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" id="edit-password" name="edit-password"
                                            placeholder="Kosongkan Jika tidak Merubah Password">
                                    </div>
                                    <input type="hidden" id="edit-id" name="id">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="update-mahasiswa-button">Update
                                    mahasiswa</button>
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
        $('#save-mahasiswa-button').click(function(e) {
            e.preventDefault();
            if (!$('#nama_mahasiswa').val() || !$('#nim').val()) {
                Swal.fire({
                    title: "Error!",
                    text: "Nama mahasiswa and nim are required.",
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
                url: '{{ route('mahasiswa.store') }}',
                data: $('#add-mahasiswa-form').serialize(),
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

        // Use event delegation for edit and delete buttons
        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: '/mahasiswa/' + id + '/edit',
                success: function(response) {
                    $('#edit-nama_mahasiswa').val(response.nama_mahasiswa);
                    $('#edit-nim').val(response.nim);
                    $('#edit-prodi').val(response.prodi);
                    $('#edit-kelas_id').val(response.kelas_id);
                    $('#edit-id').val(response.id);
                    $('#editmahasiswaModal').modal('show');
                }
            });
        });

        // update mahasiswa
        $('#update-mahasiswa-button').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'PUT',
                url: '/mahasiswa/' + $('#edit-id').val(),
                data: $('#edit-mahasiswa-form').serialize(),
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

        // delete mahasiswa
        $(document).on('click', '.delete-btn', function(e) {
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
                        url: '/mahasiswa/' + id,
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
    });
</script>
@endpush
