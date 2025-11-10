@extends('layouts.guest')

@section('title', 'Program Bantuan Pertanian')

@section('content')
<div class="container my-5">
    <!-- Judul & Deskripsi -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-success">Program Bantuan Pertanian</h2>
        <p class="text-muted">Informasi transparan tentang program bantuan pertanian yang tersedia untuk mendukung kesejahteraan petani.</p>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card">
                <h5 class="text-muted">Total Program</h5>
                <div class="stat-number text-primary">{{ $bantuans->count() }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h5 class="text-muted">Sudah Dikirim</h5>
                <div class="stat-number text-success">{{ $bantuans->where('status', 'Dikirim')->count() }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h5 class="text-muted">Total Bantuan</h5>
                <div class="stat-number text-info">{{ number_format($bantuans->sum('jumlah')) }}</div>
            </div>
        </div>
    </div>

    <!-- Tabel + Filter -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">Data Program Bantuan</h5>

            <!-- Filter Row -->
            <div class="row g-3 mb-4">
                <div class="col-md-5">
                    <input type="text" id="searchBantuan" class="form-control" placeholder="Cari nama bantuan..." value="">
                </div>
                <div class="col-md-5">
                    <select id="statusFilter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Dikirim">Dikirim</option>
                        <option value="Diproses">Diproses</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" onclick="filterBantuan()" class="btn btn-primary w-100">
                        Filter
                    </button>
                </div>
            </div>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Bantuan</th>
                            <th>Jumlah</th>
                            <th>Penerima</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bantuanTableBody">
                        @forelse($bantuans as $index => $bantuan)
                        <tr class="bantuan-row" data-status="{{ $bantuan->status }}" data-nama="{{ strtolower($bantuan->jenis_bantuan) }}">
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $bantuan->jenis_bantuan }}</strong></td>
                            <td>{{ number_format($bantuan->jumlah) }}</td>
                            <td>{{ $bantuan->user->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $bantuan->status === 'Dikirim' ? 'badge-dikirim' : 'badge-diproses' }} text-white">
                                    {{ $bantuan->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('guest.bantuan.show', $bantuan->id) }}" class="btn btn-sm btn-outline-primary">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Tidak ada data bantuan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .stat-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: 600;
    }
    .table th {
        background-color: #e9f7ef !important;
        color: #28a745;
        font-weight: 600;
    }
    .badge-dikirim {
        background-color: #28a745 !important;
    }
    .badge-diproses {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
</style>
@endpush

@push('scripts')
<script>
function filterBantuan() {
    const search = document.getElementById('searchBantuan').value.toLowerCase();
    const status = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('.bantuan-row');

    rows.forEach(row => {
        const nama = row.dataset.nama;
        const rowStatus = row.dataset.status;
        const matchSearch = nama.includes(search);
        const matchStatus = !status || rowStatus === status;

        row.style.display = (matchSearch && matchStatus) ? '' : 'none';
    });
}

// Real-time search
document.getElementById('searchBantuan').addEventListener('input', filterBantuan);
document.getElementById('statusFilter').addEventListener('change', filterBantuan);
</script>
@endpush