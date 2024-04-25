@extends('components.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Hari</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Hari</li>
                </ul>
            </div>
            <div class="col-auto">
                <div class="invoices-create-btn">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addhariModal"
                        class="btn save-invoice-btn">
                        Add Hari
                </button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">
                            <h4 class="card-title">List of Hari</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">No </th>
                                            <th class="text-center">Nama Hari</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Add hari Modal --}}
            <div class="modal fade" id="addhariModal" tabindex="-1" aria-labelledby="addhariModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addhariModalLabel">Add hari</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="add-hari-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_hari" class="form-label">Nama hari</label>
                                    <input type="text" class="form-control" id="nama_hari" name="nama_hari"
                                        required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="save-hari-button">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            {{--  Edit hari Modal --}}
            <div class="modal fade" id="edithariModal" tabindex="-1" aria-labelledby="edithariModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edithariModalLabel">Edit hari</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="edit-hari-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="edit-nama_hari" class="form-label">Nama hari</label>
                                    <input type="text" class="form-control" id="edit-nama_hari" name="edit-nama_hari"
                                        required>
                                </div>

                                <input type="hidden" id="edit-id" name="id">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="update-hari-button">Update
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

@endpush
