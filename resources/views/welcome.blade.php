@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Amount Due</th>
                                        <th>Registered On</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-02.jpg" alt="User Image"></a>
                                                <a href="profile.html">Brian Johnson
                                                    <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="60021209010e0a0f080e130f0e200518010d100c054e030f0d">[email&#160;protected]</a>
                                        </td>
                                        <td>$295</td>
                                        <td>16 Nov 2020</td>
                                        <td><span class="badge badge-pill bg-success-light">Active</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-03.jpg" alt="User Image"></a>
                                                <a href="profile.html">Marie Canales
                                                    <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="315c5043585452505f505d5442715449505c415d541f525e5c">[email&#160;protected]</a>
                                        </td>
                                        <td>$1750</td>
                                        <td>8 Nov 2020</td>
                                        <td><span class="badge badge-pill bg-danger-light">Inactive</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-04.jpg" alt="User Image"></a>
                                                <a href="profile.html">Barbara Moore
                                                    <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="9af8fbe8f8fbe8fbf7f5f5e8ffdaffe2fbf7eaf6ffb4f9f5f7">[email&#160;protected]</a>
                                        </td>
                                        <td>$8295</td>
                                        <td>24 Oct 2020</td>
                                        <td><span class="badge badge-pill bg-success-light">Active</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-05.jpg" alt="User Image"></a>
                                                <a href="profile.html">Greg Lynch <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="81e6f3e4e6edf8efe2e9c1e4f9e0ecf1ede4afe2eeec">[email&#160;protected]</a>
                                        </td>
                                        <td>$3000</td>
                                        <td>11 Oct 2020</td>
                                        <td><span class="badge badge-pill bg-danger-light">Inactive</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-06.jpg" alt="User Image"></a>
                                                <a href="profile.html">Karlene Chaidez
                                                    <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="6803091a040d060d0b0009010c0d12280d10090518040d460b0705">[email&#160;protected]</a>
                                        </td>
                                        <td>-</td>
                                        <td>29 Sep 2020</td>
                                        <td><span class="badge badge-pill bg-danger-light">Inactive</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-07.jpg" alt="User Image"></a>
                                                <a href="profile.html">John Blair <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="29434641474b4548405b694c51484459454c074a4644">[email&#160;protected]</a>
                                        </td>
                                        <td>$50</td>
                                        <td>13 Aug 2020</td>
                                        <td><span class="badge badge-pill bg-success-light">Active</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-08.jpg" alt="User Image"></a>
                                                <a href="profile.html">Russell Copeland
                                                    <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="85f7f0f6f6e0e9e9e6eaf5e0e9e4ebe1c5e0fde4e8f5e9e0abe6eae8">[email&#160;protected]</a>
                                        </td>
                                        <td>-</td>
                                        <td>2 Jul 2020</td>
                                        <td><span class="badge badge-pill bg-danger-light">Inactive</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-09.jpg" alt="User Image"></a>
                                                <a href="profile.html">Leatha Bailey
                                                    <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="f39f9692879b9291929a9f968ab3968b929e839f96dd909c9e">[email&#160;protected]</a>
                                        </td>
                                        <td>$480</td>
                                        <td>20 Jun 2020</td>
                                        <td><span class="badge badge-pill bg-success-light">Active</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-10.jpg" alt="User Image"></a>
                                                <a href="profile.html">Joseph Collins
                                                    <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="12787d6177627a717d7e7e7b7c6152776a737f627e773c717d7f">[email&#160;protected]</a>
                                        </td>
                                        <td>$600</td>
                                        <td>9 May 2020</td>
                                        <td><span class="badge badge-pill bg-success-light">Active</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-11.jpg" alt="User Image"></a>
                                                <a href="profile.html">Jennifer Floyd
                                                    <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="d1bbb4bfbfb8b7b4a3b7bdbea8b591b4a9b0bca1bdb4ffb2bebc">[email&#160;protected]</a>
                                        </td>
                                        <td>-</td>
                                        <td>17 Apr 2020</td>
                                        <td><span class="badge badge-pill bg-success-light">Active</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-12.jpg" alt="User Image"></a>
                                                <a href="profile.html">Alex Campbell
                                                    <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="bedfd2dbc6dddfd3cedcdbd2d2fedbc6dfd3ced2db90ddd1d3">[email&#160;protected]</a>
                                        </td>
                                        <td>-</td>
                                        <td>30 Mar 2020</td>
                                        <td><span class="badge badge-pill bg-success-light">Active</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                        class="avatar-img rounded-circle"
                                                        src="assets/img/profiles/avatar-13.jpg" alt="User Image"></a>
                                                <a href="profile.html">Wendell Ward <span>9876543210</span></a>
                                            </h2>
                                        </td>
                                        <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                data-cfemail="3a4d5f545e5f56564d5b485e7a5f425b574a565f14595557">[email&#160;protected]</a>
                                        </td>
                                        <td>$7500</td>
                                        <td>22 Feb 2020</td>
                                        <td><span class="badge badge-pill bg-success-light">Active</span></td>
                                        <td class="text-end">
                                            <a href="edit-customer.html" class="btn btn-sm btn-white text-success me-2"><i
                                                    class="far fa-edit me-1"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-white text-danger me-2"><i
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

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/datatables.min.js"></script>

    <script src="assets/js/script.js"></script>
@endsection
