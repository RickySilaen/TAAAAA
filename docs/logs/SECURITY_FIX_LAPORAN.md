# Security Fix - Access Control untuk Laporan Publik
**Tanggal:** November 10, 2025

## 🔒 **Perbaikan Keamanan yang Diterapkan**

### ✅ **Masalah yang Diperbaiki**
Sebelumnya, semua pengunjung (guest/tidak login) bisa mengakses fitur:
- ❌ Tambah Laporan
- ❌ Edit Laporan
- ❌ Hapus Laporan

Ini adalah masalah keamanan karena data laporan seharusnya hanya bisa dikelola oleh user yang sudah login dan memiliki hak akses.

---

## 🛡️ **Solusi yang Diterapkan**

### 1. **Validasi di View (Frontend)**

**File:** `resources/views/guest/laporan.blade.php`

#### A. Tombol "Tambah Laporan"
```php
@auth
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('guest.laporan.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Laporan
    </a>
</div>
@else
<div class="alert alert-info mb-3">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Informasi:</strong> Silakan <a href="{{ route('login') }}" class="alert-link">login</a> terlebih dahulu untuk menambah laporan.
</div>
@endauth
```

**Penjelasan:**
- Tombol "Tambah Laporan" hanya muncul jika user sudah login (`@auth`)
- Jika belum login, muncul alert yang mengarahkan ke halaman login

#### B. Tombol Edit & Delete di Tabel
```php
<td class="text-center">
    <!-- Tombol Lihat (semua orang bisa akses) -->
    <a href="{{ route('guest.laporan.show', $laporan->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
        <i class="bi bi-eye"></i>
    </a>
    
    @auth
        @if(auth()->user()->id == $laporan->user_id || auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
            <!-- Tombol Edit (hanya pemilik, admin, petugas) -->
            <a href="{{ route('guest.laporan.edit', $laporan->id) }}" class="btn btn-sm btn-warning text-white" title="Edit Laporan">
                <i class="bi bi-pencil-square"></i>
            </a>
            
            <!-- Tombol Delete (hanya pemilik, admin, petugas) -->
            <form action="{{ route('guest.laporan.destroy', $laporan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus laporan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Laporan">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        @endif
    @endauth
</td>
```

**Penjelasan:**
- Tombol "Lihat" tetap bisa diakses semua orang (untuk transparansi)
- Tombol "Edit" dan "Delete" hanya muncul jika:
  1. User sudah login (`@auth`)
  2. User adalah pemilik laporan (`auth()->user()->id == $laporan->user_id`)
  3. ATAU user memiliki role 'admin'
  4. ATAU user memiliki role 'petugas'

---

### 2. **Validasi di Controller (Backend)**

**File:** `app/Http/Controllers/GuestController.php`

#### A. Fungsi `laporanCreate()`
```php
public function laporanCreate()
{
    // Cek apakah user sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat laporan.');
    }

    return view('guest.laporan.create');
}
```

**Keamanan:**
- ✅ Cek login sebelum menampilkan form
- ✅ Redirect ke login jika belum login
- ✅ Tampilkan pesan error

#### B. Fungsi `laporanStore()`
```php
public function laporanStore(Request $request)
{
    // Cek apakah user sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat laporan.');
    }

    // Validasi input
    $request->validate([...]);

    $data = $request->all();
    $data['user_id'] = auth()->id(); // Set user_id dari user yang login
    
    $laporan = Laporan::create($data);

    // Kirim notifikasi hanya ke admin dan petugas
    $users = \App\Models\User::whereIn('role', ['admin', 'petugas'])->get();
    Notification::send($users, new LaporanCreated($laporan));

    return redirect()->route('guest.laporan.index')->with('success', 'Laporan berhasil dibuat!');
}
```

**Keamanan:**
- ✅ Cek login
- ✅ Set `user_id` otomatis dari user yang login (tidak bisa dimanipulasi)
- ✅ Notifikasi hanya ke admin & petugas (bukan semua user)

