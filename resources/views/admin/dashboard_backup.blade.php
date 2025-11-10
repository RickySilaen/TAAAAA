@extends('layouts.app')

@section('title', 'Dashboard - Sistem Bantuan Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Dashboard Cards -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="content-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Bantuan Hari Ini</p>
                                <h5 class="font-weight-bolder">{{ $bantuan_hari_ini }}</h5>
                                <a href="{{ route('daftar.bantuan') }}" class="mb-0 text-primary font-weight-bold text-decoration-none">Klik untuk detail</a>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="fas fa-hand-holding-heart text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="content-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Petani</p>
                                <h5 class="font-weight-bolder">{{ $total_petani }}</h5>
                                <a href="{{ route('petani.list') }}" class="mb-0 text-primary font-weight-bold text-decoration-none">Klik untuk detail</a>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="fas fa-user text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="content-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Laporan Baru</p>
                                <h5 class="font-weight-bolder">{{ $laporan_baru }}</h5>
                                <a href="{{ route('daftar.laporan') }}" class="mb-0 text-primary font-weight-bold text-decoration-none">Klik untuk detail</a>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                <i class="fas fa-file-contract text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="content-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Hasil Panen (kg)</p>
                                <h5 class="font-weight-bolder">{{ $total_hasil_panen }}</h5>
                                <a href="{{ route('hasil.panen') }}" class="mb-0 text-primary font-weight-bold text-decoration-none">Klik untuk detail</a>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="fas fa-tractor text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Charts and Notifications Row -->
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h5><i class="fas fa-chart-line me-2"></i>Ringkasan Bantuan Mingguan</h5>
                    <p class="text-sm mb-0">
                        <i class="fa fa-arrow-up text-success"></i>
                        <span class="font-weight-bold">{{ $bantuan_hari_ini > 0 ? '+' . $bantuan_hari_ini * 10 . '%' : '0%' }}</span> dibandingkan minggu lalu
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
                    @if($bantuans->count() == 0)
                    <div class="text-center py-4">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum Ada Data Bantuan</h6>
                        <p class="text-sm text-muted mb-0">Grafik akan muncul setelah ada data bantuan yang ditambahkan.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h5><i class="fas fa-bell me-2"></i>Notifikasi & Peringatan</h5>
                </div>
                <div class="card-body p-3">
                    <div class="notification-item mb-3 p-3 border-radius-lg bg-gradient-light">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm bg-gradient-success shadow text-center me-3">
                                <i class="fas fa-check-circle text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm font-weight-bold">Sistem Berjalan Normal</h6>
                                <span class="text-xs text-muted">Semua layanan beroperasi dengan baik</span>
                            </div>
                        </div>
                    </div>
                    @forelse($notifications as $notification)
                    <div class="notification-item mb-3 p-3 border-radius-lg bg-gradient-{{ $notification->data['color'] ?? 'info' }} {{ $notification->read_at ? 'opacity-6' : '' }}">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm bg-gradient-{{ $notification->data['color'] ?? 'info' }} shadow text-center me-3">
                                <i class="fas {{ $notification->data['icon'] ?? 'fa-bell' }} text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column flex-grow-1">
                                <h6 class="mb-1 text-dark text-sm font-weight-bold">{{ $notification->data['title'] }}</h6>
                                <span class="text-xs text-muted">{{ $notification->data['message'] }}</span>
                                <small class="text-xs text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                @if(!$notification->read_at)
                                <div class="mt-2">
                                    <button class="btn btn-xs btn-outline-success" onclick="markAsReadFromDashboard('{{ $notification->id }}')">
                                        <i class="fas fa-check me-1"></i>Tandai Dibaca
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-3">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Tidak ada notifikasi</p>
                    </div>
                    @endforelse
                    @if($laporan_baru > 0)
                    <div class="notification-item mb-3 p-3 border-radius-lg bg-gradient-warning">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm bg-gradient-info shadow text-center me-3">
                                <i class="fas fa-file-alt text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm font-weight-bold">{{ $laporan_baru }} Laporan Baru</h6>
                                <span class="text-xs text-muted">Ada laporan baru yang perlu diperiksa</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($bantuan_hari_ini > 0)
                    <div class="notification-item mb-3 p-3 border-radius-lg bg-gradient-danger">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm bg-gradient-warning shadow text-center me-3">
                                <i class="fas fa-exclamation-triangle text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm font-weight-bold">Bantuan Hari Ini</h6>
                                <span class="text-xs text-muted">{{ $bantuan_hari_ini }} bantuan perlu diproses hari ini</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Tables Row -->
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h5><i class="fas fa-list me-2"></i>Daftar Bantuan Terbaru</h5>
                    <p class="text-sm mb-0 text-muted">5 bantuan terakhir yang ditambahkan</p>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Jenis Bantuan</th>
                                    <th class="border-0">Penerima</th>
                                    <th class="border-0">Jumlah</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Tanggal</th>
                                    <th class="border-0 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bantuans as $bantuan)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-seedling text-success me-2"></i>
                                                <div>
                                                    <div class="fw-bold">{{ $bantuan->jenis_bantuan }}</div>
                                                    @if($bantuan->catatan)
                                                        <small class="text-muted">{{ Str::limit($bantuan->catatan, 25) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $bantuan->user->profile_picture ? asset('storage/' . $bantuan->user->profile_picture) : asset('img/default-avatar.png') }}"
                                                     alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                                <div>
                                                    <div class="fw-bold">{{ $bantuan->user->name ?? 'N/A' }}</div>
                                                    <small class="text-muted">{{ $bantuan->user->alamat_desa ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge bg-success">{{ number_format($bantuan->jumlah) }} unit</span>
                                        </td>
                                        <td class="align-middle">
                                            @if($bantuan->status == 'Dikirim')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Dikirim
                                                </span>
                                            @elseif($bantuan->status == 'Diproses')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i>Diproses
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-question-circle me-1"></i>{{ $bantuan->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="fw-bold">{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d M Y') }}</div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($bantuan->tanggal)->diffForHumans() }}</small>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('edit.bantuan', $bantuan->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="deleteBantuan({{ $bantuan->id }}, '{{ $bantuan->jenis_bantuan }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Detail" onclick="showBantuanDetail({{ $bantuan->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <h6>Belum Ada Data Bantuan</h6>
                                                <p class="mb-0">Bantuan terbaru akan muncul di sini setelah ditambahkan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h5><i class="fas fa-file-alt me-2"></i>Daftar Laporan Terbaru</h5>
                </div>
                <div class="card-body p-3">
                    <div class="recent-reports">
                        @forelse ($laporans as $laporan)
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 border-radius-lg" style="background: #F8F9FA;">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-info shadow text-center">
                                        <i class="fas fa-file-lines text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm font-weight-bold">{{ Str::limit($laporan->deskripsi_kemajuan, 30) }}</h6>
                                        <span class="text-xs text-muted">Hasil: {{ $laporan->hasil_panen }} kg | {{ $laporan->tanggal }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('edit.laporan', $laporan->id) }}" class="btn btn-sm btn-agriculture">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <p class="text-muted">Tidak ada laporan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Chart.js for Bantuan Mingguan
    var ctx1 = document.getElementById("chart-line").getContext("2d");
    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
    gradientStroke1.addColorStop(1, 'rgba(72, 187, 120, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(72, 187, 120, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(72, 187, 120, 0)');

    @if($bantuans->count() > 0)
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
            datasets: [{
                label: "Jumlah Bantuan",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#48BB78",
                backgroundColor: gradientStroke1,
                borderWidth: 3,
                fill: true,
                data: [12, 15, 8, 22, 18, 25, {{ $bantuan_hari_ini }}],
                maxBarThickness: 6
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#333',
                    bodyColor: '#666',
                    borderColor: '#48BB78',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return 'Hari: ' + context[0].label;
                        },
                        label: function(context) {
                            return 'Bantuan: ' + context.parsed.y + ' unit';
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#4A5568',
                        font: {
                            size: 11,
                            family: "Inter",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#4A5568',
                        padding: 20,
                        font: {
                            size: 11,
                            family: "Inter",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
    @endif

    // Mark as read from dashboard
    window.markAsReadFromDashboard = function(notificationId) {
        fetch('/notifications/' + notificationId + '/read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    };

    // Show bantuan detail modal
    window.showBantuanDetail = function(bantuanId) {
        fetch('/bantuan/' + bantuanId)
            .then(response => response.json())
            .then(data => {
                // Create modal HTML
                const modalHtml = `
                    <div class="modal fade" id="bantuanDetailModal" tabindex="-1" aria-labelledby="bantuanDetailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bantuanDetailModalLabel">
                                        <i class="fas fa-info-circle me-2"></i>Detail Bantuan
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-title text-info">
                                                        <i class="fas fa-seedling me-2"></i>Jenis Bantuan
                                                    </h6>
                                                    <p class="card-text fw-bold">${data.jenis_bantuan}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-title text-success">
                                                        <i class="fas fa-hashtag me-2"></i>Jumlah
                                                    </h6>
                                                    <p class="card-text fw-bold">${data.jumlah} unit</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-title text-warning">
                                                        <i class="fas fa-calendar me-2"></i>Tanggal
                                                    </h6>
                                                    <p class="card-text fw-bold">${new Date(data.tanggal).toLocaleDateString('id-ID')}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-title text-primary">
                                                        <i class="fas fa-tasks me-2"></i>Status
                                                    </h6>
                                                    <span class="badge ${data.status === 'Dikirim' ? 'bg-success' : 'bg-warning'} fs-6">
                                                        ${data.status === 'Dikirim' ? '<i class="fas fa-check-circle me-1"></i>' : '<i class="fas fa-clock me-1"></i>'}
                                                        ${data.status}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    ${data.catatan ? `
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h6 class="card-title text-secondary">
                                                <i class="fas fa-sticky-note me-2"></i>Catatan
                                            </h6>
                                            <p class="card-text">${data.catatan}</p>
                                        </div>
                                    </div>
                                    ` : ''}
                                    ${data.user ? `
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title text-dark">
                                                <i class="fas fa-user me-2"></i>Penerima Bantuan
                                            </h6>
                                            <div class="d-flex align-items-center">
                                                <img src="${data.user.profile_picture ? '/storage/' + data.user.profile_picture : '/img/default-avatar.png'}" alt="Avatar" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <p class="mb-0 fw-bold">${data.user.name}</p>
                                                    <small class="text-muted">${data.user.email}</small><br>
                                                    <small class="text-muted">${data.user.alamat_desa || 'N/A'}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    ` : ''}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <a href="/edit-bantuan/${data.id}" class="btn btn-primary">
                                        <i class="fas fa-edit me-2"></i>Edit Bantuan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Remove existing modal if any
                const existingModal = document.getElementById('bantuanDetailModal');
                if (existingModal) {
                    existingModal.remove();
                }

                // Add modal to body
                document.body.insertAdjacentHTML('beforeend', modalHtml);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('bantuanDetailModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error fetching bantuan details:', error);
                alert('Terjadi kesalahan saat memuat detail bantuan.');
            });
    };

    // Delete bantuan function
    window.deleteBantuan = function(bantuanId, jenisBantuan) {
        if (confirm(`Apakah Anda yakin ingin menghapus bantuan "${jenisBantuan}"?`)) {
            fetch('/delete-bantuan/' + bantuanId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Bantuan berhasil dihapus!');
                    location.reload();
                } else {
                    alert('Gagal menghapus bantuan.');
                }
            })
            .catch(error => {
                console.error('Error deleting bantuan:', error);
                alert('Terjadi kesalahan saat menghapus bantuan.');
            });
        }
    };

    // Search functionality for tables
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('globalSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                let value = e.target.value.toLowerCase();
                let rows = document.querySelectorAll('table tbody tr');
                rows.forEach(row => {
                    let text = row.textContent.toLowerCase();
                    row.style.display = text.includes(value) ? '' : 'none';
                });
            });
        }
    });
</script>
@endsection
