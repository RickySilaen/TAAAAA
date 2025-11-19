@extends('layouts.app')

@section('title', 'Dashboard Petugas - Sistem Pertanian Toba')

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
    .stat-icon i {
        font-size: 32px !important;
        opacity: 1 !important;
        visibility: visible !important;
        display: inline-block !important;
        font-family: "Font Awesome 6 Free" !important;
        font-weight: 900 !important;
    }
    
    .stat-icon-green {
        background: linear-gradient(135deg, #a8e6cf 0%, #81c995 100%) !important;
        border: 3px solid #27ae60 !important;
    }
    
    .stat-icon-green i {
        color: #0d5c2d !important;
    }
    
    .stat-icon-blue {
        background: linear-gradient(135deg, #a8d5f0 0%, #81b8d9 100%) !important;
        border: 3px solid #3498db !important;
    }
    
    .stat-icon-blue i {
        color: #1a5c8a !important;
    }
    
    .stat-icon-yellow {
        background: linear-gradient(135deg, #ffe4a8 0%, #ffd981 100%) !important;
        border: 3px solid #ffb300 !important;
    }
    
    .stat-icon-yellow i {
        color: #9a6a00 !important;
    }
    
    .stat-icon-purple {
        background: linear-gradient(135deg, #d4c5f0 0%, #b8a5d9 100%) !important;
        border: 3px solid #6B46C1 !important;
    }
    
    .stat-icon-purple i {
        color: #3d2870 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header-modern">
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        <i class="fas fa-user-tie text-primary me-2"></i>
                        Dashboard Petugas Lapangan
                    </h2>
                    <p class="text-muted mb-0">Monitoring dan Pengelolaan Data Pertanian</p>
                </div>
                <div class="header-actions">
                    <span class="badge bg-primary-soft text-primary px-3 py-2">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Petani Terdaftar -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-blue">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Petani Terdaftar</p>
                            <h3 class="stat-value">{{ $jumlah_petani }}</h3>
                            <span class="stat-badge badge bg-primary-soft text-primary">
                                <i class="fas fa-users me-1"></i>
                                Total Data
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-blue">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('petugas.petani.index') }}" class="stat-link">
                        Kelola Data <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Laporan Pending -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-yellow">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Laporan Pending</p>
                            <h3 class="stat-value">{{ $laporan_pending }}</h3>
                            <span class="stat-badge badge bg-warning-soft text-warning">
                                <i class="fas fa-clock me-1"></i>
                                Perlu Verifikasi
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-yellow">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('petugas.laporan.index') }}" class="stat-link">
                        Verifikasi <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Bantuan Aktif -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-green">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Bantuan Aktif</p>
                            <h3 class="stat-value">{{ $bantuan_aktif }}</h3>
                            <span class="stat-badge badge bg-success-soft text-success">
                                <i class="fas fa-check-circle me-1"></i>
                                Dalam Proses
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-green">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('petugas.bantuan.index') }}" class="stat-link">
                        Kelola Bantuan <i class="fas fa-arrow-right ms-1"></i>
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
                            <p class="stat-label">Total Panen Bulan Ini</p>
                            <h3 class="stat-value">{{ number_format($total_panen) }}</h3>
                            <span class="stat-badge badge bg-purple-soft text-purple">
                                <i class="fas fa-weight me-1"></i>
                                Ton
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-purple">
                            <i class="fas fa-seedling"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('petugas.monitoring') }}" class="stat-link">
                        Monitoring <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Overview -->
    <div class="row g-4 mb-4">
        <!-- Monitoring Chart -->
        <div class="col-xl-8">
            <div class="modern-card">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Monitoring Produksi</h5>
                        <p class="modern-card-subtitle">Grafik hasil panen per jenis tanaman</p>
                    </div>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary active">Bulanan</button>
                        <button type="button" class="btn btn-outline-secondary">Tahunan</button>
                    </div>
                </div>
                <div class="modern-card-body">
                    <canvas id="monitoringChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Task List -->
        <div class="col-xl-4">
            <div class="modern-card h-100">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">Tugas Prioritas</h5>
                    <p class="modern-card-subtitle">Yang perlu segera ditangani</p>
                </div>
                <div class="modern-card-body">
                    <div class="task-list">
                        <div class="task-item task-urgent">
                            <div class="task-checkbox">
                                <input type="checkbox" class="form-check-input">
                            </div>
                            <div class="task-content">
                                <p class="task-title">Verifikasi {{ $laporan_pending }} laporan pending</p>
                                <small class="task-meta">
                                    <i class="fas fa-exclamation-circle text-danger me-1"></i>
                                    Urgent
                                </small>
                            </div>
                        </div>

                        <div class="task-item task-normal">
                            <div class="task-checkbox">
                                <input type="checkbox" class="form-check-input">
                            </div>
                            <div class="task-content">
                                <p class="task-title">Update data petani baru</p>
                                <small class="task-meta">
                                    <i class="fas fa-clock text-warning me-1"></i>
                                    Hari ini
                                </small>
                            </div>
                        </div>

                        <div class="task-item task-normal">
                            <div class="task-checkbox">
                                <input type="checkbox" class="form-check-input">
                            </div>
                            <div class="task-content">
                                <p class="task-title">Distribusi bantuan pupuk</p>
                                <small class="task-meta">
                                    <i class="fas fa-calendar-alt text-info me-1"></i>
                                    Minggu ini
                                </small>
                            </div>
                        </div>

                        <div class="task-item task-normal">
                            <div class="task-checkbox">
                                <input type="checkbox" class="form-check-input">
                            </div>
                            <div class="task-content">
                                <p class="task-title">Survey lahan baru</p>
                                <small class="task-meta">
                                    <i class="fas fa-map-marker-alt text-success me-1"></i>
                                    Minggu depan
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('petugas.monitoring') }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-tasks me-1"></i>
                            Lihat Semua Tugas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data Tables -->
    <div class="row g-4">
        <!-- Recent Petani -->
        <div class="col-xl-6">
            <div class="modern-card">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Petani Terdaftar Baru</h5>
                        <p class="modern-card-subtitle">Data petani yang baru mendaftar</p>
                    </div>
                    <a href="{{ route('petugas.petani.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="modern-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover modern-table mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Petani</th>
                                    <th>Desa</th>
                                    <th>Luas Lahan</th>
                                    <th>Tgl Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($petani_baru as $petani)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="table-icon bg-primary-soft text-primary me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $petani->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $petani->alamat_desa ?? '-' }}</td>
                                    <td>{{ number_format($petani->luas_lahan ?? 0, 1) }} Ha</td>
                                    <td>{{ $petani->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('petugas.petani.show', $petani->id) }}" 
                                           class="btn btn-sm btn-light" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Tidak ada data petani baru
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Laporan -->
        <div class="col-xl-6">
            <div class="modern-card">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Laporan Perlu Verifikasi</h5>
                        <p class="modern-card-subtitle">Laporan yang belum diverifikasi</p>
                    </div>
                    <a href="{{ route('petugas.laporan.index') }}" class="btn btn-sm btn-outline-warning">
                        Lihat Semua
                    </a>
                </div>
                <div class="modern-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover modern-table mb-0">
                            <thead>
                                <tr>
                                    <th>Petani</th>
                                    <th>Jenis Tanaman</th>
                                    <th>Hasil Panen</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporan_terbaru as $laporan)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="table-icon bg-success-soft text-success me-2">
                                                <i class="fas fa-user-farmer"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $laporan->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $laporan->jenis_tanaman ?? '-' }}</td>
                                    <td>{{ number_format($laporan->hasil_panen) }} Kg</td>
                                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('petugas.laporan.show', $laporan->id) }}" 
                                           class="btn btn-sm btn-success" title="Verifikasi">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Semua laporan sudah diverifikasi
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">Aksi Cepat</h5>
                    <p class="modern-card-subtitle">Shortcut untuk tugas-tugas umum</p>
                </div>
                <div class="modern-card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('petugas.petani.index') }}" class="quick-action-btn">
                                <div class="quick-action-icon bg-primary-soft text-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span class="quick-action-label">Kelola Data Petani</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('petugas.laporan.index') }}" class="quick-action-btn">
                                <div class="quick-action-icon bg-warning-soft text-warning">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <span class="quick-action-label">Verifikasi Laporan</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('petugas.bantuan.index') }}" class="quick-action-btn">
                                <div class="quick-action-icon bg-success-soft text-success">
                                    <i class="fas fa-box"></i>
                                </div>
                                <span class="quick-action-label">Kelola Bantuan</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('petugas.monitoring') }}" class="quick-action-btn">
                                <div class="quick-action-icon bg-purple-soft text-purple">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <span class="quick-action-label">Lihat Monitoring</span>
                            </a>
                        </div>
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
    // Monitoring Chart
    const ctx = document.getElementById('monitoringChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Padi', 'Jagung', 'Kedelai', 'Cabai', 'Tomat', 'Kentang'],
                datasets: [{
                    label: 'Hasil Panen (Ton)',
                    data: [45, 32, 28, 18, 22, 15],
                    backgroundColor: [
                        'rgba(39, 174, 96, 0.8)',
                        'rgba(52, 152, 219, 0.8)',
                        'rgba(241, 196, 15, 0.8)',
                        'rgba(231, 76, 60, 0.8)',
                        'rgba(142, 68, 173, 0.8)',
                        'rgba(230, 126, 34, 0.8)'
                    ],
                    borderColor: [
                        '#27ae60',
                        '#3498db',
                        '#f1c40f',
                        '#e74c3c',
                        '#8e44ad',
                        '#e67e22'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
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
                                return context.parsed.y + ' Ton';
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
                                return value + ' Ton';
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
