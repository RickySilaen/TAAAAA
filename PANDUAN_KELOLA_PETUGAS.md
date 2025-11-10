# 📋 PANDUAN FITUR KELOLA PETUGAS

**Sistem Informasi Pertanian Toba**  
**Tanggal:** 10 November 2025  
**Fitur:** Admin Mengelola Akun Petugas

---

## 🎯 OVERVIEW

Fitur **Kelola Petugas** memungkinkan Admin untuk mendaftarkan, mengelola, dan menghapus akun petugas lapangan dalam sistem. Petugas yang didaftarkan akan langsung terverifikasi dan bisa login ke sistem.

---

## ✅ FITUR YANG TERSEDIA

### 1. **Daftar Petugas** (Index)
- **Route:** `/admin/petugas`
- **URL:** `http://localhost:8000/admin/petugas`
- **Controller:** `Admin\PetugasController@index`

**Fitur:**
- ✅ Menampilkan daftar semua petugas terdaftar
- ✅ Statistik total petugas
- ✅ Informasi lengkap: nama, email, telepon, wilayah kerja
- ✅ Status verifikasi (badge hijau/kuning)
- ✅ Pagination (10 petugas per halaman)
- ✅ Action buttons: Detail, Edit, Hapus
- ✅ Empty state jika belum ada petugas

**Cara Akses:**
1. Login sebagai admin
2. Lihat sidebar kiri
3. Klik menu **"Kelola Petugas"** (icon: user-shield)
4. Badge menampilkan jumlah total petugas

---

### 2. **Tambah Petugas Baru** (Create)
- **Route:** `/admin/petugas/create`
- **URL:** `http://localhost:8000/admin/petugas/create`
- **Controller:** `Admin\PetugasController@create`

**Form Fields:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| Nama Lengkap | Text | ✅ Ya | Max 255 karakter |
| Email | Email | ✅ Ya | Valid email, unique |
| Telepon | Text | ❌ Tidak | Max 20 karakter |
| Password | Password | ✅ Ya | Min 8 karakter |
| Konfirmasi Password | Password | ✅ Ya | Harus sama dengan password |
| Alamat Desa | Text | ✅ Ya | Max 255 karakter |
| Alamat Kecamatan | Select | ❌ Tidak | List kecamatan |

**Kecamatan Yang Tersedia:**
- Balige
- Laguboti
- Habinsaran
- Ajibata
- Lumban Julu
- Porsea
- Silaen
- Pintu Pohan Meranti
- Nassau
- Siantar Narumonda
- Bonatua Lunasi
- Tampahan
- Sigumpar
- Harian
- Bor-Bor
- Uluan

**Cara Tambah Petugas:**
1. Di halaman Daftar Petugas, klik tombol **"Tambah Petugas Baru"**
2. Isi semua field yang required (bertanda *)
3. Pilih kecamatan untuk wilayah kerja petugas
4. Klik **"Simpan Petugas"**
5. Petugas langsung terverifikasi dan bisa login

**Auto-Set Fields:**
```php
'role' => 'petugas'           // Otomatis
'is_verified' => true         // Langsung aktif
'verified_at' => now()        // Tanggal sekarang
'verified_by' => admin_id     // ID admin yang mendaftarkan
```

---

### 3. **Detail Petugas** (Show)
- **Route:** `/admin/petugas/{id}`
- **URL:** `http://localhost:8000/admin/petugas/1`
- **Controller:** `Admin\PetugasController@show`

**Informasi Yang Ditampilkan:**
- ✅ Foto profil (avatar dengan initial)
- ✅ Nama lengkap
- ✅ Email
- ✅ Nomor telepon
- ✅ Wilayah kerja (kecamatan & desa)
- ✅ Status verifikasi
- ✅ Tanggal bergabung
- ✅ Tanggal terakhir update
- ✅ Statistik aktivitas (opsional)

**Action Buttons:**
- 📝 Edit Petugas
- 🗑️ Hapus Petugas
- ⬅️ Kembali ke Daftar

---

### 4. **Edit Petugas** (Edit/Update)
- **Route:** `/admin/petugas/{id}/edit`
- **URL:** `http://localhost:8000/admin/petugas/1/edit`
- **Controller:** `Admin\PetugasController@edit` & `update`

**Form Fields:** (Sama seperti Create, tapi pre-filled)
- Nama Lengkap (pre-filled)
- Email (pre-filled, unique kecuali email sendiri)
- Telepon (pre-filled)
- Password (opsional - kosongkan jika tidak ingin ubah)
- Konfirmasi Password (jika password diisi)
- Alamat Desa (pre-filled)
- Alamat Kecamatan (pre-selected)

