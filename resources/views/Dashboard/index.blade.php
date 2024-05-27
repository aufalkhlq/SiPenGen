@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="row">

            <h2 class="page-title mt-2 mb-4">Selamat Datang <b>{{ Auth::user()->name }}!</b></h2>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-5">
                                <i class="fas fa-user"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Total User</div>
                                <div class="dash-counts">
                                    <p class="h3 text-warning me-5">{{$users}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-3">
                            <div class="progress-bar bg-5" role="progressbar" style="width: 75%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-6">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Total Dosen</div>
                                <div class="dash-counts">
                                    <p class="h3 text-info me-5">{{$dosens}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-3">
                            <div class="progress-bar bg-6" role="progressbar" style="width: 65%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-7">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Total Mata Kuliah</div>
                                <div class="dash-counts">
                                    <p class="h3 text-success me-5">{{$matkuls}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-3">
                            <div class="progress-bar bg-7" role="progressbar" style="width: 85%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-primary">
                                <i class="far fa-file"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Total Ruangan</div>
                                <div class="dash-counts">
                                    <p class="h3 text-primary me-5">{{$ruangans}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-3">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 45%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-7 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Sales Analytics</h5>
                            <div class="dropdown">
                                <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Monthly
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Weekly</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Monthly</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Yearly</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap">
                            <div class="w-md-100 d-flex align-items-center mb-3 flex-wrap flex-md-nowrap">
                                <div>
                                    <span>Total Sales</span>
                                    <p class="h3 text-primary me-5">$1000</p>
                                </div>
                                <div>
                                    <span>Receipts</span>
                                    <p class="h3 text-success me-5">$1000</p>
                                </div>
                                <div>
                                    <span>Expenses</span>
                                    <p class="h3 text-danger me-5">$300</p>
                                </div>
                                <div>
                                    <span>Earnings</span>
                                    <p class="h3 text-dark me-5">$700</p>
                                </div>
                            </div>
                        </div>
                        <div id="sales_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Invoice Analytics</h5>
                            <div class="dropdown">
                                <button class="btn btn-white btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Monthly
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Weekly</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Monthly</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Yearly</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="invoice_chart"></div>
                        <div class="text-center text-muted">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mt-4">
                                        <p class="mb-2 text-truncate"><i class="fas fa-circle text-primary me-1"></i>
                                            Invoiced</p>
                                        <h5>$2,132</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-4">
                                        <p class="mb-2 text-truncate"><i class="fas fa-circle text-success me-1"></i>
                                            Received</p>
                                        <h5>$1,763</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-4">
                                        <p class="mb-2 text-truncate"><i class="fas fa-circle text-danger me-1"></i>
                                            Pending</p>
                                        <h5>$973</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Recent Invoices</h5>
                            </div>
                            <div class="col-auto">
                                <a href="invoices.html" class="btn-right btn btn-sm btn-outline-primary">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="progress progress-md rounded-pill mb-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 47%"
                                    aria-valuenow="47" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 28%"
                                    aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 15%"
                                    aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%"
                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <i class="fas fa-circle text-success me-1"></i> Paid
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-circle text-warning me-1"></i> Unpaid
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-circle text-danger me-1"></i> Overdue
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-circle text-info me-1"></i> Draft
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html"><img
                                                        class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-04.jpg" alt="User Image">Barbara
                                                    Moore</a>
                                            </h2>
                                        </td>
                                        <td>$118</td>
                                        <td>23 Nov 2020</td>
                                        <td><span class="badge bg-success-light">Paid</span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-invoice.html"><i
                                                            class="far fa-edit me-2"></i>Edit</a>
                                                    <a class="dropdown-item" href="view-invoice.html"><i
                                                            class="far fa-eye me-2"></i>View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        sent</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-paper-plane me-2"></i>Send Invoice</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-copy me-2"></i>Clone Invoice</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html"><img
                                                        class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-06.jpg" alt="User Image">Karlene
                                                    Chaidez</a>
                                            </h2>
                                        </td>
                                        <td>$222</td>
                                        <td>18 Nov 2020</td>
                                        <td><span class="badge bg-info-light">Sent</span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-invoice.html"><i
                                                            class="far fa-edit me-2"></i>Edit</a>
                                                    <a class="dropdown-item" href="view-invoice.html"><i
                                                            class="far fa-eye me-2"></i>View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        sent</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-paper-plane me-2"></i>Send Invoice</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-copy me-2"></i>Clone Invoice</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html"><img
                                                        class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-08.jpg" alt="User Image">Russell
                                                    Copeland</a>
                                            </h2>
                                        </td>
                                        <td>$347</td>
                                        <td>10 Nov 2020</td>
                                        <td><span class="badge bg-warning-light">Partially Paid</span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-invoice.html"><i
                                                            class="far fa-edit me-2"></i>Edit</a>
                                                    <a class="dropdown-item" href="view-invoice.html"><i
                                                            class="far fa-eye me-2"></i>View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        sent</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-paper-plane me-2"></i>Send Invoice</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-copy me-2"></i>Clone Invoice</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html"><img
                                                        class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-10.jpg" alt="User Image">Joseph
                                                    Collins</a>
                                            </h2>
                                        </td>
                                        <td>$826</td>
                                        <td>25 Sep 2020</td>
                                        <td><span class="badge bg-danger-light">Overdue</span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-invoice.html"><i
                                                            class="far fa-edit me-2"></i>Edit</a>
                                                    <a class="dropdown-item" href="view-invoice.html"><i
                                                            class="far fa-eye me-2"></i>View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        sent</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-paper-plane me-2"></i>Send Invoice</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-copy me-2"></i>Clone Invoice</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html"><img
                                                        class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-11.jpg" alt="User Image">Jennifer
                                                    Floyd</a>
                                            </h2>
                                        </td>
                                        <td>$519</td>
                                        <td>18 Sep 2020</td>
                                        <td><span class="badge bg-success-light">Paid</span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-invoice.html"><i
                                                            class="far fa-edit me-2"></i>Edit</a>
                                                    <a class="dropdown-item" href="view-invoice.html"><i
                                                            class="far fa-eye me-2"></i>View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        sent</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-paper-plane me-2"></i>Send Invoice</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-copy me-2"></i>Clone Invoice</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Recent Estimates</h5>
                            </div>
                            <div class="col-auto">
                                <a href="estimates.html" class="btn-right btn btn-sm btn-outline-primary">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="progress progress-md rounded-pill mb-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 39%"
                                    aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 35%"
                                    aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 26%"
                                    aria-valuenow="26" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <i class="fas fa-circle text-success me-1"></i> Sent
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-circle text-warning me-1"></i> Draft
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-circle text-danger me-1"></i> Expired
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Expiry Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html"><img
                                                        class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-05.jpg" alt="User Image"> Greg
                                                    Lynch</a>
                                            </h2>
                                        </td>
                                        <td>5 Nov 2020</td>
                                        <td>$175</td>
                                        <td><span class="badge bg-info-light">Sent</span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-invoice.html"><i
                                                            class="far fa-edit me-2"></i>Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                    <a class="dropdown-item" href="view-estimate.html"><i
                                                            class="far fa-eye me-2"></i>View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-file-alt me-2"></i>Convert to
                                                        Invoice</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        sent</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-paper-plane me-2"></i>Send
                                                        Estimate</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        Accepted</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-times-circle me-2"></i>Mark as
                                                        Rejected</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html"><img
                                                        class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-06.jpg" alt="User Image"> Karlene
                                                    Chaidez</a>
                                            </h2>
                                        </td>
                                        <td>28 Oct 2020</td>
                                        <td>$1500</td>
                                        <td><span class="badge bg-warning-light">Expired</span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-invoice.html"><i
                                                            class="far fa-edit me-2"></i>Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                    <a class="dropdown-item" href="view-estimate.html"><i
                                                            class="far fa-eye me-2"></i>View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-file-alt me-2"></i>Convert to
                                                        Invoice</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        sent</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-paper-plane me-2"></i>Send
                                                        Estimate</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        Accepted</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-times-circle me-2"></i>Mark as
                                                        Rejected</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html"><img
                                                        class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-07.jpg" alt="User Image"> John
                                                    Blair</a>
                                            </h2>
                                        </td>
                                        <td>17 Oct 2020</td>
                                        <td>$2350</td>
                                        <td><span class="badge bg-success-light">Accepted</span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-invoice.html"><i
                                                            class="far fa-edit me-2"></i>Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                    <a class="dropdown-item" href="view-estimate.html"><i
                                                            class="far fa-eye me-2"></i>View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-file-alt me-2"></i>Convert to
                                                        Invoice</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        sent</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-paper-plane me-2"></i>Send
                                                        Estimate</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        Accepted</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-times-circle me-2"></i>Mark as
                                                        Rejected</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html"><img
                                                        class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-08.jpg" alt="User Image"> Russell
                                                    Copeland</a>
                                            </h2>
                                        </td>
                                        <td>8 Oct 2020</td>
                                        <td>$1890</td>
                                        <td><span class="badge bg-success-light">Accepted</span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-invoice.html"><i
                                                            class="far fa-edit me-2"></i>Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                    <a class="dropdown-item" href="view-estimate.html"><i
                                                            class="far fa-eye me-2"></i>View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-file-alt me-2"></i>Convert to
                                                        Invoice</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        sent</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-paper-plane me-2"></i>Send
                                                        Estimate</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        Accepted</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-times-circle me-2"></i>Mark as
                                                        Rejected</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html"><img
                                                        class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-09.jpg" alt="User Image"> Leatha
                                                    Bailey</a>
                                            </h2>
                                        </td>
                                        <td>30 Sep 2020</td>
                                        <td>$785</td>
                                        <td><span class="badge bg-success-light">Accepted</span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-invoice.html"><i
                                                            class="far fa-edit me-2"></i>Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-trash-alt me-2"></i>Delete</a>
                                                    <a class="dropdown-item" href="view-estimate.html"><i
                                                            class="far fa-eye me-2"></i>View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-file-alt me-2"></i>Convert to
                                                        Invoice</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        sent</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-paper-plane me-2"></i>Send
                                                        Estimate</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-check-circle me-2"></i>Mark as
                                                        Accepted</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="far fa-times-circle me-2"></i>Mark as
                                                        Rejected</a>
                                                </div>
                                            </div>
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
@endsection
