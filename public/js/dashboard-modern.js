/**
 * ============================================
 * MODERN DASHBOARD JAVASCRIPT
 * Professional Dashboard Enhancements
 * ============================================
 */

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeTime();
    initializeAnimations();
    initializeTooltips();
    initializeConfirmations();
});

/**
 * Real-time Clock Update
 */
function initializeTime() {
    function updateTime() {
        const now = new Date();
        const timeElement = document.getElementById('currentTime');
        
        if (timeElement) {
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            timeElement.textContent = `${hours}:${minutes}:${seconds} WIB`;
        }
    }
    
    // Update immediately and then every second
    updateTime();
    setInterval(updateTime, 1000);
}

/**
 * Scroll Animations
 */
function initializeAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe stat cards
    document.querySelectorAll('.stat-card-modern, .modern-card').forEach(card => {
        observer.observe(card);
    });
}

/**
 * Bootstrap Tooltips
 */
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], [title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

/**
 * Confirmation Dialogs
 */
function initializeConfirmations() {
    // Add confirmation to delete buttons
    document.querySelectorAll('[data-confirm]').forEach(button => {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm');
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    });
}

/**
 * Mark Notification as Read
 */
function markAsReadFromDashboard(notificationId) {
    fetch(`/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Fade out the notification
            const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.style.opacity = '0.5';
                notificationElement.querySelector('.btn-modern-success').remove();
            }
            
            // Update notification badge if exists
            const badge = document.querySelector('.badge-modern-danger');
            if (badge) {
                const count = parseInt(badge.textContent);
                if (count > 1) {
                    badge.textContent = count - 1;
                } else {
                    badge.remove();
                }
            }
            
            showToast('Notifikasi ditandai sebagai telah dibaca', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Gagal menandai notifikasi', 'error');
    });
}

/**
 * Delete Bantuan
 */
function deleteBantuan(id, nama) {
    if (confirm(`Apakah Anda yakin ingin menghapus bantuan "${nama}"?`)) {
        fetch(`/admin/bantuan/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Bantuan berhasil dihapus', 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showToast('Gagal menghapus bantuan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan', 'error');
        });
    }
}

/**
 * Show Bantuan Detail Modal
 */
function showBantuanDetail(id) {
    fetch(`/admin/bantuan/${id}/detail`)
        .then(response => response.json())
        .then(data => {
            // Create and show modal with bantuan details
            showDetailModal(data);
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Gagal memuat detail', 'error');
        });
}

/**
 * Show Toast Notification
 */
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add styles if not already present
    if (!document.getElementById('toast-styles')) {
        const style = document.createElement('style');
        style.id = 'toast-styles';
        style.textContent = `
            .toast-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                z-index: 9999;
                animation: slideInRight 0.3s ease-out;
                color: white;
                font-weight: 600;
            }
            .toast-success { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); }
            .toast-error { background: linear-gradient(135deg, #fc8181 0%, #f56565 100%); }
            .toast-info { background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); }
            .toast-content {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/**
 * Chart Helper Functions
 */
function createGradient(ctx, color1, color2) {
    const gradient = ctx.createLinearGradient(0, 230, 0, 50);
    gradient.addColorStop(1, color1);
    gradient.addColorStop(0.2, color2);
    gradient.addColorStop(0, 'rgba(255,255,255,0)');
    return gradient;
}

/**
 * Format Number with Thousands Separator
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

/**
 * Counter Animation
 */
function animateCounter(element, target, duration = 2000) {
    let current = 0;
    const increment = target / (duration / 16);
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = formatNumber(Math.floor(target));
            clearInterval(timer);
        } else {
            element.textContent = formatNumber(Math.floor(current));
        }
    }, 16);
}

/**
 * Initialize Counter Animations on Scroll
 */
function initCounterAnimations() {
    const counters = document.querySelectorAll('.stat-value');
    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                entry.target.classList.add('counted');
                const target = parseInt(entry.target.textContent.replace(/\D/g, ''));
                animateCounter(entry.target, target);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    counters.forEach(counter => observer.observe(counter));
}

// Initialize counter animations
setTimeout(initCounterAnimations, 500);

/**
 * Export Functions for Global Use
 */
window.dashboardFunctions = {
    markAsReadFromDashboard,
    deleteBantuan,
    showBantuanDetail,
    showToast,
    formatNumber,
    animateCounter
};
