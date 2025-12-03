# 🌾 Fitur Pelaporan Real-Time & Transparansi Bantuan Pertanian

## 📋 Deskripsi Fitur

Sistem pelaporan bantuan pertanian yang transparan dan real-time dengan fitur upload foto bukti. Laporan akan ditampilkan di dashboard publik setelah diverifikasi, memberikan transparansi penuh kepada masyarakat tentang penyaluran bantuan pertanian.

## ✨ Fitur Utama

### 1. **Pelaporan Bantuan oleh Petani**
- ✅ Form pelaporan dengan upload multiple foto bukti (max 5 foto @ 5MB)
- ✅ Informasi lengkap: judul, jenis bantuan, jumlah, deskripsi, tanggal penerimaan
- ✅ Preview foto sebelum upload
- ✅ Link ke pengajuan bantuan (opsional)
- ✅ Pilihan publikasi di dashboard publik

### 2. **Dashboard Transparansi Publik**
- ✅ Tampilan modern dan responsif
- ✅ Filter berdasarkan jenis bantuan dan pencarian keyword
- ✅ Statistik real-time (total laporan, jenis bantuan, petani terdaftar)
- ✅ Gallery view dengan foto bukti
- ✅ Detail laporan lengkap dengan lightbox untuk foto
- ✅ Share ke media sosial (Facebook, Twitter, WhatsApp)
- ✅ Counter views untuk setiap laporan

### 3. **Alat Bantu Pengambilan Keputusan (Admin)**
- ✅ Dashboard analitik komprehensif
- ✅ Statistik dan metrik kinerja:
  - Total laporan by periode (minggu/bulan/tahun)
  - Tingkat verifikasi, publikasi, dan penolakan
  - Laporan per jenis bantuan
  - Top 10 desa paling aktif
  - Laporan terbaru
- ✅ Insights otomatis dengan rekomendasi:
  - Jenis bantuan terpopuler
  - Alert untuk laporan pending
  - Desa dengan partisipasi tertinggi
  - Warning tingkat penolakan tinggi
- ✅ Filter periode (minggu/bulan/tahun/semua)
- ✅ Quick actions untuk verifikasi dan publikasi

### 4. **Verifikasi & Moderasi (Admin)**
- ✅ Review laporan sebelum publikasi
- ✅ Verifikasi dengan catatan
- ✅ Penolakan dengan alasan wajib
- ✅ Publikasi ke dashboard publik
- ✅ Unpublish laporan
- ✅ Filter dan pencarian advanced
- ✅ Bulk actions

## 🗂️ Struktur Database

### Tabel: `laporan_bantuans`
```sql
- id (Primary Key)
- user_id (Foreign Key -> users)
- bantuan_id (Foreign Key -> bantuans, nullable)
- judul (string)
- deskripsi (text)
- jenis_bantuan (string)
- jumlah_bantuan (decimal, nullable)
- satuan (string, nullable)
- foto_bukti (json - array of paths)
- alamat_desa (string, nullable)
- alamat_kecamatan (string, nullable)
- koordinat (string, nullable)
- status (enum: pending, verified, rejected, published)
- catatan_verifikasi (text, nullable)
- verified_by (Foreign Key -> users, nullable)
- verified_at (timestamp, nullable)
- is_public (boolean, default: true)
- views_count (integer, default: 0)
- tanggal_penerimaan (date, nullable)
- tanggal_pelaporan (date)
- timestamps
- soft_deletes
```

## 📁 File yang Dibuat

### Backend
1. **Migration**: `database/migrations/2025_12_04_000001_create_laporan_bantuans_table.php`
2. **Model**: `app/Models/LaporanBantuan.php`
3. **Service**: `app/Services/LaporanBantuanService.php`
4. **Controllers**:
   - `app/Http/Controllers/LaporanBantuanController.php` (Petani & Public)
   - `app/Http/Controllers/Admin/AdminLaporanBantuanController.php` (Admin)
5. **Policy**: `app/Policies/LaporanBantuanPolicy.php`

### Frontend Views
1. **Petani**:
   - `resources/views/petani/laporan-bantuan/index.blade.php` (List)
   - `resources/views/petani/laporan-bantuan/create.blade.php` (Form)
   
