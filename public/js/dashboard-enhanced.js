// ============================================
// ENHANCED DASHBOARD JAVASCRIPT
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Dashboard Enhanced JS Loaded');

    // Real-time Clock
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds} WIB`;
        
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }

    // Update clock every second
    setInterval(updateClock, 1000);
    updateClock(); // Initial call

    // Ripple effect for quick action buttons
    document.querySelectorAll('.quick-action-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.classList.add('ripple-effect');
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Add CSS for ripple effect
    const style = document.createElement('style');
    style.textContent = `
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(102, 126, 234, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // Smooth scroll animation for stat cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    entry.target.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);
                
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all stat cards
    document.querySelectorAll('.stat-card-modern').forEach(card => {
        observer.observe(card);
    });

    // Animate number counting
    function animateValue(element, start, end, duration) {
        const range = end - start;
        const increment = end > start ? 1 : -1;
        const stepTime = Math.abs(Math.floor(duration / range));
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            element.textContent = current.toLocaleString('id-ID');
            if (current == end) {
                clearInterval(timer);
            }
        }, stepTime);
    }

    // Animate stat values on page load
    window.addEventListener('load', () => {
        const statValues = document.querySelectorAll('.stat-value');
        statValues.forEach(stat => {
            const text = stat.textContent.trim();
            const numberMatch = text.match(/[\d,]+/);
            
            if (numberMatch) {
                const finalValue = parseInt(numberMatch[0].replace(/,/g, ''));
                
                if (!isNaN(finalValue) && finalValue > 0 && finalValue < 10000) {
                    const originalHTML = stat.innerHTML;
                    stat.textContent = '0';
                    
                    setTimeout(() => {
                        animateValue(stat, 0, finalValue, 1500);
                        
                        setTimeout(() => {
                            stat.innerHTML = originalHTML;
                        }, 1600);
                    }, 300);
                }
            }
        });
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Add hover sound effect (optional)
    const hoverElements = document.querySelectorAll('.stat-card-modern, .quick-action-btn');
    hoverElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        });
    });

    // Refresh indicator
    let refreshing = false;
    function showRefreshIndicator() {
        if (!refreshing) {
            refreshing = true;
            const indicator = document.createElement('div');
            indicator.className = 'refresh-indicator';
            indicator.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i> Memperbarui data...';
            document.body.appendChild(indicator);
            
            setTimeout(() => {
                indicator.remove();
                refreshing = false;
            }, 2000);
        }
    }

    // Auto-refresh notifications every 60 seconds
    setInterval(() => {
        if (window.location.pathname.includes('/dashboard')) {
            console.log('🔄 Checking for updates...');
            showRefreshIndicator();
        }
    }, 60000);

    console.log('✅ Dashboard features initialized successfully!');
});
