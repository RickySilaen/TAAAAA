<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use App\Models\LaporanBantuan;
use App\Services\LaporanBantuanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LaporanBantuanController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanBantuanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    /**
     * Display public dashboard (transparansi).
     */
    public function publicDashboard(Request $request)
    {
        $search = $request->get('search');
        $jenis = $request->get('jenis');

        $reports = $this->laporanService->getPublicReports(12, $search, $jenis);

        // Get available jenis bantuan for filter
        $jenisBantuanList = LaporanBantuan::published()
            ->distinct()
            ->pluck('jenis_bantuan');

        return view('guest.laporan-bantuan.dashboard', compact('reports', 'jenisBantuanList', 'search', 'jenis'));
    }

    /**
     * Show detail laporan (public).
     */
    public function show($id)
    {
        $laporan = LaporanBantuan::with(['user', 'bantuan'])
            ->published()
            ->findOrFail($id);

        // Increment views
        $laporan->incrementViews();

        return view('guest.laporan-bantuan.show', compact('laporan'));
    }

    /**
     * Display petani's own reports.
     */
    public function index()
    {
        $this->authorize('viewAny', LaporanBantuan::class);

        $reports = $this->laporanService->getPetaniReports(Auth::id(), 10);

        return view('petani.laporan-bantuan.index', compact('reports'));
    }

    /**
     * Show create form for petani.
     */
    public function create()
    {
        $this->authorize('create', LaporanBantuan::class);

        // Get bantuan yang sudah diterima petani
        $bantuanList = Bantuan::where('user_id', Auth::id())
            ->where('status', 'disetujui')
            ->get();

        return view('petani.laporan-bantuan.create', compact('bantuanList'));
    }

    /**
     * Store new report.
     */
    public function store(Request $request)
    {
        $this->authorize('create', LaporanBantuan::class);

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis_bantuan' => 'required|string|max:100',
            'jumlah_bantuan' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:50',
            'foto_bukti.*' => 'required|image|mimes:jpeg,jpg,png|max:5120', // max 5MB per image
            'bantuan_id' => 'nullable|exists:bantuans,id',
            'tanggal_penerimaan' => 'nullable|date',
            'is_public' => 'boolean',
        ], [
            'judul.required' => 'Judul laporan wajib diisi',
            'deskripsi.required' => 'Deskripsi laporan wajib diisi',
            'jenis_bantuan.required' => 'Jenis bantuan wajib diisi',
            'foto_bukti.*.required' => 'Minimal 1 foto bukti wajib diunggah',
            'foto_bukti.*.image' => 'File harus berupa gambar',
            'foto_bukti.*.max' => 'Ukuran foto maksimal 5MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $laporan = $this->laporanService->createReport($request->all(), Auth::id());

            return redirect()->route('petani.laporan-bantuan.index')
                ->with('success', 'Laporan bantuan berhasil dibuat dan akan diverifikasi oleh admin.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat laporan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show edit form.
     */
    public function edit($id)
    {
        $laporan = LaporanBantuan::findOrFail($id);
        $this->authorize('update', $laporan);

        // Get bantuan list
        $bantuanList = Bantuan::where('user_id', Auth::id())
            ->where('status', 'disetujui')
            ->get();

        return view('petani.laporan-bantuan.edit', compact('laporan', 'bantuanList'));
    }

    /**
     * Update report.
     */
    public function update(Request $request, $id)
    {
        $laporan = LaporanBantuan::findOrFail($id);
        $this->authorize('update', $laporan);

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis_bantuan' => 'required|string|max:100',
            'jumlah_bantuan' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:50',
            'foto_bukti_new.*' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'tanggal_penerimaan' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $this->laporanService->updateReport($laporan, $request->all(), Auth::id());

            return redirect()->route('petani.laporan-bantuan.index')
                ->with('success', 'Laporan bantuan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete report.
     */
    public function destroy($id)
    {
        $laporan = LaporanBantuan::findOrFail($id);
        $this->authorize('delete', $laporan);

        try {
            $this->laporanService->deleteReport($laporan);

            return redirect()->route('petani.laporan-bantuan.index')
                ->with('success', 'Laporan bantuan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }
}
