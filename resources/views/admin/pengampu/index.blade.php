@extends('components.app')
@section('content')
@push('style')
<style>
.select2-container--default .select2-selection--single {
    height: calc(1.5em + .75rem + 2px); /* Adjust the height */
    padding: .375rem .40rem; /* Adjust the padding */

    line-height: 1.5; /* Adjust the line height */
    border: 1px solid #ced4da; /* Adjust the border */
    border-radius: .25rem; /* Adjust the border radius */
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 1.5; /* Adjust the line height to match other inputs */
    color: black;
}

</style>
@endpush
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Pengampu</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pengampu</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="invoices-create-btn">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addpengampuModal"
                            class="btn save-invoice-btn">
                            Tambah Pengampu
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Pengampu</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Dosen</th>
                                        <th class="text-center">Mata Kuliah</th>
                                        <th class="text-center">Kelas</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp

                                    @foreach ($pengampus as $pengampu)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td class="text-center">{{ $pengampu->dosen->nama_dosen }}</td>
                                            <td class="text-center">{{ $pengampu->matkul->nama_matkul }}</td>
                                            <td class="text-center">{{ $pengampu->kelas->nama_kelas }}</td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-success me-2 edit-btn"
                                                    data-id="{{ $pengampu->id }}">
                                                    <i class="far fa-edit me-1"></i>Edit
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger me-2 delete-btn"
                                                    data-id="{{ $pengampu->id }}">
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

    {{-- Add pengampu Modal --}}
    <div class="modal fade" id="addpengampuModal" tabindex="-1" aria-labelledby="addpengampuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addpengampuModalLabel">Tambah Pengampu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-pengampu-form">
                        @csrf
                        <div class="mb-3">
                            <label for="dosen_id" class="form-label">Nama Dosen</label>
                            <select class="form-select basic" id="dosen_id" name="dosen_id" required>
                                <option selected disabled>Select Dosen</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama_dosen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="matkul_id" class="form-label">Mata Kuliah</label>
                            <select class="form-select basic" id="matkul_id" name="matkul_id" required>
                                <option selected disabled>Select Matkul</option>
                                @foreach ($matkuls as $matkul)
                                    <option value="{{ $matkul->id }}">{{ $matkul->nama_matkul }} - {{$matkul->kode_matkul}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select class="form-select basic" id="kelas_id" name="kelas_id" required>
                                <option selected disabled>Select Kelas</option>
                                @foreach ($kelas as $kls)
                                    <option value="{{ $kls->id }}">{{ $kls->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-pengampu-button">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit pengampu Modal --}}
    <div class="modal fade" id="editpengampuModal" tabindex="-1" aria-labelledby="editpengampuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editpengampuModalLabel">Edit Pengampu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-pengampu-form">
                        @csrf
                        <div class="mb-3">
                            <label for="edit-dosen_id" class="form-label">Nama Dosen</label>
                            <select class="form-select basic-edit" id="edit-dosen_id" name="dosen_id" required>
                                <option selected disabled>Select Dosen</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama_dosen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-matkul_id" class="form-label">Mata Kuliah</label>
                            <select class="form-select basic-edit" id="edit-matkul_id" name="matkul_id" required>
                                <option selected disabled>Select Matkul</option>
                                @foreach ($matkuls as $matkul)
                                    <option value="{{ $matkul->id }}">{{ $matkul->nama_matkul }} - {{$matkul->kode_matkul}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-kelas_id" class="form-label">Kelas</label>
                            <select class="form-select basic-edit" id="edit-kelas_id" name="kelas_id" required>
                                <option selected disabled>Select Kelas</option>
                                @foreach ($kelas as $kls)
                                    <option value="{{ $kls->id }}">{{ $kls->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="edit-id" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-pengampu-button">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        if ($.fn.select2) {
            $(".basic").select2({
                dropdownParent: $("#addpengampuModal")
            });
            $(".basic-edit").select2({
                dropdownParent: $("#editpengampuModal") // append dropdown to modal
            });
        }

        function bindActions() {
            $('#add-pengampu-form').off('submit');
            $('#save-pengampu-button').off('click');
            $('#update-pengampu-button').off('click');
            $('.edit-btn').off('click');
            $('.delete-btn').off('click');

            $('#add-pengampu-form').on('submit', function(e) {
                e.preventDefault();

                var idDosen = $('#dosen_id').val();
                var idMatkul = $('#matkul_id').val();
                var idKelas = $('#kelas_id').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('pengampu.store') }}',
                    data: $('#add-pengampu-form').serialize(),
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
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = JSON.parse(xhr.responseText).errors;
                            if (errors.dosen_id || errors.matkul_id || errors.kelas_id) {
                                swal.fire({
                                    title: "Error!",
                                    text: "All fields are required",
                                    icon: "error",
                                    button: "OK",
                                });
                            }
                        } else {
                            console.log(xhr.responseText);
                        }
                    }
                });
            });

            $('#save-pengampu-button').on('click', function() {
                $('#add-pengampu-form').submit();
            });

            $('.edit-btn').on('click', function() {
                var id = $(this).data('id');
                $.get('/pengampu/' + id + '/edit', function(data) {
                    $('#edit-id').val(data.id);
                    $('#edit-dosen_id').val(data.dosen_id).trigger('change'); // Trigger change event
                    $('#edit-matkul_id').val(data.matkul_id).trigger('change'); // Trigger change event
                    $('#edit-kelas_id').val(data.kelas_id).trigger('change'); // Trigger change event
                    $('#editpengampuModal').modal('show');
                });
            });

            $('#update-pengampu-button').on('click', function() {
                var id = $('#edit-id').val();
                $.ajax({
                    type: 'PUT',
                    url: '/pengampu/' + id,
                    data: $('#edit-pengampu-form').serialize(),
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
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = JSON.parse(xhr.responseText).errors;
                            if (errors.dosen_id || errors.matkul_id || errors.kelas_id) {
                                swal.fire({
                                    title: "Error!",
                                    text: "All fields are required",
                                    icon: "error",
                                    button: "OK",
                                });
                            }
                        } else {
                            console.log(xhr.responseText);
                        }
                    }
                });
            });

            $('.delete-btn').on('click', function() {
                var id = $(this).data('id');
                swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this record!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '/pengampu/' + id,
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
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
        }

        bindActions();

        $('.datatable').on('draw.dt', function() {
            bindActions();
        });
    });
</script>
@endpush
