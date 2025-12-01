<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use App\Models\Laporan;
use App\Models\User;
use App\Notifications\BantuanCreated;
use App\Notifications\LaporanCreated;
use App\Notifications\PetaniVerified;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    // Dashboard Petugas
    public function dashboard()
    {
        $user = Auth::user();

        // Statistik
        $jumlah_petani = User::where('role', 'petani')->count();
        $laporan_pending = Laporan::where('status', 'pending')->count();
        $bantuan_aktif = Bantuan::where('status', 'Diproses')->count();
        $total_panen = Laporan::whereMonth('created_at', now()->month)->sum('hasil_panen');

        // Data terbaru
        $petani_baru = User::where('role', 'petani')
            ->latest()
            ->take(5)
            ->get();
        $laporan_terbaru = Laporan::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact(
            'jumlah_petani',
            'laporan_pending',
            'bantuan_aktif',
            'total_panen',
            'petani_baru',
            'laporan_terbaru'
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

        $petanis = $query->orderBy('is_verified', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('petugas.petani.index', compact('petanis'));
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
        $kecamatan = $user->alamat_kecamatan;

        // Query laporan berdasarkan kecamatan petugas, atau semua jika tidak ada kecamatan
        $query = Laporan::with('user');

        if ($kecamatan) {
            $query->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }

        $laporans = $query->orderBy('created_at', 'desc')->get();

        return view('petugas.laporan.index', compact('laporans'));
    }

    public function laporanShow($id)
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        $query = Laporan::with('user');

        if ($kecamatan) {
            $query->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }

        $laporan = $query->findOrFail($id);

        return view('petugas.laporan.show', compact('laporan'));
    }

    public function laporanVerify(Request $request, $id)
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        $query = Laporan::query();

        if ($kecamatan) {
            $query->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }

        $laporan = $query->findOrFail($id);

        $laporan->update([
            'status' => 'verified',
            'catatan' => $request->catatan ?? null,
        ]);

        // Kirim notifikasi ke petani
        $laporan->user->notify(new LaporanCreated($laporan));

        return redirect()->route('petugas.laporan.show', $laporan->id)->with('success', 'Laporan berhasil diverifikasi!');
    }

    public function laporanReject(Request $request, $id)
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        $query = Laporan::query();

        if ($kecamatan) {
            $query->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }

        $laporan = $query->findOrFail($id);

        $laporan->update([
            'status' => 'rejected',
            'catatan' => $request->alasan ?? null,
        ]);

        return redirect()->route('petugas.laporan.index')->with('success', 'Laporan berhasil ditolak!');
    }

    // Kelola Bantuan
    public function bantuanIndex()
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        $query = Bantuan::with('user');

        if ($kecamatan) {
            $query->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }

        $bantuans = $query->orderBy('created_at', 'desc')->get();

        return view('petugas.bantuan.index', compact('bantuans'));
    }

    public function bantuanShow($id)
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        $query = Bantuan::with('user');

        if ($kecamatan) {
            $query->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }

        $bantuan = $query->findOrFail($id);

        return view('petugas.bantuan.show', compact('bantuan'));
    }

    public function bantuanUpdateStatus(Request $request, $id)
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        $query = Bantuan::query();

        if ($kecamatan) {
            $query->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }

        $bantuan = $query->findOrFail($id);

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
        $kecamatan = $user->alamat_kecamatan;

        $query = Bantuan::with('user');

        if ($kecamatan) {
            $query->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }

        $bantuans = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistik berdasarkan jenis bantuan
        $statsQuery = Bantuan::query();
        if ($kecamatan) {
            $statsQuery->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }
        $statsByType = $statsQuery->selectRaw('jenis_bantuan, COUNT(*) as total')
            ->groupBy('jenis_bantuan')
            ->get();

        // Statistik berdasarkan status
        $statusQuery = Bantuan::query();
        if ($kecamatan) {
            $statusQuery->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }
        $statsByStatus = $statusQuery->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        return view('petugas.monitoring', compact('bantuans', 'statsByType', 'statsByStatus'));
    }

    // Export Bantuan to PDF
    public function exportBantuanPdf()
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        $query = Bantuan::with('user');
        if ($kecamatan) {
            $query->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }
        $bantuans = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('petugas.exports.bantuan-pdf', compact('bantuans', 'kecamatan'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('daftar-bantuan-petugas-' . date('Y-m-d') . '.pdf');
    }

    // Export Laporan to PDF
    public function exportLaporanPdf()
    {
        $user = Auth::user();
        $kecamatan = $user->alamat_kecamatan;

        $query = Laporan::with('user');
        if ($kecamatan) {
            $query->whereHas('user', function ($q) use ($kecamatan) {
                $q->where('alamat_kecamatan', $kecamatan);
            });
        }
        $laporans = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('petugas.exports.laporan-pdf', compact('laporans', 'kecamatan'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('daftar-laporan-petugas-' . date('Y-m-d') . '.pdf');
    }
}
