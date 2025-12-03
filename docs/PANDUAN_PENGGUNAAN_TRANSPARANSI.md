# 📋 Panduan Penggunaan Fitur Transparansi Bantuan

## 🎯 Ringkasan Fitur

Sistem ini memiliki **3 fitur utama**:
1. **📸 Pelaporan Real-time dengan Upload Foto** (untuk Petani)
2. **📊 Alat Bantu Pengambilan Keputusan** (untuk Admin)
3. **🌐 Dashboard Publik Transparansi** (untuk Semua Orang)

---

## 👥 Akses Berdasarkan Role

### 1️⃣ **PETANI** - Membuat Laporan Bantuan

#### 🔐 Cara Login Sebagai Petani
```
URL: http://localhost:8000/login
Email: (email petani yang sudah terdaftar)
Password: (password petani)
```

#### 📝 Cara Membuat Laporan Bantuan Transparan

**Langkah 1: Akses Menu Laporan Bantuan**
- Setelah login, klik menu **"Laporan Bantuan"** di sidebar
- Atau akses langsung: `http://localhost:8000/petani/laporan-bantuan`

**Langkah 2: Buat Laporan Baru**
- Klik tombol **"+ Buat Laporan Baru"**
- Atau akses: `http://localhost:8000/petani/laporan-bantuan/create`

**Langkah 3: Isi Form Laporan**
```
📋 Judul Laporan        : Contoh: "Penerimaan Pupuk Subsidi Periode Maret 2025"
📄 Deskripsi           : Jelaskan detail bantuan yang diterima
🏷️ Jenis Bantuan       : Pilih: Pupuk/Benih/Alat/Teknologi/Pelatihan/Lainnya
📦 Jumlah Bantuan      : Contoh: 50 (opsional)
📏 Satuan              : Contoh: Kg/Karung/Unit (opsional)
🎁 Pilih Bantuan       : Pilih dari daftar bantuan yang sudah diterima (opsional)
📅 Tanggal Penerimaan  : Pilih tanggal (opsional)
📸 Upload Foto Bukti   : MINIMAL 1 FOTO (WAJIB!)
   - Format: JPG, JPEG, PNG
   - Ukuran Max: 5MB per foto
   - Bisa upload multiple foto
✅ Tampilkan di Publik? : Centang jika ingin langsung public (default: tidak)
```

**Langkah 4: Upload Foto**
- Klik **"Browse Files"** atau drag & drop
- Pilih foto bukti penerimaan bantuan
- Foto bisa lebih dari 1
- Pastikan foto jelas dan menunjukkan bukti bantuan

**Langkah 5: Submit**
- Klik tombol **"Kirim Laporan"**
- Laporan akan masuk ke status **"Pending"** (menunggu verifikasi admin)

#### 📊 Melihat Status Laporan Anda
```
Menu: Petani > Laporan Bantuan
URL: http://localhost:8000/petani/laporan-bantuan

Status Laporan:
⏳ Pending    : Menunggu verifikasi admin
✅ Verified   : Sudah diverifikasi admin
❌ Rejected   : Ditolak admin (lihat alasan)
🌐 Published  : Dipublikasikan ke dashboard publik
```

#### ✏️ Edit Laporan (Hanya jika belum verified)
- Klik **"Edit"** pada laporan yang ingin diubah
- Update data yang diperlukan
- Submit kembali

---

### 2️⃣ **ADMIN/PETUGAS** - Verifikasi & Publikasi

#### 🔐 Cara Login Sebagai Admin
```
URL: http://localhost:8000/login
Email: admin@pertanian.com (atau admin terdaftar)
Password: (password admin)
```

#### 📊 Dashboard Pengambilan Keputusan

**Akses Dashboard Analytics**
```
URL: http://localhost:8000/admin/laporan-bantuan/dashboard

Fitur yang Tersedia:
📈 Statistik Real-time:
   - Total laporan masuk
   - Laporan terverifikasi
   - Laporan pending
   - Laporan published

📊 Grafik & Chart:
   - Trend laporan per bulan
   - Distribusi jenis bantuan
   - Perbandingan status
   - Top 10 petani aktif

🎯 Insights & Rekomendasi:
   - Bantuan paling banyak dilaporkan
   - Area dengan laporan terbanyak
   - Tingkat transparansi per jenis bantuan
```

