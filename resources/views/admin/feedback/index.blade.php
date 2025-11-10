@extends('layouts.app')

@section('title', 'Kelola Feedback')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Kelola Feedback</h6>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success btn-sm" onclick="markAllAsRead()">
                                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
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

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengirim</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subjek</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedbacks as $feedback)
                                    <tr class="{{ $feedback->is_read ? '' : 'table-warning' }}">
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $feedback->nama }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $feedback->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ Str::limit($feedback->subjek, 40) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($feedback->is_read)
                                                <span class="badge badge-sm bg-gradient-success">Dibaca</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-warning">Belum Dibaca</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ \Carbon\Carbon::parse($feedback->created_at)->format('d M Y H:i') }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.feedback.show', $feedback->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(!$feedback->is_read)
                                                    <form action="{{ route('admin.feedback.mark-read', $feedback->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.feedback.destroy', $feedback->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus feedback ini?')">
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
                                        <td colspan="5" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-comments fa-3x text-secondary mb-3"></i>
                                                <h6 class="text-secondary">Belum ada feedback</h6>
                                                <p class="text-muted small">Feedback dari guest akan muncul di sini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($feedbacks->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $feedbacks->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function markAllAsRead() {
    if (confirm('Apakah Anda yakin ingin menandai semua feedback sebagai sudah dibaca?')) {
        // Create a form to submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.feedback.mark-all-read") }}';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection
