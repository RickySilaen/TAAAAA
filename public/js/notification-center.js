/**
 * Notification Center Component
 * 
 * Real-time in-app notification center with:
 * - Badge counter
 * - Dropdown panel
 * - Mark as read functionality
 * - Auto-refresh
 * - Sound notifications
 * - Browser notifications support
 */

class NotificationCenter {
    constructor(options = {}) {
        this.apiUrl = options.apiUrl || '/api/notifications';
        this.refreshInterval = options.refreshInterval || 30000; // 30 seconds
        this.soundEnabled = options.soundEnabled !== false;
        this.browserNotifications = options.browserNotifications !== false;
        
        this.unreadCount = 0;
        this.notifications = [];
        this.timer = null;
        
        this.init();
    }

    /**
     * Initialize notification center
     */
    init() {
        this.createUI();
        this.attachEventListeners();
        this.loadNotifications();
        this.startAutoRefresh();
        this.requestBrowserPermission();
    }

    /**
     * Create notification UI elements
     */
    createUI() {
        const container = document.getElementById('notification-container');
        if (!container) {
            console.error('Notification container not found');
            return;
        }

        container.innerHTML = `
            <div class="notification-center">
                <button class="notification-bell" id="notification-bell">
                    <i class="bi bi-bell-fill"></i>
                    <span class="badge" id="notification-badge">0</span>
                </button>
                
                <div class="notification-dropdown" id="notification-dropdown">
                    <div class="notification-header">
                        <h6>Notifikasi</h6>
                        <button class="btn-mark-all-read" id="mark-all-read">
                            Tandai Semua Dibaca
                        </button>
                    </div>
                    
                    <div class="notification-list" id="notification-list">
                        <div class="loading">Memuat notifikasi...</div>
                    </div>
                    
                    <div class="notification-footer">
                        <a href="/notifications">Lihat Semua Notifikasi</a>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Attach event listeners
     */
    attachEventListeners() {
        const bell = document.getElementById('notification-bell');
        const dropdown = document.getElementById('notification-dropdown');
        const markAllRead = document.getElementById('mark-all-read');

        // Toggle dropdown
        bell?.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.notification-center')) {
                dropdown.classList.remove('show');
            }
        });

        // Mark all as read
        markAllRead?.addEventListener('click', () => {
            this.markAllAsRead();
        });
    }

    /**
     * Load notifications from API
     */
    async loadNotifications() {
        try {
            const response = await fetch(`${this.apiUrl}/unread`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to load notifications');

            const data = await response.json();
            
            const oldCount = this.unreadCount;
            this.unreadCount = data.count || 0;
            this.notifications = data.data || [];

            this.updateBadge();
            this.renderNotifications();

            // Show browser notification for new items
            if (this.unreadCount > oldCount) {
                this.playNotificationSound();
                this.showNewNotifications(this.notifications.slice(0, this.unreadCount - oldCount));
            }

        } catch (error) {
            console.error('Error loading notifications:', error);
        }
    }

    /**
     * Update badge counter
     */
    updateBadge() {
        const badge = document.getElementById('notification-badge');
        if (badge) {
            badge.textContent = this.unreadCount;
            badge.style.display = this.unreadCount > 0 ? 'block' : 'none';
        }
    }

    /**
     * Render notifications in dropdown
     */
    renderNotifications() {
        const list = document.getElementById('notification-list');
        if (!list) return;

        if (this.notifications.length === 0) {
            list.innerHTML = '<div class="no-notifications">Tidak ada notifikasi baru</div>';
            return;
        }

        list.innerHTML = this.notifications.map(notification => {
            const data = notification.data || {};
            const icon = this.getIconForType(data.type);
            const timeAgo = this.formatTimeAgo(notification.created_at);

            return `
                <div class="notification-item ${notification.read_at ? 'read' : 'unread'}" 
                     data-id="${notification.id}">
                    <div class="notification-icon ${data.type || 'info'}">
                        ${icon}
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">${data.title || 'Notifikasi'}</div>
                        <div class="notification-message">${data.message || ''}</div>
                        <div class="notification-time">${timeAgo}</div>
                    </div>
                    <div class="notification-actions">
                        <button class="btn-mark-read" data-id="${notification.id}">
                            <i class="bi bi-check"></i>
                        </button>
                        <button class="btn-delete" data-id="${notification.id}">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
            `;
        }).join('');

        // Attach click handlers
        list.querySelectorAll('.btn-mark-read').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.markAsRead(btn.dataset.id);
            });
        });

        list.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.deleteNotification(btn.dataset.id);
            });
        });

        list.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', () => {
                const notification = this.notifications.find(n => n.id === item.dataset.id);
                if (notification?.data?.action_url) {
                    window.location.href = notification.data.action_url;
                }
            });
        });
    }

    /**
     * Mark notification as read
     */
    async markAsRead(notificationId) {
        try {
            const response = await fetch(`${this.apiUrl}/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to mark as read');

            const data = await response.json();
            if (data.success) {
                this.unreadCount = data.unread_count || 0;
                this.loadNotifications();
            }

        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }

    /**
     * Mark all notifications as read
     */
    async markAllAsRead() {
        try {
            const response = await fetch(`${this.apiUrl}/mark-all-read`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to mark all as read');

            const data = await response.json();
            if (data.success) {
                this.unreadCount = 0;
                this.loadNotifications();
            }

        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    }

    /**
     * Delete notification
     */
    async deleteNotification(notificationId) {
        try {
            const response = await fetch(`${this.apiUrl}/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to delete notification');

            const data = await response.json();
            if (data.success) {
                this.loadNotifications();
            }

        } catch (error) {
            console.error('Error deleting notification:', error);
        }
    }

    /**
     * Start auto-refresh timer
     */
    startAutoRefresh() {
        this.timer = setInterval(() => {
            this.loadNotifications();
        }, this.refreshInterval);
    }

    /**
     * Stop auto-refresh timer
     */
    stopAutoRefresh() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    }

    /**
     * Request browser notification permission
     */
    async requestBrowserPermission() {
        if (!this.browserNotifications) return;
        
        if ('Notification' in window && Notification.permission === 'default') {
            await Notification.requestPermission();
        }
    }

    /**
     * Show browser notification for new items
     */
    showNewNotifications(notifications) {
        if (!this.browserNotifications) return;
        if ('Notification' in window && Notification.permission === 'granted') {
            notifications.forEach(notification => {
                const data = notification.data || {};
                new Notification(data.title || 'Notifikasi Baru', {
                    body: data.message || '',
                    icon: '/images/logo.png',
                    badge: '/images/badge.png',
                    tag: notification.id
                });
            });
        }
    }

    /**
     * Play notification sound
     */
    playNotificationSound() {
        if (!this.soundEnabled) return;
        
        const audio = new Audio('/sounds/notification.mp3');
        audio.volume = 0.3;
        audio.play().catch(() => {
            // Ignore errors (e.g., autoplay policy)
        });
    }

    /**
     * Get icon for notification type
     */
    getIconForType(type) {
        const icons = {
            'success': '<i class="bi bi-check-circle-fill"></i>',
            'error': '<i class="bi bi-x-circle-fill"></i>',
            'warning': '<i class="bi bi-exclamation-triangle-fill"></i>',
            'alert': '<i class="bi bi-megaphone-fill"></i>',
            'info': '<i class="bi bi-info-circle-fill"></i>'
        };
        return icons[type] || icons.info;
    }

    /**
     * Format time ago
     */
    formatTimeAgo(timestamp) {
        const now = new Date();
        const date = new Date(timestamp);
        const seconds = Math.floor((now - date) / 1000);

        if (seconds < 60) return 'Baru saja';
        if (seconds < 3600) return Math.floor(seconds / 60) + ' menit yang lalu';
        if (seconds < 86400) return Math.floor(seconds / 3600) + ' jam yang lalu';
        if (seconds < 2592000) return Math.floor(seconds / 86400) + ' hari yang lalu';
        return date.toLocaleDateString('id-ID');
    }

    /**
     * Destroy notification center
     */
    destroy() {
        this.stopAutoRefresh();
    }
}

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.notificationCenter = new NotificationCenter();
    });
} else {
    window.notificationCenter = new NotificationCenter();
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = NotificationCenter;
}
