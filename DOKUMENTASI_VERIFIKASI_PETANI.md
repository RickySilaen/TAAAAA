# Dokumentasi Sistem Verifikasi Petani

## 📋 Overview
Sistem verifikasi akun petani telah berhasil diimplementasikan. Setiap petani yang mendaftar harus diverifikasi oleh petugas daerah sebelum dapat login ke sistem.

## 🔄 Alur Proses Verifikasi

### 1. **Pendaftaran Petani**
- Petani mengakses halaman `/register`
- Mengisi formulir pendaftaran (nama, email, password, telepon, desa, kecamatan)
- Role otomatis diset sebagai **"petani"**
- Status akun: `is_verified = false` (belum terverifikasi)
- Setelah submit, diarahkan ke halaman login dengan pesan:
  > "Pendaftaran berhasil! Akun Anda akan segera diverifikasi oleh petugas daerah. Silakan tunggu konfirmasi sebelum login."

### 2. **Notifikasi ke Petugas**
- Sistem otomatis mengirim notifikasi ke petugas yang bertugas di desa yang sama dengan petani
- Jika tidak ada petugas di desa tersebut, notifikasi dikirim ke semua petugas
- Notifikasi berisi:
  - Nama petani
  - Email petani
  - Desa petani
  - Link untuk melihat detail dan verifikasi

### 3. **Verifikasi oleh Petugas**
- Petugas login ke sistem
- Mengakses menu **"Verifikasi Petani"** (`/petugas/petani`)
- Melihat daftar petani yang menunggu verifikasi (ditandai dengan badge kuning)
- Dapat melakukan:
  - **Verifikasi**: Menyetujui akun petani
  - **Tolak**: Menolak dan menghapus pendaftaran petani
  
### 4. **Setelah Verifikasi**
- Status akun petani: `is_verified = true`
- Dicatat waktu verifikasi (`verified_at`) dan petugas yang memverifikasi (`verified_by`)
- Petani menerima notifikasi bahwa akun telah diverifikasi
- Petani dapat login ke sistem

### 5. **Login Petani**
- Petani yang **belum terverifikasi** tidak dapat login
- Akan muncul pesan error:
  > "Akun Anda belum diverifikasi oleh petugas. Silakan tunggu konfirmasi dari petugas daerah Anda."
- Petani yang **sudah terverifikasi** dapat login normal

## 🗄️ Database Schema

### Kolom Baru di Tabel `users`:
```sql
- is_verified (boolean) - Status verifikasi akun
- verified_at (timestamp) - Waktu akun diverifikasi
- verified_by (bigint) - ID petugas yang memverifikasi (foreign key ke users.id)
```

## 🎯 Routes

### Petugas Routes:
```php
GET  /petugas/petani              - Daftar petani untuk verifikasi
GET  /petugas/petani/{id}         - Detail petani
POST /petugas/petani/{id}/verify  - Verifikasi akun petani
DELETE /petugas/petani/{id}/reject - Tolak dan hapus pendaftaran
```

## 🔔 Notifikasi

### 1. PetaniRegistered (untuk Petugas)
**Kapan**: Saat ada petani baru mendaftar
**Dikirim ke**: Petugas di desa yang sama / semua petugas
**Isi**:
- Judul: "Pendaftaran Petani Baru"
- Pesan: Informasi petani yang mendaftar
- Action: Link ke detail petani

### 2. PetaniVerified (untuk Petani)
**Kapan**: Saat akun petani diverifikasi
**Dikirim ke**: Petani yang baru diverifikasi
**Isi**:
- Judul: "Akun Terverifikasi"
- Pesan: Informasi bahwa akun telah diverifikasi
- Action: Link ke halaman login

## 📱 Fitur Utama

### Untuk Petugas:
1. **Dashboard**: Menampilkan jumlah petani yang menunggu verifikasi
2. **Daftar Petani**: 
   - Tabel dengan filter status verifikasi
   - Badge kuning untuk petani belum terverifikasi
   - Badge hijau untuk petani terverifikasi
3. **Detail Petani**:
   - Informasi lengkap petani
   - Riwayat aktivitas
   - Tombol verifikasi/tolak (jika belum terverifikasi)

### Untuk Petani:
1. **Form Registrasi**: 
   - Otomatis role petani
   - Informasi tentang proses verifikasi
2. **Notifikasi**: Mendapat notifikasi saat akun diverifikasi
3. **Login**: Hanya bisa login setelah terverifikasi

### Untuk Admin:
1. **Manajemen Petugas**:
   - Tambah petugas (otomatis terverifikasi)
   - Edit petugas
   - Hapus petugas
2. Akun admin otomatis terverifikasi

## 🔒 Keamanan

1. **Middleware Protection**: 
   - Hanya petugas yang dapat mengakses menu verifikasi
   - Petugas hanya bisa verifikasi petani di daerahnya

2. **Login Validation**:
   - Petani belum terverifikasi tidak bisa login
   - Pesan error yang informatif

3. **Auto-verified**:
   - Admin otomatis terverifikasi
   - Petugas yang didaftarkan admin otomatis terverifikasi

## 📊 Status & Badge

- 🟡 **Belum Terverifikasi**: Badge kuning dengan icon jam
- 🟢 **Terverifikasi**: Badge hijau dengan icon centang
- 🔴 **Ditolak**: Akun dihapus dari sistem

## 💡 Tips Penggunaan

### Untuk Petugas:
1. Cek notifikasi secara berkala untuk pendaftaran baru
2. Verifikasi data petani sebelum menyetujui
3. Gunakan tombol "Detail" untuk melihat informasi lengkap

### Untuk Petani:
1. Pastikan data yang diisi benar dan lengkap
2. Tunggu notifikasi verifikasi sebelum mencoba login
3. Hubungi petugas daerah jika verifikasi terlalu lama

### Untuk Admin:
1. Pastikan ada petugas di setiap desa
2. Monitor jumlah petani yang menunggu verifikasi
3. Daftarkan petugas baru jika diperlukan

## 🚀 Migration

Untuk menerapkan fitur ini di server production:

```bash
# 1. Jalankan migration
php artisan migrate

# 2. Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 3. Optimize
php artisan optimize
```

## 📝 Catatan Penting

1. **Data Existing**: Petani yang sudah terdaftar sebelumnya perlu di-update manual:
   ```sql
   UPDATE users 
   SET is_verified = 1, verified_at = NOW() 
   WHERE role = 'petani';
   ```

2. **Admin & Petugas**: Otomatis terverifikasi saat dibuat

3. **Notifikasi Database**: Menggunakan database channel (tidak email)

4. **Soft Delete**: Saat pendaftaran ditolak, akun langsung dihapus (bukan soft delete)

## 🎨 UI/UX

- Halaman register: Info box tentang proses verifikasi
- Halaman login: Pesan error yang jelas untuk akun belum terverifikasi
- Dashboard petugas: Statistik petani menunggu verifikasi
- Highlight visual: Baris tabel berwarna kuning untuk petani belum verifikasi

---

**Tanggal Implementasi**: 10 November 2025
**Versi**: 1.0
**Status**: ✅ Production Ready
