@extends('layouts.guest')

@section('title', 'Berita - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="mb-0">Berita & Informasi Pertanian</h4>
                </div>
                <div class="card-body">
                    @if($beritas->count() > 0)
                        <div class="row">
                            @foreach($beritas as $berita)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        @if($berita->gambar)
                                            <img src="{{ asset('storage/' . $berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}" style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <span style="font-size: 3rem;">📰</span>
                                            </div>
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <small class="text-muted">
                                                    📅 {{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}
                                                </small>
                                                <span class="badge bg-primary">{{ $berita->kategori ?? 'Berita' }}</span>
                                            </div>
                                            <h5 class="card-title mb-3">
                                                <a href="{{ route('guest.berita.detail', $berita->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($berita->judul, 60) }}
                                                </a>
                                            </h5>
                                            <p class="card-text text-muted flex-grow-1">
                                                {{ Str::limit(strip_tags($berita->konten), 120) }}
                                            </p>
                                            <div class="mt-auto">
                                                <a href="{{ route('guest.berita.detail', $berita->slug) }}" class="btn btn-outline-primary btn-sm">
                                                    👁️ Baca Selengkapnya
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $beritas->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div style="font-size: 4rem;">📰</div>
                            <h5 class="text-muted">Belum ada berita tersedia</h5>
                            <p class="text-muted">Silakan kembali lagi nanti untuk update informasi terbaru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
