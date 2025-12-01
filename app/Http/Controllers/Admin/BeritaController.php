<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beritas = Berita::latest()->paginate(10);

        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'tanggal_publikasi' => 'nullable|date',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('storage/berita'), $imageName);
            $data['gambar'] = 'berita/' . $imageName;
        }

        // Generate slug
        $data['slug'] = Str::slug($request->judul);

        $berita = Berita::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Berita created successfully',
                'data' => $berita,
            ], 201);
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $berita = Berita::findOrFail($id);

        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);

        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'tanggal_publikasi' => 'nullable|date',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($berita->gambar && file_exists(public_path('storage/' . $berita->gambar))) {
                unlink(public_path('storage/' . $berita->gambar));
            }

            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('storage/berita'), $imageName);
            $data['gambar'] = 'berita/' . $imageName;
        }

        // Update slug if title changed
        if ($berita->judul !== $request->judul) {
            $data['slug'] = Str::slug($request->judul);
        }

        $berita->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Berita updated successfully',
                'data' => $berita,
            ], 200);
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);

        // Delete image file
        if ($berita->gambar && file_exists(public_path('storage/' . $berita->gambar))) {
            unlink(public_path('storage/' . $berita->gambar));
        }

        $berita->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Berita deleted successfully',
            ], 200);
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Toggle status of the berita.
     */
    public function toggleStatus($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->status = $berita->status === 'published' ? 'draft' : 'published';
        $berita->save();

        return redirect()->route('admin.berita.index')->with('success', 'Status berita berhasil diubah.');
    }
}
