<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     title="Sistem Pertanian API",
 *     version="1.0.0",
 *     description="RESTful API untuk Sistem Informasi Pertanian - Dokumentasi lengkap untuk endpoint CRUD Laporan dan Bantuan dengan autentikasi Laravel Sanctum",
 *
 *     @OA\Contact(
 *         email="admin@sistempertanian.com",
 *         name="API Support"
 *     ),
 *
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local Development Server"
 * )
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="API Base URL"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="Sanctum",
 *     description="Enter token from login endpoint (Example: 1|abcdefghijklmnopqrstuvwxyz)"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints untuk autentikasi pengguna"
 * )
 * @OA\Tag(
 *     name="Laporan",
 *     description="API Endpoints untuk manajemen laporan panen"
 * )
 * @OA\Tag(
 *     name="Bantuan",
 *     description="API Endpoints untuk manajemen permintaan bantuan"
 * )
 */
class ApiController extends Controller {}
