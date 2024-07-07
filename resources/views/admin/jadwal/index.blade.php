@extends('components.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Jadwal</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Jadwal</li>
                </ul>
            </div>
            <div class="col-auto">
                <div class="invoices-create-btn">
                    <form action="{{ route('jadwal.generate') }}" method="POST" id="confirm-text">
                        @csrf
                        <button type="button" class="btn btn-primary" id="generate-button">Generate Schedule</button>
                    </form>
                </div>
            </div>
            <div class="col-auto">
                <div class="invoices-create-btn">
                    <button type="button" class="btn btn-warning" id="check-conflicts-button">Check Conflicts</button>
                </div>
            </div>
            <div class="col-auto">
                <div class="invoices-create-btn">
                    <form action="{{ route('jadwal.delete') }}" method="POST" id="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" id="delete-button">Delete All</button>
                    </form>
                </div>
            </div>
            <div class="col-auto">
                <div class="invoices-create-btn">
                    <form action="{{ route('jadwal.printpdf') }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-secondary" id="printpdf-button">Print PDF</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="row">
                <div class="col">
                    <form action="{{ route('jadwal') }}" method="GET">
                        <div class="form-group">
                            <label for="kelas_id">Filter by Kelas:</label>
                            <select id="kelas_id" name="kelas_id" class="form-control" onchange="this.form.submit()">
                                <option value="">Select Kelas</option>
                                @foreach($kelas as $kelasItem)
                                <option value="{{ $kelasItem->id }}" {{ $selectedKelas == $kelasItem->id ? 'selected' : '' }}>
                                    {{ $kelasItem->nama_kelas }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-header">
                        <h4 class="card-title">Generated Jadwal</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Dosen</th>
                                        <th>Mata Kuliah</th>
                                        <th>Kode Mata Kuliah</th>
                                        <th>Ruangan</th>
                                        <th>Jam</th>
                                        <th>Hari</th>
                                        <th>Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwals as $item)
                                    @php
                                        $hasConflict = false;
                                        foreach ($conflicts as $conflict) {
                                            if ($conflict['kelas1'] == $item->kelas->nama_kelas &&
                                                $conflict['hari1'] == $item->hari->hari &&
                                                $conflict['jam1'] == $item->jam->waktu) {
                                                $hasConflict = true;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <tr class="{{ $hasConflict ? 'table-danger' : '' }}">
                                        <td>{{ $item->pengampu->dosen->nama_dosen }}</td>
                                        <td>{{ $item->pengampu->matkul->nama_matkul }}</td>
                                        <td>{{ $item->pengampu->matkul->kode_matkul }}</td>
                                        <td>{{ $item->ruangan->nama_ruangan }}</td>
                                        <td>{{ $item->jam->waktu }}</td>
                                        <td>{{ $item->hari->hari }}</td>
                                        <td>{{ $item->kelas->nama_kelas }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conflict Results Modal -->
        <div class="modal fade" id="conflictModal" tabindex="-1" role="dialog" aria-labelledby="conflictModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="conflictModalLabel">Conflict Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Kelas 1</th>
                                        <th>Dosen 1</th>
                                        <th>Mata Kuliah 1</th>
                                        <th>Kelas 2</th>
                                        <th>Dosen 2</th>
                                        <th>Mata Kuliah 2</th>
                                        <th>Tipe Konflik</th>
                                    </tr>
                                </thead>
                                <tbody id="conflict-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('script')
<script>
      $(document).ready(function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif
    })
    $('#generate-button').on('click', function(e) {

        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to generate schedule?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Generate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let startTime = Date.now(); // Record the start time

                Swal.fire({
                    title: 'Generating Schedule...',
                    html: 'Elapsed time: <span id="elapsed-time">0</span>s',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                        const elapsedTimeElement = Swal.getHtmlContainer().querySelector('#elapsed-time');
                        const timerInterval = setInterval(() => {
                            let elapsedTime = ((Date.now() - startTime) / 1000).toFixed(1); // Calculate elapsed time in seconds
                            elapsedTimeElement.textContent = elapsedTime;
                        }, 1000); // Update every second

                        // Trigger the actual schedule generation process
                        generateSchedule(startTime);
                    }
                });
            }
        });
    });

    async function generateSchedule(startTime) {
        try {
            const response = await fetch('{{ route('jadwal.generate') }}', {
                method: 'POST',
                body: new URLSearchParams(new FormData($('#confirm-text')[0]))
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            let totalTime = ((Date.now() - startTime) / 1000).toFixed(1); // Calculate total time in seconds
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: `Schedule generated successfully in ${totalTime} seconds.`,
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: `Failed to initiate schedule generation: ${error.message}. Please try again.`,
                confirmButtonText: 'OK'
            });
        }
    }

    $('#check-conflicts-button').on('click', function(e) {
        e.preventDefault();
        checkConflicts();
    });

    async function checkConflicts() {
        try {
            const response = await fetch('{{ route('jadwal.conflicts') }}', {
                method: 'GET',
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            let content = '';

            if (data.conflicts.length === 0) {
                content = '<tr><td colspan="7">No conflicts found!</td></tr>';
            } else {
                data.conflicts.forEach(conflict => {
                    content += `
                        <tr>
                            <td>${conflict.kelas1}</td>
                            <td>${conflict.dosen1}</td>
                            <td>${conflict.mata_kuliah1}</td>
                            <td>${conflict.kelas2}</td>
                            <td>${conflict.dosen2}</td>
                            <td>${conflict.mata_kuliah2}</td>
                            <td>${conflict.type}</td>
                        </tr>
                    `;
                });
            }

            $('#conflict-table-body').html(content);
            $('#conflictModal').modal('show');

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: `Failed to check conflicts: ${error.message}. Please try again.`,
                confirmButtonText: 'OK'
            });
        }
    }
    function highlightConflicts(conflicts) {
        const rows = document.querySelectorAll('.datatable tbody tr');
        rows.forEach(row => {
            const cells = row.children;
            const kelas = cells[6].textContent;
            const hari = cells[5].textContent;
            const jam = cells[4].textContent;

            conflicts.forEach(conflict => {
                if ((conflict.kelas1 === kelas && conflict.hari1 === hari && conflict.jam1 === jam) ||
                    (conflict.kelas2 === kelas && conflict.hari2 === hari && conflict.jam2 === jam)) {
                    row.classList.add('table-danger');
                }
            });
        });
    }
    $('#delete-button').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete all schedules?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete-form').submit();
            }
        });
    });
</script>
@endpush
