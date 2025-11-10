@extends('layouts.app')

@section('title', 'Detail Feedback')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Detail Feedback</h6>
                        <div>
                            @if(!$feedback->is_read)
                                <form action="{{ route('admin.feedback.mark-read', $feedback->id) }}" method="POST" class="d-inline me-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Tandai Dibaca
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.feedback.index') }}" class="btn btn-secondary btn-sm">
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
                                    <h5 class="mb-0">{{ $feedback->subjek }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        @if($feedback->is_read)
                                            <span class="badge bg-success ms-2">Sudah Dibaca</span>
                                        @else
                                            <span class="badge bg-warning ms-2">Belum Dibaca</span>
                                        @endif
                                    </div>

                                    <div class="feedback-content">
                                        {!! nl2br(e($feedback->pesan)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Informasi Pengirim</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Nama:</strong><br>
                                        {{ $feedback->nama }}
                                    </div>

                                    <div class="mb-3">
                                        <strong>Email:</strong><br>
                                        <a href="mailto:{{ $feedback->email }}">{{ $feedback->email }}</a>
                                    </div>

                                    @if($feedback->telepon)
                                        <div class="mb-3">
                                            <strong>Telepon:</strong><br>
                                            <a href="tel:{{ $feedback->telepon }}">{{ $feedback->telepon }}</a>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong>Tanggal Kirim:</strong><br>
                                        {{ \Carbon\Carbon::parse($feedback->created_at)->format('d M Y H:i') }}
                                    </div>

                                    @if($feedback->updated_at != $feedback->created_at)
                                        <div class="mb-3">
                                            <strong>Terakhir Update:</strong><br>
                                            {{ \Carbon\Carbon::parse($feedback->updated_at)->format('d M Y H:i') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Aksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="mailto:{{ $feedback->email }}?subject=Re: {{ $feedback->subjek }}" class="btn btn-primary">
                                            <i class="fas fa-reply"></i> Balas Email
                                        </a>

                                        @if($feedback->telepon)
                                            <a href="tel:{{ $feedback->telepon }}" class="btn btn-info">
                                                <i class="fas fa-phone"></i> Telepon
                                            </a>
                                        @endif

                                        <form action="{{ route('admin.feedback.destroy', $feedback->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus feedback ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="fas fa-trash"></i> Hapus Feedback
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
.feedback-content {
    line-height: 1.6;
    white-space: pre-wrap;
}
</style>
@endpush
@endsection
