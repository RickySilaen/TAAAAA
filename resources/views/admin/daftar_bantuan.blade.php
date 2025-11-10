@extends('layouts.app')

@section('title', '📋 Daftar Bantuan - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header-agriculture">
                    <h4><i class="fas fa-list me-2"></i>Daftar Bantuan Pertanian</h4>
                    <p class="mb-0 text-muted">Kelola dan pantau semua bantuan yang telah didistribusikan</p>
                </div>
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="badge-agriculture me-3">
                                    <i class="fas fa-boxes me-1"></i>{{ $bantuans->count() }} Total Bantuan
                                </span>
                                <span class="badge-agriculture-success me-3">
                                    <i class="fas fa-check-circle me-1"></i>{{ $bantuans->where('status', 'Dikirim')->count() }} Dikirim
                                </span>
                                <span class="badge-agriculture-warning">
                                    <i class="fas fa-clock me-1"></i>{{ $bantuans->where('status', 'Diproses')->count() }} Diproses
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('export.bantuan.pdf') }}" class="btn btn-agriculture me-2">
                                <i class="fas fa-file-pdf me-1"></i>Export PDF
                            </a>
                            <a href="{{ route('input.data') }}" class="btn btn-agriculture-primary">
                                <i class="fas fa-plus me-1"></i>Tambah Bantuan
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
                            <label class="form-label text-sm font-weight-bold">Status</label>
                            <select class="form-select form-select-agriculture" id="statusFilter">
                                <option value="">🌱 Semua Status</option>
                                <option value="Diproses">🔄 Diproses</option>
                                <option value="Dikirim">✅ Dikirim</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-sm font-weight-bold">Jenis Bantuan</label>
                            <select class="form-select form-select-agriculture" id="jenisFilter">
                                <option value="">🌾 Semua Jenis</option>
                                <option value="Bibit">🌱 Bibit</option>
                                <option value="Pupuk">🧪 Pupuk</option>
                                <option value="Pestisida">💧 Pestisida</option>
                                <option value="Alat">🔧 Alat</option>
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
                        <table class="table-agriculture" id="bantuanTable">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-seedling me-1"></i>Jenis Bantuan</th>
                                    <th><i class="fas fa-hashtag me-1"></i>Jumlah</th>
                                    <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                    <th><i class="fas fa-calendar me-1"></i>Tanggal</th>
                                    <th class="text-center"><i class="fas fa-cogs me-1"></i>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bantuans as $bantuan)
                                    <tr class="table-row-agriculture">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-agriculture me-3">
                                                    <i class="fas fa-{{ $bantuan->jenis_bantuan == 'Bibit' ? 'seedling' : ($bantuan->jenis_bantuan == 'Pupuk' ? 'flask' : ($bantuan->jenis_bantuan == 'Pestisida' ? 'spray-can' : 'tools')) }}"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $bantuan->jenis_bantuan }}</p>
                                                    <p class="text-xs text-muted mb-0">{{ $bantuan->user->name ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-quantity">{{ $bantuan->jumlah }} unit</span>
                                        </td>
                                        <td>
                                            <span class="status-badge {{ $bantuan->status == 'Dikirim' ? 'status-sent' : 'status-processing' }}">
                                                {{ $bantuan->status == 'Dikirim' ? '🟢' : '🔴' }} {{ $bantuan->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="date-display">
                                                <i class="fas fa-calendar-day me-1"></i>
                                                {{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('edit.bantuan', $bantuan->id) }}" class="btn btn-sm btn-agriculture-edit" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-agriculture-view" data-bs-toggle="tooltip" title="Detail" onclick="showDetail({{ $bantuan->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <form action="{{ route('delete.bantuan', $bantuan->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bantuan ini?')">
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
                                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                                <h5 class="text-muted">Tidak ada data bantuan</h5>
                                                <p class="text-muted">Belum ada bantuan yang tercatat dalam sistem</p>
                                                <a href="{{ route('input.data') }}" class="btn btn-agriculture-primary">
                                                    <i class="fas fa-plus me-1"></i>Tambah Bantuan Pertama
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
                <h5 class="modal-title text-white"><i class="fas fa-info-circle me-2"></i>Detail Bantuan</h5>
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
    document.getElementById('statusFilter').addEventListener('change', filterTable);
    document.getElementById('jenisFilter').addEventListener('change', filterTable);
    document.getElementById('startDateFilter').addEventListener('change', filterTable);
    document.getElementById('endDateFilter').addEventListener('change', filterTable);
});

function filterTable() {
    const searchValue = document.getElementById('globalSearch')?.value.toLowerCase() || '';
    const statusValue = document.getElementById('statusFilter').value;
    const jenisValue = document.getElementById('jenisFilter').value;
    const startDate = document.getElementById('startDateFilter').value;
    const endDate = document.getElementById('endDateFilter').value;

    const rows = document.querySelectorAll('#bantuanTable tbody tr');

    rows.forEach(row => {
        if (row.cells.length < 5) return;

        const jenis = row.cells[0].textContent.toLowerCase();
        const jumlah = row.cells[1].textContent.toLowerCase();
        const status = row.cells[2].textContent.toLowerCase();
        const tanggal = row.cells[3].textContent;

        let show = true;

        // Search filter
        if (searchValue && !jenis.includes(searchValue) && !jumlah.includes(searchValue)) {
            show = false;
        }

        // Status filter
        if (statusValue && !status.includes(statusValue.toLowerCase())) {
            show = false;
        }

        // Jenis filter
        if (jenisValue && !jenis.includes(jenisValue.toLowerCase())) {
            show = false;
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
    // Fetch bantuan details via AJAX
    fetch(`/api/bantuan/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-seedling me-2"></i>Jenis Bantuan</h6>
                        <p>${data.jenis_bantuan}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-hashtag me-2"></i>Jumlah</h6>
                        <p>${data.jumlah} unit</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-info-circle me-2"></i>Status</h6>
                        <p><span class="status-badge ${data.status == 'Dikirim' ? 'status-sent' : 'status-processing'}">${data.status}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar me-2"></i>Tanggal</h6>
                        <p>${new Date(data.tanggal).toLocaleDateString('id-ID')}</p>
                    </div>
                    <div class="col-12">
                        <h6><i class="fas fa-user me-2"></i>Penerima</h6>
                        <p>${data.user?.name || 'N/A'}</p>
                    </div>
                    ${data.catatan ? `
                    <div class="col-12">
                        <h6><i class="fas fa-sticky-note me-2"></i>Catatan</h6>
                        <p>${data.catatan}</p>
                    </div>
                    ` : ''}
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('detailContent').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p>Gagal memuat detail bantuan</p>
                </div>
            `;
        });

    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}
</script>
@endsection
