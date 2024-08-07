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

            .timetable-header,
            .timetable-cell {
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

            /* Colors for different subjects */
            .matkul-1 {
                background-color: #007bff;
            }

            .matkul-2 {
                background-color: #28a745;
            }

            .matkul-3 {
                background-color: #dc3545;
            }

            .matkul-4 {
                background-color: #ffc107;
            }

            .matkul-5 {
                background-color: #17a2b8;
            }

            .matkul-6 {
                background-color: #6f42c1;
            }

            .matkul-7 {
                background-color: #fd7e14;
            }

            .matkul-8 {
                background-color: #006516;
            }

            .matkul-9 {
                background-color: #1b004d;
            }
        </style>
    @endpush

    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Jadwal</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Jadwal</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <form action="{{ route('jadwal.edit') }}" method="GET">
                    <div class="form-group">
                        <label for="kelas_id">Filter by Kelas:</label>
                        <select id="kelas_id" name="kelas_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelas as $kelasItem)
                                <option value="{{ $kelasItem->id }}"
                                    {{ $selectedKelas == $kelasItem->id ? 'selected' : '' }}>
                                    {{ $kelasItem->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dosen_id">Filter by Dosen:</label>
                        <select id="dosen_id" name="dosen_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Semua Dosen</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}" {{ $selectedDosen == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->nama_dosen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
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
                                    $colorClass = 'matkul-' . (($jadwal->pengampu->matkul->id % 8) + 1);
                                @endphp
                                <div class="list-group-item {{ $colorClass }}" data-id="{{ $jadwal->id }}">
                                    {{ $jadwal->pengampu->matkul->nama_matkul }} - {{ $jadwal->kelas->nama_kelas }} <br>
                                   {{ $jadwal->ruangan->nama_ruangan }} <br>
                                   {{ $jadwal->pengampu->dosen->nama_dosen }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
        <div class="mt-4 text-center">
            <button class="btn btn-primary" onclick="saveSchedule()">Simpan Jadwal</button>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/plugins/dragula/js/dragula.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        const containers = [];
        @foreach ($jams as $jam)
            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                containers.push(document.getElementById('list-{{ $day }}-{{ $jam->id }}').querySelector(
                    '.dragula-container'));
            @endforeach
        @endforeach

        function saveSchedule() {
            const schedule = [];
            containers.forEach(container => {
                const items = container.querySelectorAll('.list-group-item');
                const day = container.parentElement.id.split('-')[1];
                const jamId = container.parentElement.id.split('-')[2];
                items.forEach(item => {
                    schedule.push({
                        id: item.getAttribute('data-id'),
                        day: day,
                        jam_id: jamId
                    });
                });
            });

            fetch('{{ route('jadwal.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(schedule)
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Schedule updated successfully!', 'success');
                } else if (data.errors) {
                    let errorMessage = '';
                    data.errors.forEach(error => {
                        errorMessage += `${error.message} ${error.details}\n`;
                    });
                    Swal.fire('Error', errorMessage, 'error');
                } else {
                    Swal.fire('Failed', 'Failed to update schedule.', 'error');
                }
            }).catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to update schedule.', 'error');
            });
        }

        dragula(containers).on('drop', function(el, target, source, sibling) {
            // Handle drop events if needed
        });
    </script>

@endpush