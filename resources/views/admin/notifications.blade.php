@extends('layouts.app')

@section('title', 'Notifikasi')

@push('styles')
<style>
    .page-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(27, 94, 32, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h60v60H0z" fill="none"/><path d="M30 0v60M0 30h60" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></svg>');
        opacity: 0.3;
    }

    .page-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        color: white;
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .btn-mark-all {
        background: white;
        color: #1b5e20;
        padding: 0.875rem 1.75rem;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-mark-all:hover {
        background: #f1f8e9;
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0,0,0,0.2);
    }

    .notifications-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .notification-list-item {
        padding: 1.75rem 2rem;
        border-bottom: 2px solid #f0f0f0;
        transition: all 0.3s ease;
        position: relative;
    }

    .notification-list-item:last-child {
        border-bottom: none;
    }

    .notification-list-item:hover {
        background: linear-gradient(90deg, #f9fdf9 0%, #ffffff 100%);
        transform: translateX(5px);
    }

    .notification-list-item.unread {
        background: #f1f8e9;
    }

    .notification-list-item.unread::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: linear-gradient(180deg, #1b5e20 0%, #4caf50 100%);
    }

    .notification-list-item.read {
        opacity: 0.7;
    }

    .notification-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-right: 1.5rem;
        flex-shrink: 0;
    }

    .notification-icon-wrapper.success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
    }

    .notification-icon-wrapper.warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
        color: #856404;
    }

    .notification-icon-wrapper.danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
    }

    .notification-icon-wrapper.info {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
        color: #0c5460;
    }

    .notification-list-content {
        flex: 1;
    }

    .notification-list-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 0.5rem;
    }

    .notification-list-title {
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.05rem;
        margin: 0;
    }

    .notification-list-time {
        color: #999;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .notification-list-message {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 0.75rem;
    }

    .notification-list-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }

    .notification-meta-item {
        color: #1b5e20;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .notification-list-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-read {
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        border: none;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-read.success {
        background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
        color: white;
    }

    .btn-read.success:hover {
        background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #e0e0e0;
        margin-bottom: 1.5rem;
    }

    .empty-state h6 {
        color: #666;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #999;
        margin: 0;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .notification-list-item {
            padding: 1.25rem 1rem;
        }

        .notification-icon-wrapper {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
            margin-right: 1rem;
        }

        .notification-list-header {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h1 class="page-title">
                    <i class="fas fa-bell"></i>
                    Semua Notifikasi
                </h1>
                @if($notifications->where('read_at', null)->count() > 0)
                <button class="btn-mark-all" onclick="markAllAsRead()">
                    <i class="fas fa-check-double"></i>
                    Tandai Semua Dibaca
                </button>
                @endif
            </div>
        </div>

        <!-- Notifications List -->
        <div class="notifications-card">
            @forelse($notifications as $notification)
            <div class="notification-list-item {{ $notification->read_at ? 'read' : 'unread' }}">
                <div class="d-flex align-items-start">
                    @php
                        $color = $notification->data['color'] ?? 'info';
                    @endphp
                    <div class="notification-icon-wrapper {{ $color }}">
                        <i class="fas {{ $notification->data['icon'] ?? 'fa-bell' }}"></i>
                    </div>
                    <div class="notification-list-content">
                        <div class="notification-list-header">
                            <h6 class="notification-list-title">{{ $notification->data['title'] ?? 'Notifikasi' }}</h6>
                            <span class="notification-list-time">
                                <i class="fas fa-clock"></i>
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="notification-list-message">{{ $notification->data['message'] ?? 'Tidak ada pesan' }}</p>
                        
                        @if(isset($notification->data['type']))
                        <div class="notification-list-meta">
                            @if($notification->data['type'] == 'bantuan_created')
                                <span class="notification-meta-item">
                                    <i class="fas fa-seedling"></i>
                                    <strong>Jenis:</strong> {{ $notification->data['jenis_bantuan'] ?? '-' }}
                                </span>
                                <span class="notification-meta-item">
                                    <i class="fas fa-hashtag"></i>
                                    <strong>Jumlah:</strong> {{ $notification->data['jumlah'] ?? '-' }}
                                </span>
                                <span class="notification-meta-item">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Status:</strong> {{ $notification->data['status'] ?? '-' }}
                                </span>
                            @elseif($notification->data['type'] == 'laporan_created')
                                <span class="notification-meta-item">
                                    <i class="fas fa-chart-line"></i>
                                    <strong>Hasil Panen:</strong> {{ $notification->data['hasil_panen'] ?? '-' }} kg
                                </span>
                                <span class="notification-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <strong>Tanggal:</strong> {{ isset($notification->data['tanggal']) ? \Carbon\Carbon::parse($notification->data['tanggal'])->format('d/m/Y') : '-' }}
                                </span>
                            @endif
                        </div>
                        @endif
                        
                        @if(!$notification->read_at)
                        <div class="notification-list-actions">
                            <button class="btn-read success" onclick="markAsRead('{{ $notification->id }}')">
                                <i class="fas fa-check"></i>
                                Tandai Dibaca
                            </button>
                        </div>
                        @else
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-check-double"></i>
                                Dibaca {{ $notification->read_at->diffForHumans() }}
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h6>Tidak ada notifikasi</h6>
                <p>Notifikasi Anda akan muncul di sini ketika ada aktivitas baru.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function markAsRead(notificationId) {
    const notificationItem = document.querySelector(`.notification-list-item:has(button[onclick*="${notificationId}"])`);
    
    fetch('/notifications/' + notificationId + '/read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (notificationItem) {
                notificationItem.style.opacity = '0';
                notificationItem.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    location.reload();
                }, 300);
            } else {
                location.reload();
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menandai notifikasi sebagai dibaca');
    });
}

function markAllAsRead() {
    if (!confirm('Apakah Anda yakin ingin menandai semua notifikasi sebagai dibaca?')) {
        return;
    }
    
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const unreadItems = document.querySelectorAll('.notification-list-item.unread');
            unreadItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(20px)';
                }, index * 50);
            });
            
            setTimeout(() => {
                location.reload();
            }, unreadItems.length * 50 + 300);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menandai semua notifikasi');
    });
}
</script>
@endpush
