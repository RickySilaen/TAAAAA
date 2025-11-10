<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{
    /**
     * Constructor - memastikan hanya admin yang bisa akses
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of petugas.
     */
    public function index()
    {
        $petugas = User::where('role', 'petugas')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.petugas.index', compact('petugas'));
    }

    /**
     * Show the form for creating a new petugas.
     */
    public function create()
    {
        return view('admin.petugas.create');
    }

    /**
     * Store a newly created petugas in storage.
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
                'role' => 'petugas',
                'telepon' => $request->telepon,
                'alamat_desa' => $request->alamat_desa,
                'alamat_kecamatan' => $request->alamat_kecamatan,
                'is_verified' => true, // Petugas langsung terverifikasi
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);

            return redirect()->route('admin.petugas.index')
                ->with('success', 'Petugas berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified petugas.
     */
    public function show($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('admin.petugas.show', compact('petugas'));
    }

    /**
     * Show the form for editing the specified petugas.
     */
    public function edit($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('admin.petugas.edit', compact('petugas'));
    }

    /**
     * Update the specified petugas in storage.
     */
    public function update(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'telepon' => 'nullable|string|max:20',
            'alamat_desa' => 'required|string|max:255',
            'alamat_kecamatan' => 'nullable|string|max:255',
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

            $petugas->update($updateData);

            return redirect()->route('admin.petugas.index')
                ->with('success', 'Data petugas berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified petugas from storage.
     */
    public function destroy($id)
    {
        try {
            $petugas = User::where('role', 'petugas')->findOrFail($id);
            $petugas->delete();

            return redirect()->route('admin.petugas.index')
                ->with('success', 'Petugas berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
