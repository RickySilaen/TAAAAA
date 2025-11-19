<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputDataController extends Controller
{
    public function index()
    {
        return view('admin.input_data'); // Blade Anda
    }

    public function storeBantuan(Request $request)
    {
        $request->validate([
            'jenis_bantuan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|in:Diproses,Dikirim',
            'tanggal' => 'required|date',
            'catatan_laporan' => 'nullable|string',
        ]);

        Bantuan::create([
            'user_id' => Auth::id(),
            'jenis_bantuan' => $request->jenis_bantuan,
            'jumlah' => $request->jumlah,
            'status' => $request->status,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan_laporan,
        ]);

        return back()->with('success', 'Data bantuan berhasil disimpan!');
    }

    public function storeLaporan(Request $request)
    {
        $request->validate([
            'jenis_tanaman' => 'required|string|max:255',
            'hasil_panen' => 'required|numeric|min:0',
            'luas_panen' => 'nullable|numeric|min:0',
            'deskripsi_kemajuan' => 'required|string',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        Laporan::create([
            'user_id' => Auth::id(),
            'jenis_tanaman' => $request->jenis_tanaman,
            'hasil_panen' => $request->hasil_panen,
            'luas_panen' => $request->luas_panen,
            'deskripsi_kemajuan' => $request->deskripsi_kemajuan,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Data laporan berhasil disimpan!');
    }
}
