<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bantuan;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BantuanCreated;
use App\Notifications\LaporanCreated;
use App\Notifications\PetaniVerified;

class PetugasController extends Controller
{
    // Dashboard Petugas
    public function dashboard()
    {
        $user = Auth::user();
        $desa = $user->alamat_desa; // Asumsi petugas bertugas di desa tertentu

        // Statistik wilayah
        $petani_di_desa = User::where('role', 'petani')->where('alamat_desa', $desa)->count();
        $petani_belum_verifikasi = User::where('role', 'petani')
            ->where('alamat_desa', $desa)
            ->where('is_verified', false)
            ->count();
        $laporan_di_desa = Laporan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->count();
        $bantuan_di_desa = Bantuan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->count();
        $total_hasil_panen = Laporan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->sum('hasil_panen');

        // Data terbaru
        $laporan_terbaru = Laporan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->with('user')->latest()->take(5)->get();
        $bantuan_terbaru = Bantuan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->with('user')->latest()->take(5)->get();
        $notifications = Auth::user()->notifications()->latest()->take(5)->get();

        return view('petugas.dashboard', compact(
            'petani_di_desa',
            'petani_belum_verifikasi',
            'laporan_di_desa',
            'bantuan_di_desa',
            'total_hasil_panen',
            'laporan_terbaru',
            'bantuan_terbaru',
            'notifications'
        ));
    }

    // Daftar Petani untuk Verifikasi
    public function petaniIndex()
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        // Jika petugas punya kecamatan, filter berdasarkan kecamatan
        // Jika tidak, tampilkan semua petani
        $query = User::where('role', 'petani');
        
        if ($kecamatan) {
            $query->where('alamat_kecamatan', $kecamatan);
        }

        $petani = $query->orderBy('is_verified', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('petugas.petani.index', compact('petani'));
    }

    // Detail Petani
    public function petaniShow($id)
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        // Jika petugas punya kecamatan, filter berdasarkan kecamatan
        // Jika tidak, tampilkan semua petani
        $query = User::where('role', 'petani')->where('id', $id);
        
        if ($kecamatan) {
            $query->where('alamat_kecamatan', $kecamatan);
        }

        $petani = $query->firstOrFail();

        return view('petugas.petani.show', compact('petani'));
    }

    // Verifikasi Petani
    public function petaniVerify(Request $request, $id)
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        // Jika petugas punya kecamatan, filter berdasarkan kecamatan
        // Jika tidak, verifikasi petani manapun
        $query = User::where('role', 'petani')
            ->where('id', $id)
            ->where('is_verified', false);
        
        if ($kecamatan) {
            $query->where('alamat_kecamatan', $kecamatan);
        }

        $petani = $query->firstOrFail();

        $petani->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        // Kirim notifikasi ke petani
        $petani->notify(new PetaniVerified($user));

        return redirect()->route('petugas.petani.index')
            ->with('success', 'Akun petani ' . $petani->name . ' berhasil diverifikasi!');
    }

    // Tolak Verifikasi Petani
    public function petaniReject(Request $request, $id)
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        // Jika petugas punya kecamatan, filter berdasarkan kecamatan
        // Jika tidak, reject petani manapun
        $query = User::where('role', 'petani')
            ->where('id', $id)
            ->where('is_verified', false);
        
        if ($kecamatan) {
            $query->where('alamat_kecamatan', $kecamatan);
        }

        $petani = $query->firstOrFail();
        $petaniName = $petani->name;

        // Hapus akun petani yang ditolak
        $petani->delete();

        return redirect()->route('petugas.petani.index')
            ->with('success', 'Pendaftaran petani ' . $petaniName . ' ditolak dan akun dihapus.');
    }

    // Verifikasi Laporan
    public function laporanIndex()
    {
        $user = Auth::user();
        $desa = $user->alamat_desa;

        $laporans = Laporan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->with('user')->get();

        return view('petugas.laporan.index', compact('laporans'));
    }

    public function laporanShow($id)
    {
        $user = Auth::user();
        $desa = $user->alamat_desa;

        $laporan = Laporan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->with('user')->findOrFail($id);

        return view('petugas.laporan.show', compact('laporan'));
    }

    public function laporanVerify(Request $request, $id)
    {
        $user = Auth::user();
        $desa = $user->alamat_desa;

        $laporan = Laporan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->findOrFail($id);

        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan_petugas' => 'nullable|string',
        ]);

        $laporan->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_petugas' => $request->catatan_petugas,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        // Kirim notifikasi ke petani
        $laporan->user->notify(new LaporanCreated($laporan));

        return redirect()->route('petugas.laporan.show', $laporan->id)->with('success', 'Laporan berhasil diverifikasi!');
    }

    // Kelola Bantuan
    public function bantuanIndex()
    {
        $user = Auth::user();
        $desa = $user->alamat_desa;

        $bantuans = Bantuan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->with('user')->get();

        return view('petugas.bantuan.index', compact('bantuans'));
    }

    public function bantuanShow($id)
    {
        $user = Auth::user();
        $desa = $user->alamat_desa;

        $bantuan = Bantuan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->with('user')->findOrFail($id);

        return view('petugas.bantuan.show', compact('bantuan'));
    }

    public function bantuanUpdateStatus(Request $request, $id)
    {
        $user = Auth::user();
        $desa = $user->alamat_desa;

        $bantuan = Bantuan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->findOrFail($id);

        $request->validate([
            'status' => 'required|in:Diproses,Dikirim,Ditolak',
            'catatan' => 'nullable|string',
        ]);

        $bantuan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        // Kirim notifikasi ke petani
        $bantuan->user->notify(new BantuanCreated($bantuan));

        return redirect()->route('petugas.bantuan.show', $bantuan->id)->with('success', 'Status bantuan berhasil diperbarui!');
    }

    // Monitoring Wilayah
    public function monitoring()
    {
        $user = Auth::user();
        $desa = $user->alamat_desa;

        $bantuans = Bantuan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->with('user')->paginate(10);

        // Statistik berdasarkan jenis bantuan
        $statsByType = Bantuan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->selectRaw('jenis_bantuan, COUNT(*) as total')
            ->groupBy('jenis_bantuan')
            ->get();

        // Statistik berdasarkan status
        $statsByStatus = Bantuan::whereHas('user', function($q) use ($desa) {
            $q->where('alamat_desa', $desa);
        })->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        return view('petugas.monitoring', compact('bantuans', 'statsByType', 'statsByStatus'));
    }
}
