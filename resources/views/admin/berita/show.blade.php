@extends('layouts.app')

@section('title', 'Detail Berita')

@push('styles')
<style>
    .berita-hero {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 40px rgba(25,118,210,0.3);
    }
    .berita-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: none;
    }
    .berita-image {
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .info-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .action-btn {
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="berita-hero">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0" style="font-weight: 800;">Detail Berita</h1>
            <div>
                <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="berita-card p-4 mb-4">
                <h2 class="mb-3" style="font-weight: 800;">{{ $berita->judul }}</h2>

                            @if($berita->ringkasan)
                                <p class="text-muted lead mb-4" style="font-size: 1.1rem; line-height: 1.8;">{{ $berita->ringkasan }}</p>
                            @endif

                            <div class="mb-4" style="line-height: 1.8;">
                                {!! $berita->konten !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="berita-card p-4 mb-4">
                                <h6 class="mb-3 fw-bold text-primary"><i class="fas fa-info-circle me-2"></i>Informasi Berita</h6>
                                
                                @if($berita->gambar)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" class="img-fluid berita-image w-100">
                                    </div>
                                @endif

                                <div class="info-item">
                                    <strong>Status:</strong>
                                    <span class="badge {{ $berita->status === 'published' ? 'bg-success' : 'bg-secondary' }} ms-2 px-3 py-2 rounded-pill">
                                        {{ $berita->status === 'published' ? 'Published' : 'Draft' }}
                                    </span>
                                </div>

                                <div class="info-item">
                                    <strong>Penulis:</strong><br>
                                    <span class="text-muted">{{ $berita->penulis }}</span>
                                </div>

                                <div class="info-item">
                                    <strong>Tanggal Publikasi:</strong><br>
                                    <span class="text-muted">{{ $berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y H:i') : '-' }}</span>
                                </div>

                                <div class="info-item">
                                    <strong>Dibuat:</strong><br>
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y H:i') }}</span>
                                </div>

                                <div class="info-item">
                                    <strong>Terakhir Update:</strong><br>
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($berita->updated_at)->format('d M Y H:i') }}</span>
                                </div>

                                <div class="info-item">
                                    <strong>Slug:</strong><br>
                                    <code class="small bg-light p-2 rounded d-block mt-1">{{ $berita->slug }}</code>
                                </div>
                            </div>

                            <div class="berita-card p-4">
                                <h6 class="mb-3 fw-bold text-success"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h6>
                                <form action="{{ route('admin.berita.toggle-status', $berita->id) }}" method="POST" class="mb-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="action-btn btn {{ $berita->status === 'published' ? 'btn-secondary' : 'btn-success' }} w-100">
                                        <i class="fas fa-{{ $berita->status === 'published' ? 'eye-slash' : 'eye' }} me-2"></i>
                                        {{ $berita->status === 'published' ? 'Unpublish' : 'Publish' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn btn btn-danger w-100">
                                        <i class="fas fa-trash me-2"></i>Hapus Berita
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
