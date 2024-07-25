@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="row">
            <h2 class="page-title mt-2 mb-4">Selamat Datang <b>{{ Auth::guard('dosen')->user()->nama_dosen }}!</b></h2>
        </div>
        <div class="row">
            <div class="col-xl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Info Dosen</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <marquee behavior="scroll" direction="left" style="font-size: 1.75rem; font-weight: bold; color: #5A67D8; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                            Selamat Datang Di Sistem Informasi Penjadwalan Ruang Kelas
                        </marquee>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
