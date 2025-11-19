<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Bantuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Bantuan",
 *     description="API Endpoints untuk manajemen permintaan bantuan"
 * )
 */
class BantuanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/bantuan",
     *     tags={"Bantuan"},
     *     summary="Get all bantuan (filtered by user role)",
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
     *         @OA\Schema(type="string", enum={"pending","disetujui","ditolak"})
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of bantuan",
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
        $query = Bantuan::with('user');

        // Filter based on role
        if ($user->role === 'petani') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'petugas') {
            // Petugas only sees bantuan from their desa
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
        $bantuan = $query->latest()->paginate($perPage);

        return response()->json($bantuan);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/bantuan",
     *     tags={"Bantuan"},
     *     summary="Create new bantuan request",
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"jenis_bantuan","jumlah","alasan"},
     *
     *             @OA\Property(property="jenis_bantuan", type="string", example="Pupuk Organik"),
     *             @OA\Property(property="jumlah", type="number", format="float", example=100),
     *             @OA\Property(property="alasan", type="string", example="Untuk meningkatkan produksi padi"),
     *             @OA\Property(property="tanggal_permintaan", type="string", format="date", example="2025-11-12"),
     *             @OA\Property(property="keterangan", type="string", example="Sangat mendesak")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Bantuan request created successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Permintaan bantuan berhasil dibuat"),
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

        // Only petani can create bantuan
        if ($user->role !== 'petani') {
            return response()->json([
                'message' => 'Hanya petani yang dapat membuat permintaan bantuan',
            ], 403);
        }

        // Check if verified
        if (! $user->is_verified) {
            return response()->json([
                'message' => 'Akun Anda belum terverifikasi',
            ], 403);
        }

        $validated = $request->validate([
            'jenis_bantuan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'alasan' => 'required|string',
            'tanggal_permintaan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $bantuan = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => $validated['jenis_bantuan'],
            'jumlah' => $validated['jumlah'],
            'alasan' => $validated['alasan'],
            'tanggal_permintaan' => $validated['tanggal_permintaan'] ?? now(),
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Permintaan bantuan berhasil dibuat',
            'data' => $bantuan->load('user'),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/bantuan/{id}",
     *     tags={"Bantuan"},
     *     summary="Get bantuan detail",
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
     *         description="Bantuan detail",
     *
     *         @OA\JsonContent(@OA\Property(property="data", type="object"))
     *     ),
     *
     *     @OA\Response(response=404, description="Bantuan not found")
     * )
     */
    public function show($id)
    {
        $user = Auth::user();
        $bantuan = Bantuan::with('user')->findOrFail($id);

        // Authorization check
        if ($user->role === 'petani' && $bantuan->user_id !== $user->id) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        if ($user->role === 'petugas' && $bantuan->user->alamat_desa !== $user->alamat_desa) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        return response()->json(['data' => $bantuan]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/bantuan/{id}",
     *     tags={"Bantuan"},
     *     summary="Update bantuan (only pending status)",
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
     *             @OA\Property(property="jenis_bantuan", type="string", example="Bibit Padi"),
     *             @OA\Property(property="jumlah", type="number", format="float", example=150),
     *             @OA\Property(property="alasan", type="string", example="Updated reason"),
     *             @OA\Property(property="keterangan", type="string", example="Updated notes")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Bantuan updated successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Bantuan berhasil diperbarui"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *
     *     @OA\Response(response=403, description="Unauthorized or already processed"),
     *     @OA\Response(response=404, description="Bantuan not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $bantuan = Bantuan::findOrFail($id);

        // Only owner can update
        if ($bantuan->user_id !== $user->id) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        // Can only update if status is pending
        if ($bantuan->status !== 'pending') {
            return response()->json([
                'message' => 'Bantuan yang sudah diproses tidak dapat diedit',
            ], 403);
        }

        $validated = $request->validate([
            'jenis_bantuan' => 'sometimes|required|string|max:255',
            'jumlah' => 'sometimes|required|numeric|min:0',
            'alasan' => 'sometimes|required|string',
            'tanggal_permintaan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $bantuan->update($validated);

        return response()->json([
            'message' => 'Bantuan berhasil diperbarui',
            'data' => $bantuan->fresh()->load('user'),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/bantuan/{id}",
     *     tags={"Bantuan"},
     *     summary="Delete bantuan (only pending status)",
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
     *         description="Bantuan deleted successfully",
     *
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Bantuan berhasil dihapus"))
     *     ),
     *
     *     @OA\Response(response=403, description="Unauthorized or already processed"),
     *     @OA\Response(response=404, description="Bantuan not found")
     * )
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $bantuan = Bantuan::findOrFail($id);

        // Only owner can delete
        if ($bantuan->user_id !== $user->id) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        // Can only delete if status is pending
        if ($bantuan->status !== 'pending') {
            return response()->json([
                'message' => 'Bantuan yang sudah diproses tidak dapat dihapus',
            ], 403);
        }

        $bantuan->delete();

        return response()->json([
            'message' => 'Bantuan berhasil dihapus',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/bantuan/{id}/approve",
     *     tags={"Bantuan"},
     *     summary="Approve bantuan (Petugas/Admin only)",
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
     *         @OA\JsonContent(@OA\Property(property="catatan", type="string", example="Disetujui"))
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Bantuan approved",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Bantuan disetujui"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function approve(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role !== 'petugas' && $user->role !== 'admin') {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        $bantuan = Bantuan::with('user')->findOrFail($id);

        // Petugas can only approve bantuan from their desa
        if ($user->role === 'petugas' && $bantuan->user->alamat_desa !== $user->alamat_desa) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        $bantuan->update([
            'status' => 'disetujui',
            'catatan' => $request->catatan ?? null,
        ]);

        return response()->json([
            'message' => 'Bantuan disetujui',
            'data' => $bantuan->fresh(),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/bantuan/{id}/reject",
     *     tags={"Bantuan"},
     *     summary="Reject bantuan (Petugas/Admin only)",
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
     *             @OA\Property(property="alasan", type="string", example="Kuota habis")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Bantuan rejected",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Bantuan ditolak"),
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

        $bantuan = Bantuan::with('user')->findOrFail($id);

        // Petugas can only reject bantuan from their desa
        if ($user->role === 'petugas' && $bantuan->user->alamat_desa !== $user->alamat_desa) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        $bantuan->update([
            'status' => 'ditolak',
            'catatan' => $validated['alasan'],
        ]);

        return response()->json([
            'message' => 'Bantuan ditolak',
            'data' => $bantuan->fresh(),
        ]);
    }
}