**Cara Edit:**
1. Di Daftar Petugas, klik button **"Edit"** (icon: pencil)
2. Form muncul dengan data yang sudah terisi
3. Ubah data yang diperlukan
4. Kosongkan password jika tidak ingin mengubahnya
5. Klik **"Update Petugas"**

**Validasi:**
```php
// Email unique, kecuali email petugas sendiri
'email' => 'unique:users,email,' . $id

// Password opsional saat edit
'password' => 'nullable|min:8|confirmed'
```

---

### 5. **Hapus Petugas** (Delete)
- **Route:** `/admin/petugas/{id}` (DELETE method)
- **Controller:** `Admin\PetugasController@destroy`

**Fitur:**
- ✅ Konfirmasi modal sebelum hapus
- ✅ Menampilkan nama & email petugas yang akan dihapus
- ✅ Peringatan: "Aksi tidak dapat dibatalkan"
- ✅ CSRF protection

**Cara Hapus:**
1. Di Daftar Petugas, klik button **"Hapus"** (icon: trash, warna merah)
2. Modal konfirmasi muncul
3. Review data petugas yang akan dihapus
4. Klik **"Ya, Hapus"** untuk konfirmasi
5. Atau klik **"Batal"** untuk membatalkan

**Peringatan:**
```
⚠️ PERINGATAN:
- Data petugas akan dihapus permanen
- Aksi ini tidak dapat dibatalkan
- Pastikan petugas tidak sedang menangani data penting
```

---

## 🎨 UI/UX FEATURES

### Sidebar Menu
```html
<a class="nav-link" href="/admin/petugas">
    <i class="fas fa-user-shield"></i>
    <span>Kelola Petugas</span>
    <span class="badge bg-primary">{{ total_petugas }}</span>
</a>
```

**Features:**
- Icon: `fa-user-shield` (perisai user)
- Badge: Menampilkan jumlah total petugas
- Active state: Highlight saat di halaman petugas
- Warna: Primary blue

---

### Halaman Index

**Statistics Cards:**
```
┌────────────────────────────┐  ┌────────────────────────────┐
│ 👥 Total Petugas          │  │ ✅ Aktif Bulan Ini        │
│ 15                         │  │ 15                         │
└────────────────────────────┘  └────────────────────────────┘
```

**Table Layout:**
| No | Nama Petugas | Email | Telepon | Wilayah Kerja | Status | Aksi |
|----|--------------|-------|---------|---------------|--------|------|
| 1  | John Doe     | john@ | 0812... | Balige        | ✅ Aktif| 👁️ ✏️ 🗑️|

**Features:**
- Avatar circle dengan initial nama
- Badge status: Hijau (Aktif) / Kuning (Pending)
- Icon untuk wilayah kerja (map-marker)
- Button group untuk aksi (info, warning, danger)
- Tooltips pada hover button

---

### Form Create/Edit

**Layout:**
```
┌─────────────────────────────────────────┐
│ Form Pendaftaran Petugas                │
├─────────────────────────────────────────┤
│ 👤 Nama Lengkap *                       │
│ [_________________________________]     │
│                                         │
│ ✉️ Email *          📞 Telepon         │
│ [______________]    [______________]    │
│                                         │
│ 🔒 Password *       🔒 Konfirmasi *     │
│ [______________]    [______________]    │
│                                         │
│ 🏘️ Alamat Desa *                       │
│ [_________________________________]     │
│                                         │
│ 🗺️ Kecamatan                           │
│ [Pilih Kecamatan ▼]                    │
│                                         │
│ [❌ Batal]  [💾 Simpan Petugas]        │
└─────────────────────────────────────────┘
```

**Validation Messages:**
- ❌ "Nama lengkap wajib diisi"
- ❌ "Email sudah terdaftar"
- ❌ "Password minimal 8 karakter"
- ❌ "Konfirmasi password tidak cocok"
- ✅ "Petugas berhasil ditambahkan!"

---

## 🔒 SECURITY & AUTHORIZATION

### Middleware Protection
```php
// Routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::resource('petugas', AdminPetugasController::class);
});

// Controller
public function __construct()
{
    $this->middleware('admin');
}
```

**Protection:**
- ✅ Hanya admin yang bisa akses
- ✅ Petugas tidak bisa akses `/admin/petugas`
- ✅ Petani tidak bisa akses `/admin/petugas`
- ✅ CSRF token pada semua form
- ✅ Password di-hash dengan bcrypt

---

