# 🌾 Sistem Informasi Pertanian

[![Laravel](https://img.shields.io/badge/Laravel-12.40.2-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)
[![Tests](https://img.shields.io/badge/Tests-153%20Passed-success?style=for-the-badge)](tests)

Aplikasi web modern untuk manajemen data pertanian, laporan hasil panen, dan distribusi bantuan kepada petani dengan sistem multi-role yang terintegrasi.

---

## 📋 Daftar Isi

- [Tentang Project](#-tentang-project)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Quick Start](#-quick-start)
- [Deployment](#-deployment)
- [Testing](#-testing)
- [Dokumentasi](#-dokumentasi)
- [Kontribusi](#-kontribusi)
- [License](#-license)

---

## 🎯 Tentang Project

Sistem Informasi Pertanian adalah aplikasi berbasis web yang dirancang untuk membantu pengelolaan data pertanian secara modern, transparan, dan efisien. Aplikasi ini memfasilitasi komunikasi antara petani, petugas lapangan, dan administrator dalam satu platform terpadu.

### 🎭 Roles & Permissions

| Role | Akses |
|------|-------|
| **Admin** | Manajemen penuh sistem, berita, galeri, newsletter, feedback |
| **Petugas** | Verifikasi petani, validasi laporan panen, monitoring bantuan |
| **Petani** | Submit laporan panen, request bantuan, akses informasi |
| **Guest** | Lihat berita, galeri, statistik publik, subscribe newsletter |

---

## ✨ Fitur Utama

### 👥 User Management
- ✅ Multi-role authentication (Admin, Petugas, Petani)
- ✅ Email verification system
- ✅ Profile management dengan foto
- ✅ Role-based access control (RBAC)

### 🌾 Laporan Pertanian
- 📊 Dashboard dengan visualisasi data real-time
- 📝 Form laporan hasil panen (jenis tanaman, luas lahan, hasil)
- ✅ Sistem verifikasi laporan oleh petugas
- 📈 Statistik produksi pertanian
- 📱 Responsive interface untuk mobile

### 🎁 Manajemen Bantuan
- 📋 Request bantuan dari petani
- ✅ Approval workflow multi-level
- 📊 Tracking status bantuan
- 🔍 Transparansi distribusi bantuan publik
- 📄 Generate PDF reports

### 📰 Content Management
- ✍️ Berita pertanian dengan slug SEO-friendly
- 🖼️ Galeri foto kegiatan
- 📧 Newsletter system dengan subscription
- 💬 Feedback & communication system

### 🔒 Security Features
- 🛡️ XSS Protection
- 🔐 CSRF Protection
- ⚡ Rate Limiting
- 🔑 Password hashing (bcrypt)
- 🚫 SQL Injection prevention
- 🔒 Secure headers

### 📊 Transparansi Publik
- 📈 Dashboard publik statistik pertanian
- 🗂️ Data bantuan yang telah didistribusikan
- 📊 Laporan hasil panen yang terverifikasi
- 📰 Akses berita dan informasi

---

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12.40.2
- **PHP**: 8.2+
- **Database**: MySQL 8.0+
- **ORM**: Eloquent
- **Authentication**: Laravel UI + Custom RBAC

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Bootstrap 5
- **Icons**: Font Awesome, Feather Icons
- **Charts**: Chart.js
- **Build Tool**: Vite

### Testing
- **Framework**: PHPUnit
- **Coverage**: 153 tests, 400 assertions
- **Success Rate**: 100%

### DevOps
- **Containerization**: Docker, Docker Compose
- **CI/CD**: GitHub Actions
- **Deployment**: Railway, Heroku support
- **Code Quality**: PHPStan, Laravel Pint

---

## 🚀 Quick Start

### Prerequisites

```bash
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18.x
- NPM or Yarn
```

### Installation

1. **Clone Repository**
   ```bash
   git clone https://github.com/RickySilaen/TAAAAA.git
   cd TAAAAA
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

4. **Configure Database**
   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sistem_pertanian
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Build Assets**
   ```bash
   npm run build
   ```

8. **Start Development Server**
   ```bash
   php artisan serve
   ```

   Access: `http://localhost:8000`

### 🔑 Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@pertanian.com | admin123 |
| Petugas | petugas@pertanian.com | petugas123 |
| Petani | petani@pertanian.com | petani123 |

---

## 🚢 Deployment

### Railway (Recommended)

1. Fork this repository
2. Connect to Railway
3. Add environment variables
4. Deploy automatically

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new)

Detailed guide: [Railway Deployment Guide](docs/RAILWAY_DEPLOYMENT_GUIDE.md)

### Docker

```bash
docker-compose up -d
```

### Heroku

```bash
heroku create your-app-name
git push heroku main
```

Detailed guide: [Heroku Deployment Guide](docs/HEROKU_DEPLOYMENT_GUIDE.md)

---

## 🧪 Testing

### Run All Tests
```bash
php artisan test
```

### Run Specific Test Suite
```bash
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

### Run with Coverage
```bash
php artisan test --coverage
```

### Code Quality
```bash
# PHP Stan
./vendor/bin/phpstan analyse

# Laravel Pint (Code Style)
./vendor/bin/pint
```

---

## 📚 Dokumentasi

- [API Documentation](docs/API_DOCUMENTATION.md)
- [Database Schema](docs/DATABASE_SCHEMA.md)
- [Architecture Overview](docs/ARCHITECTURE.md)
- [Deployment Guides](docs/)
- [User Guides](docs/)
  - [Panduan Akses Berita dan Transparansi](docs/PANDUAN_AKSES_BERITA_DAN_TRANSPARANSI.md)
  - [Panduan Penggunaan Transparansi](docs/PANDUAN_PENGGUNAAN_TRANSPARANSI.md)
  - [Quick Start Laporan Bantuan](docs/QUICK_START_LAPORAN_BANTUAN.md)

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan baca [CONTRIBUTING.md](CONTRIBUTING.md) untuk detail proses development dan pull request.

### Development Workflow

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

### Code Standards

- Follow PSR-12 coding standard
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

---

## 🐛 Bug Reports

Temukan bug? Silakan buat [issue](https://github.com/RickySilaen/TAAAAA/issues) dengan detail:
- Deskripsi bug
- Steps to reproduce
- Expected behavior
- Screenshots (jika ada)
- Environment info

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**Ricky Silaen**

- GitHub: [@RickySilaen](https://github.com/RickySilaen)
- Project: [Sistem Informasi Pertanian](https://github.com/RickySilaen/TAAAAA)

---

## 🙏 Acknowledgments

- Laravel Community
- Bootstrap Team
- All Contributors

---

## 📞 Support

Untuk pertanyaan atau dukungan, silakan:
- Buka [Issue](https://github.com/RickySilaen/TAAAAA/issues)
- Email: support@pertanian.com

---

<div align="center">

**Made with ❤️ for Indonesian Farmers**

⭐ Star project ini jika membantu!

</div>

