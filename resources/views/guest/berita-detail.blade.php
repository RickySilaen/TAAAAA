@extends('layouts.guest')

@section('title', $berita->judul . ' - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('guest.berita') }}">Berita</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($berita->judul, 50) }}</li>
                        </ol>
                    </nav>

                    <!-- Article Header -->
                    <div class="mb-4">
                        @if($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" class="img-fluid rounded mb-3" alt="{{ $berita->judul }}">
                        @endif

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h1 class="h2 mb-2">{{ $berita->judul }}</h1>
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fas fa-calendar me-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y, H:i') }}</span>
                                    @if($berita->kategori)
                                        <span class="mx-2">•</span>
                                        <span class="badge bg-primary">{{ $berita->kategori }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article Content -->
                    <div class="article-content mb-4">
                        {!! $berita->konten !!}
                    </div>

                    <!-- Share Buttons -->
                    <div class="border-top pt-4">
                        <h6 class="mb-3">Bagikan Artikel:</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                               target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f me-1"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($berita->judul) }}"
                               target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter me-1"></i>Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}"
                               target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp me-1"></i>WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Berita Lainnya -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Berita Lainnya</h6>
                </div>
                <div class="card-body">
                    @if($beritaLainnya->count() > 0)
                        @foreach($beritaLainnya as $item)
                            <div class="d-flex mb-3 pb-3 border-bottom">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="me-3 rounded" alt="{{ $item->judul }}" style="width: 80px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="me-3 bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="{{ route('guest.berita.detail', $item->slug) }}" class="text-decoration-none text-dark">
                                            {{ Str::limit($item->judul, 50) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted small mb-0">Belum ada berita lainnya.</p>
                    @endif
                </div>
            </div>

            <!-- Newsletter Subscription -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Langganan Newsletter</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">Dapatkan update informasi terbaru tentang dunia pertanian langsung ke email Anda.</p>
                    <form id="newsletterForm">
                        @csrf
                        <div class="mb-3">
                            <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Masukkan email Anda" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Nama (opsional)">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-envelope me-1"></i>Berlangganan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Link Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('guest.laporan.index') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-chart-line me-1"></i>Laporan Panen
                        </a>
                        <a href="{{ route('guest.bantuan') }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-hand-holding-heart me-1"></i>Bantuan
                        </a>
                        <a href="{{ route('guest.galeri') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-images me-1"></i>Galeri
                        </a>
                        <a href="{{ route('kontak') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope me-1"></i>Kontak Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('newsletterForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/newsletter/subscribe', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            this.reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat berlangganan. Silakan coba lagi.');
    });
});
</script>
@endsection