#### ✅ Verifikasi Laporan

**Langkah 1: Lihat Daftar Laporan**
```
Menu: Admin > Laporan Bantuan
URL: http://localhost:8000/admin/laporan-bantuan

Filter yang tersedia:
🔍 Status          : All/Pending/Verified/Rejected/Published
🏷️ Jenis Bantuan   : Filter berdasarkan jenis
📅 Tanggal         : Start date - End date
🔎 Search          : Cari berdasarkan judul/deskripsi
```

**Langkah 2: Lihat Detail Laporan**
- Klik **"Lihat Detail"** pada laporan
- Review informasi lengkap:
  - Data petani
  - Detail bantuan
  - Foto-foto bukti
  - Timeline laporan

**Langkah 3: Verifikasi/Reject**

**Untuk VERIFIKASI:**
```
✅ Klik tombol "Verifikasi"
✍️ Isi catatan verifikasi (opsional)
✓ Submit
→ Status berubah menjadi "Verified"
```

**Untuk REJECT:**
```
❌ Klik tombol "Tolak"
✍️ Isi alasan penolakan (WAJIB)
✓ Submit
→ Status berubah menjadi "Rejected"
→ Petani akan melihat alasan penolakan
```

#### 🌐 Publikasi ke Dashboard Publik

**Langkah 1: Laporan Harus Verified**
- Hanya laporan dengan status **"Verified"** yang bisa dipublikasi

**Langkah 2: Publish**
```
🌐 Klik tombol "Publikasikan"
→ Status berubah menjadi "Published"
→ is_public = true
→ Langsung muncul di dashboard publik
```

**Langkah 3: Unpublish (jika perlu)**
```
🔒 Klik tombol "Batalkan Publikasi"
→ is_public = false
→ Hilang dari dashboard publik
→ Status tetap "Verified"
```

---

### 3️⃣ **PUBLIK** - Lihat Dashboard Transparansi

#### 🌐 Akses Dashboard Publik (TIDAK PERLU LOGIN!)

**URL Utama:**
```
Dashboard Transparansi: http://localhost:8000/transparansi-bantuan
```

**Fitur yang Tersedia:**

**1. Statistik Real-time**
```
📊 Total Laporan Published
📈 Total Jenis Bantuan
👁️ Total Views
```

**2. Filter & Pencarian**
```
🔍 Search Box    : Cari berdasarkan judul/deskripsi
🏷️ Filter Jenis : Filter berdasarkan jenis bantuan
🔄 Reset Filter  : Clear semua filter
```

**3. Grid Laporan**
```
Setiap Card Menampilkan:
✅ Badge "Terverifikasi"
📸 Foto utama bantuan
📋 Judul laporan
👤 Nama petani
🏷️ Jenis bantuan
📅 Tanggal penerimaan
👁️ Jumlah views
🔍 Tombol "Lihat Detail"
```

**4. Detail Laporan**
- Klik **"Lihat Detail"** pada card
- Lihat informasi lengkap:
  - Foto-foto bukti (gallery)
  - Deskripsi lengkap
  - Data bantuan
  - Info petani
  - Timeline

**5. Pagination**
- Navigasi antar halaman
- Menampilkan 12 laporan per halaman

---

## 🚀 Contoh Alur Penggunaan Lengkap

### Skenario: Petani Melaporkan Penerimaan Pupuk

**STEP 1: PETANI (Pak Budi)**
```
1. Login sebagai petani
2. Klik "Laporan Bantuan" > "Buat Laporan"
3. Isi form:
   - Judul: "Penerimaan Pupuk Subsidi Desember 2025"
   - Deskripsi: "Menerima pupuk urea 100kg untuk lahan padi"
   - Jenis: Pupuk
   - Jumlah: 100
   - Satuan: Kg
   - Upload 3 foto (foto pupuk, foto dengan petugas, foto lokasi)
4. Submit
5. Status: Pending ⏳
```

