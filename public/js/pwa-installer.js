/**
 * PWA Installer
 * 
 * Features:
 * - Service worker registration
 * - Install prompt
 * - Update detection
 * - Offline detection
 */

class PWAInstaller {
    constructor() {
        this.deferredPrompt = null;
        this.init();
    }

    /**
     * Initialize PWA
     */
    init() {
        if ('serviceWorker' in navigator) {
            this.registerServiceWorker();
        }

        this.setupInstallPrompt();
        this.setupUpdatePrompt();
        this.setupOfflineDetection();
    }

    /**
     * Register service worker
     */
    async registerServiceWorker() {
        try {
            const registration = await navigator.serviceWorker.register('/service-worker.js', {
                scope: '/',
            });

            console.log('[PWA] Service Worker registered:', registration.scope);

            // Check for updates
            registration.addEventListener('updatefound', () => {
                const newWorker = registration.installing;
                
                newWorker.addEventListener('statechange', () => {
                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        this.showUpdatePrompt();
                    }
                });
            });

        } catch (error) {
            console.error('[PWA] Service Worker registration failed:', error);
        }
    }

    /**
     * Setup install prompt
     */
    setupInstallPrompt() {
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            this.deferredPrompt = e;
            this.showInstallButton();
        });

        window.addEventListener('appinstalled', () => {
            console.log('[PWA] App installed');
            this.hideInstallButton();
            this.deferredPrompt = null;
        });
    }

    /**
     * Show install button
     */
    showInstallButton() {
        const installBtn = document.getElementById('pwa-install-btn');
        if (installBtn) {
            installBtn.style.display = 'block';
            installBtn.addEventListener('click', () => this.promptInstall());
        }
    }

    /**
     * Hide install button
     */
    hideInstallButton() {
        const installBtn = document.getElementById('pwa-install-btn');
        if (installBtn) {
            installBtn.style.display = 'none';
        }
    }

    /**
     * Prompt user to install
     */
    async promptInstall() {
        if (!this.deferredPrompt) return;

        this.deferredPrompt.prompt();
        
        const { outcome } = await this.deferredPrompt.userChoice;
        
        console.log('[PWA] Install prompt outcome:', outcome);
        
        this.deferredPrompt = null;
        this.hideInstallButton();
    }

    /**
     * Show update prompt
     */
    showUpdatePrompt() {
        if (confirm('Versi baru aplikasi tersedia! Muat ulang sekarang?')) {
            window.location.reload();
        }
    }

    /**
     * Setup update prompt
     */
    setupUpdatePrompt() {
        let refreshing = false;
        
        navigator.serviceWorker?.addEventListener('controllerchange', () => {
            if (refreshing) return;
            refreshing = true;
            window.location.reload();
        });
    }

    /**
     * Setup offline detection
     */
    setupOfflineDetection() {
        const updateOnlineStatus = () => {
            const status = navigator.onLine ? 'online' : 'offline';
            document.body.classList.toggle('is-offline', !navigator.onLine);
            
            if (navigator.onLine) {
                this.syncData();
            }
        };

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
        
        updateOnlineStatus();
    }

    /**
     * Sync data when online
     */
    async syncData() {
        if ('serviceWorker' in navigator && 'SyncManager' in window) {
            const registration = await navigator.serviceWorker.ready;
            await registration.sync.register('sync-data');
            console.log('[PWA] Background sync registered');
        }
    }
}

// Initialize PWA
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.pwaInstaller = new PWAInstaller();
    });
} else {
    window.pwaInstaller = new PWAInstaller();
}
