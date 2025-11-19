@extends('layouts.app')

@section('title', 'Dashboard Petani - Sistem Pertanian Toba')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard-modern.css') }}?v={{ time() }}">
<style>
    :root {
        --green: #27ae60;
        --dark-green: #1e8449;
        --yellow: #ffb300;
        --purple: #6B46C1;
        --earth-brown: #8B5E3C;
    }
    
    /* ICON FIX - INLINE CSS */
    .stat-icon {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 64px !important;
        height: 64px !important;
        border-radius: 16px !important;
    }
    
    .stat-icon i,
    .stat-icon svg {
        font-size: 32px !important;
        width: 32px !important;
        height: 32px !important;
        opacity: 1 !important;
        visibility: visible !important;
        display: inline-block !important;
    }
    
    .stat-icon i {
        font-family: "Font Awesome 6 Free" !important;
        font-weight: 900 !important;
    }
    
    .stat-icon-green {
        background: linear-gradient(135deg, #a8e6cf 0%, #81c995 100%) !important;
        border: 3px solid #27ae60 !important;
    }
    
    .stat-icon-green i,
    .stat-icon-green svg {
        color: #0d5c2d !important;
    }
    
    .stat-icon-blue {
        background: linear-gradient(135deg, #a8d5f0 0%, #81b8d9 100%) !important;
        border: 3px solid #3498db !important;
    }
    
    .stat-icon-blue i,
    .stat-icon-blue svg {
        color: #1a5c8a !important;
    }
    
    .stat-icon-yellow {
        background: linear-gradient(135deg, #ffe4a8 0%, #ffd981 100%) !important;
        border: 3px solid #ffb300 !important;
    }
    
    .stat-icon-yellow i,
    .stat-icon-yellow svg {
        color: #9a6a00 !important;
    }
    
    .stat-icon-purple {
        background: linear-gradient(135deg, #d4c5f0 0%, #b8a5d9 100%) !important;
        border: 3px solid #6B46C1 !important;
    }
    
    .stat-icon-purple i,
    .stat-icon-purple svg {
        color: #3d2870 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-banner">
                <div class="welcome-content">
                    <h2 class="fw-bold text-white mb-2">
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h2>
                    <p class="text-white opacity-90 mb-0">
                        Kelola aktivitas pertanian Anda dengan mudah dan efisien
                    </p>
                </div>
                <div class="welcome-icon">
                    <i class="fas fa-tractor"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Laporan Saya -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-green">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Total Laporan Saya</p>
                            <h3 class="stat-value">{{ $total_laporan }}</h3>
                            <span class="stat-badge badge bg-success-soft text-success">
                                <i class="fas fa-file-alt me-1"></i>
                                {{ $laporan_bulan_ini }} bulan ini
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-green">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('petani.laporan.index') }}" class="stat-link">
                        Lihat Laporan <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Bantuan Diterima -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-blue">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Bantuan Diterima</p>
                            <h3 class="stat-value">{{ $bantuan_diterima }}</h3>
                            <span class="stat-badge badge bg-primary-soft text-primary">
                                <i class="fas fa-check-circle me-1"></i>
                                Sudah Diterima
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-blue">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('petani.bantuan.index') }}" class="stat-link">
                        Lihat Bantuan <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Luas Lahan -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-yellow">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Luas Lahan</p>
                            <h3 class="stat-value">{{ number_format(Auth::user()->luas_lahan ?? 0, 1) }}</h3>
                            <span class="stat-badge badge bg-warning-soft text-warning">
                                <i class="fas fa-map me-1"></i>
                                Hektar
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-yellow">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('profile') }}" class="stat-link">
                        Update Profil <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Panen -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-purple">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Total Hasil Panen</p>
                            <h3 class="stat-value">{{ number_format($total_panen) }}</h3>
                            <span class="stat-badge badge bg-purple-soft text-purple">
                                <i class="fas fa-weight me-1"></i>
                                Kg
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-purple">
                            <i class="fas fa-seedling"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('petani.laporan.index') }}" class="stat-link">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Aksi Cepat</h5>
                        <p class="modern-card-subtitle">Shortcut untuk aktivitas umum</p>
                    </div>
                </div>
                <div class="modern-card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('petani.laporan.create') }}" class="quick-action-btn-large">
                                <div class="quick-action-icon-large bg-success-soft text-success">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <div class="quick-action-text">
                                    <span class="quick-action-label">Buat Laporan Baru</span>
                                    <small class="text-muted">Laporkan hasil panen</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('petani.bantuan.create') }}" class="quick-action-btn-large">
                                <div class="quick-action-icon-large bg-primary-soft text-primary">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </div>
                                <div class="quick-action-text">
                                    <span class="quick-action-label">Ajukan Bantuan</span>
                                    <small class="text-muted">Request bantuan baru</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('bantuan.publik') }}" class="quick-action-btn-large">
                                <div class="quick-action-icon-large bg-warning-soft text-warning">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="quick-action-text">
                                    <span class="quick-action-label">Info Bantuan</span>
                                    <small class="text-muted">Lihat program bantuan</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('berita') }}" class="quick-action-btn-large">
                                <div class="quick-action-icon-large bg-purple-soft text-purple">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                <div class="quick-action-text">
                                    <span class="quick-action-label">Berita Pertanian</span>
                                    <small class="text-muted">Info & tips pertanian</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- My Reports -->
        <div class="col-xl-7">
            <div class="modern-card">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Laporan Saya</h5>
                        <p class="modern-card-subtitle">Riwayat laporan hasil panen</p>
                    </div>
                    <a href="{{ route('petani.laporan.index') }}" class="btn btn-sm btn-outline-success">
                        Lihat Semua
                    </a>
                </div>
                <div class="modern-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover modern-table mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis Tanaman</th>
                                    <th>Hasil Panen</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporan_terbaru as $laporan)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="table-icon bg-success-soft text-success me-2">
                                                <i class="fas fa-leaf"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $laporan->jenis_tanaman ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ number_format($laporan->hasil_panen) }} Kg</td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Terkirim
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('petani.laporan.show', $laporan->id) }}" 
                                               class="btn btn-light" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('petani.laporan.edit', $laporan->id) }}" 
                                               class="btn btn-light" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block opacity-25"></i>
                                        <p class="mb-2">Belum ada laporan</p>
                                        <a href="{{ route('petani.laporan.create') }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-plus me-1"></i>Buat Laporan Pertama
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Harvest Chart -->
            <div class="modern-card mt-4">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Grafik Hasil Panen</h5>
                        <p class="modern-card-subtitle">Produktivitas lahan 6 bulan terakhir</p>
                    </div>
                </div>
                <div class="modern-card-body">
                    <canvas id="harvestChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-xl-5">
            <!-- My Bantuan -->
            <div class="modern-card mb-4">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Bantuan Saya</h5>
                        <p class="modern-card-subtitle">Status bantuan yang diajukan</p>
                    </div>
                    <a href="{{ route('petani.bantuan.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="modern-card-body">
                    @forelse($bantuan_terbaru as $bantuan)
                    <div class="bantuan-item">
                        <div class="bantuan-icon {{ $bantuan->status == 'Dikirim' ? 'bg-success-soft text-success' : 'bg-warning-soft text-warning' }}">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="bantuan-content">
                            <h6 class="bantuan-title">{{ $bantuan->jenis_bantuan }}</h6>
                            <p class="bantuan-meta">
                                <i class="fas fa-cubes me-1"></i>
                                Jumlah: {{ $bantuan->jumlah }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge {{ $bantuan->status == 'Dikirim' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $bantuan->status }}
                                </span>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-hand-holding-heart fa-3x mb-3 opacity-25 text-muted"></i>
                        <p class="text-muted mb-2">Belum ada bantuan</p>
                        <a href="{{ route('petani.bantuan.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i>Ajukan Bantuan
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Tips & Info -->
            <div class="modern-card">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Tips Pertanian</h5>
                        <p class="modern-card-subtitle">Informasi berguna untuk Anda</p>
                    </div>
                </div>
                <div class="modern-card-body">
                    <div class="tips-list">
                        <div class="tips-item">
                            <div class="tips-icon bg-success-soft text-success">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="tips-content">
                                <h6 class="tips-title">Pemupukan Tepat Waktu</h6>
                                <p class="tips-text">Lakukan pemupukan sesuai jadwal untuk hasil maksimal</p>
                            </div>
                        </div>

                        <div class="tips-item">
                            <div class="tips-icon bg-primary-soft text-primary">
                                <i class="fas fa-tint"></i>
                            </div>
                            <div class="tips-content">
                                <h6 class="tips-title">Kelola Irigasi</h6>
                                <p class="tips-text">Pastikan pengairan cukup terutama saat musim kemarau</p>
                            </div>
                        </div>

                        <div class="tips-item">
                            <div class="tips-icon bg-warning-soft text-warning">
                                <i class="fas fa-bug"></i>
                            </div>
                            <div class="tips-content">
                                <h6 class="tips-title">Cegah Hama</h6>
                                <p class="tips-text">Periksa tanaman secara rutin untuk deteksi dini hama</p>
                            </div>
                        </div>

                        <div class="tips-item mb-0">
                            <div class="tips-icon bg-purple-soft text-purple">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="tips-content">
                                <h6 class="tips-title">Catat Hasil Panen</h6>
                                <p class="tips-text">Selalu laporkan hasil panen untuk data yang akurat</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('berita') }}" class="btn btn-outline-success btn-sm w-100">
                            <i class="fas fa-newspaper me-1"></i>
                            Lihat Berita & Artikel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Harvest Chart
    const ctx = document.getElementById('harvestChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Bulan 1', 'Bulan 2', 'Bulan 3', 'Bulan 4', 'Bulan 5', 'Bulan 6'],
                datasets: [{
                    label: 'Hasil Panen (Kg)',
                    data: [120, 150, 180, 165, 200, 220],
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39, 174, 96, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#27ae60',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return 'Hasil: ' + context.parsed.y + ' Kg';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            callback: function(value) {
                                return value + ' Kg';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
