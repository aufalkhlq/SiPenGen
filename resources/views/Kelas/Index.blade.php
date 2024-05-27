@extends('components.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Kelas</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kelas</li>
                </ul>
            </div>
            <div class="col-auto">
                <div class="invoices-create-btn">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addkelasModal"
                        class="btn save-invoice-btn">
                        Add Kelas
                </button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">
                            <h4 class="card-title">List of kelas</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">Nama Kelas</th>
                                            <th class="text-center">Tahun Angkatan</th>
                                            <th class="text-center">Prodi</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelas as $item)
                                        <tr>
                                            <td>{{$item->nama_kelas}}</td>
                                            <td>{{$item->tahun_angkatan}} </td>
                                            <td>{{$item->prodi}}</td>
                                            <td class="text-center"><span
                                                    class="badge badge-pill bg-success-light">Active</span></td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-success me-2 edit-btn"
                                                 ><i
                                                        class="far fa-edit me-1"></i>
                                                    Edit</button>
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger me-2 delete-btn"
                                                 >
                                                    <i class="far fa-trash-alt me-1"></i>Delete</button>
                                            </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Add kelas Modal --}}
            <div class="modal fade" id="addkelasModal" tabindex="-1" aria-labelledby="addkelasModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addkelasModalLabel">Add Kelas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="add-kelas-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                    <input type="text" class="form-control" id="nama_kelas" name="nama_kelas"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="tahun_angkatan" class="form-label">Tahun Angkatan</label>
                                    <input type="number" class="form-control" id="tahun_angkatan" name="tahun_angkatan" required>
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
                            <button type="button" class="btn btn-primary" id="save-kelas-button">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            {{--  Edit kelas Modal --}}
            <div class="modal fade" id="editkelasModal" tabindex="-1" aria-labelledby="editkelasModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editkelasModalLabel">Edit kelas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="edit-kelas-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="edit-nama_kelas" class="form-label">Nama kelas</label>
                                    <input type="text" class="form-control" id="edit-nama_kelas" name="edit-nama_kelas"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-tahun" class="form-label">Tahun Angkatan</label>
                                    <input type="number" class="form-control" id="edit-tahun" name="edit-tahun" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-prodi" class="form-label">Prodi</label>
                                    <select class="form-select" id="edit-prodi" name="edit-prodi" required>
                                        <option selected disabled>Select Prodi</option>
                                        <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
                                        <option value="D4 Teknologi Rekayasa Komputer">D4 Teknologi Rekayasa Komputer</option>
                                        <option value="D3 Teknik Elektro">D3 Teknik Elektro</option>
                                </div>
                                <input type="hidden" id="edit-id" name="id">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="update-kelas-button">Update
                                kelas</button>
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
            $('#save-kelas-button').click(function(e) {
                e.preventDefault();
                if (!$('#nama_kelas').val() || !$('#tahun_angkatan').val()) {
                    swal.fire({
                        title: "Error!",
                        text: "Nama kelas and NIP are required.",
                        icon: "error",
                        button: "OK",
                    });
                    return;
                }
                if (!$('#prodi').val()) {
                    swal.fire({
                        title: "Error!",
                        text: "Silahkan Pilih Salah Satu Prodi.",
                        icon: "error",
                        button: "OK",
                    })
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('kelas.store') }}',
                    data: $('#add-kelas-form').serialize(),
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
                });
            });
        });
  </script>
@endpush

