# PERBEDAAN FITUR & FUNGSI: PETUGAS vs PETANI

**Tanggal:** 10 November 2025  
**Tujuan:** Memastikan setiap role memiliki fungsi yang berbeda dan tidak tumpang tindih

---

## 📊 TABEL PERBANDINGAN FITUR

| No | Fitur | PETUGAS ✓/✗ | PETANI ✓/✗ | Keterangan |
|----|-------|-------------|------------|------------|
| **1. DASHBOARD** |
| 1.1 | Lihat statistik wilayah | ✓ | ✗ | Petugas lihat data seluruh petani di kecamatannya |
| 1.2 | Lihat statistik pribadi | ✗ | ✓ | Petani hanya lihat data mereka sendiri |
| **2. VERIFIKASI & APPROVAL** |
| 2.1 | Verifikasi akun petani baru | ✓ | ✗ | Hanya petugas yang bisa approve/reject pendaftaran |
| 2.2 | Verifikasi laporan panen | ✓ | ✗ | Petugas validasi data laporan petani |
| 2.3 | Update status bantuan | ✓ | ✗ | Petugas ubah status: pending → diproses → dikirim |
| **3. INPUT DATA** |
| 3.1 | Input laporan panen | ✗ | ✓ | Petani input hasil panen mereka |
| 3.2 | Input pengajuan bantuan | ✗ | ✓ | Petani ajukan bantuan (pupuk, bibit, dll) |
| 3.3 | Edit/Delete laporan sendiri | ✗ | ✓ | Petani kelola data mereka sendiri |
| **4. MONITORING** |
| 4.1 | Monitor seluruh petani di wilayah | ✓ | ✗ | Petugas pantau progress semua petani |
| 4.2 | Lihat daftar petani | ✓ | ✗ | Petugas lihat list petani + detail |
| 4.3 | Export laporan wilayah (PDF) | ✓ | ✗ | Petugas export data untuk reporting |
| **5. VIEW DATA** |
| 5.1 | Lihat semua laporan di wilayah | ✓ | ✗ | Petugas akses data semua petani |
| 5.2 | Lihat semua bantuan di wilayah | ✓ | ✗ | Petugas lihat pengajuan bantuan semua petani |
| 5.3 | Lihat laporan sendiri saja | ✗ | ✓ | Petani hanya lihat laporan mereka |
| 5.4 | Lihat bantuan sendiri saja | ✗ | ✓ | Petani hanya lihat bantuan mereka |
| **6. NOTIFIKASI** |
| 6.1 | Notif pendaftaran petani baru | ✓ | ✗ | Petugas dapat alert saat ada pendaftaran baru |
| 6.2 | Notif laporan baru dari petani | ✓ | ✗ | Petugas dapat alert saat petani submit laporan |
| 6.3 | Notif akun terverifikasi | ✗ | ✓ | Petani dapat notif saat akun diapprove |
| 6.4 | Notif status bantuan berubah | ✗ | ✓ | Petani dapat notif update status bantuan |
| **7. PROFIL** |
| 7.1 | Edit profil sendiri | ✓ | ✓ | Kedua role bisa edit profil |
| 7.2 | Upload foto profil | ✓ | ✓ | Kedua role bisa upload foto |
| **8. KOMUNIKASI** |
| 8.1 | Tambah catatan ke laporan | ✓ | ✗ | Petugas bisa kasih feedback di laporan |
| 8.2 | Tambah catatan ke bantuan | ✓ | ✗ | Petugas bisa kasih info tambahan |
| 8.3 | Lihat catatan dari petugas | ✗ | ✓ | Petani bisa baca feedback petugas |

---

## 🎯 FITUR EKSKLUSIF PETUGAS

### 1. Dashboard Petugas
```
STATISTIK WILAYAH:
- Total petani di kecamatan
- Petani belum verifikasi (dengan alert)
- Total laporan masuk
- Total bantuan diajukan
- Total hasil panen wilayah
```

### 2. Verifikasi Petani
- Lihat daftar petani baru yang mendaftar
- Approve/Reject pendaftaran
- Modal konfirmasi dengan detail lengkap
- Badge counter untuk pending verification

### 3. Verifikasi Laporan
- Review laporan yang disubmit petani
- Validasi data (approve/reject)
- Tambah catatan petugas
- Tandai laporan sudah diverifikasi

### 4. Kelola Bantuan
- Lihat semua pengajuan bantuan
- Update status: Pending → Diproses → Dikirim → Ditolak
- Tambah catatan untuk petani
- Filter berdasarkan status

### 5. Monitoring Wilayah
- Dashboard monitoring seluruh petani
- Grafik/chart hasil panen per periode
- List petani yang belum submit laporan
- Export data ke PDF untuk reporting

### 6. Notifikasi Khusus Petugas
- Alert saat ada pendaftaran baru
- Alert saat ada laporan baru
- Alert saat ada pengajuan bantuan baru