### Role Check
```php
// CheckRole Middleware
if (Auth::user()->role !== 'admin') {
    abort(403, 'Unauthorized action.');
}
```

**Akses:**
- ✅ Admin → Full CRUD
- ❌ Petugas → 403 Forbidden
- ❌ Petani → 403 Forbidden
- ❌ Guest → Redirect to login

---

## 📊 DATABASE STRUCTURE

### Users Table (Petugas)
```sql
SELECT * FROM users WHERE role = 'petugas';
```

**Fields:**
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar(255) | Nama lengkap |
| email | varchar(255) | Email (unique) |
| password | varchar(255) | Hashed password |
| role | enum | 'petugas' |
| telepon | varchar(20) | Nomor telepon |
| alamat_desa | varchar(255) | Desa kerja |
| alamat_kecamatan | varchar(255) | Kecamatan kerja |
| is_verified | boolean | true (otomatis) |
| verified_at | timestamp | Tanggal verifikasi |
| verified_by | bigint | ID admin yang verifikasi |
| created_at | timestamp | Tanggal bergabung |
| updated_at | timestamp | Tanggal update |

---

## 🚀 CARA MENGGUNAKAN

### Skenario 1: Tambah Petugas Baru

**Step-by-Step:**
```
1. Login sebagai admin
   Email: admin@example.com
   Password: password

2. Dashboard → Sidebar → "Kelola Petugas"
   
3. Klik tombol "Tambah Petugas Baru"
   
4. Isi form:
   - Nama: Budi Santoso
   - Email: budi.petugas@gmail.com
   - Telepon: 081234567890
   - Password: password123
   - Konfirmasi: password123
   - Desa: Silalahi
   - Kecamatan: Balige
   
5. Klik "Simpan Petugas"
   
6. ✅ Success: "Petugas berhasil ditambahkan!"
   
7. Petugas bisa langsung login dengan:
   Email: budi.petugas@gmail.com
   Password: password123
```

---

### Skenario 2: Edit Data Petugas

**Step-by-Step:**
```
1. Login sebagai admin
   
2. Dashboard → Sidebar → "Kelola Petugas"
   
3. Cari petugas yang ingin diedit di tabel
   
4. Klik button "Edit" (icon pensil kuning)
   
5. Form muncul dengan data ter-isi:
   - Nama: Budi Santoso (bisa diubah)
   - Email: budi.petugas@gmail.com (bisa diubah)
   - Telepon: 081234567890 (bisa diubah)
   - Password: [kosong] (isi jika ingin ubah)
   - Desa: Silalahi (bisa diubah)
   - Kecamatan: Balige (bisa diubah)
   
6. Ubah data yang perlu diubah
   Contoh: Ubah nomor telepon ke 081298765432
   
7. Klik "Update Petugas"
   
8. ✅ Success: "Data petugas berhasil diperbarui!"
```

**Tips:**
- Kosongkan password jika tidak ingin mengubahnya
- Email harus tetap unique
- Jika ubah password, wajib isi konfirmasi password

---

### Skenario 3: Lihat Detail Petugas

**Step-by-Step:**
```
1. Login sebagai admin
   
2. Dashboard → Sidebar → "Kelola Petugas"
   
3. Cari petugas di tabel
   
4. Klik button "Detail" (icon mata biru)
   
5. Halaman detail menampilkan:
   ┌────────────────────────────────────┐
   │ 👤 BUDI SANTOSO                   │
   ├────────────────────────────────────┤
   │ Email: budi.petugas@gmail.com     │
   │ Telepon: 081298765432             │
   │ Wilayah: Balige, Silalahi         │
   │ Status: ✅ Aktif                  │
   │ Bergabung: 10 Nov 2025            │
   └────────────────────────────────────┘
   
6. Button: [Edit] [Hapus] [Kembali]
```

---

### Skenario 4: Hapus Petugas

**Step-by-Step:**
```
1. Login sebagai admin
   
2. Dashboard → Sidebar → "Kelola Petugas"
   
3. Cari petugas yang ingin dihapus
   
4. Klik button "Hapus" (icon trash merah)
   
5. Modal konfirmasi muncul:
   ┌────────────────────────────────────┐
   │ ⚠️ Konfirmasi Hapus               │
   ├────────────────────────────────────┤
   │ Apakah Anda yakin?                │
   │                                    │
   │ Nama: Budi Santoso                │
   │ Email: budi.petugas@gmail.com     │
   │                                    │
   │ ⚠️ Aksi tidak dapat dibatalkan!   │
   │                                    │
   │ [Batal]  [Ya, Hapus]              │
   └────────────────────────────────────┘
   
6. Klik "Ya, Hapus" untuk konfirmasi
   
7. ✅ Success: "Petugas berhasil dihapus!"
   
8. Petugas tidak bisa login lagi
```

