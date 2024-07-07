@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="row">
            <h2 class="page-title mt-2 mb-4">Selamat Datang <b>{{ Auth::guard('dosen')->user()->nama_dosen }}!</b></h2>
        </div>
        <div class="row">
            <div class="col-xl-7 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Info Dosen</h5>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