2. **Guest/Public**:
   - `resources/views/guest/laporan-bantuan/dashboard.blade.php` (Dashboard Transparansi)
   - `resources/views/guest/laporan-bantuan/show.blade.php` (Detail Laporan)
   
3. **Admin**:
   - `resources/views/admin/laporan-bantuan/index.blade.php` (Manage)
   - `resources/views/admin/laporan-bantuan/show.blade.php` (Detail)
   - `resources/views/admin/laporan-bantuan/dashboard.blade.php` (Decision Support)

## 🛣️ Routes

### Public Routes
```php
GET  /transparansi-bantuan           -> Dashboard publik transparansi
GET  /transparansi-bantuan/{id}      -> Detail laporan publik
```

### Petani Routes (Auth + Role: petani)
```php
GET    /petani/laporan-bantuan              -> List laporan
GET    /petani/laporan-bantuan/create       -> Form buat laporan
POST   /petani/laporan-bantuan              -> Store laporan
GET    /petani/laporan-bantuan/{id}/edit    -> Form edit
PUT    /petani/laporan-bantuan/{id}         -> Update laporan
DELETE /petani/laporan-bantuan/{id}         -> Hapus laporan
```

### Admin Routes (Auth + Role: admin)
```php
GET  /admin/laporan-bantuan                 -> List semua laporan
GET  /admin/laporan-bantuan/dashboard       -> Dashboard & analytics
GET  /admin/laporan-bantuan/{id}            -> Detail laporan
POST /admin/laporan-bantuan/{id}/verify     -> Verifikasi laporan
POST /admin/laporan-bantuan/{id}/reject     -> Tolak laporan
POST /admin/laporan-bantuan/{id}/publish    -> Publikasikan
POST /admin/laporan-bantuan/{id}/unpublish  -> Unpublish
```

## 🔐 Authorization (Policy)

### Permissions
- **viewAny**: Semua user yang login
- **view**: Admin/Petugas (semua) | Petani (milik sendiri)
- **create**: Hanya Petani
- **update**: Pemilik laporan (status: pending/rejected)
- **delete**: Admin (semua) | Petani (milik sendiri & pending)
- **verify**: Admin & Petugas
- **publish**: Hanya Admin

## 📊 Service Layer Methods

### LaporanBantuanService

#### Public Methods
```php
getPublicReports($perPage, $search, $jenis)          // Dashboard publik
getPetaniReports($userId, $perPage)                  // List untuk petani
getAdminReports($filters, $perPage)                  // List untuk admin
createReport($data, $userId)                         // Buat laporan baru
updateReport($laporan, $data, $userId)               // Update laporan
verifyReport($laporan, $verifierId, $catatan)        // Verifikasi
rejectReport($laporan, $verifierId, $catatan)        // Tolak
publishReport($laporan)                              // Publikasi
getStatistics($period)                               // Statistik
getInsights()                                        // Insights & rekomendasi
deleteReport($laporan)                               // Hapus (soft delete)
```

## 🎯 Cara Penggunaan

### 1. Petani - Membuat Laporan
1. Login sebagai petani
2. Menu: **Laporan Bantuan** → **Buat Laporan Baru**
3. Isi form:
   - Judul laporan
   - Jenis bantuan (dropdown)
   - Jumlah & satuan
   - Deskripsi lengkap
   - Upload foto bukti (1-5 foto)
   - Tanggal penerimaan
   - Centang "Publikasikan" jika ingin transparan
4. Klik **Kirim Laporan**
5. Status awal: **Pending** (menunggu verifikasi)

### 2. Admin - Verifikasi Laporan
1. Login sebagai admin
2. Menu: **Laporan Bantuan** → **Kelola Laporan**
3. Filter laporan dengan status "Pending"
4. Klik tombol **Detail** atau **Verifikasi**
5. Review foto dan informasi
6. Pilih:
   - **Verifikasi**: Tambah catatan (opsional) → Submit
   - **Tolak**: Tambah alasan penolakan → Submit
7. Laporan terverifikasi siap dipublikasi

### 3. Admin - Publikasi ke Dashboard Publik
1. Filter laporan dengan status "Verified"
2. Klik tombol **Publikasikan**
3. Laporan akan muncul di dashboard publik
4. Akses: `/transparansi-bantuan`

