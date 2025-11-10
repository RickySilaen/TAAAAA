@extends('layouts.app')

@section('title', 'Kelola Newsletter')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Kelola Newsletter</h6>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.newsletter.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Buat Newsletter
                            </a>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#sendModal">
                                <i class="fas fa-paper-plane"></i> Kirim Newsletter
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success mx-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Stats Cards -->
                    <div class="row mx-3 mb-4">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Subscriber</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $totalSubscribers }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="fas fa-users text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Newsletter Terkirim</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $totalSent }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                                <i class="fas fa-paper-plane text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Draft Newsletter</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $totalDrafts }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                                <i class="fas fa-edit text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Subscriber Aktif</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $activeSubscribers }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                                <i class="fas fa-user-check text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Judul</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Kirim</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($newsletters as $newsletter)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ Str::limit($newsletter->judul, 50) }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ Str::limit(strip_tags($newsletter->konten), 80) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ $newsletter->status === 'sent' ? 'bg-gradient-success' : ($newsletter->status === 'draft' ? 'bg-gradient-warning' : 'bg-gradient-info') }}">
                                                {{ $newsletter->status === 'sent' ? 'Terkirim' : ($newsletter->status === 'draft' ? 'Draft' : 'Scheduled') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $newsletter->tanggal_kirim ? \Carbon\Carbon::parse($newsletter->tanggal_kirim)->format('d M Y H:i') : '-' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.newsletter.show', $newsletter->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($newsletter->status === 'draft')
                                                    <a href="{{ route('admin.newsletter.edit', $newsletter->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('admin.newsletter.destroy', $newsletter->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus newsletter ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-envelope-open-text fa-3x text-secondary mb-3"></i>
                                                <h6 class="text-secondary">Belum ada newsletter</h6>
                                                <a href="{{ route('admin.newsletter.create') }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus"></i> Buat Newsletter Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($newsletters->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $newsletters->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Send Newsletter Modal -->
<div class="modal fade" id="sendModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim Newsletter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.newsletter.send') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="newsletter_id" class="form-control-label">Pilih Newsletter</label>
                        <select class="form-control" name="newsletter_id" id="newsletter_id" required>
                            <option value="">Pilih Newsletter</option>
                            @foreach($newsletters->where('status', 'draft') as $newsletter)
                                <option value="{{ $newsletter->id }}">{{ $newsletter->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Newsletter</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