---

## 🌾 FITUR EKSKLUSIF PETANI

### 1. Dashboard Petani
```
STATISTIK PRIBADI:
- Total laporan saya
- Total bantuan saya
- Bantuan pending
- Total hasil panen saya
```

### 2. Input Laporan Panen
- Form input data panen
- Upload foto hasil panen (opsional)
- Input: jenis tanaman, luas lahan, hasil panen, tanggal
- Edit/Delete laporan sendiri (sebelum diverifikasi)

### 3. Pengajuan Bantuan
- Form ajukan bantuan
- Pilih jenis bantuan: Pupuk, Bibit, Alat Pertanian, dll
- Input jumlah yang dibutuhkan
- Keterangan kebutuhan
- Edit/Delete pengajuan (selama masih pending)

### 4. Riwayat Data Pribadi
- Lihat semua laporan yang pernah disubmit
- Lihat semua bantuan yang pernah diajukan
- Filter berdasarkan tanggal, status
- Download laporan pribadi (PDF)

### 5. Tracking Status
- Lihat status verifikasi laporan (pending/approved/rejected)
- Lihat status bantuan (pending/diproses/dikirim/ditolak)
- Lihat catatan dari petugas

### 6. Notifikasi Khusus Petani
- Notif saat akun diverifikasi
- Notif saat laporan diverifikasi
- Notif saat status bantuan berubah
- Notif saat dapat catatan dari petugas

---

## 🔒 ATURAN AKSES (Access Control)

### Petugas TIDAK BOLEH:
❌ Input laporan panen (bukan petani)
❌ Ajukan bantuan (bukan petani)
❌ Edit data petani lain tanpa izin
❌ Hapus data yang sudah diverifikasi

### Petani TIDAK BOLEH:
❌ Verifikasi akun petani lain
❌ Verifikasi laporan
❌ Update status bantuan
❌ Lihat data petani lain
❌ Akses menu monitoring wilayah
❌ Export data wilayah

---

## 🛣️ ROUTING STRATEGY

### Routes Petugas
```php
Route::prefix('petugas')->name('petugas.')->middleware('petugas')->group(function () {
    Route::get('dashboard', [PetugasController::class, 'dashboard']);
    
    // Verifikasi Petani
    Route::get('petani', [PetugasController::class, 'petaniIndex']);
    Route::post('petani/{id}/verify', [PetugasController::class, 'petaniVerify']);
    Route::delete('petani/{id}/reject', [PetugasController::class, 'petaniReject']);
    
    // Verifikasi Laporan
    Route::get('laporan', [PetugasController::class, 'laporanIndex']);
    Route::post('laporan/{id}/verify', [PetugasController::class, 'laporanVerify']);
    Route::post('laporan/{id}/reject', [PetugasController::class, 'laporanReject']);
    
    // Kelola Bantuan
    Route::get('bantuan', [PetugasController::class, 'bantuanIndex']);
    Route::post('bantuan/{id}/update-status', [PetugasController::class, 'updateStatus']);
    
    // Monitoring
    Route::get('monitoring', [PetugasController::class, 'monitoring']);
    Route::get('export/pdf', [PetugasController::class, 'exportPDF']);
});
```

### Routes Petani
```php
Route::prefix('petani')->name('petani.')->middleware('petani')->group(function () {
    Route::get('dashboard', [PetaniController::class, 'dashboard']);
    
    // Laporan Panen
    Route::get('laporan', [PetaniController::class, 'laporanIndex']);
    Route::get('laporan/create', [PetaniController::class, 'laporanCreate']);
    Route::post('laporan', [PetaniController::class, 'laporanStore']);
    Route::get('laporan/{id}/edit', [PetaniController::class, 'laporanEdit']);
    Route::put('laporan/{id}', [PetaniController::class, 'laporanUpdate']);
    Route::delete('laporan/{id}', [PetaniController::class, 'laporanDestroy']);
    
    // Bantuan
    Route::get('bantuan', [PetaniController::class, 'bantuanIndex']);
    Route::get('bantuan/create', [PetaniController::class, 'bantuanCreate']);
    Route::post('bantuan', [PetaniController::class, 'bantuanStore']);
    Route::get('bantuan/{id}/edit', [PetaniController::class, 'bantuanEdit']);
    Route::put('bantuan/{id}', [PetaniController::class, 'bantuanUpdate']);
    Route::delete('bantuan/{id}', [PetaniController::class, 'bantuanDestroy']);
    
    // Profil
    Route::get('profil', [PetaniController::class, 'profil']);
    Route::put('profil', [PetaniController::class, 'updateProfil']);
});
```

---

## 🎨 UI/UX DIFFERENCES

### Menu Sidebar Petugas
```
├── 📊 Dashboard
├── ✓ Verifikasi Petani [badge]
├── 📋 Verifikasi Laporan
├── 🎁 Kelola Bantuan
├── 📈 Monitoring Wilayah
└── 👤 Profil
```

