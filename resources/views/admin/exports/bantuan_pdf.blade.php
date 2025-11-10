<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Bantuan - Sistem Bantuan Pertanian Dinas Pertanian</title>
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
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-dikirim {
            background-color: #d4edda;
            color: #155724;
        }
        .status-diproses {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daftar Bantuan</h1>
        <p>Sistem Bantuan Pertanian Dinas Pertanian</p>
        <p>Dicetak pada: {{ date('d M Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Bantuan</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Penerima</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bantuans as $index => $bantuan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $bantuan->jenis_bantuan }}</td>
                    <td>{{ $bantuan->jumlah }} unit</td>
                    <td>
                        <span class="status-badge {{ $bantuan->status == 'Dikirim' ? 'status-dikirim' : 'status-diproses' }}">
                            {{ $bantuan->status }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d M Y') }}</td>
                    <td>{{ $bantuan->user->name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data bantuan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Bantuan: {{ $bantuans->count() }} item</p>
        <p>Dokumen ini dihasilkan secara otomatis oleh Sistem Bantuan Pertanian Dinas Pertanian</p>
    </div>
</body>
</html>
