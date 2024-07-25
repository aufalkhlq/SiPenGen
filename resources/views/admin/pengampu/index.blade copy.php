@extends('components.app')
@section('content')
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
                            Add Pengampu
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-header">
                        <h4 class="card-title">List of Pengampu</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Dosen</th>
                                        <th class="text-center">Mata Kuliah</th>
                                        <th class="text-center">Actions</th>
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
                                            <td class="text-center">
                                                @php
                                                    $matkul_id = json_decode($pengampu->matkul_id, true);
                                                @endphp

                                                @if (is_array($matkul_id))
                                                    @php
                                                        $counter = 0;
                                                    @endphp
                                                    @foreach ($matkul_id as $id)
                                                        @if (isset($matkuls[$id]))
                                                            <span
                                                                class="badge bg-success">{{ $matkuls[$id]->nama_matkul }}</span>
                                                            @php
                                                                $counter++;
                                                            @endphp
                                                            @if ($counter % 4 == 0)
                                                                <br>
                                                                <br>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-success me-2 edit-btn">
                                                    <i class="far fa-edit me-1"></i>Edit
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger me-2 delete-btn">
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
                    <h5 class="modal-title" id="addpengampuModalLabel">Add pengampu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-pengampu-form">
                        @csrf
                        <div class="mb-3">
                            <label for="dosen_id" class="form-label">Nama Dosen</label>
                            <select class="form-select" id="dosen_id" name="dosen_id" required>
                                <option selected disabled>Select Dosen</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama_dosen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="matkul_id" class="form-label">Mata Kuliah</label>
                            <select class="form-control tagging" multiple="multiple" tabindex="-4" style="z-index: 1052;">
                                @foreach ($matkuls as $matkul)
                                    <option value="{{ $matkul->id }}">{{ $matkul->nama_matkul }}</option>
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
    {{--  Edit pengampu Modal --}}
    <div class="modal fade" id="editpengampuModal" tabindex="-1" aria-labelledby="editpengampuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editpengampuModalLabel">Edit pengampu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-pengampu-form">
                        @csrf
                        <div class="mb-3">
                            <label for="edit-nama_pengampu" class="form-label">Nama pengampu</label>
                            <input type="text" class="form-control" id="edit-nama_pengampu" name="edit-nama_pengampu"
                                required>
                        </div>

                        <input type="hidden" id="edit-id" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-pengampu-button">Update
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
@endpush 
@push('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            if ($.fn.select2) {
                $(".tagging").select2({
                    dropdownParent: $("#addpengampuModal") // append dropdown to modal
                });
            } else {
                console.error('Select2 is not loaded');
            }

            $('#add-pengampu-form').on('submit', function(e) {
                e.preventDefault();

                // Get selected options
                var selectedOptions = $('.tagging').val();
                var idDosen = $('#dosen_id').val();
                var idMatkul = selectedOptions.join(',');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('pengampu.store') }}',
                    data: {
                        ...$(this).serializeArray().reduce((obj, item) => {
                            obj[item.name] = item.value;
                            return obj;
                        }, {}),
                        matkul_id: selectedOptions,
                        dosen_id: idDosen
                    },
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
                        if (xhr.status === 422) { // Laravel validation error status code
                            var errors = JSON.parse(xhr.responseText).errors;
                            if (errors.dosen_id) {
                                swal.fire({
                                    title: "Error!",
                                    text: "The selected dosen has already been added.",
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


            $('#save-pengampu-button').click(function() {
                $('#add-pengampu-form').submit();
            });
        });
    </script>
@endpush
