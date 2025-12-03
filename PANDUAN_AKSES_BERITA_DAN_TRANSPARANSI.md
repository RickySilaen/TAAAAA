# 📰 Panduan Akses Fitur BERITA & TRANSPARANSI

## 🎯 Ringkasan

### 1️⃣ **BERITA** (Kelola oleh Admin)
- **Tujuan**: Publikasi berita/informasi pertanian untuk publik
- **Siapa yang bisa buat**: Admin
- **Siapa yang bisa lihat**: Semua orang (publik, tidak perlu login)

### 2️⃣ **TRANSPARANSI** (Laporan Bantuan)
- **Tujuan**: Transparansi penerimaan bantuan dengan foto bukti
- **Siapa yang buat laporan**: Petani
- **Siapa yang verifikasi & publish**: Admin
- **Siapa yang lihat**: Semua orang (publik, tidak perlu login)

---

## 📰 FITUR BERITA

### 🔐 **ADMIN** - Kelola Berita

#### ✅ Cara Login Admin
```
URL: http://localhost:8000/login
Email: admin@pertanian.com (atau email admin Anda)
Password: (password admin)
```

#### 📝 Cara Membuat Berita Baru

**Langkah 1: Akses Menu Berita**
```
Setelah login sebagai admin:
1. Lihat sidebar/menu
2. Klik "Berita" atau "Kelola Berita"
3. Atau akses langsung: http://localhost:8000/admin/berita
```

**Langkah 2: Buat Berita**
```
1. Klik tombol "+ Tambah Berita" atau "Create"
2. Atau akses: http://localhost:8000/admin/berita/create
```

**Langkah 3: Isi Form Berita**
```
📋 Judul Berita       : Contoh: "Distribusi Pupuk Subsidi Tahap 1"
📝 Konten/Isi         : Isi berita lengkap (bisa pakai editor)
🏷️ Kategori          : Pilih kategori (Program/Kegiatan/Info/dll)
📸 Gambar Utama       : Upload foto (opsional)
👤 Penulis            : Otomatis dari nama admin yang login
📅 Tanggal Publish    : Pilih tanggal (default: hari ini)
✅ Status             : Published (langsung tampil) / Draft (belum tampil)
```

**Langkah 4: Submit**
```
Klik "Simpan" atau "Publish"
→ Berita langsung muncul di halaman publik
```

#### 📊 Kelola Berita yang Sudah Ada

**Lihat Semua Berita:**
```
URL: http://localhost:8000/admin/berita

Tombol yang tersedia:
✏️ Edit    : Ubah berita
🗑️ Hapus   : Delete berita
👁️ Lihat   : Preview berita
🔄 Status  : Toggle Published/Draft
```

**Edit Berita:**
```
1. Klik tombol "Edit" pada berita yang ingin diubah
2. URL: http://localhost:8000/admin/berita/{id}/edit
3. Update data yang diperlukan
4. Klik "Update"
```

**Hapus Berita:**
```
1. Klik tombol "Hapus"
2. Konfirmasi penghapusan
3. Berita akan dihapus permanent
```

**Toggle Status:**
```
1. Klik tombol "Toggle Status"
2. Published → Draft (berita hilang dari publik)
3. Draft → Published (berita muncul di publik)
```

---

### 🌐 **PUBLIK** - Lihat Berita (TIDAK PERLU LOGIN)

**Akses Halaman Berita:**
```
URL: http://localhost:8000/berita

Fitur:
📰 List semua berita published
🔍 Search berita
🏷️ Filter kategori
📄 Pagination
```

**Detail Berita:**
```
1. Klik card/judul berita
2. URL: http://localhost:8000/berita/{slug}
3. Lihat konten lengkap, gambar, tanggal, penulis
```

---

## 🌐 FITUR TRANSPARANSI BANTUAN

### 👨‍🌾 **PETANI** - Buat Laporan Transparansi

#### 🔐 Login Petani
```
URL: http://localhost:8000/login
Email: (email petani yang terdaftar)
Password: (password petani)
```

#### 📸 Cara Membuat Laporan Bantuan

**Langkah 1: Akses Menu Laporan Bantuan**
```
Setelah login sebagai petani:
1. Lihat sidebar
2. Klik "Laporan Bantuan" atau "Transparansi"
3. URL: http://localhost:8000/petani/laporan-bantuan
```

**Langkah 2: Buat Laporan Baru**
```
1. Klik tombol "+ Buat Laporan"
2. URL: http://localhost:8000/petani/laporan-bantuan/create
```

