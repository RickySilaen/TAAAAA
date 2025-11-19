<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use App\Models\Laporan;
use App\Models\User;
use App\Notifications\BantuanCreated;
use App\Notifications\LaporanCreated;
use App\Notifications\ProfileUpdated;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin Dashboard
            $bantuan_hari_ini = Bantuan::whereDate('created_at', today())->count();
            $total_petani = User::where('role', 'petani')->count();
            $laporan_baru = Laporan::whereDate('created_at', today())->count();
            $total_hasil_panen = Laporan::sum('hasil_panen');

            $bantuans = Bantuan::with('user')->latest()->take(5)->get();
            $laporans = Laporan::with('user')->latest()->take(5)->get();
            $notifications = Auth::user()->notifications()->latest()->take(5)->get();

            return view('admin.dashboard', compact(
                'bantuan_hari_ini',
                'total_petani',
                'laporan_baru',
                'total_hasil_panen',
                'bantuans',
                'laporans',
                'notifications'
            ));
        } elseif ($user->role === 'petugas') {
            // Petugas Dashboard - redirect ke PetugasController
            return app(PetugasController::class)->dashboard();
        } elseif ($user->role === 'petani') {
            // Petani Dashboard - redirect ke PetaniController
            return app(PetaniController::class)->dashboard();
        }

        // Default fallback - redirect to petugas dashboard for any other role
        return app(PetugasController::class)->dashboard();
    }

    public function daftar_bantuan()
    {
        $bantuans = Bantuan::all();

        return view('admin.daftar_bantuan', compact('bantuans'));
    }

    public function inputData()
    {
        return view('admin.input_data');
    }

    public function inputLaporan()
    {
        return view('admin.input_laporan');
    }

    public function inputBantuan()
    {
        return view('admin.input_bantuan');
    }

    public function storeBantuan(Request $request)
    {
        $request->validate([
            'jenis_bantuan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'status' => 'required|in:Dikirim,Diproses',
            'catatan' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id(); // Set the authenticated user as the owner

        $bantuan = Bantuan::create($data);

        // Send notification to all users
        $users = User::all();
        Notification::send($users, new BantuanCreated($bantuan));

        return redirect()->route('daftar.bantuan')->with('success', 'Bantuan berhasil ditambahkan!');
    }

    public function storeLaporan(Request $request)
    {
        $request->validate([
            'deskripsi_kemajuan' => 'required|string',
            'hasil_panen' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'jenis_tanaman' => 'nullable|string|max:255',
            'catatan_laporan' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        $laporan = Laporan::create($data);

        // Send notification to all users
        $users = User::all();
        Notification::send($users, new LaporanCreated($laporan));

        return redirect()->route('daftar.laporan')->with('success', 'Laporan berhasil ditambahkan!');
    }

    public function daftar_laporan()
    {
        $laporans = Laporan::with('user')->get();

        return view('admin.daftar_laporan', compact('laporans'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('admin.profile', compact('user'));
    }

    public function showProfile($id)
    {
        $user = User::findOrFail($id);

        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'alamat_desa' => 'nullable|string|max:255',
            'luas_lahan' => 'nullable|numeric|min:0',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'alamat_desa', 'luas_lahan']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                Storage::delete('public/' . $user->profile_picture);
            }

            $fileName = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
            $path = $request->file('profile_picture')->storeAs('profile_pictures', $fileName, 'public');
            $data['profile_picture'] = 'profile_pictures/' . $fileName;
        }

        $user->update($data);

        // Send notification
        $user->notify(new ProfileUpdated($user));

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateUserProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'alamat_desa' => 'nullable|string|max:255',
            'luas_lahan' => 'nullable|numeric|min:0',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'alamat_desa', 'luas_lahan']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                Storage::delete('public/' . $user->profile_picture);
            }

            $fileName = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
            $path = $request->file('profile_picture')->storeAs('profile_pictures', $fileName, 'public');
            $data['profile_picture'] = 'profile_pictures/' . $fileName;
        }

        $user->update($data);

        // Send notification
        $user->notify(new ProfileUpdated($user));

        return redirect()->route('profile.show', $user->id)->with('success', 'Profil berhasil diperbarui!');
    }

    public function hasilPanen()
    {
        $laporans = Laporan::with('user')->get();
        $total_hasil_panen = Laporan::sum('hasil_panen');

        return view('admin.hasil_panen', compact('laporans', 'total_hasil_panen'));
    }

    public function editBantuan($id)
    {
        $bantuan = Bantuan::findOrFail($id);

        return view('admin.edit_bantuan', compact('bantuan'));
    }

    public function updateBantuan(Request $request, $id)
    {
        $bantuan = Bantuan::findOrFail($id);

        $request->validate([
            'jenis_bantuan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'status' => 'required|in:Dikirim,Diproses',
            'catatan' => 'nullable|string',
        ]);

        $bantuan->update($request->all());

        return redirect()->route('daftar.bantuan')->with('success', 'Bantuan berhasil diperbarui!');
    }

    public function deleteBantuan($id)
    {
        $bantuan = Bantuan::findOrFail($id);
        $bantuan->delete();

        // Check if request is AJAX
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Bantuan berhasil dihapus!']);
        }

        return redirect()->route('daftar.bantuan')->with('success', 'Bantuan berhasil dihapus!');
    }

    public function deleteLaporan($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('daftar.laporan')->with('success', 'Laporan berhasil dihapus!');
    }

    public function editLaporan($id)
    {
        $laporan = Laporan::findOrFail($id);

        return view('admin.edit_laporan', compact('laporan'));
    }

    public function updateLaporan(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'deskripsi_kemajuan' => 'required|string',
            'hasil_panen' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'jenis_tanaman' => 'nullable|string|max:255',
            'catatan_laporan' => 'nullable|string',
        ]);

        $laporan->update($request->all());

        return redirect()->route('daftar.laporan')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function monitoring()
    {
        $bantuans = Bantuan::with('user')->paginate(10);

        // Stats by type
        $statsByType = Bantuan::selectRaw('jenis_bantuan, COUNT(*) as total')
            ->groupBy('jenis_bantuan')
            ->get();

        // Stats by status
        $statsByStatus = Bantuan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // Stats by desa
        $statsByDesa = Bantuan::selectRaw('users.alamat_desa, COUNT(*) as total')
            ->join('users', 'bantuans.user_id', '=', 'users.id')
            ->groupBy('users.alamat_desa')
            ->get();

        // Historical data (monthly)
        $historicalData = Bantuan::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.monitoring', compact('bantuans', 'statsByType', 'statsByStatus', 'statsByDesa', 'historicalData'));
    }

    public function latestBantuan()
    {
        $bantuans = Bantuan::latest()->take(10)->get();

        return response()->json($bantuans);
    }

    public function exportBantuanPDF()
    {
        $bantuans = Bantuan::all();
        $pdf = Pdf::loadView('admin.exports.bantuan_pdf', compact('bantuans'));

        return $pdf->download('daftar_bantuan.pdf');
    }

    public function exportLaporanPDF()
    {
        $laporans = Laporan::all();
        $pdf = Pdf::loadView('admin.exports.laporan_pdf', compact('laporans'));

        return $pdf->download('daftar_laporan.pdf');
    }

    public function markNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllNotificationsAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    public function notificationsIndex()
    {
        $notifications = Auth::user()->notifications()->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }

    public function showBantuan($id)
    {
        $bantuan = Bantuan::with('user')->findOrFail($id);

        return response()->json($bantuan);
    }

    public function showLaporan($id)
    {
        $laporan = Laporan::with('user')->findOrFail($id);

        return response()->json($laporan);
    }

    public function petaniList()
    {
        $petanis = User::where('role', 'petani')->get();

        return view('admin.petani_list', compact('petanis'));
    }

    public function tambahPetani()
    {
        return view('admin.tambah_petani');
    }

    public function storePetani(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat_desa' => 'nullable|string|max:255',
            'luas_lahan' => 'nullable|numeric|min:0',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['role'] = 'petani';

        User::create($data);

        return redirect()->route('petani.list')->with('success', 'Petani berhasil ditambahkan!');
    }

    public function editPetani($id)
    {
        $petani = User::findOrFail($id);

        return view('admin.edit_petani', compact('petani'));
    }

    public function updatePetani(Request $request, $id)
    {
        $petani = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'alamat_desa' => 'nullable|string|max:255',
            'luas_lahan' => 'nullable|numeric|min:0',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'alamat_desa', 'luas_lahan']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $petani->update($data);

        return redirect()->route('petani.list')->with('success', 'Petani berhasil diperbarui!');
    }

    public function deletePetani($id)
    {
        $petani = User::findOrFail($id);
        $petani->delete();

        return redirect()->route('petani.list')->with('success', 'Petani berhasil dihapus!');
    }
}
