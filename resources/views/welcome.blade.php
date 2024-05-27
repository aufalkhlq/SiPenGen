@extends('components.app')
@section('content')


    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Form Select2</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Form Select2</li>
                            </ul>
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
                </div>

                <div class="row">
                    <div class="col-md-6">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Basic</h5>
                            </div>
                            <div class="modal fade" id="addpengampuModal" tabindex="-1" aria-labelledby="addpengampuModalLabel" aria-hidden="true">
                                <div class="modal-dialog" style="z-index: 1051;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addpengampuModalLabel">Add pengampu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="add-pengampu-form">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="id_dosen" class="form-label">Nama Dosen</label>
                                                    <select class="form-select" id="id_dosen" name="id_dosen" required style="z-index: 1052;">
                                                        <option selected disabled>Select Dosen</option>
                                                        <!-- Isi dengan opsi-opsi pilihan Dosen -->
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="id_matkul" class="form-label">Mata Kuliah</label>
                                                    <select class="form-control tagging" multiple="multiple" tabindex="-4" style="z-index: 1052;">
                                                        <option>orange</option>
                                                        <option>white</option>
                                                        <option>purple</option>
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

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Use select2() function on select element to convert it to Select 2.</p>
                                        <select class="js-example-basic-single select2">
                                            <option selected="selected">orange</option>
                                            <option>white</option>
                                            <option>purple</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Nested</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Add options inside the optgroups to for group options.</p>
                                        <select class="form-control nested">
                                            <optgroup label="Group1">
                                                <option selected="selected">orange</option>
                                                <option>white</option>
                                                <option>purple</option>
                                            </optgroup>
                                            <optgroup label="Group2">
                                                <option>purple</option>
                                                <option>orange</option>
                                                <option>white</option>
                                            </optgroup>
                                            <optgroup label="Group3">
                                                <option>white</option>
                                                <option>purple</option>
                                                <option>orange</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Placeholder</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Apply Placeholder by setting option placeholder option.</p>
                                        <select class="placeholder js-states form-control">
                                            <option>Choose...</option>
                                            <option value="one">First</option>
                                            <option value="two">Second</option>
                                            <option value="three">Third</option>
                                            <option value="four">Fourth</option>
                                            <option value="five">Fifth</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Tagging with multi-value select boxes</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Set tags: true to convert select 2 in Tag mode.</p>
                                        <select class="form-control tagging" multiple="multiple">
                                            <option>orange</option>
                                            <option>white</option>
                                            <option>purple</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Small Select2</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Use data('select2') function to get container of select2.</p>
                                        <select class="form-control form-small select">
                                            <option selected="selected">orange</option>
                                            <option>white</option>
                                            <option>purple</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Disabling options</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Disable Select using disabled attribute.</p>
                                        <select class="form-control disabled-results">
                                            <option value="one">First</option>
                                            <option value="two" disabled="disabled">Second</option>
                                            <option value="three">Third</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Limiting the number of Tagging</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Set maximumSelectionLength: 2 with tags: true to limit selectin in Tag mode.
                                        </p>
                                        <select class="form-control tagging" multiple="multiple">
                                            <option>orange</option>
                                            <option>white</option>
                                            <option>purple</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('script')

    <script>
        $(document).ready(function() {
            // Check if Select2 is loaded
            if ($.fn.select2) {
                $(".tagging").select2({
                    dropdownParent: $("#addpengampuModal") // append dropdown to modal
                });
            } else {
                console.error('Select2 is not loaded');
            }
        });
    </script>
    @endpush

