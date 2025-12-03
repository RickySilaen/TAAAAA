<?php

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\PetugasController as AdminPetugasController;
use App\Http\Controllers\AdminPetaniController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\InputDataController;
use App\Http\Controllers\PetaniController;
use App\Http\Controllers\PetugasController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Health Check Routes
|--------------------------------------------------------------------------
*/
Route::get('/health', [HealthCheckController::class, 'index']);
Route::get('/health/detailed', [HealthCheckController::class, 'detailed']);

/*
|--------------------------------------------------------------------------
| Guest Routes (Tidak Perlu Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/tentang', [GuestController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [GuestController::class, 'kontak'])->name('kontak');
Route::get('/dashboard-guest', [GuestController::class, 'dashboard'])->name('guest.dashboard');
Route::get('/bantuan-publik', [GuestController::class, 'bantuanPublik'])->name('bantuan.publik');
Route::get('/bantuan-publik/{id}', [GuestController::class, 'bantuanShow'])->name('guest.bantuan.show');
Route::get('/laporan-publik', [GuestController::class, 'laporanPublik'])->name('laporan.publik');
Route::get('/laporan-publik/index', [GuestController::class, 'laporanIndex'])->name('guest.laporan.index');
Route::get('/laporan-publik/create', [GuestController::class, 'laporanCreate'])->name('guest.laporan.create');
Route::post('/laporan-publik', [GuestController::class, 'laporanStore'])->name('guest.laporan.store');
Route::get('/laporan-publik/{id}', [GuestController::class, 'laporanShow'])->name('guest.laporan.show');
Route::get('/laporan-publik/{id}/edit', [GuestController::class, 'laporanEdit'])->name('guest.laporan.edit');
Route::put('/laporan-publik/{id}', [GuestController::class, 'laporanUpdate'])->name('guest.laporan.update');
Route::delete('/laporan-publik/{id}', [GuestController::class, 'laporanDestroy'])->name('guest.laporan.destroy');
Route::get('/berita', [GuestController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [GuestController::class, 'beritaDetail'])->name('berita.detail');
Route::get('/galeri', [GuestController::class, 'galeri'])->name('galeri');
Route::get('/faq', [GuestController::class, 'faq'])->name('faq');

// Laporan Bantuan - Public Dashboard for Transparency
Route::get('/transparansi-bantuan', [\App\Http\Controllers\LaporanBantuanController::class, 'publicDashboard'])->name('transparansi.bantuan');
Route::get('/transparansi-bantuan/{id}', [\App\Http\Controllers\LaporanBantuanController::class, 'show'])->name('transparansi.bantuan.show');

Route::post('/newsletter/subscribe', [GuestController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');
Route::post('/feedback', [GuestController::class, 'feedback'])->name('feedback.submit');
Route::get('/download/bantuan/pdf', [GuestController::class, 'downloadBantuanPdf'])->name('download.bantuan.pdf');
Route::get('/download/laporan/pdf', [GuestController::class, 'downloadLaporanPdf'])->name('download.laporan.pdf');

// Test PDF Route
Route::get('/test-pdf', function () {
    $pdf = Pdf::loadHTML('<html><body><h1>Test PDF</h1><p>Tanggal: ' . date('Y-m-d H:i:s') . '</p></body></html>');

    return response($pdf->output())
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="test.pdf"')
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
})->name('test.pdf');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Login, Register, Logout)
|--------------------------------------------------------------------------
*/

// Authentication Routes with email verification enabled
Auth::routes(['verify' => true]);

// Email Verification Routes (manually registered for compatibility)
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [\App\Http\Controllers\Auth\EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [\App\Http\Controllers\Auth\EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.resend');
});

