@extends('layouts.guest')

@section('title', 'Detail Bantuan - Sistem Pertanian')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-success">Detail Program Bantuan</h2>
        <p class="text-muted">Informasi lengkap tentang program bantuan pertanian.</p>
    </div>

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('bantuan.publik') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Bantuan
        </a>
    </div>

    <!-- Detail Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Header Info -->
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-primary mb-3">{{ $bantuan->jenis_bantuan }}</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <small class="text-muted d-block">Jumlah Bantuan</small>
                                    <h5 class="mb-0 text-success">{{ number_format($bantuan->jumlah) }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge {{ $bantuan->status === 'Dikirim' ? 'bg-success' : 'bg-warning text-dark' }} fs-6">
                                        {{ $bantuan->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Information -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="border-start border-primary border-4 ps-3">
                                <h6 class="text-muted mb-1">Penerima Bantuan</h6>
                                <p class="mb-0 fw-semibold">{{ $bantuan->user->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start border-info border-4 ps-3">
                                <h6 class="text-muted mb-1">Tanggal Distribusi</h6>
                                <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($bantuan->tanggal)->format('d F Y') }}</p>
                            </div>
                        </div>
                        @if($bantuan->catatan)
                        <div class="col-12">
                            <div class="border-start border-warning border-4 ps-3">
                                <h6 class="text-muted mb-1">Catatan</h6>
                                <p class="mb-0">{{ $bantuan->catatan }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-4 pt-4 border-top">
                        <div class="row text-center g-4">
                            <div class="col-md-4">
                                <div class="p-3">
                                    <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                                    <h6 class="mb-1">Dibuat</h6>
                                    <small class="text-muted">{{ $bantuan->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3">
                                    <i class="fas fa-clock fa-2x text-info mb-2"></i>
                                    <h6 class="mb-1">Terakhir Update</h6>
                                    <small class="text-muted">{{ $bantuan->updated_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3">
                                    <i class="fas fa-id-badge fa-2x text-success mb-2"></i>
                                    <h6 class="mb-1">ID Bantuan</h6>
                                    <small class="text-muted">#{{ $bantuan->id }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Actions -->
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <h6 class="mb-3">Informasi Tambahan</h6>
                    <p class="text-muted mb-3">
                        Program bantuan ini merupakan bagian dari komitmen pemerintah untuk mendukung kesejahteraan petani.
                        Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kontak yang tersedia.
                    </p>
                    <a href="{{ route('kontak') }}" class="btn btn-primary">
                        <i class="fas fa-envelope me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
