/**
 * Service Worker for PWA
 * 
 * Features:
 * - Offline support with caching strategies
 * - Background sync
 * - Push notifications
 * - Asset caching
 * - Dynamic content caching
 */

const CACHE_NAME = 'sistem-pertanian-v1';
const STATIC_CACHE = 'static-v1';
const DYNAMIC_CACHE = 'dynamic-v1';
const IMAGE_CACHE = 'images-v1';

// Assets to cache immediately
const STATIC_ASSETS = [
    '/',
    '/css/app.css',
    '/js/app.js',
    '/js/notification-center.js',
    '/js/dashboard-charts.js',
    '/css/notification-center.css',
    '/images/logo.png',
    '/manifest.json',
    '/offline.html',
];

// Install event - cache static assets
self.addEventListener('install', event => {
    console.log('[Service Worker] Installing...');
    
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => {
                console.log('[Service Worker] Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', event => {
    console.log('[Service Worker] Activating...');
    
    event.waitUntil(
        caches.keys()
            .then(cacheNames => {
                return Promise.all(
                    cacheNames
                        .filter(name => name !== STATIC_CACHE && name !== DYNAMIC_CACHE && name !== IMAGE_CACHE)
                        .map(name => {
                            console.log('[Service Worker] Deleting old cache:', name);
                            return caches.delete(name);
                        })
                );
            })
            .then(() => self.clients.claim())
    );
});

// Fetch event - serve from cache with network fallback
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip cross-origin requests
    if (url.origin !== location.origin) {
        return;
    }

    // Skip API requests
    if (url.pathname.startsWith('/api/')) {
        event.respondWith(networkFirst(request));
        return;
    }

    // Handle images
    if (request.destination === 'image') {
        event.respondWith(cacheFirst(request, IMAGE_CACHE));
        return;
    }

    // Handle static assets
    if (isStaticAsset(url.pathname)) {
        event.respondWith(cacheFirst(request, STATIC_CACHE));
        return;
    }

    // Handle pages
    event.respondWith(networkFirst(request, DYNAMIC_CACHE));
});

/**
 * Cache-first strategy
 * Try cache first, fall back to network
 */
async function cacheFirst(request, cacheName = STATIC_CACHE) {
    try {
        const cache = await caches.open(cacheName);
        const cached = await cache.match(request);
        
        if (cached) {
            console.log('[Service Worker] Serving from cache:', request.url);
            return cached;
        }

        const response = await fetch(request);
        
        if (response.ok) {
            cache.put(request, response.clone());
        }
        
        return response;
    } catch (error) {
        console.error('[Service Worker] Cache-first failed:', error);
        
        // Return offline page for navigation requests
        if (request.mode === 'navigate') {
            const cache = await caches.open(STATIC_CACHE);
            return cache.match('/offline.html');
        }
        
        throw error;
    }
}

/**
 * Network-first strategy
 * Try network first, fall back to cache
 */
async function networkFirst(request, cacheName = DYNAMIC_CACHE) {
    try {
        const response = await fetch(request);
        
        if (response.ok) {
            const cache = await caches.open(cacheName);
            cache.put(request, response.clone());
        }
        
        return response;
    } catch (error) {
        console.log('[Service Worker] Network failed, trying cache:', request.url);
        
        const cache = await caches.open(cacheName);
        const cached = await cache.match(request);
        
        if (cached) {
            return cached;
        }

        // Return offline page for navigation requests
        if (request.mode === 'navigate') {
            const staticCache = await caches.open(STATIC_CACHE);
            return staticCache.match('/offline.html');
        }
        
        throw error;
    }
}

/**
 * Check if URL is a static asset
 */
function isStaticAsset(pathname) {
    const staticExtensions = ['.css', '.js', '.woff', '.woff2', '.ttf', '.eot', '.svg'];
    return staticExtensions.some(ext => pathname.endsWith(ext));
}

/**
 * Background Sync - sync data when connection restored
 */
self.addEventListener('sync', event => {
    console.log('[Service Worker] Background sync:', event.tag);
    
    if (event.tag === 'sync-notifications') {
        event.waitUntil(syncNotifications());
    }
    
    if (event.tag === 'sync-forms') {
        event.waitUntil(syncForms());
    }
});

/**
 * Sync notifications
 */
async function syncNotifications() {
    try {
        // Get pending notifications from IndexedDB
        const pendingNotifications = await getPendingNotifications();
        
        // Send each notification
        for (const notification of pendingNotifications) {
            await fetch('/api/notifications', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(notification),
            });
        }
        
        // Clear pending notifications
        await clearPendingNotifications();
        
        console.log('[Service Worker] Notifications synced');
    } catch (error) {
        console.error('[Service Worker] Failed to sync notifications:', error);
    }
}

/**
 * Sync forms
 */
async function syncForms() {
    try {
        // Get pending forms from IndexedDB
        const pendingForms = await getPendingForms();
        
        // Submit each form
        for (const form of pendingForms) {
            await fetch(form.action, {
                method: form.method,
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(form.data),
            });
        }
        
        // Clear pending forms
        await clearPendingForms();
        
        console.log('[Service Worker] Forms synced');
    } catch (error) {
        console.error('[Service Worker] Failed to sync forms:', error);
    }
}

/**
 * Push notification event
 */
self.addEventListener('push', event => {
    console.log('[Service Worker] Push received');
    
    const data = event.data ? event.data.json() : {};
    const title = data.title || 'Sistem Pertanian';
    const options = {
        body: data.message || 'Anda memiliki notifikasi baru',
        icon: '/images/logo.png',
        badge: '/images/badge.png',
        vibrate: [200, 100, 200],
        tag: data.tag || 'notification',
        data: data.data || {},
        actions: data.actions || [
            { action: 'open', title: 'Buka' },
            { action: 'close', title: 'Tutup' },
        ],
    };
    
    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

/**
 * Notification click event
 */
self.addEventListener('notificationclick', event => {
    console.log('[Service Worker] Notification clicked');
    
    event.notification.close();
    
    if (event.action === 'open' || !event.action) {
        const url = event.notification.data?.url || '/';
        
        event.waitUntil(
            clients.matchAll({ type: 'window', includeUncontrolled: true })
                .then(clientList => {
                    // Check if window is already open
                    for (const client of clientList) {
                        if (client.url === url && 'focus' in client) {
                            return client.focus();
                        }
                    }
                    
                    // Open new window
                    if (clients.openWindow) {
                        return clients.openWindow(url);
                    }
                })
        );
    }
});

/**
 * Message event - communicate with main thread
 */
self.addEventListener('message', event => {
    console.log('[Service Worker] Message received:', event.data);
    
    if (event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
    
    if (event.data.type === 'CLEAR_CACHE') {
        event.waitUntil(
            caches.keys().then(cacheNames => {
                return Promise.all(
                    cacheNames.map(name => caches.delete(name))
                );
            })
        );
    }
    
    if (event.data.type === 'CACHE_URLS') {
        event.waitUntil(
            caches.open(DYNAMIC_CACHE).then(cache => {
                return cache.addAll(event.data.urls);
            })
        );
    }
});

// Helper functions for IndexedDB (simplified)
async function getPendingNotifications() {
    // Implement IndexedDB read
    return [];
}

async function clearPendingNotifications() {
    // Implement IndexedDB clear
}

async function getPendingForms() {
    // Implement IndexedDB read
    return [];
}

async function clearPendingForms() {
    // Implement IndexedDB clear
}
