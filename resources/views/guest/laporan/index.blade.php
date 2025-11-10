@extends('layouts.guest')

@section('title', 'Laporan Hasil Panen - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h4><i class="fas fa-file-alt me-2"></i>Laporan Hasil Panen</h4>
                    <p class="mb-0 text-muted">Lihat semua laporan hasil panen dari petani</p>
                </div>
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="badge-agriculture me-3">
                                    <i class="fas fa-file-lines me-1"></i>{{ $laporans->count() }} Total Laporan
                                </span>
                                <span class="badge-agriculture-success me-3">
                                    <i class="fas fa-chart-line me-1"></i>{{ $laporans->where('hasil_panen', '>', 0)->count() }} Dengan Hasil Panen
                                </span>
                                <span class="badge-agriculture-warning">
                                    <i class="fas fa-clock me-1"></i>{{ $laporans->where('hasil_panen', 0)->count() }} Dalam Proses
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('guest.laporan.create') }}" class="btn btn-agriculture-primary">
                                <i class="fas fa-plus me-1"></i>Buat Laporan Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h5><i class="fas fa-filter me-2"></i>Filter & Pencarian</h5>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label text-sm font-weight-bold">Jenis Tanaman</label>
                            <select class="form-select form-select-agriculture" id="jenisTanamanFilter">
                                <option value="">🌱 Semua Tanaman</option>
                                <option value="Padi">🌾 Padi</option>
                                <option value="Jagung">🌽 Jagung</option>
                                <option value="Kedelai">🫘 Kedelai</option>
                                <option value="Singkong">🥔 Singkong</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-sm font-weight-bold">Hasil Panen</label>
                            <select class="form-select form-select-agriculture" id="hasilFilter">
                                <option value="">📊 Semua Hasil</option>
                                <option value="dengan_hasil">✅ Dengan Hasil</option>
                                <option value="tanpa_hasil">⏳ Tanpa Hasil</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-sm font-weight-bold">Bulan</label>
                            <select class="form-select form-select-agriculture" id="bulanFilter">
                                <option value="">📅 Semua Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
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
                        <table class="table-agriculture" id="laporanTable">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-seedling me-1"></i>Deskripsi Kemajuan</th>
                                    <th><i class="fas fa-user me-1"></i>Petani</th>
                                    <th><i class="fas fa-weight me-1"></i>Hasil Panen</th>
                                    <th><i class="fas fa-calendar me-1"></i>Tanggal</th>
                                    <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                    <th class="text-center"><i class="fas fa-cogs me-1"></i>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporans as $laporan)
                                    <tr class="table-row-agriculture">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-agriculture me-3">
                                                    <i class="fas fa-{{ $laporan->jenis_tanaman == 'Padi' ? 'rice' : ($laporan->jenis_tanaman == 'Jagung' ? 'corn' : ($laporan->jenis_tanaman == 'Kedelai' ? 'bean' : 'leaf')) }}"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-weight-bold mb-0">{{ Str::limit($laporan->deskripsi_kemajuan, 50) }}</p>
                                                    <p class="text-xs text-muted mb-0">
                                                        @if($laporan->jenis_tanaman)
                                                            <i class="fas fa-seedling me-1"></i>{{ $laporan->jenis_tanaman }}
                                                        @else
                                                            <i class="fas fa-question-circle me-1"></i>Tanaman belum ditentukan
                                                        @endif
                                                        @if($laporan->catatan)
                                                            | <i class="fas fa-sticky-note me-1"></i>{{ Str::limit($laporan->catatan, 30) }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($laporan->user)
                                                    <div class="avatar-circle me-2">
                                                        {{ substr($laporan->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-weight-bold mb-0">{{ $laporan->user->name }}</p>
                                                        <p class="text-xs text-muted mb-0">{{ $laporan->user->desa ?? 'Desa belum diisi' }}</p>
                                                    </div>
                                                @else
                                                    <div class="avatar-circle me-2">
                                                        {{ substr($laporan->nama_petani ?? 'G', 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-weight-bold mb-0">{{ $laporan->nama_petani ?? 'Guest' }}</p>
                                                        <p class="text-xs text-muted mb-0">{{ $laporan->alamat_desa ?? 'Alamat belum diisi' }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($laporan->hasil_panen > 0)
                                                <span class="badge-quantity">{{ $laporan->hasil_panen }} kg</span>
                                            @else
                                                <span class="badge-agriculture-warning">Belum Panen</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="date-display">
                                                <i class="fas fa-calendar-day me-1"></i>
                                                {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($laporan->hasil_panen > 0)
                                                <span class="badge-agriculture-success">Selesai</span>
                                            @else
                                                <span class="badge-agriculture-warning">Dalam Proses</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('guest.laporan.show', $laporan->id) }}" class="btn btn-sm btn-agriculture-view" data-bs-toggle="tooltip" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                                                <h5 class="text-muted">Belum ada laporan</h5>
                                                <p class="text-muted">Belum ada laporan hasil panen yang dibuat</p>
                                                <a href="{{ route('guest.laporan.create') }}" class="btn btn-agriculture-primary">
                                                    <i class="fas fa-plus me-1"></i>Buat Laporan Pertama
                                                </a>
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
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Filter functionality
    document.getElementById('jenisTanamanFilter').addEventListener('change', filterTable);
    document.getElementById('hasilFilter').addEventListener('change', filterTable);
    document.getElementById('bulanFilter').addEventListener('change', filterTable);
});

function filterTable() {
    const jenisValue = document.getElementById('jenisTanamanFilter').value;
    const hasilValue = document.getElementById('hasilFilter').value;
    const bulanValue = document.getElementById('bulanFilter').value;

    const rows = document.querySelectorAll('#laporanTable tbody tr');

    rows.forEach(row => {
        if (row.cells.length < 6) return;

        const deskripsi = row.cells[0].textContent.toLowerCase();
        const hasil = row.cells[2].textContent.toLowerCase();
        const tanggal = row.cells[3].textContent;
        const bulan = tanggal.split(' ')[1]; // Extract month from date

        let show = true;

        // Jenis tanaman filter
        if (jenisValue && !deskripsi.includes(jenisValue.toLowerCase())) {
            show = false;
        }

        // Hasil filter
        if (hasilValue) {
            if (hasilValue === 'dengan_hasil' && hasil.includes('belum panen')) {
                show = false;
            } else if (hasilValue === 'tanpa_hasil' && !hasil.includes('belum panen')) {
                show = false;
            }
        }

        // Bulan filter
        if (bulanValue && bulan !== getMonthName(bulanValue)) {
            show = false;
        }

        row.style.display = show ? '' : 'none';
    });
}

function getMonthName(monthNum) {
    const months = {
        '01': 'Jan', '02': 'Feb', '03': 'Mar', '04': 'Apr', '05': 'Mei', '06': 'Jun',
        '07': 'Jul', '08': 'Ags', '09': 'Sep', '10': 'Okt', '11': 'Nov', '12': 'Des'
    };
    return months[monthNum] || '';
}
</script>
@endsection
