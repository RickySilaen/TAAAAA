/* =========================================================
   PROFESSIONAL ADMIN LAYOUT - JAVASCRIPT
   Clean, efficient, and conflict-free
   ========================================================= */

(function() {
    'use strict';

    // Wait for DOM to be fully loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        initSidebarToggle();
        initSearchShortcut();
        initSmoothScroll();
        initDropdowns();
        initBackToTop();
        initTooltips();
    }

    /* === SIDEBAR TOGGLE === */
    function initSidebarToggle() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const navLinks = sidebar ? sidebar.querySelectorAll('.nav-link') : [];

        if (!sidebar || !sidebarToggle || !sidebarOverlay) return;

        // Toggle sidebar on button click
        sidebarToggle.addEventListener('click', function() {
            toggleSidebar();
        });

        // Close sidebar when overlay is clicked
        sidebarOverlay.addEventListener('click', function() {
            closeSidebar();
        });

        // Close sidebar when clicking nav link (mobile only)
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    closeSidebar();
                }
            });
        });

        // Handle resize
        window.addEventListener('resize', debounce(function() {
            if (window.innerWidth >= 992) {
                closeSidebar();
            }
        }, 250));

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        }

        function closeSidebar() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    /* === SEARCH KEYBOARD SHORTCUT === */
    function initSearchShortcut() {
        const searchInput = document.getElementById('globalSearch');
        if (!searchInput) return;

        document.addEventListener('keydown', function(e) {
            // Ctrl+K or Cmd+K
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }

            // Escape to blur
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.blur();
            }
        });
    }

    /* === SMOOTH SCROLL === */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#' || href === '#!') return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    /* === DROPDOWNS === */
    function initDropdowns() {
        // Bootstrap handles most dropdown functionality
        // This is for additional custom behavior
        const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
        
        dropdowns.forEach(function(dropdown) {
            dropdown.addEventListener('shown.bs.dropdown', function() {
                this.setAttribute('aria-expanded', 'true');
            });

            dropdown.addEventListener('hidden.bs.dropdown', function() {
                this.setAttribute('aria-expanded', 'false');
            });
        });
    }

    /* === BACK TO TOP BUTTON === */
    function initBackToTop() {
        // Create back to top button
        const backToTop = document.createElement('button');
        backToTop.className = 'back-to-top';
        backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
        backToTop.setAttribute('aria-label', 'Back to Top');
        backToTop.style.cssText = `
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4F46E5, #4338CA);
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
        `;

        document.body.appendChild(backToTop);

        // Show/hide based on scroll position
        window.addEventListener('scroll', debounce(function() {
            if (window.pageYOffset > 300) {
                backToTop.style.opacity = '1';
                backToTop.style.visibility = 'visible';
            } else {
                backToTop.style.opacity = '0';
                backToTop.style.visibility = 'hidden';
            }
        }, 100));

        // Smooth scroll to top
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Hover effect
        backToTop.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });

        backToTop.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }

    /* === TOOLTIPS === */
    function initTooltips() {
        // Initialize Bootstrap tooltips if present
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    /* === UTILITY FUNCTIONS === */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                func.apply(context, args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    /* === AUTO-HIDE ALERTS === */
    function initAutoHideAlerts() {
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    }

    // Initialize auto-hide alerts after a short delay
    setTimeout(initAutoHideAlerts, 500);

    /* === FADE IN ON SCROLL === */
    function initFadeInOnScroll() {
        const elements = document.querySelectorAll('.fade-in-scroll');
        
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            elements.forEach(function(element) {
                observer.observe(element);
            });
        } else {
            // Fallback for older browsers
            elements.forEach(function(element) {
                element.classList.add('fade-in');
            });
        }
    }

    initFadeInOnScroll();

    /* === LOADING INDICATOR === */
    function showLoadingIndicator() {
        const indicator = document.createElement('div');
        indicator.id = 'loading-indicator';
        indicator.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #4F46E5, #818CF8);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
            z-index: 9999;
        `;
        document.body.appendChild(indicator);

        setTimeout(function() {
            indicator.style.transform = 'scaleX(0.7)';
        }, 100);

        return indicator;
    }

    function hideLoadingIndicator(indicator) {
        indicator.style.transform = 'scaleX(1)';
        setTimeout(function() {
            indicator.remove();
        }, 300);
    }

    // Show loading indicator for page transitions
    window.addEventListener('beforeunload', function() {
        showLoadingIndicator();
    });

    /* === EXPORT PUBLIC API === */
    window.AdminLayout = {
        version: '1.0.0',
        showLoading: showLoadingIndicator,
        hideLoading: hideLoadingIndicator
    };

    console.log('✅ Professional Admin Layout initialized');
})();
