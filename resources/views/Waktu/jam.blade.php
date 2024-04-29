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
                                        {{-- <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
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
                                        </tr>
                                    </tbody> --}}
                                        <tbody>
                                            @foreach ($jams as $jam)
                                                <tr>
                                                    <td>{{ $jam->jam }}</td>
                                                    <td>{{ $jam->waktu }} </td>
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

                {{--  Edit ruangan Modal --}}
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
                                <button type="button" class="btn btn-primary" id="update-jam-button">Update
                                </button>
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