### 4. Publik - Melihat Transparansi
1. Buka URL: `/transparansi-bantuan` (tanpa login)
2. Filter berdasarkan jenis bantuan atau search
3. Klik **Lihat Detail** untuk foto lengkap
4. Share ke media sosial

### 5. Admin - Dashboard Alat Bantu Keputusan
1. Menu: **Laporan Bantuan** → **Dashboard & Analisis**
2. Pilih periode (minggu/bulan/tahun)
3. Lihat insights otomatis:
   - Alert laporan pending
   - Jenis bantuan terpopuler
   - Desa paling aktif
   - Tingkat penolakan
4. Gunakan quick actions untuk verifikasi cepat

## 🎨 Fitur UI/UX

### Modern Design
- Card-based layout
- Gradient backgrounds
- Smooth transitions
- Responsive grid
- Shadow effects
- Badge dan status colors

### Interactive Elements
- Image preview saat upload
- Lightbox untuk gallery foto
- Modal untuk verifikasi/reject
- Filter & search real-time
- Pagination
- Alert notifications

### Dashboard Publik Features
- Stats cards dengan animasi
- Photo gallery dengan hover effect
- Views counter
- Social media share buttons
- Location badges
- Verified badges

## 📈 Metrics & Analytics

### Statistics Tracked
- Total laporan
- Laporan pending
- Laporan verified
- Laporan published
- Tingkat verifikasi (%)
- Tingkat publikasi (%)
- Tingkat penolakan (%)
- Laporan per jenis bantuan
- Laporan per lokasi
- Views count per laporan

### Insights Generated
1. **Info**: Jenis bantuan terpopuler
2. **Warning**: Banyak laporan pending
3. **Success**: Desa paling aktif
4. **Danger**: Tingkat penolakan tinggi (>20%)

## 🔄 Workflow

```
Petani → Buat Laporan → Upload Foto
                ↓
        Status: PENDING
                ↓
    Admin → Review → Verifikasi/Tolak
                ↓
        Status: VERIFIED/REJECTED
                ↓
    (Jika Verified) Admin → Publikasi
                ↓
        Status: PUBLISHED
                ↓
    Dashboard Publik (Transparansi)
```

## 🛡️ Security Features

- ✅ Authorization dengan Policy
- ✅ CSRF Protection
- ✅ Validation input
- ✅ File upload validation (type, size)
- ✅ XSS Protection
- ✅ SQL Injection Prevention (Eloquent ORM)
- ✅ Soft Deletes (data tidak hilang permanen)

## 📱 Responsive Design

- ✅ Mobile-friendly
- ✅ Tablet optimized
- ✅ Desktop enhanced
- ✅ Bootstrap 5 grid system
- ✅ Flexbox layout

## 🚀 Performance

- ✅ Database indexes pada kolom penting
- ✅ Eager loading relationships
- ✅ Pagination untuk list
- ✅ Image optimization (max 5MB)
- ✅ Efficient queries
- ✅ Caching ready

## 🔧 Konfigurasi Storage

Pastikan storage link sudah dibuat:
```bash
php artisan storage:link
```

Foto disimpan di: `storage/app/public/laporan_bantuan/{user_id}/`

## 📝 Todo Future Enhancements

- [ ] Real-time notifications (Pusher/Broadcasting)
- [ ] Export laporan ke PDF/Excel
- [ ] Chart visualizations (Chart.js)
- [ ] Email notifications
- [ ] Commenting system
- [ ] Rating/feedback system
- [ ] Map integration (koordinat)
- [ ] Advanced search dengan Elasticsearch
- [ ] Mobile app API

## 🎓 Testing

Untuk testing fitur:
1. Buat akun petani
2. Login dan buat laporan dengan foto
3. Login sebagai admin
4. Verifikasi laporan
5. Publikasikan
6. Akses dashboard publik tanpa login
7. Test filter dan search
8. Test dashboard analytics

## 📞 Support

Fitur ini terintegrasi penuh dengan sistem yang ada:
- Model User dengan relasi
- Model Bantuan untuk linking
- Notification system ready
- Activity logging ready
- Backup system compatible

---

**✅ Fitur Siap Digunakan!**

Semua file telah dibuat, migration telah dijalankan, dan routes telah dikonfigurasi. Sistem pelaporan transparan dengan alat bantu pengambilan keputusan siap untuk digunakan! 🎉
