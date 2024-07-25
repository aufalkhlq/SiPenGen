@extends('components.app')
@section('title', 'Edit Jadwal')
@section('content')
    @push('style')
        <link rel="stylesheet" href="{{ asset('assets/plugins/dragula/css/dragula.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
        <style>
            .timetable {
                display: grid;
                grid-template-columns: 120px repeat(5, 1fr);
                grid-template-rows: 50px repeat(14, 1fr);
                gap: 10px;
            }
            .timetable-header, .timetable-cell {
                border: 1px solid #dee2e6;
                padding: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 5px;
            }
            .timetable-cell {
                min-height: 140px;
                background-color: #f8f9fa;
                position: relative;
                transition: background-color 0.3s, transform 0.3s;
            }
            .timetable-cell:hover {
                background-color: #e2e6ea;
                transform: scale(1.02);
            }
            .dragula-container {
                display: flex;
                flex-direction: column;
                gap: 10px;
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
            }
            .list-group-item {
                color: white;
                padding: 10px;
                border-radius: 5px;
                cursor: move;
                margin: 2px 0;
                transition: background-color 0.3s, transform 0.3s;
            }
            .list-group-item:hover {
                transform: scale(1.05);
            }
            /* Colors for different classes */
            .kelas-1 { background-color: #007bff; }
            .kelas-2 { background-color: #28a745; }
            .kelas-3 { background-color: #dc3545; }
            .kelas-4 { background-color: #ffc107; }
            .kelas-5 { background-color: #17a2b8; }
            .kelas-6 { background-color: #6f42c1; }
            .kelas-7 { background-color: #fd7e14; }
            .kelas-8 { background-color: #343a40; }
        </style>
    @endpush

    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Jadwal Dosen</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Jadwal Dosen</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <div class="invoices-create-btn">
                        <form action="{{ route('dosen.jadwalcetak') }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary" id="printpdf-button">Cetak Excel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="timetable mt-4">
            <!-- Header Row for Days -->
            <div class="timetable-header">Jam/Hari</div>
            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                <div class="timetable-header">{{ $hari }}</div>
            @endforeach
            <!-- Time Rows and Schedule Cells -->
            @foreach ($jams as $jam)
                <div class="timetable-header">{{ $jam->waktu }}</div>
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                    <div class="timetable-cell" id="list-{{ $day }}-{{ $jam->id }}">
                        <div class="dragula-container">
                            @foreach ($jadwals->where('jam.id', $jam->id)->where('hari.hari', $day) as $jadwal)
                                @php
                                    $colorClass = 'kelas-' . (($jadwal->kelas->id % 8) + 1);
                                @endphp
                                <div class="list-group-item {{ $colorClass }}" data-id="{{ $jadwal->id }}">
                                    {{ $jadwal->pengampu->matkul->nama_matkul }}
                                    {{ $jadwal->kelas->nama_kelas }}
                                    <br>
                                    ({{ $jadwal->jam->waktu }})
                                    - {{ $jadwal->ruangan->nama_ruangan }}
                                    <br>
                                    {{ $jadwal->pengampu->dosen->nama_dosen }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
