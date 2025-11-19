# 🌾 Sistem Informasi Pertanian

Aplikasi web untuk manajemen data pertanian, laporan hasil panen, dan distribusi bantuan kepada petani.

![Laravel](https://img.shields.io/badge/Laravel-12.31.1-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3.2-blue?style=flat&logo=php)
![License](https://img.shields.io/badge/License-MIT-green?style=flat)

---

## 📋 Tentang Project

Sistem Informasi Pertanian adalah aplikasi berbasis web yang dirancang untuk membantu pengelolaan data pertanian dengan fitur:

- 👥 **Multi-Role System** (Admin, Petugas, Petani)
- 📊 **Dashboard Modern** dengan visualisasi data
- 🌾 **Manajemen Laporan Panen**
- 🎁 **Sistem Distribusi Bantuan**
- ✅ **Verifikasi Petani** oleh Petugas
- 📰 **Berita & Newsletter**
- 🖼️ **Galeri Foto**
- 📱 **Responsive Design**

---

## 🚀 Quick Start

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

### Installation

1. **Clone Repository**
   ```bash
   git clone https://github.com/RickySilaen/TAAAAA.git
   cd sistem_pertanian
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   
   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run Migration & Seeder**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Build Assets**
   ```bash
   npm run build
   ```

8. **Run Application**
   ```bash
   php artisan serve
   ```

   Akses di: `http://localhost:8000`

---

## 👤 Default Users

Setelah seeding, gunakan akun berikut:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@pertanian.com | password |
| Petugas | petugas@pertanian.com | password |
| Petani | petani@pertanian.com | password |

---

## 📁 Struktur Project

```
sistem_pertanian/
├── app/                    # Application code
│   ├── Http/              # Controllers, Middleware
│   ├── Models/            # Eloquent models
│   └── Notifications/     # Email notifications
├── config/                # Configuration files
├── database/              # Migrations, seeders
├── docs/                  # 📚 Dokumentasi (BARU!)
│   ├── panduan/          # User guides
│   ├── guides/           # Technical docs
│   ├── logs/             # Change logs
│   └── summaries/        # Summary docs
├── public/               # Public assets
├── resources/            # Views, CSS, JS
│   ├── views/           # Blade templates
│   └── css/             # Stylesheets
├── routes/              # Route definitions
└── storage/             # Uploaded files, logs
```

---

## 📚 Dokumentasi

Dokumentasi lengkap tersedia di folder [`docs/`](docs/):

### 📖 Panduan Pengguna
- [Panduan Dashboard Admin](docs/panduan/PANDUAN_DASHBOARD_ADMIN.md)
- [Panduan Kelola Petugas](docs/panduan/PANDUAN_KELOLA_PETUGAS.md)
- [Panduan Kelola Petani](docs/panduan/PANDUAN_KELOLA_PETANI.md)
- [Panduan Sistem Verifikasi](docs/panduan/PANDUAN_SISTEM_VERIFIKASI.md)

### 🔧 Dokumentasi Teknis
Lihat [docs/guides/](docs/guides/) untuk dokumentasi teknis lengkap

### 📝 Change Logs
Lihat [docs/logs/](docs/logs/) untuk riwayat perubahan

### 📊 Laporan Pembersihan
- [Laporan Pembersihan Project](docs/LAPORAN_PEMBERSIHAN_PROJECT.md)

---

## 🎨 Fitur Utama

### Untuk Admin
- ✅ Dashboard dengan statistik lengkap
- ✅ Manajemen Petugas & Petani
- ✅ Kelola Berita & Newsletter
- ✅ Galeri Foto
- ✅ Laporan & Export PDF

### Untuk Petugas
- ✅ Verifikasi Petani
- ✅ Monitoring Laporan
- ✅ Validasi Bantuan
- ✅ Dashboard Wilayah

### Untuk Petani
- ✅ Input Laporan Panen
- ✅ Pengajuan Bantuan
- ✅ Riwayat Transaksi
- ✅ Notifikasi Status

---

## 🛠️ Tech Stack

- **Framework:** Laravel 12.31.1
- **PHP:** 8.3.2
- **Database:** MySQL
- **Frontend:** Bootstrap 5, Vite
- **Icons:** Font Awesome
- **PDF:** DomPDF

---

## 🔧 Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

### Clear Cache
```bash
php artisan optimize:clear
```

### Watch Assets
```bash
npm run dev
```

---

## 📝 License

Project ini menggunakan [MIT License](LICENSE).

---

## 👨‍💻 Author

**Ricky Silaen**  
GitHub: [@RickySilaen](https://github.com/RickySilaen)

---

## 🙏 Acknowledgments

- Laravel Framework
- Bootstrap
- Font Awesome
- Semua kontributor open source

---

## 📞 Support

Jika ada pertanyaan atau masalah:
- 📧 Email: support@pertanian.com
- 🐛 Issues: [GitHub Issues](https://github.com/RickySilaen/TAAAAA/issues)
- 📖 Docs: [Documentation](docs/)

---

<p align="center">
  Made with ❤️ using Laravel
</p>

