@extends('layouts.app')

@section('title', 'Kelola Laporan Bantuan')

@push('styles')
<style>
    .page-hero {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 40px rgba(46,125,50,0.3);
    }
    .modern-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
    }
    .modern-card-header {
        background: linear-gradient(135deg, #f8fdf9, #e8f5e9);
        padding: 1.5rem;
        border-bottom: 2px solid #c8e6c9;
    }
    .filter-input {
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s;
    }
    .filter-input:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 0.2rem rgba(46,125,50,0.15);
    }
    .btn-filter {
        border-radius: 12px;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
    }
    .table-modern {
        margin: 0;
    }
    .table-modern thead th {
        background: #f8fdf9;
        color: #1b5e20;
        font-weight: 700;
        border: none;
        padding: 1rem;
    }
    .table-modern tbody tr {
        transition: all 0.3s;
    }
    .table-modern tbody tr:hover {
        background: #f8fdf9;
        transform: translateX(5px);
    }
    .table-modern tbody td {
        border-top: 1px solid #f0f0f0;
        padding: 1rem;
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <div class="page-hero">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2" style="color: white; font-weight: 800;">Kelola Laporan Bantuan</h1>
                <p class="mb-0" style="opacity: 0.9;">Verifikasi dan kelola laporan bantuan dari petani</p>
            </div>
            <a href="{{ route('admin.laporan-bantuan.dashboard') }}" class="btn btn-light">
                <i class="fas fa-chart-line me-2"></i>Dashboard & Analisis
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="modern-card mb-4">
        <div class="modern-card-header">
            <h6 class="m-0 fw-bold text-success"><i class="fas fa-filter me-2"></i>Filter & Pencarian</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.laporan-bantuan.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label fw-bold">Status</label>
                    <select class="form-select filter-input" id="status" name="status">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $status)
                            <option value="{{ $status }}" {{ $filters['status'] == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="jenis_bantuan" class="form-label fw-bold">Jenis Bantuan</label>
                    <select class="form-select filter-input" id="jenis_bantuan" name="jenis_bantuan">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisBantuanOptions as $jenis)
                            <option value="{{ $jenis }}" {{ $filters['jenis_bantuan'] == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="start_date" class="form-label fw-bold">Dari Tanggal</label>
                    <input type="date" class="form-control filter-input" id="start_date" name="start_date" value="{{ $filters['start_date'] }}">
                </div>
                <div class="col-md-2">
                    <label for="end_date" class="form-label fw-bold">Sampai Tanggal</label>
                    <input type="date" class="form-control filter-input" id="end_date" name="end_date" value="{{ $filters['end_date'] }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success btn-filter w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h6 class="m-0 fw-bold text-success"><i class="fas fa-list me-2"></i>Daftar Laporan ({{ $reports->total() }})</h6>
        </div>
        <div class="card-body p-0">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Pelapor</th>
                                <th>Jenis Bantuan</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $laporan)
                            <tr>
                                <td>{{ $laporan->tanggal_pelaporan->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ Str::limit($laporan->judul, 50) }}</strong>
                                    @if($laporan->is_public)
                                        <span class="badge bg-info ms-1" title="Dipublikasikan">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $laporan->user->name }}</td>
                                <td><span class="badge bg-primary">{{ $laporan->jenis_bantuan }}</span></td>
                                <td>{!! $laporan->status_badge !!}</td>
                                <td>{{ $laporan->views_count }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.laporan-bantuan.show', $laporan->id) }}" 
                                           class="btn btn-info" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($laporan->status === 'pending')
                                            <button type="button" 
                                                    class="btn btn-success" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#verifyModal{{ $laporan->id }}"
                                                    title="Verifikasi">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rejectModal{{ $laporan->id }}"
                                                    title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif

                                        @if($laporan->status === 'verified' && !$laporan->is_public)
                                            <form action="{{ route('admin.laporan-bantuan.publish', $laporan->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary" title="Publikasikan">
                                                    <i class="fas fa-globe"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <!-- Verify Modal -->
                                    <div class="modal fade" id="verifyModal{{ $laporan->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.laporan-bantuan.verify', $laporan->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Verifikasi Laporan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Anda akan memverifikasi laporan: <strong>{{ $laporan->judul }}</strong></p>
                                                        <div class="mb-3">
                                                            <label for="catatan{{ $laporan->id }}" class="form-label">Catatan (Opsional)</label>
                                                            <textarea class="form-control" 
                                                                      id="catatan{{ $laporan->id }}" 
                                                                      name="catatan_verifikasi" 
                                                                      rows="3"
                                                                      placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-check me-2"></i>Verifikasi
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $laporan->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.laporan-bantuan.reject', $laporan->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Tolak Laporan</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Anda akan menolak laporan: <strong>{{ $laporan->judul }}</strong></p>
                                                        <div class="mb-3">
                                                            <label for="catatanReject{{ $laporan->id }}" class="form-label">
                                                                Alasan Penolakan <span class="text-danger">*</span>
                                                            </label>
                                                            <textarea class="form-control" 
                                                                      id="catatanReject{{ $laporan->id }}" 
                                                                      name="catatan_verifikasi" 
                                                                      rows="3"
                                                                      placeholder="Jelaskan alasan penolakan..."
                                                                      required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-times me-2"></i>Tolak Laporan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $reports->appends($filters)->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted">Tidak ada laporan ditemukan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