### Menu Sidebar Petani
```
├── 📊 Dashboard
├── ➕ Input Data
├── 📋 Laporan Saya
├── 🎁 Bantuan Saya
└── 👤 Profil
```

---

## 📱 NOTIFICATION DIFFERENCES

### Petugas Menerima:
1. **Pendaftaran Petani Baru**
   - Icon: 👤 User
   - Warna: Biru
   - Aksi: Link ke verifikasi petani

2. **Laporan Baru Masuk**
   - Icon: 📋 Document
   - Warna: Hijau
   - Aksi: Link ke verifikasi laporan

3. **Pengajuan Bantuan Baru**
   - Icon: 🎁 Gift
   - Warna: Orange
   - Aksi: Link ke kelola bantuan

### Petani Menerima:
1. **Akun Terverifikasi**
   - Icon: ✓ Check
   - Warna: Hijau
   - Pesan: "Selamat! Akun Anda sudah diverifikasi oleh petugas"

2. **Laporan Diverifikasi**
   - Icon: ✓ Check
   - Warna: Hijau
   - Pesan: "Laporan panen Anda sudah diverifikasi"

3. **Laporan Ditolak**
   - Icon: ✗ Cross
   - Warna: Merah
   - Pesan: "Laporan ditolak. Catatan: [alasan]"

4. **Status Bantuan Berubah**
   - Icon: 🔔 Bell
   - Warna: Biru
   - Pesan: "Status bantuan Anda: Pending → Diproses"

---

## 🔐 SECURITY & VALIDATION

### Middleware Protection
```php
// Pastikan petugas tidak bisa akses route petani
Route::middleware('petugas')->group(function() {
    // hanya petugas yang bisa akses
});

// Pastikan petani tidak bisa akses route petugas
Route::middleware('petani')->group(function() {
    // hanya petani yang bisa akses
});
```

### Controller Validation
```php
// Di PetaniController - hanya bisa edit data sendiri
public function laporanEdit($id) {
    $laporan = Laporan::where('user_id', Auth::id())
                      ->findOrFail($id);
    // Jika bukan punya user, akan throw 404
}

// Di PetugasController - hanya bisa lihat data wilayahnya
public function laporanIndex() {
    $laporans = Laporan::whereHas('user', function($q) {
        $q->where('alamat_kecamatan', Auth::user()->alamat_kecamatan);
    })->get();
}
```

---

## 📊 DATABASE CONSTRAINTS

### Kolom `verified_by` di tabel `laporan`
```sql
verified_by: foreign key ke users.id (role: petugas)
verified_at: timestamp
status_verifikasi: enum('pending', 'approved', 'rejected')
catatan_petugas: text (opsional)
```

### Kolom `updated_by` di tabel `bantuan`
```sql
updated_by: foreign key ke users.id (role: petugas)
updated_at: timestamp
status: enum('pending', 'diproses', 'dikirim', 'ditolak')
catatan_petugas: text (opsional)
```

---

## ✅ IMPLEMENTATION CHECKLIST

### Backend
- [ ] Pisahkan semua method di PetugasController vs PetaniController
- [ ] Tambah middleware 'petugas' dan 'petani' ke semua route
- [ ] Validasi ownership di setiap method (user hanya bisa edit data sendiri)
- [ ] Filter berdasarkan wilayah untuk petugas
- [ ] Add kolom verified_by, status_verifikasi di tabel laporan
- [ ] Add kolom updated_by, catatan_petugas di tabel bantuan

### Frontend
- [ ] Buat menu sidebar berbeda untuk petugas vs petani
- [ ] Buat dashboard berbeda dengan statistik sesuai role
- [ ] Hide/Show fitur berdasarkan role (@if Auth::user()->role === 'petugas')
- [ ] Badge counter untuk petugas di menu verifikasi
- [ ] Alert/Warning jika user salah role coba akses fitur

### Testing
- [ ] Test petugas tidak bisa akses route petani
- [ ] Test petani tidak bisa akses route petugas
- [ ] Test petani hanya bisa edit data sendiri
- [ ] Test petugas hanya bisa lihat data wilayahnya
- [ ] Test notification dikirim ke role yang benar

---

## 🚀 NEXT STEPS

1. **Update Routes** - Pisahkan dengan jelas route petugas vs petani
2. **Update Middleware** - Pastikan setiap route punya middleware yang benar
3. **Update Controllers** - Tambah validasi ownership dan wilayah
4. **Update Views** - Customize UI berdasarkan role
5. **Add Notifications** - Implement notif berbeda untuk setiap role
6. **Testing** - Test semua skenario akses

---

**Status:** 📝 Planning Complete  
**Ready for Implementation:** ✅ Yes  
**Estimated Time:** 4-6 hours
