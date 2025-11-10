@extends('layouts.app')

@section('title', 'Detail Foto Galeri')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Detail Foto Galeri</h6>
                        <div>
                            <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="text-center mb-4">
                                <img src="{{ asset('storage/' . $galeri->gambar) }}"
                                     alt="{{ $galeri->judul }}" class="img-fluid rounded shadow"
                                     style="max-height: 500px;">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Informasi Foto</h6>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title mb-3">{{ $galeri->judul }}</h5>

                                    @if($galeri->deskripsi)
                                        <p class="card-text mb-3">{{ $galeri->deskripsi }}</p>
                                    @endif

                                    <div class="mb-2">
                                        <strong>Status:</strong>
                                        <span class="badge {{ $galeri->status === 'published' ? 'bg-success' : 'bg-secondary' }} ms-2">
                                            {{ $galeri->status === 'published' ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>

                                    @if($galeri->kategori)
                                        <div class="mb-2">
                                            <strong>Kategori:</strong>
                                            <span class="badge bg-info ms-2">{{ ucfirst($galeri->kategori) }}</span>
                                        </div>
                                    @endif

                                    <div class="mb-2">
                                        <strong>Urutan:</strong> {{ $galeri->urutan }}
                                    </div>

                                    <div class="mb-2">
                                        <strong>Dibuat:</strong>
                                        {{ \Carbon\Carbon::parse($galeri->created_at)->format('d M Y H:i') }}
                                    </div>

                                    <div class="mb-2">
                                        <strong>Terakhir Update:</strong>
                                        {{ \Carbon\Carbon::parse($galeri->updated_at)->format('d M Y H:i') }}
                                    </div>

                                    <div class="mt-3">
                                        <strong>Path File:</strong>
                                        <code class="small">{{ $galeri->gambar }}</code>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Aksi Cepat</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <form action="{{ route('admin.galeri.destroy', $galeri->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="fas fa-trash"></i> Hapus Foto
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
    </div>
</div>
@endsection
