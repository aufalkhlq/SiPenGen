@extends('components.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Dosen</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dosen</li>
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

            </div>
            <div class="row mt-4">
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
                                            <tr>
                                                <td>{{ $item->pengampu->dosen->nama_dosen }}</td>
                                                <td>
                                                    @foreach (json_decode($item->pengampu->matkul_id) as $matkulId)
                                                        {{ App\Models\Matkul::find($matkulId)->nama_matkul }}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach (json_decode($item->pengampu->matkul_id) as $matkulId)
                                                        {{ App\Models\Matkul::find($matkulId)->kode_matkul }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $item->ruangan->nama_ruangan }}</td>
                                                <td>{{ $item->jam->waktu }} </td>
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

        </div>
    </div>
@endsection
@push('script')
  
    <script>
        // $('#confirm-text').on('click', function(e) {
        //     e.preventDefault();
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You want to generate schedule?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, Generate it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             Swal.fire({
        //                 title: 'Generating Schedule...',
        //                 html: 'Please wait, processing <b></b> queries.',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false,
        //                 allowEnterKey: false,
        //                 onOpen: () => {
        //                     Swal.showLoading();
        //                     const b = Swal.getHtmlContainer().querySelector('b');
        //                     let i = 0;
        //                     // Assuming totalQueries is the total number of queries to be processed.
        //                     const totalQueries = 100;
        //                     timerInterval = setInterval(() => {
        //                         if (i === totalQueries) {
        //                             clearInterval(timerInterval);
        //                             $('#confirm-text').submit();
        //                         } else {
        //                             i++;
        //                             b.textContent = i;
        //                         }
        //                     }, 100);
        //                 }
        //             });
        //         }
        //     })
        // });

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
                            const elapsedTimeElement = Swal.getHtmlContainer().querySelector(
                                '#elapsed-time');
                            const timerInterval = setInterval(() => {
                                let elapsedTime = ((Date.now() - startTime) / 1000)
                                    .toFixed(1); // Calculate elapsed time in seconds
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
    </script>
@endpush