**Langkah 3: Isi Form dengan FOTO**
```
📋 Judul             : Contoh: "Penerimaan Pupuk Urea 100kg"
📄 Deskripsi         : Jelaskan detail bantuan
🏷️ Jenis Bantuan     : Pilih: Pupuk/Benih/Alat/Pelatihan/dll
📦 Jumlah            : Contoh: 100
📏 Satuan            : Contoh: Kg
📅 Tanggal Terima    : Pilih tanggal
📸 FOTO BUKTI        : **WAJIB! Upload minimal 1 foto**
   - Format: JPG/JPEG/PNG
   - Max: 5MB per foto
   - Bisa upload banyak foto
   - Foto harus jelas (foto bantuan, foto dengan petugas, dll)
```

**Langkah 4: Submit**
```
Klik "Kirim Laporan"
→ Status: Pending (Menunggu verifikasi admin)
→ Belum muncul di dashboard publik
```

#### 📊 Lihat Status Laporan Anda
```
URL: http://localhost:8000/petani/laporan-bantuan

Status yang mungkin:
⏳ Pending    : Menunggu admin verifikasi
✅ Verified   : Admin sudah verifikasi (belum public)
🌐 Published  : Sudah dipublikasi ke dashboard publik
❌ Rejected   : Ditolak admin (lihat alasan)
```

---

### 🔐 **ADMIN** - Kelola Transparansi

#### 📊 Dashboard Analytics
```
URL: http://localhost:8000/admin/laporan-bantuan/dashboard

Fitur:
📈 Statistik real-time
📊 Grafik trend laporan
🎯 Insights & rekomendasi
📉 Distribusi jenis bantuan
👥 Top petani aktif
```

#### ✅ Verifikasi & Publikasi Laporan

**Langkah 1: Lihat Semua Laporan**
```
URL: http://localhost:8000/admin/laporan-bantuan

Filter:
🔍 Status          : Pending/Verified/Rejected/Published
🏷️ Jenis Bantuan   : Filter by jenis
📅 Tanggal         : Range tanggal
🔎 Search          : Cari judul/petani
```

**Langkah 2: Review Detail Laporan**
```
1. Klik "Lihat Detail" pada laporan
2. URL: http://localhost:8000/admin/laporan-bantuan/{id}
3. Review:
   - Data petani
   - Foto-foto bukti (PENTING!)
   - Deskripsi lengkap
   - Detail bantuan
```

**Langkah 3: VERIFIKASI Laporan**
```
Di halaman detail:
1. Review foto bukti (pastikan jelas dan asli)
2. Klik tombol "✅ Verifikasi"
3. Isi catatan verifikasi (opsional)
4. Submit
→ Status: Verified
```

**Langkah 4: PUBLIKASI ke Dashboard Publik**
```
Setelah status Verified:
1. Klik tombol "🌐 Publikasikan"
2. Konfirmasi
→ Status: Published
→ is_public = true
→ LANGSUNG MUNCUL DI DASHBOARD PUBLIK
```

**Jika Laporan Tidak Layak (REJECT):**
```
1. Klik tombol "❌ Tolak"
2. Isi alasan penolakan (WAJIB!)
   Contoh: "Foto tidak jelas", "Data tidak lengkap"
3. Submit
→ Status: Rejected
→ Petani bisa lihat alasan penolakan
```

**Batalkan Publikasi:**
```
Jika sudah Published tapi perlu diturunkan:
1. Klik tombol "🔒 Batalkan Publikasi"
2. Konfirmasi
→ is_public = false
→ Hilang dari dashboard publik
→ Status tetap Verified
```

---

### 🌐 **PUBLIK** - Lihat Dashboard Transparansi (TIDAK PERLU LOGIN!)

#### Akses Dashboard Publik
```
URL: http://localhost:8000/transparansi-bantuan

Bisa diakses siapa saja tanpa login!
```

#### Fitur Dashboard Publik
```
📊 Statistik Real-time:
   - Total laporan published
   - Total jenis bantuan
   - Total views

🔍 Filter & Search:
   - Search berdasarkan judul/deskripsi
   - Filter jenis bantuan
   - Reset filter

📋 Grid Laporan:
   Setiap card menampilkan:
   ✅ Badge "Terverifikasi"
   📸 Foto utama bantuan
   📋 Judul laporan
   👤 Nama petani
   🏷️ Jenis bantuan
   📅 Tanggal penerimaan
   👁️ Jumlah views
   🔍 Tombol "Lihat Detail"

📸 Detail Laporan:
   - Galeri foto (semua foto)
   - Deskripsi lengkap
   - Data bantuan
   - Info petani
   - Timeline
```

---

## 🗺️ **PETA NAVIGASI LENGKAP**

### 🌐 URL PUBLIK (Tidak Perlu Login)
```
🏠 Homepage                    : http://localhost:8000
📰 Berita                      : http://localhost:8000/berita
📄 Detail Berita               : http://localhost:8000/berita/{slug}
🌐 Dashboard Transparansi      : http://localhost:8000/transparansi-bantuan
🔍 Detail Laporan Transparansi : http://localhost:8000/transparansi-bantuan/{id}
```