#### C. Fungsi `laporanEdit()`
```php
public function laporanEdit($id)
{
    // Cek apakah user sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengedit laporan.');
    }

    $laporan = Laporan::findOrFail($id);
    
    // Cek apakah user memiliki hak akses (pemilik, admin, atau petugas)
    if (auth()->user()->id != $laporan->user_id && 
        auth()->user()->role != 'admin' && 
        auth()->user()->role != 'petugas') {
        return redirect()->route('guest.laporan.index')->with('error', 'Anda tidak memiliki hak akses untuk mengedit laporan ini.');
    }
    
    return view('guest.laporan.edit', compact('laporan'));
}
```

**Keamanan:**
- ✅ Cek login
- ✅ Cek kepemilikan atau role
- ✅ Redirect dengan pesan error jika tidak berhak

#### D. Fungsi `laporanUpdate()`
```php
public function laporanUpdate(Request $request, $id)
{
    // Cek apakah user sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengupdate laporan.');
    }

    $laporan = Laporan::findOrFail($id);
    
    // Cek apakah user memiliki hak akses (pemilik, admin, atau petugas)
    if (auth()->user()->id != $laporan->user_id && 
        auth()->user()->role != 'admin' && 
        auth()->user()->role != 'petugas') {
        return redirect()->route('guest.laporan.index')->with('error', 'Anda tidak memiliki hak akses untuk mengupdate laporan ini.');
    }

    // Validasi dan update
    $request->validate([...]);
    $laporan->update($data);

    return redirect()->route('guest.laporan.show', $laporan->id)->with('success', 'Laporan berhasil diperbarui!');
}
```

**Keamanan:**
- ✅ Cek login
- ✅ Cek kepemilikan atau role
- ✅ Validasi input
- ✅ Update hanya jika berhak

#### E. Fungsi `laporanDestroy()`
```php
public function laporanDestroy($id)
{
    // Cek apakah user sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk menghapus laporan.');
    }

    $laporan = Laporan::findOrFail($id);
    
    // Cek apakah user memiliki hak akses (pemilik, admin, atau petugas)
    if (auth()->user()->id != $laporan->user_id && 
        auth()->user()->role != 'admin' && 
        auth()->user()->role != 'petugas') {
        return redirect()->route('guest.laporan.index')->with('error', 'Anda tidak memiliki hak akses untuk menghapus laporan ini.');
    }

    $laporan->delete();

    return redirect()->route('guest.laporan.index')->with('success', 'Laporan berhasil dihapus!');
}
```

**Keamanan:**
- ✅ Cek login
- ✅ Cek kepemilikan atau role
- ✅ Delete hanya jika berhak

---

## 🎯 **Matrix Hak Akses**

| Aksi | Guest (Tidak Login) | User Biasa | Pemilik Laporan | Admin | Petugas |
|------|---------------------|------------|-----------------|-------|---------|
| **Lihat Daftar Laporan** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Lihat Detail Laporan** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Tambah Laporan** | ❌ | ✅ | ✅ | ✅ | ✅ |
| **Edit Laporan Sendiri** | ❌ | ❌ | ✅ | ✅ | ✅ |
| **Edit Laporan Orang Lain** | ❌ | ❌ | ❌ | ✅ | ✅ |
| **Hapus Laporan Sendiri** | ❌ | ❌ | ✅ | ✅ | ✅ |
| **Hapus Laporan Orang Lain** | ❌ | ❌ | ❌ | ✅ | ✅ |

---

## 🔐 **Lapisan Keamanan**

### 1. **Frontend Security (View)**
- Menyembunyikan tombol aksi dari user yang tidak berhak
- Menampilkan pesan informasi untuk user yang belum login
- User experience yang baik (UX)

