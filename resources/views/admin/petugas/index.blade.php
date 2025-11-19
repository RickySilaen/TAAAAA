
@extends('layouts.app')

@section('title', 'Kelola Petugas')

@push('styles')
    @include('admin.petugas._styles')
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="header-content p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon me-3">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <h1 class="mb-0">Manajemen Petugas</h1>
                            <p class="mb-0 mt-1">Kelola data akun petugas pertanian kabupaten</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('admin.petugas.create') }}" class="btn btn-modern-primary">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Petugas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-custom alert-success fade show">
        <i class="fas fa-check-circle me-3 fs-4"></i>
        <div class="fw-semibold">{{ session('success') }}</div>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-custom alert-danger fade show">
        <i class="fas fa-exclamation-circle me-3 fs-4"></i>
        <div class="fw-semibold">{{ session('error') }}</div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label text-muted">Total Petugas</div>
                    <div class="stat-value text-primary">{{ $petugas->total() }}</div>
                    <div class="d-flex align-items-center mt-2">
                        <span class="badge bg-success data-badge me-2">
                            <i class="fas fa-arrow-up me-1"></i>100%
                        </span>
                        <small class="text-muted">Petugas aktif</small>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label text-muted">Kecamatan</div>
                    <div class="stat-value text-success">{{ $petugas->pluck('alamat_kecamatan')->filter()->unique()->count() }}</div>
                    <div class="d-flex align-items-center mt-2">
                        <span class="badge bg-info data-badge me-2">
                            <i class="fas fa-check-circle me-1"></i>Aktif
                        </span>
                        <small class="text-muted">Wilayah kerja</small>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label text-muted">Bulan Ini</div>
                    <div class="stat-value text-warning">{{ $petugas->filter(function($p) { return $p->created_at && $p->created_at->isCurrentMonth(); })->count() }}</div>
                    <div class="d-flex align-items-center mt-2">
                        <span class="badge bg-warning data-badge me-2">
                            <i class="fas fa-clock me-1"></i>Terbaru
                        </span>
                        <small class="text-muted">Petugas baru</small>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-table-container">
        @if($petugas->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Desa</th>
                        <th>Kecamatan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($petugas as $index => $item)
                    <tr>
                        <td>
                            <span class="badge bg-primary data-badge">{{ $petugas->firstItem() + $index }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $item->name }}</div>
                                    <small class="text-muted">ID: {{ $item->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-semibold text-muted">{{ $item->email }}</td>
                        <td class="fw-semibold text-success">{{ $item->telepon ?? '-' }}</td>
                        <td class="fw-semibold text-danger">{{ $item->alamat_desa ?? '-' }}</td>
                        <td class="fw-semibold text-primary">{{ $item->alamat_kecamatan ?? '-' }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.petugas.edit', $item->id) }}" class="action-btn btn-edit" title="Edit Petugas">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.petugas.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Hapus Petugas"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="row align-items-center w-100">
                <div class="col-md-6">
                    <div class="pagination-info">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        <span>Menampilkan <strong>{{ $petugas->firstItem() }}</strong> sampai <strong>{{ $petugas->lastItem() }}</strong> dari <strong>{{ $petugas->total() }}</strong> data</span>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    {{ $petugas->links() }}
                </div>
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-users fs-1 text-white"></i>
            </div>
            <h2 class="empty-title">Belum Ada Data Petugas</h2>
            <p class="empty-description">Silakan tambahkan petugas pertama Anda untuk memulai mengelola data petugas pertanian</p>
            <a href="{{ route('admin.petugas.create') }}" class="btn btn-modern-primary">
                <i class="fas fa-plus-circle me-2"></i>Tambah Petugas Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