**STEP 2: ADMIN**
```
1. Login sebagai admin
2. Lihat dashboard analytics:
   - Ada 1 laporan baru pending
   - Dashboard menampilkan notification
3. Klik "Laporan Bantuan" > Filter "Pending"
4. Lihat laporan Pak Budi
5. Review foto-foto:
   ✓ Foto jelas
   ✓ Menunjukkan bukti pupuk
   ✓ Data lengkap
6. Klik "Verifikasi"
7. Isi catatan: "Laporan sesuai, foto bukti lengkap"
8. Submit
9. Status: Verified ✅
10. Klik "Publikasikan"
11. Status: Published 🌐
```

**STEP 3: PUBLIK**
```
1. Buka browser (tidak perlu login)
2. Akses: http://localhost:8000/transparansi-bantuan
3. Lihat dashboard:
   - Statistik bertambah +1
   - Card laporan Pak Budi muncul
4. Klik "Lihat Detail"
5. Lihat foto-foto dan detail lengkap
6. Views +1 👁️
```

---

## 📱 URL Lengkap Semua Fitur

### Guest/Public (Tidak perlu login)
```
🏠 Homepage                 : http://localhost:8000
🌐 Dashboard Transparansi   : http://localhost:8000/transparansi-bantuan
🔍 Detail Laporan          : http://localhost:8000/transparansi-bantuan/{id}
📰 Berita                  : http://localhost:8000/berita
🖼️ Galeri                  : http://localhost:8000/galeri
```

### Petani (Perlu login role: petani)
```
📊 Dashboard               : http://localhost:8000/petani/dashboard
📋 Daftar Laporan         : http://localhost:8000/petani/laporan-bantuan
➕ Buat Laporan           : http://localhost:8000/petani/laporan-bantuan/create
✏️ Edit Laporan           : http://localhost:8000/petani/laporan-bantuan/{id}/edit
🔍 Detail Laporan         : http://localhost:8000/petani/laporan-bantuan/{id}
```

### Admin (Perlu login role: admin)
```
📊 Dashboard Analytics     : http://localhost:8000/admin/laporan-bantuan/dashboard
📋 Kelola Laporan         : http://localhost:8000/admin/laporan-bantuan
🔍 Detail Laporan         : http://localhost:8000/admin/laporan-bantuan/{id}
✅ Verifikasi             : POST /admin/laporan-bantuan/{id}/verify
❌ Reject                 : POST /admin/laporan-bantuan/{id}/reject
🌐 Publish                : POST /admin/laporan-bantuan/{id}/publish
🔒 Unpublish              : POST /admin/laporan-bantuan/{id}/unpublish
```

---

## 💡 Tips Penggunaan

### Untuk Petani:
- ✅ Upload foto yang jelas dan berkualitas
- ✅ Sertakan foto dari berbagai sudut
- ✅ Isi deskripsi selengkap mungkin
- ✅ Tunggu verifikasi admin sebelum muncul di publik
- ✅ Cek status laporan secara berkala

### Untuk Admin:
- ✅ Verifikasi laporan secepat mungkin
- ✅ Berikan catatan yang jelas saat reject
- ✅ Gunakan dashboard analytics untuk insights
- ✅ Publikasikan laporan yang sudah verified
- ✅ Monitor statistik secara berkala

### Untuk Publik:
- ✅ Gunakan filter untuk pencarian spesifik
- ✅ Lihat detail untuk informasi lengkap
- ✅ Badge "Terverifikasi" menjamin keaslian

---

## 🔧 Troubleshooting

### Foto Tidak Ter-upload?
```
Cek:
✓ Format: JPG/JPEG/PNG
✓ Ukuran: Max 5MB per foto
✓ Koneksi internet stabil
✓ Storage folder writable (storage/app/public/laporan-bantuan)
```

### Laporan Tidak Muncul di Publik?
```
Cek:
✓ Status = Published? (bukan hanya Verified)
✓ is_public = true?
✓ Admin sudah klik "Publikasikan"?
✓ Clear browser cache
```

### Dashboard Analytics Tidak Muncul?
```
Cek:
✓ Login sebagai admin
✓ Role = admin/petugas
✓ URL: /admin/laporan-bantuan/dashboard
```

---

## 📞 Support

Jika ada masalah:
1. Cek dokumentasi ini
2. Lihat log error: `storage/logs/laravel.log`
3. Cek console browser (F12)
4. Hubungi admin sistem

---

**🎉 Selamat menggunakan sistem transparansi bantuan pertanian!**

Last Updated: 4 Desember 2025
Version: 1.0
