# 🌾 Sistem Verifikasi Petani - Panduan Lengkap

## ✅ Masalah Yang Sudah Diperbaiki

### Error: Column 'alamat_kecamatan' not found
**Status**: ✅ **FIXED**

**Penyebab**: Kolom `alamat_kecamatan` dan `telepon` tidak ada di database

**Solusi**:
- Migration baru telah dibuat dan dijalankan
- Kolom `alamat_kecamatan` dan `telepon` berhasil ditambahkan ke tabel `users`
- Sistem sekarang berjalan normal

---

## 🚀 Cara Memulai Sistem

### 1. Pastikan Database Sudah Siap
```bash
# Jika belum ada database, jalankan:
php artisan migrate

# Jika ingin reset database (HATI-HATI: menghapus semua data):
php artisan migrate:fresh
```

### 2. Buat Admin dan Petugas Default
```bash
php artisan db:seed --class=AdminPetugasSeeder
```

### 3. Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 👥 Akun Default

### 👨‍💼 Admin
- **Email**: `admin@pertanian.com`
- **Password**: `admin123`
- **Akses**: Semua fitur sistem termasuk manajemen petugas

### 👨‍🌾 Petugas

#### Petugas Balige
- **Email**: `petugas.balige@pertanian.com`
- **Password**: `petugas123`
- **Daerah**: Balige

#### Petugas Laguboti
- **Email**: `petugas.laguboti@pertanian.com`
- **Password**: `petugas123`
- **Daerah**: Laguboti

#### Petugas Lumban Julu
- **Email**: `petugas.lumbanjulu@pertanian.com`
- **Password**: `petugas123`
- **Daerah**: Lumban Julu

---

## 📝 Cara Testing Sistem Verifikasi

### Test 1: Registrasi Petani Baru
1. Buka browser: `http://127.0.0.1:8000/register`
2. Isi form registrasi:
   - Nama: `Petani Test`
   - Email: `petani@test.com`
   - Password: `12345678`
   - Konfirmasi Password: `12345678`
   - Telepon: `081234567890` (opsional)
   - Desa: `Balige` (atau desa lain)
   - Kecamatan: `Balige` (opsional)
3. Centang "Saya setuju..."
4. Klik **"Daftar Sekarang"**
5. ✅ Anda akan diarahkan ke halaman login dengan pesan sukses

### Test 2: Coba Login (Harus Gagal)
1. Di halaman login, masukkan:
   - Email: `petani@test.com`
   - Password: `12345678`
2. Klik Login
3. ❌ **Harus muncul error**: "Akun Anda belum diverifikasi oleh petugas..."

### Test 3: Login Sebagai Petugas
1. Logout (jika sudah login)
2. Login dengan:
   - Email: `petugas.balige@pertanian.com`
   - Password: `petugas123`
3. ✅ Berhasil login

### Test 4: Verifikasi Petani
1. Setelah login sebagai petugas
2. Klik menu **"Verifikasi Petani"** atau akses: `/petugas/petani`
3. Anda akan melihat daftar petani yang menunggu verifikasi
4. Petani yang baru mendaftar akan ditandai dengan:
   - Badge kuning "Menunggu"
   - Baris tabel berwarna kuning muda
5. Klik tombol **"Detail"** (icon mata) untuk melihat detail
6. Klik tombol **"Verifikasi"** (icon centang hijau)
7. Konfirmasi verifikasi
8. ✅ Petani berhasil diverifikasi!

### Test 5: Login Petani Setelah Verifikasi
1. Logout dari akun petugas
2. Login dengan akun petani:
   - Email: `petani@test.com`
   - Password: `12345678`
3. ✅ **Sekarang berhasil login!**

---

## 🎯 Fitur-Fitur Sistem

### Untuk Admin:
✅ Manajemen Petugas (Tambah, Edit, Hapus)
✅ Lihat semua data sistem
✅ Manajemen berita, galeri, newsletter

### Untuk Petugas:
✅ Verifikasi pendaftaran petani di daerahnya
✅ Tolak pendaftaran petani
✅ Lihat detail petani
✅ Dashboard dengan statistik daerah
✅ Notifikasi pendaftaran petani baru

### Untuk Petani:
✅ Registrasi akun (otomatis role petani)
✅ Menunggu verifikasi dari petugas
✅ Notifikasi saat akun diverifikasi
✅ Login setelah terverifikasi
✅ Akses fitur bantuan dan laporan

---

## 🔐 Keamanan

1. **Registrasi Terbatas**: Hanya untuk role petani
2. **Verifikasi Wajib**: Petani tidak bisa login sebelum diverifikasi
3. **Scope Daerah**: Petugas hanya bisa verifikasi petani di daerahnya
4. **Auto-verified**: Admin dan petugas otomatis terverifikasi

---

## 📊 Struktur Database

### Tabel Users - Kolom Penting:
- `role` - admin / petugas / petani
- `is_verified` - Status verifikasi (true/false)
- `verified_at` - Waktu verifikasi
- `verified_by` - ID petugas yang memverifikasi
- `alamat_desa` - Desa tempat tinggal
- `alamat_kecamatan` - Kecamatan
- `telepon` - Nomor telepon

---

## 🛠️ Troubleshooting

### Error: Column not found
```bash
# Jalankan migration
php artisan migrate
```

### Error: Class not found
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
composer dump-autoload
```

### Lupa Password Admin/Petugas
```bash
# Jalankan ulang seeder
php artisan db:seed --class=AdminPetugasSeeder
```

### Reset Semua Data
```bash
# HATI-HATI: Menghapus semua data!
php artisan migrate:fresh --seed
php artisan db:seed --class=AdminPetugasSeeder
```

---

## 📱 URL Penting

- **Homepage**: `http://127.0.0.1:8000/`
- **Register**: `http://127.0.0.1:8000/register`
- **Login**: `http://127.0.0.1:8000/login`
- **Dashboard**: `http://127.0.0.1:8000/dashboard`
- **Verifikasi Petani (Petugas)**: `http://127.0.0.1:8000/petugas/petani`
- **Manajemen Petugas (Admin)**: `http://127.0.0.1:8000/admin/petugas`

---

## ✨ Fitur Notifikasi

### Notifikasi untuk Petugas:
- 🔔 Notifikasi saat ada petani baru mendaftar
- 📍 Hanya untuk petani di daerah yang sama
- 🔗 Link langsung ke detail petani

### Notifikasi untuk Petani:
- ✅ Notifikasi saat akun diverifikasi
- 👤 Informasi petugas yang memverifikasi
- 🔗 Link ke halaman login

---

## 📞 Support

Jika ada masalah atau pertanyaan, hubungi administrator sistem.

---

**Tanggal Update**: 10 November 2025
**Versi**: 1.0
**Status**: ✅ Production Ready
