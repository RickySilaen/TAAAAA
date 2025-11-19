<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BantuanController;
use App\Http\Controllers\Api\V1\LaporanController;
use Illuminate\Support\Facades\Route;

/*
 * @OA\Info(
 *     title="Sistem Pertanian API",
 *     version="1.0.0",
 *     description="RESTful API untuk Sistem Informasi Pertanian",
 *     @OA\Contact(
 *         email="admin@sistempertanian.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local Development Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter token from login endpoint"
 * )
 */

// API Version 1
Route::prefix('v1')->group(function () {
    // Public routes (no authentication required)
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Protected routes (authentication required)
    Route::middleware('auth:sanctum')->group(function () {
        // Authentication endpoints
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/logout-all', [AuthController::class, 'logoutAll']);
            Route::get('/me', [AuthController::class, 'me']);
        });

        // Laporan endpoints with rate limiting
        Route::middleware('throttle:60,1')->group(function () {
            Route::apiResource('laporan', LaporanController::class);
            Route::post('/laporan/{id}/verify', [LaporanController::class, 'verify']);
            Route::post('/laporan/{id}/reject', [LaporanController::class, 'reject']);
        });

        // Bantuan endpoints with rate limiting
        Route::middleware('throttle:60,1')->group(function () {
            Route::apiResource('bantuan', BantuanController::class);
            Route::post('/bantuan/{id}/approve', [BantuanController::class, 'approve']);
            Route::post('/bantuan/{id}/reject', [BantuanController::class, 'reject']);
        });
    });
});

// Guest rate limiting for public endpoints (30 requests per minute)
Route::middleware('throttle:30,1')->group(function () {
    // Additional public endpoints can be added here
});
