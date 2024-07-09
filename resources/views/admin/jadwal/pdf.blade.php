<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jadwal PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @foreach($kelas as $kls)
        <h2>Jadwal Kelas: {{ $kls->nama_kelas }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Kode Mata Kuliah</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Ruang</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwals->where('kelas_id', $kls->id) as $jadwal)
                    <tr>
                        <td>{{ $jadwal->hari->hari }}</td>
                        <td>{{ $jadwal->jam->waktu }}</td>
                        <td>{{ $jadwal->pengampu->matkul->kode_matkul }}</td>
                        <td>{{ $jadwal->pengampu->matkul->nama_matkul }}</td>
                        <td>{{ $jadwal->pengampu->dosen->nama_dosen }}</td>
                        <td>{{ $jadwal->ruangan->nama_ruangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