### 👨‍🌾 URL PETANI (Login sebagai petani)
```
📊 Dashboard Petani            : http://localhost:8000/petani/dashboard
📋 Daftar Laporan Saya         : http://localhost:8000/petani/laporan-bantuan
➕ Buat Laporan Baru           : http://localhost:8000/petani/laporan-bantuan/create
✏️ Edit Laporan                : http://localhost:8000/petani/laporan-bantuan/{id}/edit
```

### 🔐 URL ADMIN (Login sebagai admin)
```
BERITA:
📰 Kelola Berita               : http://localhost:8000/admin/berita
➕ Tambah Berita               : http://localhost:8000/admin/berita/create
✏️ Edit Berita                 : http://localhost:8000/admin/berita/{id}/edit

TRANSPARANSI:
📊 Dashboard Analytics         : http://localhost:8000/admin/laporan-bantuan/dashboard
📋 Kelola Laporan              : http://localhost:8000/admin/laporan-bantuan
🔍 Detail Laporan              : http://localhost:8000/admin/laporan-bantuan/{id}
```

---

## 📋 **CHECKLIST PENGGUNAAN**

### ✅ Membuat Berita (Admin)
- [ ] Login sebagai admin
- [ ] Akses /admin/berita
- [ ] Klik "Tambah Berita"
- [ ] Isi judul, konten, kategori
- [ ] Upload gambar (opsional)
- [ ] Set status: Published
- [ ] Submit
- [ ] ✅ Berita muncul di /berita

### ✅ Membuat Laporan Transparansi (Petani)
- [ ] Login sebagai petani
- [ ] Akses /petani/laporan-bantuan
- [ ] Klik "Buat Laporan"
- [ ] Isi judul, deskripsi, jenis bantuan
- [ ] **Upload minimal 1 foto bukti (WAJIB!)**
- [ ] Submit
- [ ] ✅ Laporan masuk dengan status: Pending

### ✅ Verifikasi & Publikasi Laporan (Admin)
- [ ] Login sebagai admin
- [ ] Akses /admin/laporan-bantuan
- [ ] Pilih laporan Pending
- [ ] Lihat detail & foto bukti
- [ ] Klik "Verifikasi"
- [ ] Klik "Publikasikan"
- [ ] ✅ Laporan muncul di /transparansi-bantuan

### ✅ Lihat Berita & Transparansi (Publik)
- [ ] Buka browser (tidak perlu login)
- [ ] Akses /berita untuk lihat berita
- [ ] Akses /transparansi-bantuan untuk lihat laporan
- [ ] ✅ Semua konten published terlihat

---

## 🚀 **QUICK START**

### Start Server
```powershell
php artisan serve
```

### Test Fitur Berita
```
1. Login admin: http://localhost:8000/login
2. Buat berita: http://localhost:8000/admin/berita/create
3. Lihat publik: http://localhost:8000/berita
```

### Test Fitur Transparansi
```
1. Login petani: http://localhost:8000/login
2. Buat laporan: http://localhost:8000/petani/laporan-bantuan/create
3. Login admin: http://localhost:8000/login
4. Verifikasi: http://localhost:8000/admin/laporan-bantuan
5. Lihat publik: http://localhost:8000/transparansi-bantuan
```

---

## 💡 **TIPS**

### Untuk Admin Berita:
- ✅ Gunakan judul yang menarik
- ✅ Sertakan gambar berkualitas
- ✅ Tulis konten yang informatif
- ✅ Pilih kategori yang tepat
- ✅ Set Published jika sudah siap tayang

### Untuk Petani:
- ✅ Upload foto yang jelas dan berkualitas
- ✅ Foto dari berbagai sudut (bantuan, dengan petugas, lokasi)
- ✅ Isi deskripsi lengkap dan detail
- ✅ Tunggu verifikasi admin

### Untuk Admin Transparansi:
- ✅ Verifikasi laporan secepat mungkin
- ✅ Pastikan foto bukti valid
- ✅ Berikan catatan yang jelas jika reject
- ✅ Publikasikan laporan yang layak
- ✅ Monitor dashboard analytics

---

## 🔧 **TROUBLESHOOTING**

### Berita Tidak Muncul di Publik?
```
Cek:
✓ Status = Published (bukan Draft)
✓ Tanggal publish <= hari ini
✓ Clear cache: php artisan cache:clear
```

### Laporan Tidak Muncul di Dashboard Publik?
```
Cek:
✓ Status = Published (bukan hanya Verified)
✓ is_public = true
✓ Admin sudah klik tombol "Publikasikan"
✓ Clear cache: php artisan view:clear
```

### Foto Tidak Ter-upload?
```
Cek:
✓ Format: JPG/JPEG/PNG
✓ Ukuran max: 5MB
✓ Storage linked: php artisan storage:link
✓ Folder writable: storage/app/public/
```

---

**🎉 Selamat menggunakan fitur Berita & Transparansi!**

Last Updated: 4 Desember 2025
Version: 1.0
