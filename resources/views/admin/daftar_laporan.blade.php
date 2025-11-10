@extends('layouts.app')

@section('title', '📋 Daftar Laporan - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h4><i class="fas fa-file-alt me-2"></i>Daftar Laporan Pertanian</h4>
                    <p class="mb-0 text-muted">Pantau laporan hasil panen dan kemajuan pertanian</p>
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
                            <a href="{{ route('export.laporan.pdf') }}" class="btn btn-agriculture me-2">
                                <i class="fas fa-file-pdf me-1"></i>Export PDF
                            </a>
                            <a href="{{ route('input.data') }}" class="btn btn-agriculture-primary">
                                <i class="fas fa-plus me-1"></i>Tambah Laporan
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
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Jenis Tanaman</label>
                            <select class="form-select form-select-agriculture" id="jenisTanamanFilter">
                                <option value="">🌱 Semua Tanaman</option>
                                <option value="Padi">🌾 Padi</option>
                                <option value="Jagung">🌽 Jagung</option>
                                <option value="Kedelai">🫘 Kedelai</option>
                                <option value="Singkong">🥔 Singkong</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Hasil Panen</label>
                            <select class="form-select form-select-agriculture" id="hasilFilter">
                                <option value="">📊 Semua Hasil</option>
                                <option value="dengan_hasil">✅ Dengan Hasil</option>
                                <option value="tanpa_hasil">⏳ Tanpa Hasil</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Tanggal Mulai</label>
                            <input type="date" class="form-control form-control-agriculture" id="startDateFilter">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Tanggal Akhir</label>
                            <input type="date" class="form-control form-control-agriculture" id="endDateFilter">
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
                                    <th><i class="fas fa-weight me-1"></i>Hasil Panen</th>
                                    <th><i class="fas fa-calendar me-1"></i>Tanggal</th>
                                    <th><i class="fas fa-user me-1"></i>Petani</th>
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
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-agriculture me-2">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $laporan->user->name ?? 'N/A' }}</p>
                                                    <p class="text-xs text-muted mb-0">{{ $laporan->user->email ?? '' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('edit.laporan', $laporan->id) }}" class="btn btn-sm btn-agriculture-edit" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-agriculture-view" data-bs-toggle="tooltip" title="Detail" onclick="showDetail({{ $laporan->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <form action="{{ route('delete.laporan', $laporan->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-agriculture-delete" data-bs-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                                                <h5 class="text-muted">Tidak ada data laporan</h5>
                                                <p class="text-muted">Belum ada laporan yang tercatat dalam sistem</p>
                                                <a href="{{ route('input.data') }}" class="btn btn-agriculture-primary">
                                                    <i class="fas fa-plus me-1"></i>Tambah Laporan Pertama
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

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-agriculture">
                <h5 class="modal-title text-white"><i class="fas fa-info-circle me-2"></i>Detail Laporan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be loaded here -->
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

    // Global search functionality
    const searchInput = document.getElementById('globalSearch');
    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }

    // Filter functionality
    document.getElementById('jenisTanamanFilter').addEventListener('change', filterTable);
    document.getElementById('hasilFilter').addEventListener('change', filterTable);
    document.getElementById('startDateFilter').addEventListener('change', filterTable);
    document.getElementById('endDateFilter').addEventListener('change', filterTable);
});

function filterTable() {
    const searchValue = document.getElementById('globalSearch')?.value.toLowerCase() || '';
    const jenisValue = document.getElementById('jenisTanamanFilter').value;
    const hasilValue = document.getElementById('hasilFilter').value;
    const startDate = document.getElementById('startDateFilter').value;
    const endDate = document.getElementById('endDateFilter').value;

    const rows = document.querySelectorAll('#laporanTable tbody tr');

    rows.forEach(row => {
        if (row.cells.length < 5) return;

        const deskripsi = row.cells[0].textContent.toLowerCase();
        const hasil = row.cells[1].textContent.toLowerCase();
        const tanggal = row.cells[2].textContent;
        const petani = row.cells[3].textContent.toLowerCase();

        let show = true;

        // Search filter
        if (searchValue && !deskripsi.includes(searchValue) && !petani.includes(searchValue)) {
            show = false;
        }

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

        // Date filter
        if (startDate || endDate) {
            const rowDate = new Date(tanggal.split(' ').reverse().join('-'));
            if (startDate && rowDate < new Date(startDate)) show = false;
            if (endDate && rowDate > new Date(endDate)) show = false;
        }

        row.style.display = show ? '' : 'none';
    });
}

function showDetail(id) {
    // Fetch laporan details via AJAX
    fetch(`/api/laporan/${id}`)
        .then(response => response.json())
        .then(data => {
            let catatanHtml = '';
            if (data.catatan) {
                catatanHtml = `
                    <div class="col-12">
                        <h6><i class="fas fa-sticky-note me-2"></i>Catatan</h6>
                        <p>${data.catatan}</p>
                    </div>
                `;
            }

            document.getElementById('detailContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-file-alt me-2"></i>Deskripsi Kemajuan</h6>
                        <p>${data.deskripsi_kemajuan}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-weight me-2"></i>Hasil Panen</h6>
                        <p>${data.hasil_panen > 0 ? data.hasil_panen + ' kg' : 'Belum panen'}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar me-2"></i>Tanggal</h6>
                        <p>${new Date(data.tanggal).toLocaleDateString('id-ID')}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-seedling me-2"></i>Jenis Tanaman</h6>
                        <p>${data.jenis_tanaman || 'Tidak ditentukan'}</p>
                    </div>
                    <div class="col-12">
                        <h6><i class="fas fa-user me-2"></i>Petani</h6>
                        <p>${data.user?.name || 'N/A'}</p>
                    </div>
                    ${catatanHtml}
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('detailContent').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p>Gagal memuat detail laporan</p>
                </div>
            `;
        });

    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}
</script>
@endsection
