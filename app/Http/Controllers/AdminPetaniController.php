<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminPetaniController extends Controller
{
    /**
     * Constructor - memastikan hanya admin yang bisa akses.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of petani.
     */
    public function index()
    {
        $petani = User::where('role', 'petani')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.petani.index', compact('petani'));
    }

    /**
     * Show the form for creating a new petani.
     */
    public function create()
    {
        return view('admin.petani.create');
    }

    /**
     * Store a newly created petani in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telepon' => 'nullable|string|max:20',
            'alamat_desa' => 'required|string|max:255',
            'alamat_kecamatan' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'alamat_desa.required' => 'Alamat desa wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'petani',
                'telepon' => $request->telepon,
                'alamat_desa' => $request->alamat_desa,
                'alamat_kecamatan' => $request->alamat_kecamatan,
                'is_verified' => true, // Petani yang didaftarkan admin langsung terverifikasi
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);

            return redirect()->route('admin.petani.index')
                ->with('success', 'Petani berhasil ditambahkan dan langsung terverifikasi!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified petani.
     */
    public function show($id)
    {
        $petani = User::where('role', 'petani')->findOrFail($id);

        // Statistik petani
        $total_laporan = $petani->laporans()->count();
        $total_bantuan = $petani->bantuans()->count();
        $total_hasil_panen = $petani->laporans()->sum('hasil_panen');

        return view('admin.petani.show', compact('petani', 'total_laporan', 'total_bantuan', 'total_hasil_panen'));
    }

    /**
     * Show the form for editing the specified petani.
     */
    public function edit($id)
    {
        $petani = User::where('role', 'petani')->findOrFail($id);

        return view('admin.petani.edit', compact('petani'));
    }

    /**
     * Update the specified petani in storage.
     */
    public function update(Request $request, $id)
    {
        $petani = User::where('role', 'petani')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'telepon' => 'nullable|string|max:20',
            'alamat_desa' => 'required|string|max:255',
            'alamat_kecamatan' => 'nullable|string|max:255',
            'is_verified' => 'sometimes|boolean',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'alamat_desa.required' => 'Alamat desa wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat_desa' => $request->alamat_desa,
                'alamat_kecamatan' => $request->alamat_kecamatan,
            ];

            // Update password jika diisi
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            // Update status verifikasi jika ada perubahan
            if ($request->has('is_verified') && $request->is_verified != $petani->is_verified) {
                $updateData['is_verified'] = $request->is_verified;
                $updateData['verified_at'] = $request->is_verified ? now() : null;
                $updateData['verified_by'] = $request->is_verified ? auth()->id() : null;
            }

            $petani->update($updateData);

            return redirect()->route('admin.petani.index')
                ->with('success', 'Data petani berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified petani from storage.
     */
    public function destroy($id)
    {
        try {
            $petani = User::where('role', 'petani')->findOrFail($id);

            // Cek apakah petani punya data terkait
            $has_laporans = $petani->laporans()->count() > 0;
            $has_bantuans = $petani->bantuans()->count() > 0;

            if ($has_laporans || $has_bantuans) {
                return redirect()->back()
                    ->with('warning', 'Petani tidak bisa dihapus karena memiliki data laporan atau bantuan. Silakan hapus data terkait terlebih dahulu atau nonaktifkan akun petani.');
            }

            $petani->delete();

            return redirect()->route('admin.petani.index')
                ->with('success', 'Petani berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle verification status of petani.
     */
    public function toggleVerification($id)
    {
        try {
            $petani = User::where('role', 'petani')->findOrFail($id);

            $petani->is_verified = ! $petani->is_verified;
            $petani->verified_at = $petani->is_verified ? now() : null;
            $petani->verified_by = $petani->is_verified ? auth()->id() : null;
            $petani->save();

            $status = $petani->is_verified ? 'diverifikasi' : 'dibatalkan verifikasinya';

            return redirect()->back()
                ->with('success', "Petani berhasil {$status}!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
