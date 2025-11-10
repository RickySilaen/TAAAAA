@extends('layouts.app')

@section('title', 'Detail Berita')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Detail Berita</h6>
                        <div>
                            <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mb-3">{{ $berita->judul }}</h3>

                            @if($berita->ringkasan)
                                <p class="text-muted lead mb-4">{{ $berita->ringkasan }}</p>
                            @endif

                            <div class="mb-4">
                                {!! $berita->konten !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Informasi Berita</h6>
                                </div>
                                <div class="card-body">
                                    @if($berita->gambar)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" class="img-fluid rounded">
                                        </div>
                                    @endif

                                    <div class="mb-2">
                                        <strong>Status:</strong>
                                        <span class="badge {{ $berita->status === 'published' ? 'bg-success' : 'bg-secondary' }} ms-2">
                                            {{ $berita->status === 'published' ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>

                                    <div class="mb-2">
                                        <strong>Penulis:</strong> {{ $berita->penulis }}
                                    </div>

                                    <div class="mb-2">
                                        <strong>Tanggal Publikasi:</strong>
                                        {{ $berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y H:i') : '-' }}
                                    </div>

                                    <div class="mb-2">
                                        <strong>Dibuat:</strong>
                                        {{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y H:i') }}
                                    </div>

                                    <div class="mb-2">
                                        <strong>Terakhir Update:</strong>
                                        {{ \Carbon\Carbon::parse($berita->updated_at)->format('d M Y H:i') }}
                                    </div>

                                    <div class="mt-3">
                                        <strong>Slug:</strong>
                                        <code class="small">{{ $berita->slug }}</code>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Aksi Cepat</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.berita.toggle-status', $berita->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $berita->status === 'published' ? 'btn-secondary' : 'btn-success' }} w-100 mb-2">
                                            <i class="fas fa-{{ $berita->status === 'published' ? 'eye-slash' : 'eye' }}"></i>
                                            {{ $berita->status === 'published' ? 'Unpublish' : 'Publish' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100">
                                            <i class="fas fa-trash"></i> Hapus Berita
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
@endsection
