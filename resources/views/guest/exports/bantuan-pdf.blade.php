<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Program Bantuan - Dinas Pertanian Kabupaten Toba</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #28a745;
            margin-bottom: 25px;
        }

        .logo-section {
            margin-bottom: 15px;
        }

        .logo-text {
            font-size: 24px;
            color: #28a745;
            font-weight: bold;
        }

        .header h1 {
            font-size: 20px;
            color: #28a745;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            font-size: 14px;
            color: #666;
            font-weight: normal;
            margin-bottom: 10px;
        }

        .header .info {
            font-size: 11px;
            color: #888;
        }

        .summary-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 8px;
        }

        .summary-grid {
            width: 100%;
        }

        .summary-item {
            display: inline-block;
            width: 32%;
            text-align: center;
            padding: 10px;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }

        .summary-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead tr {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        th {
            padding: 12px 8px;
            text-align: left;
            color: white;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e8f5e9;
        }

        .no-cell {
            text-align: center;
            font-weight: bold;
            color: #28a745;
        }

        .jenis-bantuan {
            font-weight: bold;
            color: #333;
        }

        .jumlah-cell {
            text-align: center;
            font-weight: bold;
            color: #28a745;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-dikirim {
            background-color: #d4edda;
            color: #155724;
        }

        .status-diproses {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-pending {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .status-ditolak {
            background-color: #f8d7da;
            color: #721c24;
        }

        .penerima-cell {
            max-width: 150px;
        }

        .penerima-name {
            font-weight: bold;
            color: #333;
        }

        .penerima-alamat {
            font-size: 10px;
            color: #666;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #28a745;
            text-align: center;
        }

        .footer-info {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }

        .footer-note {
            font-size: 9px;
            color: #999;
            font-style: italic;
        }

        .page-break {
            page-break-after: always;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-section">
            <div class="logo-text">🌾 DINAS PERTANIAN</div>
        </div>
        <h1>Daftar Program Bantuan Pertanian</h1>
        <h2>Kabupaten Toba - Provinsi Sumatera Utara</h2>
        <div class="info">
            Dicetak pada: {{ date('d F Y, H:i:s') }} WIB
        </div>
    </div>

    <div class="summary-box">
        <div class="summary-title">📊 Ringkasan Data</div>
        <table class="summary-grid" style="border: none;">
            <tr>
                <td style="border: none; text-align: center; width: 33%;">
                    <div class="summary-value">{{ $bantuans->count() }}</div>
                    <div class="summary-label">Total Bantuan</div>
                </td>
                <td style="border: none; text-align: center; width: 33%;">
                    <div class="summary-value">{{ $bantuans->where('status', 'Dikirim')->count() }}</div>
                    <div class="summary-label">Sudah Dikirim</div>
                </td>
                <td style="border: none; text-align: center; width: 34%;">
                    <div class="summary-value">{{ number_format($bantuans->sum('jumlah')) }}</div>
                    <div class="summary-label">Total Unit</div>
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 22%;">Jenis Bantuan</th>
                <th style="width: 10%;">Jumlah</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 36%;">Penerima</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bantuans as $index => $bantuan)
                <tr>
                    <td class="no-cell">{{ $index + 1 }}</td>
                    <td class="jenis-bantuan">{{ $bantuan->jenis_bantuan }}</td>
                    <td class="jumlah-cell">{{ number_format($bantuan->jumlah) }} unit</td>
                    <td>
                        @php
                            $statusClass = match($bantuan->status) {
                                'Dikirim' => 'status-dikirim',
                                'Diproses' => 'status-diproses',
                                'Ditolak' => 'status-ditolak',
                                default => 'status-pending'
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $bantuan->status }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d M Y') }}</td>
                    <td class="penerima-cell">
                        <div class="penerima-name">{{ $bantuan->user->name ?? 'N/A' }}</div>
                        @if($bantuan->user && $bantuan->user->alamat_desa)
                            <div class="penerima-alamat">📍 {{ $bantuan->user->alamat_desa }}</div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <p>Tidak ada data bantuan yang tersedia.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="footer-info">
            <strong>Total Data:</strong> {{ $bantuans->count() }} program bantuan | 
            <strong>Total Unit:</strong> {{ number_format($bantuans->sum('jumlah')) }} unit
        </div>
        <div class="footer-info">
            Dinas Pertanian Kabupaten Toba | Jl. Sisingamangaraja No. 1, Balige
        </div>
        <div class="footer-note">
            Dokumen ini dihasilkan secara otomatis oleh Sistem Informasi Pertanian Terpadu
        </div>
    </div>
</body>
</html>
