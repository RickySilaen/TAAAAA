<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        $role = auth()->user()->role; // Pastikan kolom 'role' ada di tabel users

        if ($role === 'admin') {
            return '/dashboard';
        } elseif ($role === 'petugas') {
            return '/dashboard';
        } elseif ($role === 'petani') {
            return '/dashboard';
        }

        // default fallback
        return '/';
    }

    /**
     * Validasi kredensial dan status verifikasi.
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Validate the user login request.
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Override method untuk cek verifikasi setelah kredensial valid.
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // Cek apakah user ada
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        // Jika user adalah petani dan belum terverifikasi
        if ($user && $user->role === 'petani' && ! $user->is_verified) {
            return false; // Gagalkan login
        }

        // Lanjutkan proses login normal
        return $this->guard()->attempt(
            $credentials,
            $request->filled('remember')
        );
    }

    /**
     * Override untuk menampilkan pesan error khusus untuk akun belum terverifikasi.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && $user->role === 'petani' && ! $user->is_verified) {
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Akun Anda belum diverifikasi oleh petugas. Silakan tunggu konfirmasi dari petugas daerah Anda.',
                ]);
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau password salah.',
            ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
