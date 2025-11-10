@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">📢 Semua Notifikasi</h6>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" onclick="markAllAsRead()">
                                <i class="fas fa-check-double me-1"></i>Tandai Semua Dibaca
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    @forelse($notifications as $notification)
                    <div class="notification-item mb-3 p-3 border-radius-lg bg-gradient-{{ $notification->data['color'] ?? 'light' }} {{ $notification->read_at ? 'opacity-6' : '' }}">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm bg-gradient-{{ $notification->data['color'] ?? 'info' }} shadow text-center me-3">
                                <i class="fas {{ $notification->data['icon'] ?? 'fa-bell' }} text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="mb-1 text-dark text-sm font-weight-bold">{{ $notification->data['title'] }}</h6>
                                    <small class="text-xs text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="text-xs text-muted mb-2">{{ $notification->data['message'] }}</p>
                                @if($notification->data['type'] == 'bantuan_created')
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-xs text-primary">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Jenis: {{ $notification->data['jenis_bantuan'] }} |
                                        Jumlah: {{ $notification->data['jumlah'] }} |
                                        Status: {{ $notification->data['status'] }}
                                    </small>
                                    @if(!$notification->read_at)
                                    <button class="btn btn-xs btn-outline-success" onclick="markAsRead('{{ $notification->id }}')">
                                        <i class="fas fa-check me-1"></i>Tandai Dibaca
                                    </button>
                                    @endif
                                </div>
                                @elseif($notification->data['type'] == 'laporan_created')
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-xs text-primary">
                                        <i class="fas fa-chart-line me-1"></i>
                                        Hasil Panen: {{ $notification->data['hasil_panen'] }} kg |
                                        Tanggal: {{ \Carbon\Carbon::parse($notification->data['tanggal'])->format('d/m/Y') }}
                                    </small>
                                    @if(!$notification->read_at)
                                    <button class="btn btn-xs btn-outline-success" onclick="markAsRead('{{ $notification->id }}')">
                                        <i class="fas fa-check me-1"></i>Tandai Dibaca
                                    </button>
                                    @endif
                                </div>
                                @else
                                @if(!$notification->read_at)
                                <div class="text-end">
                                    <button class="btn btn-xs btn-outline-success" onclick="markAsRead('{{ $notification->id }}')">
                                        <i class="fas fa-check me-1"></i>Tandai Dibaca
                                    </button>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Tidak ada notifikasi</h6>
                        <p class="text-sm text-muted">Notifikasi Anda akan muncul di sini ketika ada aktivitas baru.</p>
                    </div>
                    @endforelse

                    @if($notifications->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $notifications->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function markAsRead(notificationId) {
    fetch('/notifications/' + notificationId + '/read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(response => {
        if (response.ok) {
            location.reload();
        }
    });
}

function markAllAsRead() {
    if (confirm('Apakah Anda yakin ingin menandai semua notifikasi sebagai dibaca?')) {
        fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}
</script>
@endsection
