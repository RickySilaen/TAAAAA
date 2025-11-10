@extends('layouts.app')

@section('title', 'Kelola Galeri')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Kelola Galeri</h6>
                        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Foto
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success mx-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row g-3 px-3">
                        @forelse($galeris as $galeri)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card h-100">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $galeri->gambar) }}"
                                             class="card-img-top" alt="{{ $galeri->judul }}"
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-img-overlay d-flex align-items-start justify-content-end p-2">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.galeri.show', $galeri->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.galeri.destroy', $galeri->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title mb-2">{{ Str::limit($galeri->judul, 30) }}</h6>
                                        @if($galeri->deskripsi)
                                            <p class="card-text small text-muted">{{ Str::limit($galeri->deskripsi, 50) }}</p>
                                        @endif
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($galeri->created_at)->format('d M Y') }}
                                            </small>
                                            <span class="badge badge-sm {{ $galeri->status === 'published' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                                {{ $galeri->status === 'published' ? 'Published' : 'Draft' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-images fa-4x text-secondary mb-3"></i>
                                        <h6 class="text-secondary">Belum ada foto di galeri</h6>
                                        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Tambah Foto Pertama
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($galeris->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $galeris->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card-img-overlay {
    background: rgba(0,0,0,0.5);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card:hover .card-img-overlay {
    opacity: 1;
}

.btn-group .btn {
    border-radius: 0.25rem !important;
    margin-left: 2px;
}
</style>
@endpush
@endsection
