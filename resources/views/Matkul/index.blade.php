@extends('components.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Mata Kuliah</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Mata Kuliah</li>
                </ul>
            </div>
            <div class="col-auto">
                <div class="invoices-create-btn">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addmatkulModal"
                        class="btn save-invoice-btn">
                        Add Mata Kuliah
                </button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">
                            <h4 class="card-title">List of Mata Kuliah</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">Nama Mata Kuliah</th>
                                            <th class="text-center">Kode Mata Kuliah</th>
                                            <th class="text-center">SKS</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($matkuls as $matkul)
                                        <tr>
                                            <td>{{$matkul->nama_matkul}}</td>
                                            <td>{{$matkul->kode_matkul}}</td>
                                            <td>{{$matkul->sks}}</td>
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

            {{-- Add matkul Modal --}}
            <div class="modal fade" id="addmatkulModal" tabindex="-1" aria-labelledby="addmatkulModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addmatkulModalLabel">Add Mata Kuliah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="add-matkul-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
                                    <input type="text" class="form-control" id="nama_matkul" name="nama_matkul"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_matkul" class="form-label">Kode Mata Kuliah</label>
                                    <input type="text" class="form-control" id="kode_matkul" name="kode_matkul" required>
                                </div>
                                <div class="mb-3">
                                    <label for="sks" class="form-label">SKS</label>
                                    <input type="number" class="form-control" id="sks" name="sks" required>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="save-matkul-button">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            {{--  Edit matkul Modal --}}
            <div class="modal fade" id="editmatkulModal" tabindex="-1" aria-labelledby="editmatkulModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editmatkulModalLabel">Edit matkul</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="edit-matkul-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="edit-nama_matkul" class="form-label">Nama matkul</label>
                                    <input type="text" class="form-control" id="edit-nama_matkul" name="edit-nama_matkul"
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
                            <button type="button" class="btn btn-primary" id="update-matkul-button">Update
                                matkul</button>
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
        $('#save-matkul-button').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '{{ route('matkul.store') }}',
                data: $('#add-matkul-form').serialize(),
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

