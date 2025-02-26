<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Masuk</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Surat Masuk</h2>
    <p>Periode: {{ request('tanggal_awal') }} - {{ request('tanggal_akhir') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Tanggal Surat</th>
                <th>Pengirim</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suratMasuk as $index => $surat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $surat->nomor_surat }}</td>
                    <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</td>
                    <td>{{ $surat->pengirim }}</td>
                    <td>{{ $surat->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
