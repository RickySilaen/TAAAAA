<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Handle a registration request for the application (override).
     */
    public function register(\Illuminate\Http\Request $request)
    {
        $this->validator($request->all())->validate();

        event(new \Illuminate\Auth\Events\Registered($user = $this->create($request->all())));

        // Redirect dengan pesan sukses, tapi jangan login otomatis
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda akan segera diverifikasi oleh petugas daerah. Silakan tunggu konfirmasi sebelum login.');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:petani'], // Hanya menerima role petani
            'alamat_desa' => ['nullable', 'string', 'max:255'],
            'alamat_kecamatan' => ['nullable', 'string', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:20'],
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'petani', // Force role to petani
            'alamat_desa' => $data['alamat_desa'] ?? null,
            'alamat_kecamatan' => $data['alamat_kecamatan'] ?? null,
            'telepon' => $data['telepon'] ?? null,
            'is_verified' => false, // Akun petani belum terverifikasi
        ];

        $user = User::create($userData);

        // Kirim notifikasi ke petugas sesuai daerah
        $this->notifyPetugasOfNewRegistration($user);

        return $user;
    }

    /**
     * Kirim notifikasi ke petugas sesuai daerah petani yang baru mendaftar
     */
    protected function notifyPetugasOfNewRegistration($petani)
    {
        // Cari petugas yang sesuai dengan daerah petani
        $petugas = User::where('role', 'petugas')
            ->where('alamat_desa', $petani->alamat_desa)
            ->get();

        // Jika tidak ada petugas di desa yang sama, notif ke semua petugas
        if ($petugas->isEmpty()) {
            $petugas = User::where('role', 'petugas')->get();
        }

        // Kirim notifikasi ke setiap petugas
        foreach ($petugas as $p) {
            $p->notify(new \App\Notifications\PetaniRegistered($petani));
        }
    }
}
