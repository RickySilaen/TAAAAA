# 🚀 Quick Start Guide - Fitur Pelaporan Transparan

## ✅ Fitur Telah Dibuat

Sistem pelaporan bantuan pertanian dengan transparansi penuh telah selesai dibuat dengan fitur:

### 🌟 Fitur Utama
1. **Upload Foto Bukti** - Petani dapat upload hingga 5 foto bukti penerimaan bantuan
2. **Dashboard Transparansi Publik** - Masyarakat dapat melihat semua laporan terverifikasi tanpa login
3. **Alat Bantu Keputusan** - Admin mendapat insights dan analytics untuk pengambilan keputusan
4. **Real-time Statistics** - Statistik otomatis dan update real-time

## 📦 Yang Sudah Dibuat

### Backend (✅ Complete)
- ✅ Migration tabel `laporan_bantuans`
- ✅ Model `LaporanBantuan` dengan relasi lengkap
- ✅ Service `LaporanBantuanService` untuk logika bisnis
- ✅ Controller untuk Petani dan Admin
- ✅ Policy untuk authorization
- ✅ Routes untuk semua fitur

### Frontend (✅ Complete)
- ✅ Form pelaporan untuk petani (create & edit)
- ✅ List laporan untuk petani
- ✅ Dashboard publik dengan filter & search
- ✅ Detail laporan publik dengan gallery foto
- ✅ Admin dashboard dengan analytics
- ✅ Admin management untuk verifikasi

## 🎯 Cara Menggunakan

### 1️⃣ Setup Awal (Sekali Saja)

```bash
# Pastikan storage link sudah dibuat
php artisan storage:link

# Migration sudah dijalankan ✅
# php artisan migrate (sudah selesai)
```

### 2️⃣ Akses Fitur

#### Sebagai Petani:
1. Login ke sistem sebagai petani
2. Menu: **Laporan Bantuan** → **Buat Laporan Baru**
3. Isi form dan upload foto bukti
4. Submit → Tunggu verifikasi admin

**URL:** `/petani/laporan-bantuan`

#### Sebagai Admin:
1. Login sebagai admin
2. Menu: **Laporan Bantuan** → **Dashboard & Analisis**
3. Lihat insights dan statistik
4. Verifikasi laporan pending
5. Publikasikan ke dashboard publik

**URL Admin:**
- Dashboard: `/admin/laporan-bantuan/dashboard`
- Manage: `/admin/laporan-bantuan`

#### Sebagai Publik (Tanpa Login):
1. Buka browser
2. Akses: `http://your-domain.com/transparansi-bantuan`
3. Browse dan filter laporan
4. Klik detail untuk lihat foto lengkap

**URL Publik:** `/transparansi-bantuan`

## 🔗 URL Routes

```
Public (No Login):
- /transparansi-bantuan           → Dashboard transparansi
- /transparansi-bantuan/{id}      → Detail laporan

Petani (Login Required):
- /petani/laporan-bantuan         → List laporan saya
- /petani/laporan-bantuan/create  → Buat laporan baru
- /petani/laporan-bantuan/{id}/edit → Edit laporan

Admin (Login Required):
- /admin/laporan-bantuan/dashboard  → Dashboard & insights
- /admin/laporan-bantuan            → Kelola semua laporan
- /admin/laporan-bantuan/{id}       → Detail & verifikasi
```

## 📸 Upload Foto

### Spesifikasi:
- **Format:** JPG, JPEG, PNG
- **Ukuran:** Max 5MB per foto
- **Jumlah:** 1-5 foto per laporan
- **Storage:** `storage/app/public/laporan_bantuan/{user_id}/`

### Preview:
- ✅ Preview otomatis sebelum upload
- ✅ Lightbox gallery di detail view
- ✅ Responsive image display

## 📊 Dashboard Analytics

### Metrics yang Ditampilkan:
- Total laporan
- Laporan pending (butuh verifikasi)
- Laporan terverifikasi
- Laporan dipublikasikan
- Tingkat verifikasi (%)
- Tingkat publikasi (%)
- Tingkat penolakan (%)

