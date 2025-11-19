<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Health Check Controller.
 *
 * Provides endpoints for monitoring system health.
 * Used by CI/CD pipeline and monitoring tools.
 */
class HealthCheckController extends Controller
{
    /**
     * Basic health check.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now()->toIso8601String(),
            'version' => config('app.version', '1.0.0'),
        ]);
    }

    /**
     * Detailed health check.
     */
    public function detailed(): JsonResponse
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'storage' => $this->checkStorage(),
        ];

        $allHealthy = collect($checks)->every(fn ($check) => $check['status'] === 'healthy');

        return response()->json([
            'status' => $allHealthy ? 'healthy' : 'degraded',
            'checks' => $checks,
            'timestamp' => now()->toIso8601String(),
            'version' => config('app.version', '1.0.0'),
        ], $allHealthy ? 200 : 503);
    }

    /**
     * Check database connection.
     */
    private function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            $status = 'healthy';
            $message = 'Database connection successful';
        } catch (\Exception $e) {
            $status = 'unhealthy';
            $message = 'Database connection failed: ' . $e->getMessage();
        }

        return [
            'status' => $status,
            'message' => $message,
        ];
    }

    /**
     * Check cache system.
     */
    private function checkCache(): array
    {
        try {
            cache()->put('health_check', true, 10);
            $result = cache()->get('health_check');

            if ($result === true) {
                $status = 'healthy';
                $message = 'Cache system working';
            } else {
                $status = 'unhealthy';
                $message = 'Cache read/write failed';
            }
        } catch (\Exception $e) {
            $status = 'unhealthy';
            $message = 'Cache system error: ' . $e->getMessage();
        }

        return [
            'status' => $status,
            'message' => $message,
        ];
    }

    /**
     * Check storage directory.
     */
    private function checkStorage(): array
    {
        $storagePath = storage_path('app');

        if (is_writable($storagePath)) {
            $status = 'healthy';
            $message = 'Storage directory writable';
        } else {
            $status = 'unhealthy';
            $message = 'Storage directory not writable';
        }

        return [
            'status' => $status,
            'message' => $message,
        ];
    }
}