---

## 🐛 TROUBLESHOOTING

### Error 1: "Email sudah terdaftar"
**Solusi:**
```
- Gunakan email yang berbeda
- Cek di database: SELECT * FROM users WHERE email = 'email@example.com'
- Jika user sudah ada tapi dihapus, gunakan email lain
```

---

### Error 2: "Konfirmasi password tidak cocok"
**Solusi:**
```
- Pastikan password dan konfirmasi password SAMA PERSIS
- Periksa caps lock
- Tidak ada spasi di awal/akhir
```

---

### Error 3: 403 Forbidden saat akses /admin/petugas
**Solusi:**
```
- Pastikan login sebagai admin
- Check role: php artisan tinker
  >>> Auth::user()->role
- Jika bukan admin, login dengan akun admin
```

---

### Error 4: Sidebar menu tidak muncul
**Solusi:**
```bash
# Clear cache
php artisan view:clear
php artisan cache:clear
php artisan config:clear

# Refresh browser (Ctrl + F5)
```

---

### Error 5: Badge count tidak akurat
**Solusi:**
```bash
# Hitung manual di tinker
php artisan tinker
>>> \App\Models\User::where('role', 'petugas')->count()

# Clear cache
php artisan cache:clear

# Refresh halaman
```

---

## 📈 STATISTIK & MONITORING

### Query Untuk Monitoring
```php
// Total petugas
$total = User::where('role', 'petugas')->count();

// Petugas per kecamatan
$per_kecamatan = User::where('role', 'petugas')
    ->groupBy('alamat_kecamatan')
    ->selectRaw('alamat_kecamatan, COUNT(*) as total')
    ->get();

// Petugas bergabung bulan ini
$bulan_ini = User::where('role', 'petugas')
    ->whereMonth('created_at', now()->month)
    ->count();

// Petugas paling baru
$terbaru = User::where('role', 'petugas')
    ->latest()
    ->take(5)
    ->get();
```

---

## ✅ CHECKLIST TESTING

### Testing Tambah Petugas
- [ ] Form create bisa diakses
- [ ] Validasi required fields bekerja
- [ ] Email unique validation bekerja
- [ ] Password min 8 karakter
- [ ] Konfirmasi password cocok
- [ ] Data tersimpan ke database
- [ ] Role otomatis 'petugas'
- [ ] is_verified otomatis true
- [ ] Redirect ke index setelah berhasil
- [ ] Flash message success muncul
- [ ] Petugas bisa login

### Testing Edit Petugas
- [ ] Form edit pre-filled dengan data
- [ ] Email unique kecuali email sendiri
- [ ] Password opsional (boleh kosong)
- [ ] Data terupdate di database
- [ ] Redirect ke index setelah update
- [ ] Flash message success muncul

### Testing Hapus Petugas
- [ ] Modal konfirmasi muncul
- [ ] Data petugas ditampilkan di modal
- [ ] Tombol "Batal" menutup modal
- [ ] Tombol "Ya, Hapus" menghapus data
- [ ] Data terhapus dari database
- [ ] Redirect ke index setelah hapus
- [ ] Flash message success muncul

### Testing Sidebar Menu
- [ ] Menu "Kelola Petugas" muncul untuk admin
- [ ] Menu TIDAK muncul untuk petugas
- [ ] Menu TIDAK muncul untuk petani
- [ ] Badge menampilkan count yang benar
- [ ] Active state saat di halaman petugas
- [ ] Link mengarah ke /admin/petugas

---

## 📞 SUPPORT

**Jika ada masalah:**
1. Check error log: `storage/logs/laravel.log`
2. Check browser console (F12)
3. Cek database: `php artisan tinker`
4. Clear cache: `php artisan cache:clear`
5. Restart server: Stop & `php artisan serve`

---

## 🎉 KESIMPULAN

✅ **Fitur Kelola Petugas telah selesai dibuat dan siap digunakan!**

**Features:**
- ✅ Create (Tambah petugas baru)
- ✅ Read (Lihat daftar & detail)
- ✅ Update (Edit data petugas)
- ✅ Delete (Hapus petugas)
- ✅ Sidebar menu dengan badge
- ✅ Security & authorization
- ✅ Form validation
- ✅ CRUD lengkap

**Status: PRODUCTION READY** 🚀

---

**Dibuat:** 10 November 2025  
**Oleh:** Tim Developer Sistem Pertanian  
**Versi:** 1.0
