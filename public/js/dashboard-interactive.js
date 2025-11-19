/**
 * Dashboard Interaktivitas - Sistem Pertanian Toba
 * Enhanced JavaScript untuk Dashboard Modern
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // INITIALIZE ALL FEATURES
    // ============================================
    initAnimations();
    initDateTimeWidget();
    initTooltips();
    initCounters();
    initTaskCheckboxes();
    
    // ============================================
    // FADE IN ANIMATIONS
    // ============================================
    function initAnimations() {
        const cards = document.querySelectorAll('.stat-card, .modern-card');
        
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }
    
    // ============================================
    // DATE & TIME WIDGET
    // ============================================
    function initDateTimeWidget() {
        const dateElement = document.querySelector('.current-date');
        const timeElement = document.querySelector('.current-time');
        
        if (dateElement || timeElement) {
            updateDateTime();
            setInterval(updateDateTime, 1000);
        }
        
        function updateDateTime() {
            const now = new Date();
            
            if (dateElement) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                dateElement.textContent = now.toLocaleDateString('id-ID', options);
            }
            
            if (timeElement) {
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                timeElement.textContent = `${hours}:${minutes}:${seconds}`;
            }
        }
    }
    
    // ============================================
    // BOOTSTRAP TOOLTIPS
    // ============================================
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            }
        });
    }
    
    // ============================================
    // ANIMATED COUNTERS
    // ============================================
    function initCounters() {
        const statValues = document.querySelectorAll('.stat-value');
        
        statValues.forEach(element => {
            const target = parseFloat(element.textContent.replace(/,/g, ''));
            
            if (!isNaN(target)) {
                animateCounter(element, 0, target, 2000);
            }
        });
    }
    
    function animateCounter(element, start, end, duration) {
        const startTime = performance.now();
        const originalText = element.textContent;
        
        // Check if it's a decimal number
        const isDecimal = originalText.includes('.');
        const decimalPlaces = isDecimal ? originalText.split('.')[1].length : 0;
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Easing function
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const current = start + (end - start) * easeOutQuart;
            
            if (isDecimal) {
                element.textContent = current.toFixed(decimalPlaces);
            } else {
                element.textContent = Math.floor(current).toLocaleString('id-ID');
            }
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = isDecimal ? 
                    end.toFixed(decimalPlaces) : 
                    end.toLocaleString('id-ID');
            }
        }
        
        requestAnimationFrame(updateCounter);
    }
    
    // ============================================
    // TASK CHECKBOXES
    // ============================================
    function initTaskCheckboxes() {
        const taskCheckboxes = document.querySelectorAll('.task-item .form-check-input');
        
        taskCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const taskItem = this.closest('.task-item');
                const taskTitle = taskItem.querySelector('.task-title');
                
                if (this.checked) {
                    taskTitle.style.textDecoration = 'line-through';
                    taskTitle.style.opacity = '0.5';
                    taskItem.style.background = 'var(--success-soft)';
                    
                    // Show success notification
                    showToast('Tugas selesai!', 'success');
                } else {
                    taskTitle.style.textDecoration = 'none';
                    taskTitle.style.opacity = '1';
                    taskItem.style.background = 'var(--light-bg)';
                }
            });
        });
    }
    
    // ============================================
    // NOTIFICATION TOAST
    // ============================================
    function showToast(message, type = 'info') {
        // Create toast container if not exists
        let toastContainer = document.querySelector('.toast-container');
        
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        // Show toast
        if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });
            bsToast.show();
            
            // Remove after hide
            toast.addEventListener('hidden.bs.toast', function() {
                toast.remove();
            });
        }
    }
    
    // ============================================
    // CHART COLORS - Agricultural Theme
    // ============================================
    window.chartColors = {
        green: '#27ae60',
        darkGreen: '#1e8449',
        blue: '#3498db',
        yellow: '#ffb300',
        purple: '#6B46C1',
        brown: '#8B5E3C',
        red: '#e74c3c',
        orange: '#e67e22'
    };
    
    window.chartGradients = {
        green: function(ctx) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(39, 174, 96, 0.3)');
            gradient.addColorStop(1, 'rgba(39, 174, 96, 0.05)');
            return gradient;
        },
        blue: function(ctx) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(52, 152, 219, 0.3)');
            gradient.addColorStop(1, 'rgba(52, 152, 219, 0.05)');
            return gradient;
        }
    };
    
    // ============================================
    // TABLE ENHANCEMENTS
    // ============================================
    const tables = document.querySelectorAll('.modern-table');
    
    tables.forEach(table => {
        // Add hover effect to rows
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.01)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
    
    // ============================================
    // SEARCH FUNCTIONALITY (if exists)
    // ============================================
    const searchInput = document.querySelector('.search-input');
    const searchableTable = document.querySelector('.searchable-table');
    
    if (searchInput && searchableTable) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = searchableTable.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
    
    // ============================================
    // REFRESH BUTTON (if exists)
    // ============================================
    const refreshButtons = document.querySelectorAll('.btn-refresh');
    
    refreshButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.add('fa-spin');
                
                setTimeout(() => {
                    icon.classList.remove('fa-spin');
                    showToast('Data berhasil diperbarui', 'success');
                }, 1500);
            }
        });
    });
    
    // ============================================
    // CHART DEFAULT OPTIONS
    // ============================================
    if (typeof Chart !== 'undefined') {
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#4A5568';
        Chart.defaults.plugins.legend.labels.usePointStyle = true;
        Chart.defaults.plugins.legend.labels.padding = 15;
    }
    
    // ============================================
    // SMOOTH SCROLL
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '#!') {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    // ============================================
    // NOTIFICATION MARK AS READ
    // ============================================
    const notificationItems = document.querySelectorAll('.notification-item.unread');
    
    notificationItems.forEach(item => {
        item.addEventListener('click', function() {
            this.classList.remove('unread');
            this.style.background = 'var(--light-bg)';
        });
    });
    
    // ============================================
    // AUTO DISMISS ALERTS
    // ============================================
    const alerts = document.querySelectorAll('.alert-dismissible');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }
        }, 5000);
    });
    
    // ============================================
    // PRINT FUNCTIONALITY
    // ============================================
    const printButtons = document.querySelectorAll('.btn-print');
    
    printButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            window.print();
        });
    });
    
    // ============================================
    // QUICK ACTION HOVER EFFECTS
    // ============================================
    const quickActions = document.querySelectorAll('.quick-action-btn, .quick-action-btn-large');
    
    quickActions.forEach(action => {
        action.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.quick-action-icon, .quick-action-icon-large');
            if (icon) {
                icon.style.transform = 'scale(1.1) rotate(5deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
        
        action.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.quick-action-icon, .quick-action-icon-large');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });
    
});

// ============================================
// UTILITY FUNCTIONS
// ============================================

/**
 * Format number to Indonesian locale
 */
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

/**
 * Format currency to IDR
 */
function formatCurrency(num) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(num);
}

/**
 * Format date to Indonesian
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

/**
 * Get relative time (e.g., "2 jam yang lalu")
 */
function getRelativeTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);
    
    if (diffMins < 1) return 'Baru saja';
    if (diffMins < 60) return `${diffMins} menit yang lalu`;
    if (diffHours < 24) return `${diffHours} jam yang lalu`;
    if (diffDays < 7) return `${diffDays} hari yang lalu`;
    
    return formatDate(dateString);
}

// Export functions for global use
window.dashboardUtils = {
    formatNumber,
    formatCurrency,
    formatDate,
    getRelativeTime
};
