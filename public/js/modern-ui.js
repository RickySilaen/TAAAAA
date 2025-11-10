/* =========================================
   MODERN UI - SMOOTH INTERACTIONS
   ========================================= */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        
        // === SIDEBAR TOGGLE FOR MOBILE === //
        initSidebarToggle();
        
        // === SMOOTH SCROLL === //
        initSmoothScroll();
        
        // === LAZY LOAD IMAGES === //
        initLazyLoad();
        
        // === RIPPLE EFFECT === //
        initRippleEffect();
        
        // === TOOLTIP INITIALIZATION === //
        initTooltips();
        
        // === AUTO HIDE ALERTS === //
        initAutoHideAlerts();
        
        // === FADE IN ANIMATIONS === //
        initFadeInAnimations();
    });

    // Sidebar Toggle
    function initSidebarToggle() {
        // Create mobile toggle button if not exists
        if (!document.querySelector('.sidebar-toggle-mobile')) {
            const toggleBtn = document.createElement('button');
            toggleBtn.className = 'sidebar-toggle-mobile';
            toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
            toggleBtn.setAttribute('aria-label', 'Toggle Sidebar');
            document.body.appendChild(toggleBtn);
        }

        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.querySelector('.sidebar-toggle-mobile');
        
        if (sidebar && toggleBtn) {
            // Create overlay
            let overlay = document.querySelector('.sidebar-overlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'sidebar-overlay';
                document.body.appendChild(overlay);
            }

            // Toggle sidebar on button click
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                toggleBtn.querySelector('i').classList.toggle('fa-bars');
                toggleBtn.querySelector('i').classList.toggle('fa-times');
            });

            // Close sidebar on overlay click
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                toggleBtn.querySelector('i').classList.add('fa-bars');
                toggleBtn.querySelector('i').classList.remove('fa-times');
            });

            // Close sidebar on link click (mobile)
            const sidebarLinks = sidebar.querySelectorAll('.nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        setTimeout(() => {
                            sidebar.classList.remove('show');
                            overlay.classList.remove('show');
                            toggleBtn.querySelector('i').classList.add('fa-bars');
                            toggleBtn.querySelector('i').classList.remove('fa-times');
                        }, 300);
                    }
                });
            });

            // Close sidebar on resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    toggleBtn.querySelector('i').classList.add('fa-bars');
                    toggleBtn.querySelector('i').classList.remove('fa-times');
                }
            });
        }
    }

    // Smooth Scroll
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
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
    }

    // Lazy Load Images
    function initLazyLoad() {
        const images = document.querySelectorAll('img[data-src]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    }

    // Ripple Effect on Buttons
    function initRippleEffect() {
        const buttons = document.querySelectorAll('.btn-modern, .btn-icon-modern');
        
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.className = 'ripple';
                
                // Add ripple styles
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.6)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s ease-out';
                ripple.style.pointerEvents = 'none';
                
                // Ensure button has position relative
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple animation
        if (!document.querySelector('#ripple-style')) {
            const style = document.createElement('style');
            style.id = 'ripple-style';
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    // Initialize Tooltips
    function initTooltips() {
        // Bootstrap tooltips
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    // Auto Hide Alerts
    function initAutoHideAlerts() {
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        
        alerts.forEach(alert => {
            // Fade in
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            alert.style.transition = 'all 0.3s ease-out';
            
            setTimeout(() => {
                alert.style.opacity = '1';
                alert.style.transform = 'translateY(0)';
            }, 100);

            // Auto hide after 5 seconds
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        });
    }

    // Fade In Animations
    function initFadeInAnimations() {
        const elements = document.querySelectorAll('.modern-card, .stat-card, .page-header-modern');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        elements.forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });
    }

    // === UTILITY FUNCTIONS === //

    // Debounce function
    window.debounce = function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

    // Throttle function
    window.throttle = function(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    };

    // Smooth number counter animation
    window.animateNumber = function(element, start, end, duration) {
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = Math.round(current);
        }, 16);
    };

    // === EXPORT GLOBAL FUNCTIONS === //
    window.ModernUI = {
        debounce: window.debounce,
        throttle: window.throttle,
        animateNumber: window.animateNumber,
        initTooltips: initTooltips
    };

})();

// === BACK TO TOP BUTTON === //
(function() {
    // Create back to top button
    const backToTop = document.createElement('button');
    backToTop.className = 'back-to-top';
    backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTop.setAttribute('aria-label', 'Back to Top');
    backToTop.style.cssText = `
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
    `;
    document.body.appendChild(backToTop);

    // Show/hide on scroll
    window.addEventListener('scroll', window.ModernUI.throttle(() => {
        if (window.pageYOffset > 300) {
            backToTop.style.opacity = '1';
            backToTop.style.visibility = 'visible';
        } else {
            backToTop.style.opacity = '0';
            backToTop.style.visibility = 'hidden';
        }
    }, 100));

    // Scroll to top on click
    backToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Hover effect
    backToTop.addEventListener('mouseenter', () => {
        backToTop.style.transform = 'scale(1.1) translateY(-5px)';
        backToTop.style.boxShadow = '0 6px 16px rgba(79, 70, 229, 0.4)';
    });

    backToTop.addEventListener('mouseleave', () => {
        backToTop.style.transform = 'scale(1) translateY(0)';
        backToTop.style.boxShadow = '0 4px 12px rgba(79, 70, 229, 0.3)';
    });
})();

// === LOADING INDICATOR === //
(function() {
    // Show loading on page navigation
    window.addEventListener('beforeunload', () => {
        document.body.style.opacity = '0.6';
        document.body.style.pointerEvents = 'none';
    });

    // Remove loading on page load
    window.addEventListener('load', () => {
        document.body.style.opacity = '1';
        document.body.style.pointerEvents = 'auto';
    });
})();
