<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * Cache-Control directives:
     * - public: Can be cached by any cache (browser, CDN)
     * - private: Can only be cached by browser
     * - no-cache: Must revalidate with server before use
     * - no-store: Must not be cached at all
     * - max-age: Maximum time resource is fresh (seconds)
     * - must-revalidate: Must check server when stale
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Don't cache authenticated pages
        if (auth()->check()) {
            return $this->addPrivateHeaders($response);
        }

        // Cache static assets aggressively
        if ($this->isStaticAsset($request)) {
            return $this->addStaticAssetHeaders($response);
        }

        // Cache public pages moderately
        if ($this->isPublicPage($request)) {
            return $this->addPublicPageHeaders($response);
        }

        // Don't cache dynamic/admin pages
        return $this->addPrivateHeaders($response);
    }

    /**
     * Check if request is for static asset.
     */
    protected function isStaticAsset(Request $request): bool
    {
        $path = $request->path();

        $staticExtensions = [
            'css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg',
            'woff', 'woff2', 'ttf', 'eot', 'ico', 'pdf',
        ];

        foreach ($staticExtensions as $ext) {
            if (str_ends_with($path, '.' . $ext)) {
                return true;
            }
        }

        return str_starts_with($path, 'build/') ||
               str_starts_with($path, 'assets/') ||
               str_starts_with($path, 'css/') ||
               str_starts_with($path, 'js/') ||
               str_starts_with($path, 'images/');
    }

    /**
     * Check if request is for public page.
     */
    protected function isPublicPage(Request $request): bool
    {
        $publicRoutes = [
            'berita',
            'galeri',
            'api/berita',
            'api/galeri',
        ];

        $path = $request->path();

        foreach ($publicRoutes as $route) {
            if (str_starts_with($path, $route)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add headers for static assets (1 year cache).
     */
    protected function addStaticAssetHeaders(Response $response): Response
    {
        return $response->withHeaders([
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'Expires' => gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT',
            'Pragma' => 'public',
        ]);
    }

    /**
     * Add headers for public pages (5 minutes cache).
     */
    protected function addPublicPageHeaders(Response $response): Response
    {
        return $response->withHeaders([
            'Cache-Control' => 'public, max-age=300, must-revalidate',
            'Expires' => gmdate('D, d M Y H:i:s', time() + 300) . ' GMT',
            'Vary' => 'Accept-Encoding',
        ]);
    }

    /**
     * Add headers for private/dynamic pages (no cache).
     */
    protected function addPrivateHeaders(Response $response): Response
    {
        return $response->withHeaders([
            'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
