<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bantuan;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LaporanCreated;

class PetaniController extends Controller
{
    // Dashboard Petani
    public function dashboard()
    {
        $user = Auth::user();

        // Statistik petani
        $total_laporan = Laporan::where('user_id', $user->id)->count();
        $total_bantuan = Bantuan::where('user_id', $user->id)->count();
        $bantuan_pending = Bantuan::where('user_id', $user->id)->where('status', 'pending')->count();
        $bantuan_disetujui = Bantuan::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $total_hasil_panen = Laporan::where('user_id', $user->id)->sum('hasil_panen');

        // Data terbaru
        $laporan_terbaru = Laporan::where('user_id', $user->id)->latest()->take(5)->get();
        $bantuan_terbaru = Bantuan::where('user_id', $user->id)->latest()->take(5)->get();
        $notifications = Auth::user()->notifications()->latest()->take(5)->get();

        return view('petani.dashboard', compact(
            'total_laporan',
            'total_bantuan',
            'bantuan_pending',
            'bantuan_disetujui',
            'total_hasil_panen',
            'laporan_terbaru',
            'bantuan_terbaru',
            'notifications'
        ));
    }

    // ==================== LAPORAN MANAGEMENT ====================
    
    public function laporanIndex()
    {
        $user = Auth::user();
        $laporans = Laporan::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('petani.laporan.index', compact('laporans'));
    }

    public function laporanCreate()
    {
        return view('petani.laporan.create');
    }

    public function laporanStore(Request $request)
    {
        $validated = $request->validate([
            'jenis_tanaman' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric|min:0',
            'hasil_panen' => 'required|numeric|min:0',
            'tanggal_panen' => 'required|date',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/laporan'), $filename);
            $validated['foto'] = $filename;
        }

        $laporan = Laporan::create($validated);

        // Kirim notifikasi ke admin/petugas
        $admins = User::whereIn('role', ['admin', 'petugas'])->get();
        Notification::send($admins, new LaporanCreated($laporan));

        return redirect()->route('petani.laporan.index')->with('success', 'Laporan berhasil dibuat!');
    }

    public function laporanShow(Laporan $laporan)
    {
        // Pastikan hanya pemilik yang bisa lihat
        if ($laporan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('petani.laporan.show', compact('laporan'));
    }

    public function laporanEdit(Laporan $laporan)
    {
        // Pastikan hanya pemilik yang bisa edit
        if ($laporan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa edit jika status masih pending
        if ($laporan->status !== 'pending') {
            return redirect()->route('petani.laporan.index')
                ->with('error', 'Laporan yang sudah diverifikasi tidak dapat diedit!');
        }

        return view('petani.laporan.edit', compact('laporan'));
    }

    public function laporanUpdate(Request $request, Laporan $laporan)
    {
        // Pastikan hanya pemilik yang bisa update
        if ($laporan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa update jika status masih pending
        if ($laporan->status !== 'pending') {
            return redirect()->route('petani.laporan.index')
                ->with('error', 'Laporan yang sudah diverifikasi tidak dapat diedit!');
        }

        $validated = $request->validate([
            'jenis_tanaman' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric|min:0',
            'hasil_panen' => 'required|numeric|min:0',
            'tanggal_panen' => 'required|date',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($laporan->foto && file_exists(public_path('uploads/laporan/' . $laporan->foto))) {
                unlink(public_path('uploads/laporan/' . $laporan->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/laporan'), $filename);
            $validated['foto'] = $filename;
        }

        $laporan->update($validated);

        return redirect()->route('petani.laporan.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function laporanDestroy(Laporan $laporan)
    {
        // Pastikan hanya pemilik yang bisa delete
        if ($laporan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa delete jika status masih pending
        if ($laporan->status !== 'pending') {
            return redirect()->route('petani.laporan.index')
                ->with('error', 'Laporan yang sudah diverifikasi tidak dapat dihapus!');
        }

        // Hapus foto jika ada
        if ($laporan->foto && file_exists(public_path('uploads/laporan/' . $laporan->foto))) {
            unlink(public_path('uploads/laporan/' . $laporan->foto));
        }

        $laporan->delete();

        return redirect()->route('petani.laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }

    // ==================== BANTUAN MANAGEMENT ====================
    
    public function bantuanIndex()
    {
        $user = Auth::user();
        $bantuans = Bantuan::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('petani.bantuan.index', compact('bantuans'));
    }

    public function bantuanShow(Bantuan $bantuan)
    {
        // Pastikan hanya pemilik yang bisa lihat
        if ($bantuan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('petani.bantuan.show', compact('bantuan'));
    }

    public function bantuanEdit(Bantuan $bantuan)
    {
        // Pastikan hanya pemilik yang bisa edit
        if ($bantuan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa edit jika status masih pending
        if ($bantuan->status !== 'pending') {
            return redirect()->route('petani.bantuan.index')
                ->with('error', 'Bantuan yang sudah diproses tidak dapat diedit!');
        }

        return view('petani.bantuan.edit', compact('bantuan'));
    }

    public function bantuanUpdate(Request $request, Bantuan $bantuan)
    {
        // Pastikan hanya pemilik yang bisa update
        if ($bantuan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa update jika status masih pending
        if ($bantuan->status !== 'pending') {
            return redirect()->route('petani.bantuan.index')
                ->with('error', 'Bantuan yang sudah diproses tidak dapat diedit!');
        }

        $validated = $request->validate([
            'jenis_bantuan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'alasan' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        // Handle dokumen upload
        if ($request->hasFile('dokumen')) {
            // Hapus dokumen lama jika ada
            if ($bantuan->dokumen && file_exists(public_path('uploads/bantuan/' . $bantuan->dokumen))) {
                unlink(public_path('uploads/bantuan/' . $bantuan->dokumen));
            }

            $file = $request->file('dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bantuan'), $filename);
            $validated['dokumen'] = $filename;
        }

        $bantuan->update($validated);

        return redirect()->route('petani.bantuan.index')->with('success', 'Bantuan berhasil diperbarui!');
    }
}
