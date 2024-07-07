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
    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam ke</th>
                <th>Waktu</th>
                <th>Kode Mata Kuliah</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Ruang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwals as $jadwal)
                <tr>
                    <td>{{ $jadwal->hari->hari }}</td>
                    <td>{{ $jadwal->jam_ke }}</td>
                    <td>{{ $jadwal->waktu }}</td>
                    <td>{{ $jadwal->kode_mata_kuliah }}</td>
                    <td>{{ $jadwal->mata_kuliah }}</td>
                    <td>{{ $jadwal->dosen }}</td>
                    <td>{{ $jadwal->ruang }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