### Insights Otomatis:
1. **Alert** - Banyak laporan pending
2. **Info** - Jenis bantuan terpopuler
3. **Success** - Desa paling aktif
4. **Warning** - Tingkat penolakan tinggi

### Filter Periode:
- Minggu ini
- Bulan ini
- Tahun ini
- Semua data

## 🔐 Authorization

### Petani:
- ✅ Buat laporan baru
- ✅ Edit laporan sendiri (jika status: pending/rejected)
- ✅ Hapus laporan sendiri (jika status: pending)
- ✅ Lihat laporan sendiri

### Admin/Petugas:
- ✅ Lihat semua laporan
- ✅ Verifikasi laporan
- ✅ Tolak laporan (dengan alasan)
- ✅ Publikasi ke dashboard publik
- ✅ Unpublish dari dashboard
- ✅ Akses dashboard analytics

### Publik:
- ✅ Lihat laporan yang dipublikasi
- ✅ Filter & search laporan
- ✅ Lihat detail dan foto

## 🎨 Fitur UI

### Modern Design:
- Gradient backgrounds
- Card-based layout
- Smooth animations
- Responsive design
- Bootstrap 5

### Interactive:
- Image preview
- Modal dialogs
- Alert notifications
- Real-time filter
- Pagination

### Dashboard Publik:
- Stats cards
- Photo gallery
- Views counter
- Social share buttons
- Location badges

## ✨ Workflow Lengkap

```
1. Petani Create Laporan + Upload Foto
   ↓
2. Status: PENDING
   ↓
3. Admin Review & Verify/Reject
   ↓
4. Status: VERIFIED atau REJECTED
   ↓
5. (Jika Verified) Admin Publish
   ↓
6. Status: PUBLISHED
   ↓
7. Muncul di Dashboard Publik (/transparansi-bantuan)
   ↓
8. Masyarakat bisa lihat tanpa login
```

## 🧪 Testing Cepat

### Test 1: Buat Laporan (Petani)
1. Login sebagai petani
2. Buka `/petani/laporan-bantuan/create`
3. Isi form dan upload 2-3 foto
4. Submit
5. Cek status: harus "Pending"

### Test 2: Verifikasi (Admin)
1. Login sebagai admin
2. Buka `/admin/laporan-bantuan`
3. Klik detail laporan pending
4. Klik "Verifikasi Laporan"
5. Cek status: harus "Verified"

### Test 3: Publikasi (Admin)
1. Filter laporan dengan status "Verified"
2. Klik "Publikasikan"
3. Logout
4. Buka `/transparansi-bantuan` (tanpa login)
5. Laporan harus muncul

### Test 4: Dashboard Analytics (Admin)
1. Login sebagai admin
2. Buka `/admin/laporan-bantuan/dashboard`
3. Cek statistik dan insights
4. Pilih periode berbeda
5. Lihat perubahan data

## 📱 Responsive

Semua halaman sudah responsive:
- ✅ Mobile (320px - 767px)
- ✅ Tablet (768px - 1023px)
- ✅ Desktop (1024px+)

## 🔧 Troubleshooting

### Foto tidak muncul?
```bash
# Pastikan storage link dibuat
php artisan storage:link

# Cek permission folder
chmod -R 775 storage/app/public
```

### Error 403 saat akses?
- Cek role user (admin/petani)
- Pastikan login dengan akun yang benar
- Cek policy authorization

### Laporan tidak muncul di dashboard publik?
- Pastikan status = "published"
- Pastikan is_public = true
- Pastikan sudah diverifikasi admin

## 📖 Dokumentasi Lengkap

Lihat dokumentasi lengkap di:
`docs/LAPORAN_BANTUAN_TRANSPARANSI_FEATURE.md`

## 🎉 Selesai!

Fitur pelaporan transparan dengan upload foto telah **siap digunakan**!

### Quick Links:
- **Petani:** `/petani/laporan-bantuan`
- **Admin:** `/admin/laporan-bantuan/dashboard`
- **Publik:** `/transparansi-bantuan`

---

**Happy Reporting! 🌾**
