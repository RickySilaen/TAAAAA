<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Laporan",
 *     description="API Endpoints untuk manajemen laporan panen"
 * )
 */
class LaporanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/laporan",
     *     tags={"Laporan"},
     *     summary="Get all laporan (filtered by user role)",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page",
     *
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by status",
     *
     *         @OA\Schema(type="string", enum={"pending","verified","rejected"})
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of laporan",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Laporan::with('user');

        // Filter based on role
        if ($user->role === 'petani') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'petugas') {
            // Petugas only sees laporan from their desa
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('alamat_desa', $user->alamat_desa);
            });
        }
        // Admin sees all

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->get('per_page', 15);
        $laporan = $query->latest()->paginate($perPage);

        return response()->json($laporan);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/laporan",
     *     tags={"Laporan"},
     *     summary="Create new laporan",
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"jenis_tanaman","hasil_panen","tanggal_panen"},
     *
     *             @OA\Property(property="jenis_tanaman", type="string", example="Padi"),
     *             @OA\Property(property="hasil_panen", type="number", format="float", example=1500.5),
     *             @OA\Property(property="tanggal_panen", type="string", format="date", example="2025-11-10"),
     *             @OA\Property(property="luas_panen", type="number", format="float", example=2.5),
     *             @OA\Property(property="catatan", type="string", example="Panen raya musim ini")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Laporan created successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Laporan berhasil dibuat"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=403, description="Unverified account")
     * )
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Only petani can create laporan
        if ($user->role !== 'petani') {
            return response()->json([
                'message' => 'Hanya petani yang dapat membuat laporan',
            ], 403);
        }

        // Check if verified
        if (! $user->is_verified) {
            return response()->json([
                'message' => 'Akun Anda belum terverifikasi',
            ], 403);
        }

        $validated = $request->validate([
            'jenis_tanaman' => 'required|string|max:255',
            'hasil_panen' => 'required|numeric|min:0',
            'tanggal_panen' => 'required|date',
            'luas_panen' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $laporan = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => $validated['jenis_tanaman'],
            'hasil_panen' => $validated['hasil_panen'],
            'tanggal_panen' => $validated['tanggal_panen'],
            'luas_panen' => $validated['luas_panen'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Laporan berhasil dibuat',
            'data' => $laporan->load('user'),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/laporan/{id}",
     *     tags={"Laporan"},
     *     summary="Get laporan detail",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Laporan detail",
     *
     *         @OA\JsonContent(@OA\Property(property="data", type="object"))
     *     ),
     *
     *     @OA\Response(response=404, description="Laporan not found")
     * )
     */
    public function show($id)
    {
        $user = Auth::user();
        $laporan = Laporan::with('user')->findOrFail($id);

        // Authorization check
        if ($user->role === 'petani' && $laporan->user_id !== $user->id) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        if ($user->role === 'petugas' && $laporan->user->alamat_desa !== $user->alamat_desa) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        return response()->json(['data' => $laporan]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/laporan/{id}",
     *     tags={"Laporan"},
     *     summary="Update laporan",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="jenis_tanaman", type="string", example="Jagung"),
     *             @OA\Property(property="hasil_panen", type="number", format="float", example=2000.5),
     *             @OA\Property(property="tanggal_panen", type="string", format="date", example="2025-11-12"),
     *             @OA\Property(property="luas_panen", type="number", format="float", example=3.0),
     *             @OA\Property(property="catatan", type="string", example="Updated notes")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Laporan updated successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Laporan berhasil diperbarui"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Laporan not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $laporan = Laporan::findOrFail($id);

        // Only owner can update
        if ($laporan->user_id !== $user->id) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        $validated = $request->validate([
            'jenis_tanaman' => 'sometimes|required|string|max:255',
            'hasil_panen' => 'sometimes|required|numeric|min:0',
            'tanggal_panen' => 'sometimes|required|date',
            'luas_panen' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $laporan->update($validated);

        return response()->json([
            'message' => 'Laporan berhasil diperbarui',
            'data' => $laporan->fresh()->load('user'),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/laporan/{id}",
     *     tags={"Laporan"},
     *     summary="Delete laporan",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Laporan deleted successfully",
     *
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Laporan berhasil dihapus"))
     *     ),
     *
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Laporan not found")
     * )
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $laporan = Laporan::findOrFail($id);

        // Only owner can delete
        if ($laporan->user_id !== $user->id) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        $laporan->delete();

        return response()->json([
            'message' => 'Laporan berhasil dihapus',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/laporan/{id}/verify",
     *     tags={"Laporan"},
     *     summary="Verify laporan (Petugas only)",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *
     *         @OA\JsonContent(@OA\Property(property="catatan", type="string", example="Approved"))
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Laporan verified",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Laporan berhasil diverifikasi"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function verify(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role !== 'petugas' && $user->role !== 'admin') {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        $laporan = Laporan::with('user')->findOrFail($id);

        // Petugas can only verify laporan from their desa
        if ($user->role === 'petugas' && $laporan->user->alamat_desa !== $user->alamat_desa) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        $laporan->update([
            'status' => 'verified',
            'catatan' => $request->catatan ?? null,
        ]);

        return response()->json([
            'message' => 'Laporan berhasil diverifikasi',
            'data' => $laporan->fresh(),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/laporan/{id}/reject",
     *     tags={"Laporan"},
     *     summary="Reject laporan (Petugas only)",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"alasan"},
     *
     *             @OA\Property(property="alasan", type="string", example="Data tidak valid")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Laporan rejected",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Laporan ditolak"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function reject(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role !== 'petugas' && $user->role !== 'admin') {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        $validated = $request->validate([
            'alasan' => 'required|string',
        ]);

        $laporan = Laporan::with('user')->findOrFail($id);

        // Petugas can only reject laporan from their desa
        if ($user->role === 'petugas' && $laporan->user->alamat_desa !== $user->alamat_desa) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        $laporan->update([
            'status' => 'rejected',
            'catatan' => $validated['alasan'],
        ]);

        return response()->json([
            'message' => 'Laporan ditolak',
            'data' => $laporan->fresh(),
        ]);
    }
}