Route::middleware(['guest', 'throttle:5,1'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Butuh Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_verified'])->group(function () {
    // Dashboard - Auto redirect berdasarkan role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | SHARED ROUTES (Admin, Petugas, Petani)
    |--------------------------------------------------------------------------
    | Routes yang bisa diakses oleh semua role yang sudah login
    */

    // Profil (Semua role bisa edit profil sendiri)
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/profile/{id}', [DashboardController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('update.profile');
    Route::post('/profile/{id}', [DashboardController::class, 'updateUserProfile'])->name('update.user.profile');

    // Notifications (Semua role)
    Route::post('/notifications/{id}/read', [DashboardController::class, 'markNotificationAsRead'])->name('notification.read');
    Route::post('/notifications/mark-all-read', [DashboardController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications', [DashboardController::class, 'notificationsIndex'])->name('notifications.index');

    /*
    |--------------------------------------------------------------------------
    | LEGACY ROUTES (Akan dihapus/dipindah ke role-specific routes)
    |--------------------------------------------------------------------------
    | Routes lama yang masih dipakai, akan di-refactor bertahap
    */

    // TODO: Pindahkan ke petani routes
    Route::get('/daftar-bantuan', [DashboardController::class, 'daftar_bantuan'])->name('daftar.bantuan');
    Route::get('/input-laporan', [DashboardController::class, 'inputLaporan'])->name('input.laporan');
    Route::get('/input-bantuan', [DashboardController::class, 'inputBantuan'])->name('input.bantuan');
    Route::put('/bantuan/{id}', [DashboardController::class, 'updateBantuan'])->name('update.bantuan');
    Route::delete('/bantuan/{id}', [DashboardController::class, 'deleteBantuan'])->name('delete.bantuan');
    Route::get('/bantuan/{id}/edit', [DashboardController::class, 'editBantuan'])->name('edit.bantuan');
    Route::get('/daftar-laporan', [DashboardController::class, 'daftar_laporan'])->name('daftar.laporan');
    Route::get('/laporan/{id}/edit', [DashboardController::class, 'editLaporan'])->name('edit.laporan');
    Route::put('/laporan/{id}', [DashboardController::class, 'updateLaporan'])->name('update.laporan');
    Route::delete('/laporan/{id}', [DashboardController::class, 'deleteLaporan'])->name('delete.laporan');
    Route::get('/input-data', [InputDataController::class, 'index'])->name('input.data');
    Route::post('/input-data/bantuan', [InputDataController::class, 'storeBantuan'])->name('store.bantuan');
    Route::post('/input-data/laporan', [InputDataController::class, 'storeLaporan'])->name('store.laporan');

    // TODO: Tentukan siapa yang bisa akses (admin/petugas?)
    Route::get('/petani-list', [DashboardController::class, 'petaniList'])->name('petani.list');
    Route::get('/tambah-petani', [DashboardController::class, 'tambahPetani'])->name('tambah.petani');
    Route::post('/tambah-petani', [DashboardController::class, 'storePetani'])->name('store.petani');
    Route::get('/edit-petani/{id}', [DashboardController::class, 'editPetani'])->name('edit.petani');
    Route::put('/edit-petani/{id}', [DashboardController::class, 'updatePetani'])->name('update.petani');
    Route::delete('/delete-petani/{id}', [DashboardController::class, 'deletePetani'])->name('delete.petani');

    // Monitoring & Export
    Route::get('/hasil-panen', [DashboardController::class, 'hasilPanen'])->name('hasil.panen');
    Route::get('/monitoring', [DashboardController::class, 'monitoring'])->name('monitoring');
    Route::get('/monitoring/latest', [DashboardController::class, 'latestBantuan'])->name('latest.bantuan');
    Route::get('/export/bantuan/pdf', [DashboardController::class, 'exportBantuanPDF'])->name('export.bantuan.pdf');
    Route::get('/export/laporan/pdf', [DashboardController::class, 'exportLaporanPDF'])->name('export.laporan.pdf');

    // Notifications
    Route::post('/notifications/{id}/read', [DashboardController::class, 'markNotificationAsRead'])->name('notification.read');
    Route::post('/notifications/mark-all-read', [DashboardController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications', [DashboardController::class, 'notificationsIndex'])->name('notifications.index');

    // API
    Route::get('/api/bantuan/{id}', [DashboardController::class, 'showBantuan'])->name('api.bantuan.show');
    Route::get('/api/laporan/{id}', [DashboardController::class, 'showLaporan'])->name('api.laporan.show');

    /*
    |--------------------------------------------------------------------------
    | Petugas Routes (Role Petugas)
    |--------------------------------------------------------------------------
    */
    Route::prefix('petugas')->name('petugas.')->middleware('petugas')->group(function () {
        // Dashboard
        Route::get('dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');

        // Verifikasi Petani
        Route::get('petani', [PetugasController::class, 'petaniIndex'])->name('petani.index');
        Route::get('petani/{id}', [PetugasController::class, 'petaniShow'])->name('petani.show');
        Route::post('petani/{id}/verify', [PetugasController::class, 'petaniVerify'])->name('petani.verify');
        Route::delete('petani/{id}/reject', [PetugasController::class, 'petaniReject'])->name('petani.reject');

        // Laporan Management
        Route::get('laporan', [PetugasController::class, 'laporanIndex'])->name('laporan.index');
        Route::get('laporan/{laporan}', [PetugasController::class, 'laporanShow'])->name('laporan.show');
        Route::post('laporan/{laporan}/verify', [PetugasController::class, 'laporanVerify'])->name('laporan.verify');
        Route::delete('laporan/{laporan}/reject', [PetugasController::class, 'laporanReject'])->name('laporan.reject');

        // Bantuan Management
        Route::get('bantuan', [PetugasController::class, 'bantuanIndex'])->name('bantuan.index');
        Route::get('bantuan/{bantuan}', [PetugasController::class, 'bantuanShow'])->name('bantuan.show');
        Route::post('bantuan/{bantuan}/update-status', [PetugasController::class, 'bantuanUpdateStatus'])->name('bantuan.update-status');

        // Monitoring
        Route::get('monitoring', [PetugasController::class, 'monitoring'])->name('monitoring');

        // Export PDF
        Route::get('export/bantuan/pdf', [PetugasController::class, 'exportBantuanPdf'])->name('export.bantuan.pdf');
        Route::get('export/laporan/pdf', [PetugasController::class, 'exportLaporanPdf'])->name('export.laporan.pdf');
    });

    /*
    |--------------------------------------------------------------------------
    | Petani Routes (Role Petani)
    |--------------------------------------------------------------------------
    */
    Route::prefix('petani')->name('petani.')->middleware('petani')->group(function () {
        // Dashboard
        Route::get('dashboard', [PetaniController::class, 'dashboard'])->name('dashboard');

        // Laporan Management
        Route::get('laporan', [PetaniController::class, 'laporanIndex'])->name('laporan.index');
        Route::get('laporan/create', [PetaniController::class, 'laporanCreate'])->name('laporan.create');
        Route::post('laporan', [PetaniController::class, 'laporanStore'])->name('laporan.store');
        Route::get('laporan/{laporan}', [PetaniController::class, 'laporanShow'])->name('laporan.show');
        Route::get('laporan/{laporan}/edit', [PetaniController::class, 'laporanEdit'])->name('laporan.edit');
        Route::put('laporan/{laporan}', [PetaniController::class, 'laporanUpdate'])->name('laporan.update');
        Route::delete('laporan/{laporan}', [PetaniController::class, 'laporanDestroy'])->name('laporan.destroy');

        // Bantuan Management
        Route::get('bantuan', [PetaniController::class, 'bantuanIndex'])->name('bantuan.index');
        Route::get('bantuan/create', [PetaniController::class, 'bantuanCreate'])->name('bantuan.create');
        Route::post('bantuan', [PetaniController::class, 'bantuanStore'])->name('bantuan.store');
        Route::get('bantuan/{bantuan}', [PetaniController::class, 'bantuanShow'])->name('bantuan.show');
        Route::get('bantuan/{bantuan}/edit', [PetaniController::class, 'bantuanEdit'])->name('bantuan.edit');
        Route::put('bantuan/{bantuan}', [PetaniController::class, 'bantuanUpdate'])->name('bantuan.update');
        Route::delete('bantuan/{bantuan}', [PetaniController::class, 'bantuanDestroy'])->name('bantuan.destroy');

        // Laporan Bantuan (Transparansi)
        Route::get('laporan-bantuan', [\App\Http\Controllers\LaporanBantuanController::class, 'index'])->name('laporan-bantuan.index');
        Route::get('laporan-bantuan/create', [\App\Http\Controllers\LaporanBantuanController::class, 'create'])->name('laporan-bantuan.create');
        Route::post('laporan-bantuan', [\App\Http\Controllers\LaporanBantuanController::class, 'store'])->name('laporan-bantuan.store');
        Route::get('laporan-bantuan/{id}/edit', [\App\Http\Controllers\LaporanBantuanController::class, 'edit'])->name('laporan-bantuan.edit');
        Route::put('laporan-bantuan/{id}', [\App\Http\Controllers\LaporanBantuanController::class, 'update'])->name('laporan-bantuan.update');
        Route::delete('laporan-bantuan/{id}', [\App\Http\Controllers\LaporanBantuanController::class, 'destroy'])->name('laporan-bantuan.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes (Role Admin)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        // Manajemen Petugas
        Route::resource('petugas', AdminPetugasController::class);

        // Manajemen Petani
        Route::resource('petani', AdminPetaniController::class);

        // Berita
        Route::resource('berita', BeritaController::class);
        Route::post('berita/{id}/toggle-status', [BeritaController::class, 'toggleStatus'])->name('berita.toggle-status');

        // Galeri
        Route::resource('galeri', GaleriController::class);

        // Feedback
        Route::resource('feedback', FeedbackController::class);
        Route::post('feedback/{id}/mark-read', [FeedbackController::class, 'markAsRead'])->name('feedback.mark-read');
        Route::post('feedback/{id}/mark-unread', [FeedbackController::class, 'markAsUnread'])->name('feedback.mark-unread');

        // Newsletter
        Route::resource('newsletter', NewsletterController::class);
        Route::post('newsletter/{id}/send', [NewsletterController::class, 'send'])->name('newsletter.send');
        Route::get('newsletter-subscribers', [NewsletterController::class, 'getSubscribers'])->name('newsletter.subscribers');

        // Laporan Bantuan - Admin Management & Decision Support
        Route::get('laporan-bantuan', [\App\Http\Controllers\Admin\AdminLaporanBantuanController::class, 'index'])->name('laporan-bantuan.index');
        Route::get('laporan-bantuan/dashboard', [\App\Http\Controllers\Admin\AdminLaporanBantuanController::class, 'dashboard'])->name('laporan-bantuan.dashboard');
        Route::get('laporan-bantuan/{id}', [\App\Http\Controllers\Admin\AdminLaporanBantuanController::class, 'show'])->name('laporan-bantuan.show');
        Route::post('laporan-bantuan/{id}/verify', [\App\Http\Controllers\Admin\AdminLaporanBantuanController::class, 'verify'])->name('laporan-bantuan.verify');
        Route::post('laporan-bantuan/{id}/reject', [\App\Http\Controllers\Admin\AdminLaporanBantuanController::class, 'reject'])->name('laporan-bantuan.reject');
        Route::post('laporan-bantuan/{id}/publish', [\App\Http\Controllers\Admin\AdminLaporanBantuanController::class, 'publish'])->name('laporan-bantuan.publish');
        Route::post('laporan-bantuan/{id}/unpublish', [\App\Http\Controllers\Admin\AdminLaporanBantuanController::class, 'unpublish'])->name('laporan-bantuan.unpublish');
    });
    Route::post('/log/error', function (Request $request) {
        \Log::channel('form_errors')->error('Form Validation Error', [
            'form' => $request->form,
            'errors' => $request->errors,
            'input' => $request->input,
            'url' => $request->url,
            'user_agent' => $request->userAgent(),
            'user_id' => auth()->id() ?? 'guest',
        ]);

        return response()->json(['status' => 'logged']);
    })->name('log.error');
});
