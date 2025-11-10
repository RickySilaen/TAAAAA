/**
 * Modern Interactive Features for Dinas Pertanian Toba
 * Author: GitHub Copilot
 * Version: 1.0
 */

(function() {
    'use strict';

    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        
        // Initialize all features
        initScrollToTop();
        initSmoothScroll();
        initNavbarScroll();
        initLazyLoading();
        initTooltips();
        initPreloader();
        
    });

    /**
     * Scroll to Top Button
     */
    function initScrollToTop() {
        // Create scroll to top button if it doesn't exist
        let scrollBtn = document.querySelector('.scroll-to-top');
        
        if (!scrollBtn) {
            scrollBtn = document.createElement('div');
            scrollBtn.className = 'scroll-to-top';
            scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
            scrollBtn.setAttribute('aria-label', 'Scroll to top');
            document.body.appendChild(scrollBtn);
        }

        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollBtn.classList.add('visible');
            } else {
                scrollBtn.classList.remove('visible');
            }
        });

        // Scroll to top on click
        scrollBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Skip if href is just "#"
                if (href === '#') return;
                
                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /**
     * Navbar Scroll Effect
     */
    function initNavbarScroll() {
        const navbar = document.querySelector('.main-header');
        
        if (!navbar) return;

        let lastScroll = 0;
        
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            
            // Add shadow when scrolled
            if (currentScroll > 50) {
                navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
            } else {
                navbar.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
            }
            
            // Hide navbar on scroll down, show on scroll up
            if (currentScroll > lastScroll && currentScroll > 500) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScroll = currentScroll;
        });
    }

    /**
     * Lazy Loading Images
     */
    function initLazyLoading() {
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        
                        // Add fade-in effect
                        img.style.opacity = '0';
                        img.style.transition = 'opacity 0.5s ease';
                        
                        img.addEventListener('load', function() {
                            this.style.opacity = '1';
                        });
                        
                        // If already loaded
                        if (img.complete) {
                            img.style.opacity = '1';
                        }
                        
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px'
            });

            images.forEach(img => imageObserver.observe(img));
        }
    }

    /**
     * Initialize Tooltips (Bootstrap 5)
     */
    function initTooltips() {
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );
            
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    /**
     * Preloader
     */
    function initPreloader() {
        const preloader = document.querySelector('.preloader');
        
        if (preloader) {
            window.addEventListener('load', function() {
                setTimeout(function() {
                    preloader.style.opacity = '0';
                    setTimeout(function() {
                        preloader.style.display = 'none';
                    }, 300);
                }, 500);
            });
        }
    }

    /**
     * Form Validation Helper
     */
    window.validateForm = function(formId) {
        const form = document.getElementById(formId);
        if (!form) return false;
        
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');
                
                // Remove invalid class on input
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                }, { once: true });
            }
        });
        
        return isValid;
    };

    /**
     * Show Toast Notification
     */
    window.showToast = function(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${getIconForType(type)} me-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        // Add styles
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            z-index: 9999;
            animation: slideInRight 0.3s ease;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    };

    function getIconForType(type) {
        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    /**
     * Copy to Clipboard
     */
    window.copyToClipboard = function(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Teks berhasil disalin!', 'success');
            }).catch(() => {
                showToast('Gagal menyalin teks', 'error');
            });
        } else {
            // Fallback for older browsers
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            
            try {
                document.execCommand('copy');
                showToast('Teks berhasil disalin!', 'success');
            } catch (err) {
                showToast('Gagal menyalin teks', 'error');
            }
            
            document.body.removeChild(textarea);
        }
    };

    /**
     * Format Number with Separator
     */
    window.formatNumber = function(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    };

    /**
     * Debounce Function
     */
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

    /**
     * Throttle Function
     */
    window.throttle = function(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    };

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
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

        .main-header {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .toast-success {
            border-left: 4px solid #28a745;
        }

        .toast-error {
            border-left: 4px solid #dc3545;
        }

        .toast-warning {
            border-left: 4px solid #ffc107;
        }

        .toast-info {
            border-left: 4px solid #17a2b8;
        }
    `;
    document.head.appendChild(style);

})();
