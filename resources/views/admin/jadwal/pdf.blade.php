<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8pt;
        }
        .header, .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .header td, .content-table th, .content-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        .header {
            margin-bottom: 10px;
        }
        .header td {
            border: none;
            padding: 2px 5px;
        }
        .header-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            padding: 10px;
            border: 1px solid black;
        }
        .header-logo {
            width: 10%;
            vertical-align: top;
        }
        .header-info {
            width: 90%;
        }
        .content-table th {
            background-color: #f2f2f2;
        }
        .page-break {
            page-break-after: always;
        }
        .separator-row {
            height: 10px;
            background-color: #fff;
        }
        .repeat-header {
            display: table-header-group;
        }
    </style>
</head>
<body>
    @foreach($kelas as $kls)
        <table class="header">
            <tr>
                <td rowspan="2" class="header-logo">
                    <img src="{{ public_path('path/to/logo.png') }}" alt="Logo" width="80">
                </td>
                <td colspan="6" class="header-title">JADWAL KULIAH</td>
            </tr>
            <tr>
                <td colspan="6" class="header-info">
                    <table>
                        <tr>
                            <td>Jurusan</td>
                            <td>: Teknik Elektro</td>
                            <td>No. FPM</td>
                            <td>: 7.5.13/L.1</td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td>: D3 Teknik Informatika</td>
                            <td>Revisi</td>
                            <td>: 2</td>
                        </tr>
                        <tr>
                            <td>Semester</td>
                            <td>: IV (Empat) / Genap</td>
                            <td>Tanggal</td>
                            <td>: 01 Juli 2010</td>
                        </tr>
                        <tr>
                            <td>Tahun Akademik</td>
                            <td>: 2023 - 2024</td>
                            <td>Halaman</td>
                            <td>: 1</td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>: {{ $kls->nama_kelas }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="content-table">
            <thead class="repeat-header">
                <tr>
                    <th>Hari</th>
                    <th>Jam ke</th>
                    <th>Waktu</th>
                    <th>Kode MK</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Ruang</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $currentHari = null;
                @endphp

                @foreach($jadwals->where('kelas_id', $kls->id)->sortBy(['hari_id', 'jam_id']) as $jadwal)
                    @if ($jadwal->hari->hari != $currentHari)
                        @if ($currentHari)
                            <tr class="separator-row">
                                <td colspan="7"></td>
                            </tr>
                        @endif
                        @php
                            $currentHari = $jadwal->hari->hari;
                        @endphp
                        <tr>
                            <td rowspan="{{ $jadwals->where('kelas_id', $kls->id)->where('hari_id', $jadwal->hari_id)->count() }}" style="text-align: center; font-weight: bold;">{{ $jadwal->hari->hari }}</td>
                            <td>{{ $jadwal->jam->jam }}</td>
                            <td>{{ $jadwal->jam->waktu }}</td>
                            <td>{{ $jadwal->pengampu->matkul->kode_matkul }}</td>
                            <td>{{ $jadwal->pengampu->matkul->nama_matkul }}</td>
                            <td>{{ $jadwal->pengampu->dosen->nama_dosen }}</td>
                            <td>{{ $jadwal->ruangan->nama_ruangan }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $jadwal->jam->jam }}</td>
                            <td>{{ $jadwal->jam->waktu }}</td>
                            <td>{{ $jadwal->pengampu->matkul->kode_matkul }}</td>
                            <td>{{ $jadwal->pengampu->matkul->nama_matkul }}</td>
                            <td>{{ $jadwal->pengampu->dosen->nama_dosen }}</td>
                            <td>{{ $jadwal->ruangan->nama_ruangan }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <table class="header">
            <tr>
                <td>Dosen Wali</td>
                <td>: Amran Yobiokatbera, S.Kom., M.Kom.</td>
            </tr>
        </table>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
