import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { compression } from 'vite-plugin-compression';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    
    build: {
        // Code splitting for better caching
        rollupOptions: {
            output: {
                manualChunks: {
                    // Vendor chunk for third-party libraries
                    vendor: [
                        'axios',
                        'bootstrap',
                    ],
                },
            },
        },
        
        // Optimize chunk size
        chunkSizeWarningLimit: 500,
        
        // Enable minification
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true, // Remove console.log in production
                drop_debugger: true,
            },
        },
        
        // Source maps for debugging (disable in production)
        sourcemap: false,
        
        // Asset inlining threshold (10kb)
        assetsInlineLimit: 10240,
    },
    
    // Optimize dependencies
    optimizeDeps: {
        include: ['axios', 'bootstrap'],
    },
    
    // Server configuration
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});
