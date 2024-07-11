@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="row">

            <h2 class="page-title mt-2 mb-4">Selamat Datang <b>{{ Auth::user()->name }}!</b></h2>
            <div class="col-xl-4 col-sm-6 col-12">
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
            <div class="col-xl-4 col-sm-6 col-12">
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
            <div class="col-xl-4 col-sm-6 col-12">
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
            <div class="col-xl-4 col-sm-6 col-12">
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
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-primary">
                                <i class="far fa-file"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Total Mahasiswa </div>
                                <div class="dash-counts">
                                    <p class="h3 text-primary me-5">{{$mahasiswas}}</p>
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
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-primary">
                                <i class="far fa-file"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Total Kelas</div>
                                <div class="dash-counts">
                                    <p class="h3 text-primary me-5">{{$kelas}}</p>
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
    </div>
@endsection
