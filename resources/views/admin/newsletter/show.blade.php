@extends('layouts.app')

@section('title', 'Detail Newsletter')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Detail Newsletter</h6>
                        <div>
                            @if($newsletter->status === 'draft')
                                <a href="{{ route('admin.newsletter.edit', $newsletter->id) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.newsletter.send') }}" method="POST" class="d-inline me-2">
                                    @csrf
                                    <input type="hidden" name="newsletter_id" value="{{ $newsletter->id }}">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-paper-plane"></i> Kirim Sekarang
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.newsletter.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4 class="mb-0">{{ $newsletter->judul }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="newsletter-content">
                                        {!! $newsletter->konten !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Informasi Newsletter</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        <span class="badge {{ $newsletter->status === 'sent' ? 'bg-success' : ($newsletter->status === 'draft' ? 'bg-warning' : 'bg-info') }} ms-2">
                                            {{ $newsletter->status === 'sent' ? 'Terkirim' : ($newsletter->status === 'draft' ? 'Draft' : 'Scheduled') }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Target Audience:</strong><br>
                                        <span class="badge bg-primary">{{ ucfirst($newsletter->target_audience) }}</span>
                                    </div>

                                    @if($newsletter->tanggal_kirim)
                                        <div class="mb-3">
                                            <strong>Tanggal Kirim:</strong><br>
                                            {{ \Carbon\Carbon::parse($newsletter->tanggal_kirim)->format('d M Y H:i') }}
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong>Dibuat:</strong><br>
                                        {{ \Carbon\Carbon::parse($newsletter->created_at)->format('d M Y H:i') }}
                                    </div>

                                    <div class="mb-3">
                                        <strong>Terakhir Update:</strong><br>
                                        {{ \Carbon\Carbon::parse($newsletter->updated_at)->format('d M Y H:i') }}
                                    </div>

                                    @if($newsletter->status === 'sent')
                                        <div class="mb-3">
                                            <strong>Dikirim Oleh:</strong><br>
                                            {{ $newsletter->sent_by ?? 'System' }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if($newsletter->status === 'sent')
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Statistik Pengiriman</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="h5 mb-0">{{ $newsletter->recipients_count ?? 0 }}</div>
                                                <small class="text-muted">Penerima</small>
                                            </div>
                                            <div class="col-6">
                                                <div class="h5 mb-0 text-success">{{ $newsletter->delivered_count ?? 0 }}</div>
                                                <small class="text-muted">Terkirim</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Aksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        @if($newsletter->status === 'draft')
                                            <form action="{{ route('admin.newsletter.send') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="newsletter_id" value="{{ $newsletter->id }}">
                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="fas fa-paper-plane"></i> Kirim Newsletter
                                                </button>
                                            </form>
                                        @endif

                                        <button type="button" class="btn btn-info w-100" onclick="copyToClipboard()">
                                            <i class="fas fa-copy"></i> Copy Konten
                                        </button>

                                        <form action="{{ route('admin.newsletter.destroy', $newsletter->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus newsletter ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="fas fa-trash"></i> Hapus Newsletter
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

@push('styles')
<style>
.newsletter-content {
    line-height: 1.6;
}

.newsletter-content h1, .newsletter-content h2, .newsletter-content h3,
.newsletter-content h4, .newsletter-content h5, .newsletter-content h6 {
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
}

.newsletter-content p {
    margin-bottom: 1rem;
}

.newsletter-content ul, .newsletter-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}
</style>
@endpush

@push('scripts')
<script>
function copyToClipboard() {
    const content = document.querySelector('.newsletter-content').innerText;
    navigator.clipboard.writeText(content).then(function() {
        // Show success message
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
        btn.classList.remove('btn-info');
        btn.classList.add('btn-success');

        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-info');
        }, 2000);
    });
}
</script>
@endpush
@endsection
