<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanBantuan;
use App\Services\LaporanBantuanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLaporanBantuanController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanBantuanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    /**
     * Display all reports for admin.
     */
    public function index(Request $request)
    {
        $filters = [
            'status' => $request->get('status'),
            'jenis_bantuan' => $request->get('jenis_bantuan'),
            'search' => $request->get('search'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
        ];

        $reports = $this->laporanService->getAdminReports($filters, 15);

        // Get filter options
        $statusOptions = ['pending', 'verified', 'rejected', 'published'];
        $jenisBantuanOptions = LaporanBantuan::distinct()->pluck('jenis_bantuan');

        return view('admin.laporan-bantuan.index', compact('reports', 'filters', 'statusOptions', 'jenisBantuanOptions'));
    }

    /**
     * Show detail report.
     */
    public function show($id)
    {
        $laporan = LaporanBantuan::with(['user', 'bantuan', 'verifier'])->findOrFail($id);

        return view('admin.laporan-bantuan.show', compact('laporan'));
    }

    /**
     * Verify report.
     */
    public function verify(Request $request, $id)
    {
        $laporan = LaporanBantuan::findOrFail($id);

        $request->validate([
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ]);

        try {
            $this->laporanService->verifyReport(
                $laporan,
                Auth::id(),
                $request->catatan_verifikasi
            );

            return redirect()->back()
                ->with('success', 'Laporan berhasil diverifikasi.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memverifikasi laporan: ' . $e->getMessage());
        }
    }

    /**
     * Reject report.
     */
    public function reject(Request $request, $id)
    {
        $laporan = LaporanBantuan::findOrFail($id);

        $request->validate([
            'catatan_verifikasi' => 'required|string|max:1000',
        ], [
            'catatan_verifikasi.required' => 'Alasan penolakan wajib diisi',
        ]);

        try {
            $this->laporanService->rejectReport(
                $laporan,
                Auth::id(),
                $request->catatan_verifikasi
            );

            return redirect()->back()
                ->with('success', 'Laporan berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menolak laporan: ' . $e->getMessage());
        }
    }

    /**
     * Publish report to public dashboard.
     */
    public function publish($id)
    {
        $laporan = LaporanBantuan::findOrFail($id);

        try {
            $this->laporanService->publishReport($laporan);

            return redirect()->back()
                ->with('success', 'Laporan berhasil dipublikasikan ke dashboard publik.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mempublikasikan laporan: ' . $e->getMessage());
        }
    }

    /**
     * Unpublish report.
     */
    public function unpublish($id)
    {
        $laporan = LaporanBantuan::findOrFail($id);

        try {
            $laporan->unpublish();

            return redirect()->back()
                ->with('success', 'Laporan berhasil dihapus dari dashboard publik.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus publikasi: ' . $e->getMessage());
        }
    }

    /**
     * Dashboard with statistics and insights.
     */
    public function dashboard(Request $request)
    {
        $period = $request->get('period', 'month');

        $statistics = $this->laporanService->getStatistics($period);
        $insights = $this->laporanService->getInsights();

        return view('admin.laporan-bantuan.dashboard', compact('statistics', 'insights', 'period'));
    }
}