### 2. **Backend Security (Controller)**
- Validasi authentication (`auth()->check()`)
- Validasi authorization (cek kepemilikan & role)
- Redirect dengan pesan error yang jelas
- Mencegah akses langsung via URL

### 3. **Database Security**
- `user_id` diset otomatis dari `auth()->id()`
- Tidak bisa dimanipulasi via request
- Foreign key relationship dengan tabel users

---

## 📋 **Testing Checklist**

### ✅ Sebagai Guest (Tidak Login):
- [ ] Tidak bisa lihat tombol "Tambah Laporan"
- [ ] Melihat alert untuk login jika ingin tambah laporan
- [ ] Tidak bisa lihat tombol "Edit" & "Delete" di tabel
- [ ] Bisa lihat tombol "Lihat Detail"
- [ ] Jika akses URL langsung `/laporan-publik/create` → redirect ke login
- [ ] Jika akses URL langsung `/laporan-publik/{id}/edit` → redirect ke login

### ✅ Sebagai User Login (Bukan Pemilik):
- [ ] Bisa lihat tombol "Tambah Laporan"
- [ ] Tidak bisa lihat tombol "Edit" & "Delete" untuk laporan orang lain
- [ ] Bisa lihat tombol "Edit" & "Delete" untuk laporan sendiri
- [ ] Jika akses URL edit laporan orang lain → redirect dengan error

### ✅ Sebagai Pemilik Laporan:
- [ ] Bisa lihat tombol "Tambah Laporan"
- [ ] Bisa lihat tombol "Edit" & "Delete" untuk laporan sendiri
- [ ] Bisa edit & hapus laporan sendiri
- [ ] Tidak bisa edit laporan orang lain (kecuali admin/petugas)

### ✅ Sebagai Admin/Petugas:
- [ ] Bisa lihat semua tombol aksi
- [ ] Bisa edit & hapus semua laporan
- [ ] Bisa tambah laporan baru

---

## 📝 **Pesan Error yang Ditampilkan**

| Skenario | Pesan |
|----------|-------|
| Akses create tanpa login | "Silakan login terlebih dahulu untuk membuat laporan." |
| Akses edit tanpa login | "Silakan login terlebih dahulu untuk mengedit laporan." |
| Akses update tanpa login | "Silakan login terlebih dahulu untuk mengupdate laporan." |
| Akses delete tanpa login | "Silakan login terlebih dahulu untuk menghapus laporan." |
| Edit laporan tanpa hak akses | "Anda tidak memiliki hak akses untuk mengedit laporan ini." |
| Update laporan tanpa hak akses | "Anda tidak memiliki hak akses untuk mengupdate laporan ini." |
| Delete laporan tanpa hak akses | "Anda tidak memiliki hak akses untuk menghapus laporan ini." |

---

## ✅ **Status Implementasi**

- ✅ Frontend validation (View) - SELESAI
- ✅ Backend validation (Controller) - SELESAI
- ✅ User_id auto-set - SELESAI
- ✅ Role-based access control - SELESAI
- ✅ Error messages - SELESAI
- ✅ Cache cleared - SELESAI

---

## 🚀 **Cara Testing**

1. **Test sebagai Guest:**
   ```
   - Buka http://127.0.0.1:8000/laporan-publik
   - Pastikan tidak ada tombol Edit/Delete
   - Pastikan ada alert "Silakan login"
   ```

2. **Test sebagai User Login:**
   ```
   - Login dengan akun user biasa
   - Buat laporan baru
   - Coba edit laporan sendiri ✅
   - Coba edit laporan orang lain ❌
   ```

3. **Test sebagai Admin:**
   ```
   - Login dengan akun admin
   - Bisa edit/hapus semua laporan ✅
   ```

---

**Tanggal:** November 10, 2025  
**Status:** ✅ Keamanan Akses Laporan Berhasil Diterapkan  
**File yang Dimodifikasi:**
- `resources/views/guest/laporan.blade.php`
- `app/Http/Controllers/GuestController.php`
