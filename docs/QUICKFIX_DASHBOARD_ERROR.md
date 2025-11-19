# Quick Fix - Dashboard Error

## ✅ Error Fixed: Column 'verified_at' not found

### Problem
Dashboard petugas mengalami error karena mencoba mengakses kolom `verified_at` yang tidak ada di tabel `laporans`.

```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'verified_at' in 'where clause'
```

### Root Cause
Di `PetugasController.php`, kode menggunakan:
```php
$laporan_pending = Laporan::whereNull('verified_at')->count();
$laporan_terbaru = Laporan::with('user')->whereNull('verified_at')->latest()->take(5)->get();
```

Namun tabel `laporans` tidak memiliki kolom `verified_at`, melainkan kolom `status`.

### Solution Applied

**File**: `app/Http/Controllers/PetugasController.php`

**Before:**
```php
$laporan_pending = Laporan::whereNull('verified_at')->count();
$laporan_terbaru = Laporan::with('user')
    ->whereNull('verified_at')
    ->latest()
    ->take(5)
    ->get();
```

**After:**
```php
$laporan_pending = Laporan::where('status', 'pending')->count();
$laporan_terbaru = Laporan::with('user')
    ->where('status', 'pending')
    ->latest()
    ->take(5)
    ->get();
```

### Laporan Status Values
Berdasarkan migration, kolom `status` memiliki default value `'pending'`. Nilai yang mungkin:
- `pending` - Laporan baru, belum diverifikasi
- `verified` atau `approved` - Laporan sudah diverifikasi
- `rejected` - Laporan ditolak

### Testing
1. ✅ Clear cache: `php artisan config:clear`
2. ✅ Akses dashboard sebagai petugas
3. ✅ Dashboard harus menampilkan jumlah laporan pending dengan benar

### Related Files
- `app/Http/Controllers/PetugasController.php` - Fixed ✅
- `database/migrations/2025_10_02_065655_create_laporans_table.php` - Reference
- `resources/views/petugas/dashboard.blade.php` - Using the data

### Next Steps
Jika ingin menambahkan verified_at untuk tracking waktu verifikasi:

1. **Create Migration:**
```bash
php artisan make:migration add_verified_at_to_laporans_table
```

2. **Add Column:**
```php
public function up()
{
    Schema::table('laporans', function (Blueprint $table) {
        $table->timestamp('verified_at')->nullable()->after('status');
        $table->foreignId('verified_by')->nullable()->constrained('users')->after('verified_at');
    });
}
```

3. **Update Logic:**
- Saat verifikasi: `$laporan->update(['verified_at' => now(), 'verified_by' => auth()->id()]);`
- Query pending: `Laporan::whereNull('verified_at')->get();`

---

**Status**: ✅ FIXED  
**Date**: November 12, 2025  
**Impact**: Dashboard petugas sekarang berfungsi normal
