<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Panen - Petugas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            padding: 15px;
        }

        .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 3px solid #047857;
            margin-bottom: 20px;
        }

        .logo-text {
            font-size: 20px;
            color: #047857;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            color: #047857;
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
            background: #d1fae5;
            color: #047857;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 10px;
        }

        .summary-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
        }

        .summary-title {
            font-size: 12px;
            font-weight: bold;
            color: #047857;
            margin-bottom: 8px;
            border-bottom: 1px solid #bbf7d0;
            padding-bottom: 5px;
        }

        table.summary-grid {
            width: 100%;
            border: none;
        }

        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #047857;
        }

        .summary-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.main-table thead tr {
            background: linear-gradient(135deg, #047857 0%, #10b981 100%);
        }

        table.main-table th {
            padding: 8px 5px;
            text-align: left;
            color: white;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        table.main-table td {
            padding: 7px 5px;
            border-bottom: 1px solid #eee;
            font-size: 9px;
        }

        table.main-table tr:nth-child(even) {
            background-color: #f0fdf4;
        }

        .no-cell {
            text-align: center;
            font-weight: bold;
            color: #047857;
        }

        .petani-name {
            font-weight: bold;
        }

        .petani-alamat {
            font-size: 8px;
            color: #666;
        }

        .tanaman-cell {
            font-weight: bold;
            color: #047857;
        }

        .hasil-cell {
            text-align: right;
            font-weight: bold;
            color: #047857;
        }

        .luas-cell {
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-verified {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .deskripsi-cell {
            font-size: 8px;
            color: #555;
        }

        .footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 2px solid #047857;
            text-align: center;
        }

        .footer-stats {
            background: #f0fdf4;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 15px;
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
            width: 180px;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            margin-bottom: 5px;
            height: 50px;
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
        <div class="logo-text">🌾 LAPORAN PETUGAS</div>
        <h1>Laporan Hasil Panen Pertanian</h1>
        <h2>Dinas Pertanian Kabupaten Toba</h2>
        @if($kecamatan)
            <div class="kecamatan-badge">📍 Wilayah: {{ $kecamatan }}</div>
        @endif
        <div class="info">
            Dicetak pada: {{ date('d F Y, H:i:s') }} WIB
        </div>
    </div>

    <div class="summary-box">
        <div class="summary-title">📊 Ringkasan Data Hasil Panen</div>
        <table class="summary-grid">
            <tr>
                <td style="border: none; text-align: center; width: 20%;">
                    <div class="summary-value">{{ $laporans->count() }}</div>
                    <div class="summary-label">Total Laporan</div>
                </td>
                <td style="border: none; text-align: center; width: 20%;">
                    <div class="summary-value">{{ number_format($laporans->sum('hasil_panen'), 0) }}</div>
                    <div class="summary-label">Total (kg)</div>
                </td>
                <td style="border: none; text-align: center; width: 20%;">
                    <div class="summary-value">{{ number_format($laporans->sum('luas_lahan'), 1) }}</div>
                    <div class="summary-label">Lahan (Ha)</div>
                </td>
                <td style="border: none; text-align: center; width: 20%;">
                    <div class="summary-value">{{ $laporans->where('status', 'verified')->count() }}</div>
                    <div class="summary-label">Terverifikasi</div>
                </td>
                <td style="border: none; text-align: center; width: 20%;">
                    <div class="summary-value">{{ $laporans->where('status', 'pending')->count() }}</div>
                    <div class="summary-label">Menunggu</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 18%;">Petani</th>
                <th style="width: 12%;">Tanaman</th>
                <th style="width: 10%;">Hasil</th>
                <th style="width: 8%;">Luas</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 26%;">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $index => $laporan)
                <tr>
                    <td class="no-cell">{{ $index + 1 }}</td>
                    <td>
                        <div class="petani-name">{{ $laporan->user->name ?? $laporan->nama_petani ?? 'N/A' }}</div>
                        @if($laporan->user && $laporan->user->alamat_desa)
                            <div class="petani-alamat">{{ $laporan->user->alamat_desa }}</div>
                        @elseif($laporan->alamat_desa)
                            <div class="petani-alamat">{{ $laporan->alamat_desa }}</div>
                        @endif
                    </td>
                    <td class="tanaman-cell">{{ $laporan->jenis_tanaman ?? '-' }}</td>
                    <td class="hasil-cell">{{ number_format($laporan->hasil_panen, 1) }} kg</td>
                    <td class="luas-cell">{{ number_format($laporan->luas_lahan, 2) }} Ha</td>
                    <td>{{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') : $laporan->created_at->format('d M Y') }}</td>
                    <td>
                        @php
                            $statusClass = match($laporan->status) {
                                'verified' => 'status-verified',
                                'rejected' => 'status-rejected',
                                default => 'status-pending'
                            };
                            $statusLabel = match($laporan->status) {
                                'verified' => 'Terverifikasi',
                                'rejected' => 'Ditolak',
                                default => 'Pending'
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="deskripsi-cell">{{ Str::limit($laporan->deskripsi_kemajuan, 40) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="empty-state">
                        Tidak ada data laporan yang tersedia.
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
        <div class="footer-stats">
            <table class="summary-grid">
                <tr>
                    <td style="border: none; text-align: center; width: 33%;">
                        <span style="font-weight: bold; color: #047857;">{{ $laporans->where('status', 'verified')->count() }}</span> Terverifikasi
                    </td>
                    <td style="border: none; text-align: center; width: 34%;">
                        <span style="font-weight: bold; color: #047857;">{{ $laporans->where('status', 'pending')->count() }}</span> Menunggu
                    </td>
                    <td style="border: none; text-align: center; width: 33%;">
                        @php
                            $avgPerHa = $laporans->sum('luas_lahan') > 0 
                                ? $laporans->sum('hasil_panen') / $laporans->sum('luas_lahan') 
                                : 0;
                        @endphp
                        <span style="font-weight: bold; color: #047857;">{{ number_format($avgPerHa, 0) }}</span> kg/Ha rata-rata
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer-note">
            Dokumen ini dihasilkan secara otomatis oleh Sistem Informasi Pertanian Terpadu
        </div>
    </div>
</body>
</html>
