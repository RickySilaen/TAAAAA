<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bantuan;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Newsletter;
use App\Models\Feedback;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LaporanCreated;

class GuestController extends Controller
{
    public function index()
    {
        // Ambil data bantuan terbaru untuk ditampilkan di halaman publik
        $bantuans = Bantuan::latest()->take(5)->get();

        // Ambil berita terbaru
        $beritas = Berita::where('status', 'published')->latest()->take(3)->get();

        // Ambil galeri terbaru
        $galeris = Galeri::latest()->take(6)->get();

        // Statistik umum untuk transparansi publik
        $totalPetani = User::where('role', 'petani')->count();
        $totalBantuan = Bantuan::count();
        $totalLaporan = Laporan::count();
        $totalHasilPanen = Laporan::sum('hasil_panen');

        return view('index', compact('bantuans', 'beritas', 'galeris', 'totalPetani', 'totalBantuan', 'totalLaporan', 'totalHasilPanen'));
    }

    public function tentang()
    {
        return view('guest.tentang');
    }

    public function kontak()
    {
        return view('guest.kontak');
    }

    public function dashboard()
    {
        // Data untuk dashboard guest
        $totalCrops = 25; // Bisa diganti dengan data dinamis dari database
        $farmingGuides = 12; // Bisa diganti dengan data dinamis
        $weatherUpdates = 'Daily'; // Bisa diganti dengan data cuaca real-time

        return view('guest.dashboard', compact('totalCrops', 'farmingGuides', 'weatherUpdates'));
    }

    public function bantuanPublik()
    {
        $bantuans = Bantuan::with('user')->latest()->paginate(10);
        return view('guest.bantuan', compact('bantuans'));
    }

    public function bantuanShow($id)
    {
        $bantuan = Bantuan::with('user')->findOrFail($id);
        return view('guest.bantuan.show', compact('bantuan'));
    }

    public function laporanPublik()
    {
        $laporans = Laporan::with('user')->latest()->paginate(10);
        return view('guest.laporan', compact('laporans'));
    }

    public function berita()
    {
        $beritas = Berita::where('status', 'published')->latest()->paginate(9);
        return view('guest.berita', compact('beritas'));
    }

    public function beritaDetail($slug)
    {
        $berita = Berita::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $beritaLainnya = Berita::where('status', 'published')->where('id', '!=', $berita->id)->latest()->take(3)->get();
        return view('guest.berita-detail', compact('berita', 'beritaLainnya'));
    }

    public function galeri()
    {
        $galeris = Galeri::latest()->paginate(12);
        return view('guest.galeri', compact('galeris'));
    }

    public function faq()
    {
        return view('guest.faq');
    }

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
            'nama' => 'nullable|string|max:255'
        ]);

        Newsletter::create([
            'email' => $request->email,
            'nama' => $request->nama,
            'subscribed_at' => now()
        ]);

        return response()->json(['message' => 'Berhasil berlangganan newsletter!']);
    }

    public function feedback(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
            'kategori' => 'required|in:saran,keluhan,pertanyaan,lainnya'
        ]);

        Feedback::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'subjek' => $request->subjek,
            'pesan' => $request->pesan,
            'kategori' => $request->kategori,
            'tanggal' => now()
        ]);

        return response()->json(['message' => 'Feedback berhasil dikirim!']);
    }

    public function downloadBantuanPdf()
    {
        $bantuans = Bantuan::with('user')->get();
        $pdf = \PDF::loadView('guest.exports.bantuan-pdf', compact('bantuans'));
        return $pdf->download('daftar-bantuan-' . date('Y-m-d') . '.pdf');
    }

    public function downloadLaporanPdf()
    {
        $laporans = Laporan::with('user')->get();
        $pdf = \PDF::loadView('guest.exports.laporan-pdf', compact('laporans'));
        return $pdf->download('daftar-laporan-' . date('Y-m-d') . '.pdf');
    }

    // Laporan Management for Guest (no auth required)
    public function laporanIndex()
    {
        $laporans = Laporan::with('user')->latest()->paginate(10);
        return view('guest.laporan.index', compact('laporans'));
    }

    public function laporanCreate()
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat laporan.');
        }

        return view('guest.laporan.create');
    }

    public function laporanStore(Request $request)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat laporan.');
        }

        $request->validate([
            'deskripsi_kemajuan' => 'required|string',
            'jenis_tanaman' => 'nullable|string|max:255',
            'hasil_panen' => 'required|numeric|min:0',
            'luas_lahan' => 'required|numeric|min:0.01',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'nama_petani' => 'required|string|max:255',
            'alamat_desa' => 'required|string|max:255',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id(); // Set user_id dari user yang login
        $data['catatan_laporan'] = $data['catatan']; // Map to correct column name
        unset($data['catatan']); // Remove the old key

        $laporan = Laporan::create($data);

        // Send notification to admin and petugas
        $users = \App\Models\User::whereIn('role', ['admin', 'petugas'])->get();
        Notification::send($users, new LaporanCreated($laporan));

        return redirect()->route('guest.laporan.index')->with('success', 'Laporan berhasil dibuat!');
    }

    public function laporanShow($id)
    {
        $laporan = Laporan::with('user')->findOrFail($id);
        return view('guest.laporan.show', compact('laporan'));
    }

    public function laporanEdit($id)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengedit laporan.');
        }

        $laporan = Laporan::findOrFail($id);
        
        // Cek apakah user memiliki hak akses (pemilik, admin, atau petugas)
        if (auth()->user()->id != $laporan->user_id && 
            auth()->user()->role != 'admin' && 
            auth()->user()->role != 'petugas') {
            return redirect()->route('guest.laporan.index')->with('error', 'Anda tidak memiliki hak akses untuk mengedit laporan ini.');
        }
        
        return view('guest.laporan.edit', compact('laporan'));
    }

    public function laporanUpdate(Request $request, $id)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengupdate laporan.');
        }

        $laporan = Laporan::findOrFail($id);
        
        // Cek apakah user memiliki hak akses (pemilik, admin, atau petugas)
        if (auth()->user()->id != $laporan->user_id && 
            auth()->user()->role != 'admin' && 
            auth()->user()->role != 'petugas') {
            return redirect()->route('guest.laporan.index')->with('error', 'Anda tidak memiliki hak akses untuk mengupdate laporan ini.');
        }

        $request->validate([
            'deskripsi_kemajuan' => 'required|string',
            'jenis_tanaman' => 'nullable|string|max:255',
            'hasil_panen' => 'required|numeric|min:0',
            'luas_lahan' => 'required|numeric|min:0.01',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'nama_petani' => 'required|string|max:255',
            'alamat_desa' => 'required|string|max:255',
        ]);

        $data = $request->all();
        $data['catatan_laporan'] = $data['catatan']; // Map to correct column name
        unset($data['catatan']); // Remove the old key

        $laporan->update($data);

        return redirect()->route('guest.laporan.show', $laporan->id)->with('success', 'Laporan berhasil diperbarui!');
    }

    public function laporanDestroy($id)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk menghapus laporan.');
        }

        $laporan = Laporan::findOrFail($id);
        
        // Cek apakah user memiliki hak akses (pemilik, admin, atau petugas)
        if (auth()->user()->id != $laporan->user_id && 
            auth()->user()->role != 'admin' && 
            auth()->user()->role != 'petugas') {
            return redirect()->route('guest.laporan.index')->with('error', 'Anda tidak memiliki hak akses untuk menghapus laporan ini.');
        }

        $laporan->delete();

        return redirect()->route('guest.laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }
}
