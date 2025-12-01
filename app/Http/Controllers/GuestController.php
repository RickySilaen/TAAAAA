<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use App\Models\Berita;
use App\Models\Feedback;
use App\Models\Galeri;
use App\Models\Laporan;
use App\Models\Newsletter;
use App\Models\User;
use App\Notifications\LaporanCreated;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class GuestController extends Controller
{
    public function index()
    {
        // Ambil data bantuan terbaru yang sudah dikirim (terverifikasi petugas)
        $bantuans = Bantuan::where('status', 'Dikirim')->latest()->take(5)->get();

        // Ambil berita terbaru
        $beritas = Berita::where('status', 'published')->latest()->take(3)->get();

        // Ambil galeri terbaru
        $galeris = Galeri::latest()->take(6)->get();

        // Statistik umum untuk transparansi publik - hanya data terverifikasi
        $totalPetani = User::where('role', 'petani')->count();
        $totalBantuan = Bantuan::where('status', 'Dikirim')->count();
        $totalLaporan = Laporan::where('status', 'verified')->count();
        $totalHasilPanen = Laporan::where('status', 'verified')->sum('hasil_panen');

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
        // Hanya tampilkan bantuan yang sudah dikirim (sudah diproses petugas)
        $bantuans = Bantuan::with('user')
            ->where('status', 'Dikirim')
            ->latest()
            ->paginate(12);

        // Statistik untuk halaman publik
        $totalBantuan = Bantuan::where('status', 'Dikirim')->count();
        $totalPenerima = Bantuan::where('status', 'Dikirim')->distinct('user_id')->count('user_id');

        // Statistik berdasarkan jenis bantuan
        $bantuanPerJenis = Bantuan::where('status', 'Dikirim')
            ->selectRaw('jenis_bantuan, COUNT(*) as total, SUM(jumlah) as jumlah_total')
            ->groupBy('jenis_bantuan')
            ->get();

        return view('guest.bantuan', compact('bantuans', 'totalBantuan', 'totalPenerima', 'bantuanPerJenis'));
    }

    public function bantuanShow($id)
    {
        $bantuan = Bantuan::with('user')->findOrFail($id);

        return view('guest.bantuan.show', compact('bantuan'));
    }

    public function laporanPublik()
    {
        // Hanya tampilkan laporan yang sudah diverifikasi oleh petugas
        $laporans = Laporan::with('user')
            ->where('status', 'verified')
            ->latest()
            ->paginate(12);

        // Statistik untuk halaman publik
        $totalLaporan = Laporan::where('status', 'verified')->count();
        $totalProduksi = Laporan::where('status', 'verified')->sum('hasil_panen') / 1000; // Convert to ton
        $totalPetani = Laporan::where('status', 'verified')->distinct('user_id')->count('user_id');

        // Data untuk chart - produksi per bulan
        $produksiPerBulan = Laporan::where('status', 'verified')
            ->selectRaw('MONTH(created_at) as bulan, SUM(hasil_panen) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('guest.laporan', compact('laporans', 'totalLaporan', 'totalProduksi', 'totalPetani', 'produksiPerBulan'));
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
            'nama' => 'nullable|string|max:255',
        ]);

        Newsletter::create([
            'email' => $request->email,
            'nama' => $request->nama ?? null,
            'status' => 'active',
            'subscribed_at' => now(),
        ]);

        // Support both AJAX and traditional form submission
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Berhasil berlangganan newsletter!']);
        }

        return redirect()->back()->with('success', 'Berhasil berlangganan newsletter!');
    }

    public function feedback(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
            'kategori' => 'nullable|in:saran,keluhan,pertanyaan,lainnya',
        ]);

        Feedback::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'subjek' => $request->subjek,
            'pesan' => $request->pesan,
            'kategori' => $request->kategori ?? 'lainnya',
            'status' => 'unread',
            'tanggal' => now(),
        ]);

        // Support both AJAX and traditional form submission
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Feedback berhasil dikirim!']);
        }

        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }

    public function downloadBantuanPdf()
    {
        $bantuans = Bantuan::with('user')->get();
        $pdf = Pdf::loadView('guest.exports.bantuan-pdf', compact('bantuans'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('daftar-bantuan-' . date('Y-m-d') . '.pdf');
    }

    public function downloadLaporanPdf()
    {
        $laporans = Laporan::with('user')->get();
        $pdf = Pdf::loadView('guest.exports.laporan-pdf', compact('laporans'));
        $pdf->setPaper('a4', 'landscape');

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
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat laporan.');
        }

        return view('guest.laporan.create');
    }

    public function laporanStore(Request $request)
    {
        // Cek apakah user sudah login
        if (! auth()->check()) {
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
        if (! auth()->check()) {
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
        if (! auth()->check()) {
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
        if (! auth()->check()) {
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
