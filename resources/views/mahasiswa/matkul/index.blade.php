@extends('components.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Mata Kuliah</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Mata Kuliah</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-header">
                    <h4 class="card-title">Daftar Mata Kuliah</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0 datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">Mata Kuliah</th>
                                    <th class="text-center">Kode Mata Kuliah</th>
                                    <th class="text-center">Dosen</th>
                                    <th class="text-center">SKS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengampus as $pengampu)
                                    <tr>
                                        <td class="text-center">{{ $pengampu->matkul->nama_matkul }}</td>
                                        <td class="text-center">{{ $pengampu->matkul->kode_matkul }}</td>
                                        <td class="text-center">{{ $pengampu->dosen->nama_dosen }}</td>
                                        <td class="text-center">{{ $pengampu->matkul->sks }}</td>
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
@endsection
