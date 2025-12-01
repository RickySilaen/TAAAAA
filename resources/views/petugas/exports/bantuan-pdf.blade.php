<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Program Bantuan - Petugas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            padding: 15px;
        }

        .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 3px solid #0d6efd;
            margin-bottom: 20px;
        }

        .logo-text {
            font-size: 20px;
            color: #0d6efd;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            color: #0d6efd;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 12px;
            color: #666;
            font-weight: normal;
        }

        .header .info {
            font-size: 10px;
            color: #888;
            margin-top: 5px;
        }

        .kecamatan-badge {
            display: inline-block;
            background: #e7f1ff;
            color: #0d6efd;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 10px;
        }

        .summary-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
        }

        .summary-title {
            font-size: 12px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 8px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }

        table.summary-grid {
            width: 100%;
            border: none;
        }

        .summary-value {
            font-size: 20px;
            font-weight: bold;
            color: #0d6efd;
        }

        .summary-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.main-table thead tr {
            background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
        }

        table.main-table th {
            padding: 10px 6px;
            text-align: left;
            color: white;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        table.main-table td {
            padding: 8px 6px;
            border-bottom: 1px solid #eee;
            font-size: 10px;
        }

        table.main-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .no-cell {
            text-align: center;
            font-weight: bold;
            color: #0d6efd;
        }

        .jenis-bantuan {
            font-weight: bold;
        }

        .jumlah-cell {
            text-align: center;
            font-weight: bold;
            color: #28a745;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 9px;
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

        .penerima-name {
            font-weight: bold;
        }

        .penerima-alamat {
            font-size: 9px;
            color: #666;
        }

        .footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 2px solid #0d6efd;
            text-align: center;
        }

        .footer-info {
            font-size: 9px;
            color: #666;
            margin-bottom: 5px;
        }

        .footer-note {
            font-size: 8px;
            color: #999;
            font-style: italic;
        }

        .signature-section {
            margin-top: 30px;
            text-align: right;
            padding-right: 30px;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            margin-bottom: 5px;
            height: 60px;
        }

        .signature-name {
            font-size: 10px;
            font-weight: bold;
        }

        .signature-title {
            font-size: 9px;
            color: #666;
        }

        .empty-state {
            text-align: center;
            padding: 30px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-text">👨‍💼 LAPORAN PETUGAS</div>
        <h1>Daftar Program Bantuan Pertanian</h1>
        <h2>Dinas Pertanian Kabupaten Toba</h2>
        @if($kecamatan)
            <div class="kecamatan-badge">📍 Wilayah: {{ $kecamatan }}</div>
        @endif
        <div class="info">
            Dicetak pada: {{ date('d F Y, H:i:s') }} WIB
        </div>
    </div>

    <div class="summary-box">
        <div class="summary-title">📊 Ringkasan Data Bantuan</div>
        <table class="summary-grid">
            <tr>
                <td style="border: none; text-align: center; width: 25%;">
                    <div class="summary-value">{{ $bantuans->count() }}</div>
                    <div class="summary-label">Total Bantuan</div>
                </td>
                <td style="border: none; text-align: center; width: 25%;">
                    <div class="summary-value">{{ $bantuans->where('status', 'Dikirim')->count() }}</div>
                    <div class="summary-label">Dikirim</div>
                </td>
                <td style="border: none; text-align: center; width: 25%;">
                    <div class="summary-value">{{ $bantuans->where('status', 'Diproses')->count() }}</div>
                    <div class="summary-label">Diproses</div>
                </td>
                <td style="border: none; text-align: center; width: 25%;">
                    <div class="summary-value">{{ number_format($bantuans->sum('jumlah')) }}</div>
                    <div class="summary-label">Total Unit</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="main-table">
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
                    <td class="jumlah-cell">{{ number_format($bantuan->jumlah) }}</td>
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
                    <td>
                        <div class="penerima-name">{{ $bantuan->user->name ?? 'N/A' }}</div>
                        @if($bantuan->user && $bantuan->user->alamat_desa)
                            <div class="penerima-alamat">{{ $bantuan->user->alamat_desa }}</div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        Tidak ada data bantuan yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <p style="font-size: 10px; margin-bottom: 5px;">{{ $kecamatan ?? 'Kabupaten Toba' }}, {{ date('d F Y') }}</p>
            <p style="font-size: 10px;">Petugas,</p>
            <div class="signature-line"></div>
            <div class="signature-name">{{ Auth::user()->name ?? '........................' }}</div>
            <div class="signature-title">Petugas Lapangan</div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-info">
            Total: {{ $bantuans->count() }} program bantuan | {{ number_format($bantuans->sum('jumlah')) }} unit
        </div>
        <div class="footer-note">
            Dokumen ini dihasilkan secara otomatis oleh Sistem Informasi Pertanian Terpadu
        </div>
    </div>
</body>
</html>
