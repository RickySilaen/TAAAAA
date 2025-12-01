@extends('layouts.guest')

@section('title', 'Galeri - Sistem Pertanian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="mb-0">Galeri Kegiatan Pertanian</h4>
                </div>
                <div class="card-body">
                    @if($galeris->count() > 0)
                        <div class="row">
                            @foreach($galeris as $galeri)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        @if($galeri->gambar)
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $galeri->gambar) }}"
                                                     class="card-img-top"
                                                     alt="{{ $galeri->judul }}"
                                                     style="height: 200px; object-fit: cover; cursor: pointer;"
                                                     onclick="openModal('{{ asset('storage/' . $galeri->gambar) }}', '{{ $galeri->judul }}', '{{ $galeri->deskripsi }}')">
                                                <div class="position-absolute top-50 start-50 translate-middle d-none d-lg-block">
                                                    <span class="fs-3 text-white bg-dark bg-opacity-50 rounded-circle p-2">🔍</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <span style="font-size: 3rem;">🖼️</span>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h6 class="card-title mb-2">{{ $galeri->judul }}</h6>
                                            @if($galeri->deskripsi)
                                                <p class="card-text small text-muted mb-2">{{ Str::limit($galeri->deskripsi, 80) }}</p>
                                            @endif
                                            <small class="text-muted">
                                                📅 {{ \Carbon\Carbon::parse($galeri->created_at)->format('d M Y') }}
                                                @if($galeri->lokasi)
                                                    <br>📍 {{ $galeri->lokasi }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $galeris->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div style="font-size: 4rem;">🖼️</div>
                            <h5 class="text-muted">Belum ada gambar di galeri</h5>
                            <p class="text-muted">Galeri akan segera diisi dengan dokumentasi kegiatan pertanian.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk melihat gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Detail Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid mb-3" style="max-height: 70vh;">
                <h6 id="modalTitle"></h6>
                <p id="modalDescription" class="text-muted"></p>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(imageSrc, title, description) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = description;

    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
</script>
@endsection
