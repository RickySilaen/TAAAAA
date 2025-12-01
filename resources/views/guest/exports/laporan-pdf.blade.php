<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Panen - Dinas Pertanian Kabupaten Toba</title>
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
            border-bottom: 3px solid #047857;
            margin-bottom: 25px;
        }

        .logo-section {
            margin-bottom: 15px;
        }

        .logo-text {
            font-size: 24px;
            color: #047857;
            font-weight: bold;
        }

        .header h1 {
            font-size: 20px;
            color: #047857;
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
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #047857;
            margin-bottom: 10px;
            border-bottom: 1px solid #bbf7d0;
            padding-bottom: 8px;
        }

        .summary-grid {
            width: 100%;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #047857;
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
            background: linear-gradient(135deg, #047857 0%, #10b981 100%);
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
            background-color: #f0fdf4;
        }

        tr:hover {
            background-color: #dcfce7;
        }

        .no-cell {
            text-align: center;
            font-weight: bold;
            color: #047857;
        }

        .petani-cell {
            max-width: 150px;
        }

        .petani-name {
            font-weight: bold;
            color: #333;
        }

        .petani-alamat {
            font-size: 10px;
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
            font-size: 12px;
        }

        .luas-cell {
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
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
            max-width: 200px;
            font-size: 10px;
            color: #555;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #047857;
            text-align: center;
        }

        .footer-stats {
            background: #f0fdf4;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .footer-stats-grid {
            width: 100%;
        }

        .footer-stat-item {
            display: inline-block;
            width: 24%;
            text-align: center;
            padding: 8px;
        }

        .footer-stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #047857;
        }

        .footer-stat-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
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
        <h1>Laporan Hasil Panen Pertanian</h1>
        <h2>Kabupaten Toba - Provinsi Sumatera Utara</h2>
        <div class="info">
            Dicetak pada: {{ date('d F Y, H:i:s') }} WIB
        </div>
    </div>

    <div class="summary-box">
        <div class="summary-title">📊 Ringkasan Data Hasil Panen</div>
        <table class="summary-grid" style="border: none;">
            <tr>
                <td style="border: none; text-align: center; width: 25%;">
                    <div class="summary-value">{{ $laporans->count() }}</div>
                    <div class="summary-label">Total Laporan</div>
                </td>
                <td style="border: none; text-align: center; width: 25%;">
                    <div class="summary-value">{{ number_format($laporans->sum('hasil_panen'), 0) }}</div>
                    <div class="summary-label">Total Hasil (kg)</div>
                </td>
                <td style="border: none; text-align: center; width: 25%;">
                    <div class="summary-value">{{ number_format($laporans->sum('luas_lahan'), 2) }}</div>
                    <div class="summary-label">Total Lahan (Ha)</div>
                </td>
                <td style="border: none; text-align: center; width: 25%;">
                    <div class="summary-value">{{ $laporans->pluck('user_id')->unique()->count() }}</div>
                    <div class="summary-label">Jumlah Petani</div>
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 20%;">Petani</th>
                <th style="width: 14%;">Jenis Tanaman</th>
                <th style="width: 12%;">Hasil Panen</th>
                <th style="width: 10%;">Luas</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 18%;">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $index => $laporan)
                <tr>
                    <td class="no-cell">{{ $index + 1 }}</td>
                    <td class="petani-cell">
                        <div class="petani-name">{{ $laporan->user->name ?? $laporan->nama_petani ?? 'N/A' }}</div>
                        @if($laporan->user && $laporan->user->alamat_desa)
                            <div class="petani-alamat">📍 {{ $laporan->user->alamat_desa }}</div>
                        @elseif($laporan->alamat_desa)
                            <div class="petani-alamat">📍 {{ $laporan->alamat_desa }}</div>
                        @endif
                    </td>
                    <td class="tanaman-cell">
                        🌱 {{ $laporan->jenis_tanaman ?? '-' }}
                    </td>
                    <td class="hasil-cell">
                        {{ number_format($laporan->hasil_panen, 2) }} kg
                    </td>
                    <td class="luas-cell">
                        {{ number_format($laporan->luas_lahan, 2) }} Ha
                    </td>
                    <td>
                        {{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') : $laporan->created_at->format('d M Y') }}
                    </td>
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
                    <td class="deskripsi-cell">
                        {{ Str::limit($laporan->deskripsi_kemajuan, 50) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <p>Tidak ada data laporan yang tersedia.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="footer-stats">
            <table class="footer-stats-grid" style="border: none;">
                <tr>
                    <td style="border: none; text-align: center; width: 33%;">
                        <div class="footer-stat-value">{{ $laporans->where('status', 'verified')->count() }}</div>
                        <div class="footer-stat-label">Terverifikasi</div>
                    </td>
                    <td style="border: none; text-align: center; width: 33%;">
                        <div class="footer-stat-value">{{ $laporans->where('status', 'pending')->count() }}</div>
                        <div class="footer-stat-label">Menunggu</div>
                    </td>
                    <td style="border: none; text-align: center; width: 34%;">
                        @php
                            $avgPerHa = $laporans->sum('luas_lahan') > 0 
                                ? $laporans->sum('hasil_panen') / $laporans->sum('luas_lahan') 
                                : 0;
                        @endphp
                        <div class="footer-stat-value">{{ number_format($avgPerHa, 0) }}</div>
                        <div class="footer-stat-label">Rata-rata kg/Ha</div>
                    </td>
                </tr>
            </table>
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
