<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perhitungan</title>
    <style>
        /* Add your styles here */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 10px;
            margin-bottom: 20px;
        }

        .date-time {
            text-align: right;
            font-family:'Times New Roman', Times, serif;
            font-size: 14px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Hasil Perhitungan dan Peringkat</h1>
        <h1>Calon Penerima PKH di Desa Mentibar, Kec. Paloh</h1>
    </div>

    <div class="date-time">
        <p>Tanggal dan Waktu Export: {{ now()->format('d F Y, H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemohon</th>
                <th>No KK</th>
                <th>Alamat</th>
                <th>Nilai Vektor V</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasilData as $index => $hasil)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $hasil->pemohon->nama }}</td>
                    <td>{{ $hasil->pemohon->no_kk }}</td>
                    <td>{{ $hasil->pemohon->alamat }}</td>
                    <td>{{ number_format($hasil->hasil, 3) }}</td>
                    <td>{{ $loop->iteration }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sistem Seleksi Calon Penerima PKH</p>
        <p>Desa Mentibar</p>
    </div>
</body>
</html>
