@extends('components.app')
@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Items </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Items List</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card invoices-tabs-card">
            <div class="card-body card-body pt-0 pb-0">
                <div class="invoices-items-main-tabs">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-md-12">
                            <div class="invoices-items-tabs">
                                <ul>
                                    <li><a href="invoice-items.html" class="active">All Items</a></li>
                                    <li><a href="{{route('user')}}">Category</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card invoices-tabs-card">
            <div class="card-body card-body pt-0 pb-0">
                <div class="invoices-main-tabs border-0 pb-0">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-md-12">
                            <div class="invoices-settings-btn invoices-settings-btn-one">
                                <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#add_items">
                                    <i data-feather="plus-circle"></i> Add New Item
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Pricing</th>
                                        <th>Discount (%)</th>
                                        <th>Description</th>
                                        <th>Date Added</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label class="custom_check">
                                                <input type="checkbox" name="invoice">
                                                <span class="checkmark"></span>
                                            </label>
                                            <a href="#" class="items-links">GoMechanic Neutron 600...</a>
                                        </td>
                                        <td class="text-primary">$1,542</td>
                                        <td>23</td>
                                        <td class="items-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </td>
                                        <td>16 Mar 2022</td>
                                        <td class="text-end">
                                            <a href="edit-invoice.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a class="btn btn-sm btn-white text-danger" href="#"
                                                data-bs-toggle="modal" data-bs-target="#delete_paid"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="custom_check">
                                                <input type="checkbox" name="invoice">
                                                <span class="checkmark"></span>
                                            </label>
                                            <a href="#" class="items-links">Car Wash Shampoo 250ml...</a>
                                        </td>
                                        <td class="text-primary">$1,222</td>
                                        <td>40</td>
                                        <td class="items-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </td>
                                        <td>14 Mar 2022</td>
                                        <td class="text-end">
                                            <a href="edit-invoice.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a class="btn btn-sm btn-white text-danger" href="#"
                                                data-bs-toggle="modal" data-bs-target="#delete_paid"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="custom_check">
                                                <input type="checkbox" name="invoice">
                                                <span class="checkmark"></span>
                                            </label>
                                            <a href="#" class="items-links">Bosch 1300W High Pressure...</a>
                                        </td>
                                        <td class="text-primary">$3,470</td>
                                        <td>31</td>
                                        <td class="items-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </td>
                                        <td>7 Mar 2022</td>
                                        <td class="text-end">
                                            <a href="edit-invoice.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a class="btn btn-sm btn-white text-danger" href="#"
                                                data-bs-toggle="modal" data-bs-target="#delete_paid"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="custom_check">
                                                <input type="checkbox" name="invoice">
                                                <span class="checkmark"></span>
                                            </label>
                                            <a href="#" class="items-links">Clear Coat Spray -Quick Dr...9</a>
                                        </td>
                                        <td class="text-primary">$8,265</td>
                                        <td>60</td>
                                        <td class="items-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </td>
                                        <td>24 Mar 2022</td>
                                        <td class="text-end">
                                            <a href="edit-invoice.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a class="btn btn-sm btn-white text-danger" href="#"
                                                data-bs-toggle="modal" data-bs-target="#delete_paid"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="custom_check">
                                                <input type="checkbox" name="invoice">
                                                <span class="checkmark"></span>
                                            </label>
                                            <a href="#" class="items-links">Aquatak High Pressure Wash.</a>
                                        </td>
                                        <td class="text-primary">$5,200</td>
                                        <td>50</td>
                                        <td class="items-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        </td>
                                        <td>17 Mar 2022</td>
                                        <td class="text-end">
                                            <a href="edit-invoice.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a class="btn btn-sm btn-white text-danger" href="#"
                                                data-bs-toggle="modal" data-bs-target="#delete_paid"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="modal custom-modal fade bank-details" id="add_items" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-header text-start mb-0">
                        <h4 class="mb-0">Create New Item</h4>
                    </div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="bank-inner-details">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input type="text" class="form-control" placeholder="Add New Item">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-select form-control">
                                        <option>Select category</option>
                                        <option>GoMechanic Neutron 600</option>
                                        <option>Car Wash Shampoo 250ml</option>
                                        <option>Bosch 1300W High Pressure...</option>
                                        <option>Clear Coat Spray -Quick Dr...9</option>
                                        <option>Aquatak High Pressure Wash.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Price Per unit</label>
                                    <input type="text" class="form-control" placeholder="$">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" class="form-control" placeholder="%">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Description (Optional) </label>
                                    <textarea class="form-control" placeholder="Add item description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="bank-details-btn">
                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn bank-cancel-btn me-2">Cancel</a>
                        <a href="javascript:void(0);" class="btn bank-save-btn">Save Item</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal custom-modal fade" id="delete_paid" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Invoice Iems</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary paid-continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-bs-dismiss="modal"
                                    class="btn btn-primary paid-cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
