@extends('layouts.app')

@section('title', 'Hasil Panen - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-0 text-gradient">
                                <i class="fas fa-tractor text-success me-2"></i>
                                Hasil Panen Petani
                            </h4>
                            <p class="text-muted mb-0">Pantau produktivitas pertanian di Kabupaten Toba</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="d-flex align-items-center justify-content-end">
                                <div class="me-4">
                                    <h3 class="mb-0 text-success">{{ number_format($total_hasil_panen, 0, ',', '.') }} kg</h3>
                                    <small class="text-muted">Total Hasil Panen</small>
                                </div>
                                <div class="bg-success rounded-circle p-3">
                                    <i class="fas fa-seedling text-white fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" id="searchInput" placeholder="Cari berdasarkan nama petani atau deskripsi...">
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-success active" id="filterAll">
                                    <i class="fas fa-list me-1"></i>Semua
                                </button>
                                <button type="button" class="btn btn-outline-success" id="filterHigh">
                                    <i class="fas fa-arrow-up me-1"></i>Hasil Tinggi
                                </button>
                                <button type="button" class="btn btn-outline-success" id="filterLow">
                                    <i class="fas fa-arrow-down me-1"></i>Hasil Rendah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="row">
        <div class="col-12">
            <div class="content-card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center mb-0" id="panenTable">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" style="width: 5%">
                                        <i class="fas fa-user"></i>
                                    </th>
                                    <th class="align-middle" style="width: 25%">Petani</th>
                                    <th class="align-middle" style="width: 30%">Deskripsi Kemajuan</th>
                                    <th class="text-center align-middle" style="width: 15%">Hasil Panen</th>
                                    <th class="text-center align-middle" style="width: 15%">Tanggal</th>
                                    <th class="text-center align-middle" style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporans as $laporan)
                                    <tr class="panen-row" data-hasil="{{ $laporan->hasil_panen }}">
                                        <td class="text-center">
                                            <div class="avatar avatar-sm mx-auto">
                                                <img src="{{ $laporan->user && $laporan->user->profile_picture ? asset('storage/' . $laporan->user->profile_picture) : asset('assets/img/default-avatar.png') }}"
                                                     alt="Avatar" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm font-weight-bold">
                                                    {{ $laporan->user ? $laporan->user->name : 'User tidak ditemukan' }}
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $laporan->user ? $laporan->user->alamat_desa : '-' }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0">{{ Str::limit($laporan->deskripsi_kemajuan, 80) }}</p>
                                            @if($laporan->jenis_tanaman)
                                                <small class="badge bg-light text-dark">
                                                    <i class="fas fa-leaf me-1"></i>{{ $laporan->jenis_tanaman }}
                                                </small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success fs-6 px-3 py-2">
                                                {{ number_format($laporan->hasil_panen, 0, ',', '.') }} kg
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="text-sm font-weight-bold">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') }}</span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($laporan->tanggal)->diffForHumans() }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('edit.laporan', $laporan->id) }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-title="Edit Laporan">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('api.laporan.show', $laporan->id) }}"
                                                   class="btn btn-sm btn-outline-info"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">Belum ada data hasil panen</h5>
                                                <p class="text-muted mb-0">Data hasil panen akan muncul setelah petani menginput laporan kemajuan.</p>
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
    </div>

    <!-- Statistics Cards -->
    @if($laporans->count() > 0)
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="content-card">
                <div class="card-body text-center">
                    <div class="bg-primary rounded-circle p-3 d-inline-block mb-3">
                        <i class="fas fa-users text-white fa-2x"></i>
                    </div>
                    <h5 class="mb-1">{{ $laporans->unique('user_id')->count() }}</h5>
                    <small class="text-muted">Petani Aktif</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="content-card">
                <div class="card-body text-center">
                    <div class="bg-success rounded-circle p-3 d-inline-block mb-3">
                        <i class="fas fa-chart-line text-white fa-2x"></i>
                    </div>
                    <h5 class="mb-1">{{ number_format($laporans->avg('hasil_panen'), 1) }} kg</h5>
                    <small class="text-muted">Rata-rata Panen</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="content-card">
                <div class="card-body text-center">
                    <div class="bg-warning rounded-circle p-3 d-inline-block mb-3">
                        <i class="fas fa-trophy text-white fa-2x"></i>
                    </div>
                    <h5 class="mb-1">{{ number_format($laporans->max('hasil_panen'), 0, ',', '.') }} kg</h5>
                    <small class="text-muted">Hasil Tertinggi</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="content-card">
                <div class="card-body text-center">
                    <div class="bg-info rounded-circle p-3 d-inline-block mb-3">
                        <i class="fas fa-calendar-alt text-white fa-2x"></i>
                    </div>
                    <h5 class="mb-1">{{ $laporans->count() }}</h5>
                    <small class="text-muted">Total Laporan</small>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#panenTable tbody tr.panen-row');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isVisible = text.includes(searchTerm);
            row.style.display = isVisible ? '' : 'none';
        });
    });

    // Filter functionality
    const filterAll = document.getElementById('filterAll');
    const filterHigh = document.getElementById('filterHigh');
    const filterLow = document.getElementById('filterLow');

    function filterRows(criteria) {
        const rows = document.querySelectorAll('.panen-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const hasil = parseInt(row.dataset.hasil);
            let show = false;

            switch(criteria) {
                case 'all':
                    show = true;
                    break;
                case 'high':
                    show = hasil >= 100; // Consider high yield as 100kg+
                    break;
                case 'low':
                    show = hasil < 100; // Consider low yield as less than 100kg
                    break;
            }

            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        return visibleCount;
    }

    filterAll.addEventListener('click', function() {
        filterRows('all');
        setActiveFilter(this);
    });

    filterHigh.addEventListener('click', function() {
        filterRows('high');
        setActiveFilter(this);
    });

    filterLow.addEventListener('click', function() {
        filterRows('low');
        setActiveFilter(this);
    });

    function setActiveFilter(activeButton) {
        [filterAll, filterHigh, filterLow].forEach(btn => {
            btn.classList.remove('active');
            btn.classList.add('btn-outline-success');
        });
        activeButton.classList.add('active');
        activeButton.classList.remove('btn-outline-success');
    }

    // Auto-refresh functionality (optional)
    let autoRefreshInterval;

    function startAutoRefresh() {
        autoRefreshInterval = setInterval(() => {
            // You can add auto-refresh logic here if needed
            console.log('Auto-refresh triggered');
        }, 300000); // 5 minutes
    }

    function stopAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
    }

    // Start auto-refresh when page loads
    startAutoRefresh();

    // Stop auto-refresh when user interacts with search
    searchInput.addEventListener('focus', stopAutoRefresh);
});
</script>
@endsection
