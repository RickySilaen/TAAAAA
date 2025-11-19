# PANDUAN LENGKAP - Fitur Verifikasi Petani untuk Petugas

**Tanggal:** 10 November 2025  
**Versi:** 1.0  
**Status:** ✅ Lengkap dan Siap Digunakan

---

## 📋 Daftar Isi
1. [Ringkasan Fitur](#ringkasan-fitur)
2. [Cara Akses Fitur](#cara-akses-fitur)
3. [Langkah-langkah Verifikasi](#langkah-langkah-verifikasi)
4. [Langkah-langkah Penolakan](#langkah-langkah-penolakan)
5. [Tampilan UI](#tampilan-ui)
6. [Troubleshooting](#troubleshooting)

---

## 🎯 Ringkasan Fitur

### Apa yang Bisa Dilakukan Petugas?

Petugas dapat:
- ✅ **Melihat daftar petani** yang mendaftar di wilayah kerjanya (berdasarkan kecamatan)
- ✅ **Memverifikasi akun petani** agar bisa login dan menggunakan sistem
- ✅ **Menolak pendaftaran** petani yang tidak memenuhi syarat
- ✅ **Melihat detail lengkap** informasi petani sebelum memverifikasi
- ✅ **Mendapat notifikasi** saat ada pendaftaran petani baru

### Filter Wilayah
- Petugas hanya melihat petani dari **kecamatan yang sama**
- Jika `alamat_kecamatan` tidak diisi, petugas akan melihat **semua petani**
- Sistem otomatis filter berdasarkan data `alamat_kecamatan` di tabel `users`

---

## 🚪 Cara Akses Fitur

### 1. Login sebagai Petugas

```
Email: petugas@balige.com (contoh)
Password: password (sesuai yang dibuat admin)
```

### 2. Akses Melalui Menu

Ada **3 cara** untuk mengakses fitur verifikasi petani:

#### A. Melalui Sidebar Menu
1. Login sebagai petugas
2. Klik hamburger menu (☰) di kiri atas
3. Sidebar akan terbuka, klik **"Verifikasi Petani"**
4. Badge merah akan muncul jika ada petani yang belum diverifikasi

```
📱 Sidebar Menu:
├── Dashboard
├── Verifikasi Petani [badge: 2] ← KLIK DI SINI
├── Verifikasi Laporan
├── Kelola Bantuan
└── Monitoring Wilayah
```

#### B. Melalui Dashboard - Card Statistik
1. Setelah login, Anda di dashboard petugas
2. Lihat card **"Perlu Verifikasi"** (warna merah)
3. Angka menunjukkan jumlah petani belum diverifikasi
4. Klik card tersebut untuk langsung ke halaman verifikasi

```
📊 Dashboard Cards:
┌─────────────┬──────────────────┬─────────────┬──────────────┐
│ Petani Aktif│ Perlu Verifikasi │Total Laporan│ Total Bantuan│
│     15      │       2          │     42      │      8       │
│             │   [KLIK DISINI]  │             │              │
└─────────────┴──────────────────┴─────────────┴──────────────┘
```

#### C. Melalui Dashboard - Aksi Cepat
1. Di dashboard, lihat panel **"Aksi Cepat"** (kanan atas)
2. Klik tombol merah **"Verifikasi Petani"** dengan badge angka
3. Jika tidak ada yang perlu diverifikasi, tombol akan berwarna outline

```
🎯 Aksi Cepat:
┌────────────────────────────────┐
│ Verifikasi Petani [2]          │ ← Merah dengan badge
│ Verifikasi Laporan             │
│ Kelola Bantuan                 │
│ Monitoring Wilayah             │
└────────────────────────────────┘
```

---

## ✅ Langkah-langkah Verifikasi Petani

### Step 1: Buka Halaman Daftar Petani
- Akses melalui salah satu cara di atas
- Anda akan melihat tabel daftar petani

### Step 2: Lihat Informasi Petani

Tabel menampilkan:
| Kolom | Keterangan |
|-------|------------|
| Foto Profil | Avatar atau inisial nama |
| Nama | Nama lengkap petani |
| Email | Email pendaftaran |
| Desa | Alamat desa petani |
| Kecamatan | Alamat kecamatan petani |
| Telepon | Nomor telepon |
| Status | Badge: Belum Verifikasi (merah) / Terverifikasi (hijau) |
| Aksi | Tombol Lihat Detail / Verifikasi / Tolak |

### Step 3A: Verifikasi dari Halaman List (Cepat)

1. **Klik tombol "Verifikasi Akun"** (hijau) pada baris petani
2. **Modal konfirmasi muncul** dengan informasi:
   - Foto profil petani
   - Nama lengkap
   - Email
   - Detail alamat (desa, kecamatan)
   - Telepon
   - Tanggal pendaftaran
3. **Baca peringatan**: "Setelah diverifikasi, petani akan mendapat notifikasi dan dapat login"
4. **Klik "Ya, Verifikasi Sekarang"** untuk konfirmasi
5. **Atau klik "Batal"** untuk membatalkan

```
Modal Konfirmasi:
┌────────────────────────────────────────┐
│ ✅ Konfirmasi Verifikasi Akun          │
├────────────────────────────────────────┤
│        [Foto Profil Petani]            │
│     Muhammad Iskandar                  │
│   muhammad.iskandar@email.com          │
│                                        │
│  Desa: Desa X | Kecamatan: Kecamatan A│
│  Telepon: 081234567890                 │
│  Terdaftar: 10/11/2025                 │
│                                        │
│  ℹ️ Setelah diverifikasi, petani akan │
│     mendapat notifikasi dan bisa login│
│                                        │
│  [Batal] [Ya, Verifikasi Sekarang]    │
└────────────────────────────────────────┘
```

### Step 3B: Verifikasi dari Halaman Detail (Lengkap)

1. **Klik tombol "Lihat Detail"** pada baris petani
2. Halaman detail petani terbuka dengan informasi lengkap:
   - Foto profil besar
   - Data pribadi lengkap
   - Riwayat pendaftaran
3. **Scroll ke bawah**, lihat tombol **"Verifikasi Akun"** (hijau)
4. **Klik tombol**, modal konfirmasi muncul (sama seperti step 3A)
5. **Konfirmasi** untuk verifikasi

### Step 4: Hasil Verifikasi

Setelah klik "Ya, Verifikasi Sekarang":

1. ✅ **Status berubah** dari "Belum Verifikasi" → "Terverifikasi"
2. ✅ **Database update**:
   - `is_verified = true`
   - `verified_at = waktu sekarang`
   - `verified_by = ID petugas`
3. ✅ **Notifikasi dikirim** ke petani:
   - Icon: ✅ (check)
   - Judul: "Akun Terverifikasi"
   - Pesan: "Akun Anda telah diverifikasi oleh petugas. Sekarang Anda bisa login."
4. ✅ **Redirect ke halaman list** dengan pesan sukses:
   ```
   ✅ Akun petani Muhammad Iskandar berhasil diverifikasi!
   ```
5. ✅ **Petani bisa login** menggunakan email dan password yang didaftarkan

---

## ❌ Langkah-langkah Penolakan Petani

### Step 1: Buka Modal Penolakan

Dari halaman list atau detail, klik tombol **"Tolak Pendaftaran"** (merah)

### Step 2: Baca Peringatan dengan Teliti

Modal penolakan akan muncul dengan **peringatan bahaya**:

```
Modal Penolakan:
┌────────────────────────────────────────┐
│ ⚠️ Konfirmasi Penolakan                │
├────────────────────────────────────────┤
│        [Foto Profil Petani]            │
│     Muhammad Iskandar                  │
│   muhammad.iskandar@email.com          │
│                                        │
│  ⚠️ Yakin ingin menolak pendaftaran?  │
│                                        │
│  ⚠️ PERHATIAN!                         │
│  • Akun akan dihapus permanen         │
│  • Data tidak dapat dipulihkan        │
│  • Petani harus daftar ulang          │
│                                        │
│  [Batal, Kembali] [Ya, Tolak & Hapus] │
└────────────────────────────────────────┘
```

### Step 3: Konfirmasi Penolakan

1. **Pastikan Anda yakin** - tindakan ini **TIDAK BISA DIBATALKAN**
2. Klik **"Ya, Tolak & Hapus"** untuk melanjutkan
3. Atau klik **"Batal, Kembali"** untuk membatalkan

### Step 4: Hasil Penolakan

Setelah konfirmasi:

1. ❌ **Akun petani dihapus** dari database
2. ❌ **Semua data terkait** (jika ada) akan hilang
3. ✅ **Redirect ke halaman list** dengan pesan:
   ```
   ✅ Pendaftaran petani Muhammad Iskandar ditolak dan akun dihapus.
   ```
4. ❌ **Petani TIDAK mendapat notifikasi** (karena akun sudah dihapus)
5. ❌ **Petani harus daftar ulang** jika ingin masuk sistem lagi

---

## 🎨 Tampilan UI

### 1. Halaman Daftar Petani (`petugas/petani/index.blade.php`)

**Header:**
- Judul: "Daftar Petani"
- Subtitle: Menampilkan kecamatan petugas
- Statistik: Total petani vs Belum verifikasi

**Filter (Opsional - Bisa Ditambahkan):**
- Filter by status: Semua / Belum Verifikasi / Terverifikasi
- Search: Cari berdasarkan nama atau email

**Tabel:**
- Responsive design
- Hover effect pada baris
- Color coding:
  - Baris petani belum verifikasi: background kuning muda
  - Baris petani terverifikasi: background putih
- Badge status:
  - Belum Verifikasi: Badge merah
  - Terverifikasi: Badge hijau

**Tombol Aksi:**
- Lihat Detail: Outline primary (biru)
- Verifikasi Akun: Solid success (hijau) - hanya muncul jika belum verifikasi
- Tolak Pendaftaran: Outline danger (merah) - hanya muncul jika belum verifikasi

### 2. Modal Konfirmasi Verifikasi

**Design:**
- Header: Background hijau dengan icon ✅
- Body: White background
- Informasi petani dalam card border
- Alert box hijau dengan info konsekuensi
- Footer: Button secondary (batal) dan success (verifikasi)

**Animasi:**
- Fade in saat muncul
- Centered di layar
- Backdrop dengan opacity 0.5

### 3. Modal Konfirmasi Penolakan

**Design:**
- Header: Background merah dengan icon ⚠️
- Body: White background
- Alert box merah dengan warning
- Bullet points untuk konsekuensi
- Footer: Button secondary (batal) dan danger (hapus)

**Animasi:**
- Fade in dengan shake effect (opsional)
- Centered di layar
- Backdrop merah dengan opacity 0.6

---

## 🔧 Troubleshooting

### Masalah 1: Menu "Verifikasi Petani" Tidak Muncul

**Penyebab:**
- Anda login sebagai petani atau admin, bukan petugas
- Sidebar belum terbuka

**Solusi:**
1. Pastikan login sebagai petugas
2. Klik icon hamburger (☰) untuk buka sidebar
3. Clear cache: `php artisan optimize:clear`

### Masalah 2: Tidak Ada Petani yang Muncul

**Penyebab:**
- Belum ada petani yang mendaftar
- Filter kecamatan tidak cocok
- Alamat kecamatan petugas kosong

**Solusi:**
1. Cek database: `SELECT * FROM users WHERE role='petani' AND is_verified=false`
2. Pastikan `alamat_kecamatan` petugas dan petani cocok
3. Jika kecamatan petugas kosong, sistem akan tampilkan semua petani

**Check dengan script:**
```bash
php check_verifikasi.php
```

### Masalah 3: Error 403 Saat Klik Verifikasi

**Penyebab:**
- Middleware `petugas` memblokir akses
- Role user bukan petugas

**Solusi:**
1. Logout dan login ulang
2. Pastikan di database: `SELECT role FROM users WHERE id=X` → harus 'petugas'
3. Clear session: `php artisan cache:clear`

### Masalah 4: Modal Tidak Muncul

**Penyebab:**
- JavaScript Bootstrap belum load
- Conflict dengan library lain

**Solusi:**
1. Refresh halaman (F5)
2. Clear browser cache (Ctrl+Shift+Delete)
3. Cek console browser untuk error JavaScript
4. Pastikan Bootstrap 5.3.3 sudah load di `app.blade.php`

### Masalah 5: Petani Sudah Diverifikasi Tapi Masih Tidak Bisa Login

**Penyebab:**
- Cache belum clear
- Kolom `is_verified` masih false di database

**Solusi:**
1. Cek database:
   ```sql
   SELECT id, name, email, is_verified, verified_at 
   FROM users 
   WHERE email='email.petani@example.com';
   ```
2. Jika `is_verified` masih 0, update manual:
   ```bash
   php artisan tinker --execute="User::where('email', 'email@example.com')->update(['is_verified' => true]);"
   ```
3. Clear semua cache:
   ```bash
   php artisan optimize:clear
   ```

### Masalah 6: Notifikasi Tidak Terkirim ke Petani

**Penyebab:**
- Notification class error
- Queue belum dijalankan (jika pakai queue)

**Solusi:**
1. Cek tabel notifications:
   ```sql
   SELECT * FROM notifications WHERE notifiable_id=X ORDER BY created_at DESC LIMIT 5;
   ```
2. Pastikan file `app/Notifications/PetaniVerified.php` ada
3. Jika pakai queue, jalankan worker:
   ```bash
   php artisan queue:work
   ```
4. Jika tidak pakai queue, pastikan notification channel 'database' aktif

---

## 📊 Data Flow Diagram

```
ALUR VERIFIKASI PETANI:

1. PENDAFTARAN
   Petani → Form Register → RegisterController
   ↓
   Create User (is_verified=false)
   ↓
   Kirim Notifikasi ke Petugas Kecamatan

2. LOGIN DITOLAK
   Petani Login → LoginController
   ↓
   Check is_verified == false?
   ↓
   Redirect dengan error: "Akun belum diverifikasi"

3. PETUGAS VERIFIKASI
   Petugas Login → Dashboard → Verifikasi Petani
   ↓
   Lihat Daftar Petani (filter kecamatan)
   ↓
   Klik Verifikasi → Modal Konfirmasi
   ↓
   Konfirmasi → PetugasController@petaniVerify
   ↓
   Update User (is_verified=true, verified_at, verified_by)
   ↓
   Kirim Notifikasi ke Petani

4. LOGIN BERHASIL
   Petani Login → LoginController
   ↓
   Check is_verified == true?
   ↓
   Redirect ke Dashboard Petani ✅
```

---

## 📝 Checklist untuk Admin

Sebelum deploy ke production, pastikan:

- [ ] Semua petugas sudah terverifikasi (`is_verified=true`)
- [ ] Kolom `alamat_kecamatan` terisi untuk semua petugas
- [ ] Route `petugas.petani.*` sudah ditest
- [ ] Middleware `petugas` berfungsi dengan benar
- [ ] Notification system aktif
- [ ] Modal Bootstrap berfungsi di semua browser
- [ ] Responsive design sudah dicek (mobile, tablet, desktop)
- [ ] Pesan error sudah user-friendly
- [ ] Dokumentasi sudah dibaca oleh petugas

---

## 🚀 Demo Akun

Untuk testing, gunakan akun berikut:

### Petugas (Untuk Verifikasi)
```
Email: petugas@balige.com
Password: password
Kecamatan: Kecamatan Balige
```

### Petani (Belum Verifikasi)
```
Email: muhammad.erick@example.com
Password: password
Status: Belum Verifikasi
Kecamatan: Kecamatan Balige
```

**Cara Test:**
1. Login sebagai petugas@balige.com
2. Buka menu "Verifikasi Petani"
3. Cari "muhammad erick"
4. Klik "Verifikasi Akun"
5. Konfirmasi di modal
6. Logout petugas
7. Login sebagai muhammad.erick@example.com ✅ (seharusnya berhasil)

---

## 📞 Kontak Support

Jika mengalami masalah yang tidak tercantum di dokumentasi ini:

1. **Cek file log**: `storage/logs/laravel.log`
2. **Jalankan debugging script**: `php check_verifikasi.php`
3. **Screenshot error** dan kirim ke developer
4. **Sertakan informasi**:
   - Akun yang digunakan (email)
   - Langkah-langkah yang dilakukan
   - Pesan error yang muncul
   - Browser dan versi yang digunakan

---

**Dokumentasi dibuat oleh:** Tim Developer Sistem Pertanian  
**Terakhir diupdate:** 10 November 2025  
**Versi:** 1.0  
**Status:** ✅ Production Ready
