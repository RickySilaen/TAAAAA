@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Pertanian Toba')

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
        background: #e8f5e9 !important;
        border: 3px solid #27ae60 !important;
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
        color: #0d5c2d !important;
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
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header-modern">
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        <i class="fas fa-tachometer-alt text-success me-2"></i>
                        Dashboard Administrator
                    </h2>
                    <p class="text-muted mb-0">Sistem Informasi Pertanian Kabupaten Toba</p>
                </div>
                <div class="header-actions">
                    <span class="badge bg-success-soft text-success px-3 py-2">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Bantuan Hari Ini -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-green">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Bantuan Hari Ini</p>
                            <h3 class="stat-value">{{ $bantuan_hari_ini }}</h3>
                            <span class="stat-badge badge bg-success-soft text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ $bantuan_hari_ini > 0 ? '+' . $bantuan_hari_ini : '0' }} hari ini
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-green">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('daftar.bantuan') }}" class="stat-link">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Petani -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-blue">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Total Petani</p>
                            <h3 class="stat-value">{{ $total_petani }}</h3>
                            <span class="stat-badge badge bg-primary-soft text-primary">
                                <i class="fas fa-users me-1"></i>
                                Terdaftar
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-blue">
                            <svg width="32" height="32" viewBox="0 0 640 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('admin.petani.index') }}" class="stat-link">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Laporan Baru -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-yellow">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Laporan Baru</p>
                            <h3 class="stat-value">{{ $laporan_baru }}</h3>
                            <span class="stat-badge badge bg-warning-soft text-warning">
                                <i class="fas fa-clock me-1"></i>
                                {{ $laporan_baru > 0 ? 'Perlu Review' : 'Semua Clear' }}
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-yellow">
                            <svg width="32" height="32" viewBox="0 0 384 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('daftar.laporan') }}" class="stat-link">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Hasil Panen -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-purple">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label">Total Hasil Panen</p>
                            <h3 class="stat-value">{{ number_format($total_hasil_panen) }}</h3>
                            <span class="stat-badge badge bg-purple-soft text-purple">
                                <i class="fas fa-seedling me-1"></i>
                                Ton
                            </span>
                        </div>
                        <div class="stat-icon stat-icon-purple">
                            <svg width="32" height="32" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64V400c0 44.2 35.8 80 80 80H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H80c-8.8 0-16-7.2-16-16V64zm406.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L320 210.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L240 221.3l57.4 57.4c12.5 12.5 32.8 12.5 45.3 0l128-128z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer">
                    <a href="{{ route('hasil.panen') }}" class="stat-link">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Bantuan Chart -->
        <div class="col-xl-8">
            <div class="modern-card">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Statistik Bantuan Bulanan</h5>
                        <p class="modern-card-subtitle">Data bantuan yang diberikan per bulan</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-calendar me-1"></i> 2024
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">2024</a></li>
                            <li><a class="dropdown-item" href="#">2023</a></li>
                        </ul>
                    </div>
                </div>
                <div class="modern-card-body">
                    <canvas id="bantuanChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-xl-4">
            <div class="modern-card h-100">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">Statistik Cepat</h5>
                    <p class="modern-card-subtitle">Ringkasan data sistem</p>
                </div>
                <div class="modern-card-body">
                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-success-soft text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="quick-stat-label">Bantuan Disetujui</p>
                            <h4 class="quick-stat-value">{{ \App\Models\Bantuan::where('status', 'Dikirim')->count() }}</h4>
                        </div>
                    </div>

                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-warning-soft text-warning">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="quick-stat-label">Bantuan Pending</p>
                            <h4 class="quick-stat-value">{{ \App\Models\Bantuan::where('status', 'Diproses')->count() }}</h4>
                        </div>
                    </div>

                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-primary-soft text-primary">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="quick-stat-label">Total Laporan</p>
                            <h4 class="quick-stat-value">{{ \App\Models\Laporan::count() }}</h4>
                        </div>
                    </div>

                    <div class="quick-stat-item mb-0">
                        <div class="quick-stat-icon bg-purple-soft text-purple">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="quick-stat-label">Petugas Aktif</p>
                            <h4 class="quick-stat-value">{{ \App\Models\User::where('role', 'petugas')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row g-4">
        <!-- Recent Bantuan -->
        <div class="col-xl-6">
            <div class="modern-card">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Bantuan Terbaru</h5>
                        <p class="modern-card-subtitle">5 bantuan terakhir yang diajukan</p>
                    </div>
                    <a href="{{ route('daftar.bantuan') }}" class="btn btn-sm btn-outline-success">
                        Lihat Semua
                    </a>
                </div>
                <div class="modern-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover modern-table mb-0">
                            <thead>
                                <tr>
                                    <th>Jenis Bantuan</th>
                                    <th>Petani</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bantuans as $bantuan)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="table-icon bg-success-soft text-success me-2">
                                                <i class="fas fa-box"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $bantuan->jenis_bantuan }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $bantuan->user->name ?? 'N/A' }}</td>
                                    <td>{{ $bantuan->jumlah }}</td>
                                    <td>
                                        <span class="badge {{ $bantuan->status == 'Dikirim' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $bantuan->status }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Belum ada data bantuan
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
                        <h5 class="modern-card-title">Laporan Terbaru</h5>
                        <p class="modern-card-subtitle">5 laporan terakhir dari petani</p>
                    </div>
                    <a href="{{ route('daftar.laporan') }}" class="btn btn-sm btn-outline-primary">
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
                                @forelse($laporans as $laporan)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="table-icon bg-primary-soft text-primary me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $laporan->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $laporan->jenis_tanaman ?? '-' }}</td>
                                    <td>{{ number_format($laporan->hasil_panen) }} Kg</td>
                                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('api.laporan.show', $laporan->id) }}" 
                                           class="btn btn-sm btn-light" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Belum ada laporan
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

    <!-- Notifications -->
    @if($notifications->count() > 0)
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="modern-card">
                <div class="modern-card-header">
                    <div>
                        <h5 class="modern-card-title">Notifikasi Terbaru</h5>
                        <p class="modern-card-subtitle">Update sistem terkini</p>
                    </div>
                    <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-secondary">
                        Lihat Semua
                    </a>
                </div>
                <div class="modern-card-body">
                    <div class="notification-list">
                        @foreach($notifications->take(5) as $notification)
                        <div class="notification-item {{ $notification->read_at ? '' : 'unread' }}">
                            <div class="notification-icon bg-info-soft text-info">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="notification-content">
                                <p class="notification-title">{{ $notification->data['title'] ?? 'Notifikasi' }}</p>
                                <p class="notification-message">{{ $notification->data['message'] ?? 'Anda memiliki notifikasi baru' }}</p>
                                <small class="notification-time">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bantuan Chart
    const ctx = document.getElementById('bantuanChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Bantuan Diberikan',
                    data: [12, 19, 15, 25, 22, 30, 28, 35, 32, 40, 38, 45],
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39, 174, 96, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#27ae60',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }, {
                    label: 'Laporan Masuk',
                    data: [8, 12, 10, 18, 15, 22, 20, 25, 23, 30, 28, 35],
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#3498db',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 12,
                                family: 'Inter, sans-serif'
                            }
                        }
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
                        cornerRadius: 8
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
    
    // ICON FALLBACK SCRIPT - Show emoji if FontAwesome fails
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const icons = {
                'fa-hand-holding-heart': '🤝',
                'fa-users': '👥',
                'fa-file-alt': '📄',
                'fa-chart-line': '📈',
                'fa-seedling': '🌱',
                'fa-clipboard-list': '📋',
                'fa-box': '📦',
                'fa-map-marked-alt': '🗺️'
            };
            
            document.querySelectorAll('.stat-icon i').forEach(icon => {
                // Check if FontAwesome loaded
                const computedStyle = window.getComputedStyle(icon, ':before');
                const content = computedStyle.getPropertyValue('content');
                
                // If icon not showing or FontAwesome failed
                if (!content || content === 'none' || content === '""' || icon.offsetWidth < 5) {
                    // Get the icon class
                    let iconClass = '';
                    icon.classList.forEach(cls => {
                        if (cls.startsWith('fa-') && cls !== 'fas' && cls !== 'far' && cls !== 'fab') {
                            iconClass = cls;
                        }
                    });
                    
                    // Replace with emoji
                    if (icons[iconClass]) {
                        icon.style.fontFamily = 'Arial, sans-serif';
                        icon.style.fontSize = '32px';
                        icon.innerHTML = icons[iconClass];
                        console.log('✅ Fallback icon displayed:', iconClass, '→', icons[iconClass]);
                    }
                }
            });
        }, 500);
    });
</script>
@endsection
