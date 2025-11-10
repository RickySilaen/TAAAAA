<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan - Sistem Bantuan Pertanian Dinas Pertanian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .hasil-panen {
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daftar Laporan</h1>
        <p>Sistem Bantuan Pertanian Dinas Pertanian</p>
        <p>Dicetak pada: {{ date('d M Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Deskripsi Kemajuan</th>
                <th>Hasil Panen (kg)</th>
                <th>Tanggal</th>
                <th>Pelapor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $index => $laporan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ Str::limit($laporan->deskripsi_kemajuan, 100) }}</td>
                    <td class="hasil-panen">{{ $laporan->hasil_panen }}</td>
                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                    <td>{{ $laporan->user->name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data laporan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Laporan: {{ $laporans->count() }} item</p>
        <p>Total Hasil Panen: {{ $laporans->sum('hasil_panen') }} kg</p>
        <p>Dokumen ini dihasilkan secara otomatis oleh Sistem Bantuan Pertanian Dinas Pertanian</p>
    </div>
</body>
</html>
