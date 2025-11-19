<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints untuk autentikasi"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     tags={"Authentication"},
     *     summary="Register akun petani baru",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="petani@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
     *             @OA\Property(property="alamat_desa", type="string", example="Desa Sejahtera"),
     *             @OA\Property(property="alamat_kecamatan", type="string", example="Kecamatan Balige"),
     *             @OA\Property(property="telepon", type="string", example="081234567890"),
     *             @OA\Property(property="luas_lahan", type="number", format="float", example=2.5)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Registrasi berhasil",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Registrasi berhasil! Silakan tunggu verifikasi dari petugas."),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat_desa' => 'nullable|string|max:255',
            'alamat_kecamatan' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'luas_lahan' => 'nullable|numeric|min:0',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'petani',
            'alamat_desa' => $validated['alamat_desa'] ?? null,
            'alamat_kecamatan' => $validated['alamat_kecamatan'] ?? null,
            'telepon' => $validated['telepon'] ?? null,
            'luas_lahan' => $validated['luas_lahan'] ?? null,
            'is_verified' => false,
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil! Silakan tunggu verifikasi dari petugas.',
            'user' => $user->only(['id', 'name', 'email', 'role', 'is_verified']),
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     tags={"Authentication"},
     *     summary="Login dan dapatkan API token",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"email","password"},
     *
     *             @OA\Property(property="email", type="string", format="email", example="petani@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="device_name", type="string", example="Mobile App")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Login berhasil",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Login berhasil"),
     *             @OA\Property(property="token", type="string", example="1|abcdef123456..."),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *
     *     @OA\Response(response=422, description="Invalid credentials"),
     *     @OA\Response(response=403, description="Account not verified")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Check if petani is verified
        if ($user->role === 'petani' && ! $user->is_verified) {
            return response()->json([
                'message' => 'Akun Anda belum diverifikasi. Silakan tunggu verifikasi dari petugas.',
            ], 403);
        }

        $deviceName = $request->device_name ?? $request->userAgent();
        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user->only(['id', 'name', 'email', 'role', 'is_verified']),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     tags={"Authentication"},
     *     summary="Logout dan hapus current token",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Logout berhasil",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Logout berhasil")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout-all",
     *     tags={"Authentication"},
     *     summary="Logout dari semua device",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Logout dari semua device berhasil",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Logout dari semua device berhasil")
     *         )
     *     )
     * )
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout dari semua device berhasil',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/me",
     *     tags={"Authentication"},
     *     summary="Get authenticated user info",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="User data",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="user", type="object")
     *         )
     *     )
     * )
     */
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}
