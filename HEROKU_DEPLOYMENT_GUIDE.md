# 🚀 Panduan Deploy ke Heroku

Panduan lengkap untuk deploy aplikasi Sistem Pertanian ke Heroku.

## 📋 Prasyarat

1. **Akun Heroku** - Daftar di [heroku.com](https://signup.heroku.com/)
2. **Heroku CLI** - Install dari [devcenter.heroku.com/articles/heroku-cli](https://devcenter.heroku.com/articles/heroku-cli)
3. **Git** - Pastikan git sudah terinstall

## 🔧 Langkah-langkah Deployment

### 1. Login ke Heroku

```bash
heroku login
```

Akan membuka browser untuk login. Setelah login, kembali ke terminal.

### 2. Buat Aplikasi Heroku Baru

```bash
# Buat aplikasi dengan nama custom (opsional)
heroku create nama-aplikasi-anda

# Atau biarkan Heroku generate nama otomatis
heroku create
```

### 3. Tambahkan Database MySQL (JawsDB)

```bash
# Add JawsDB MySQL addon (gratis)
heroku addons:create jawsdb:kitefin
```

### 4. Set Environment Variables

```bash
# Set APP_KEY (generate dulu)
php artisan key:generate --show

# Set semua environment variables
heroku config:set APP_NAME="Sistem Pertanian"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY="base64:xxxxx" # ganti dengan hasil generate
heroku config:set LOG_CHANNEL=stack
heroku config:set LOG_LEVEL=error
heroku config:set QUEUE_CONNECTION=database
heroku config:set SESSION_DRIVER=database
heroku config:set CACHE_DRIVER=database
```

### 5. Konfigurasi Database dari JawsDB

```bash
# Lihat database credentials
heroku config:get JAWSDB_URL

# URL format: mysql://username:password@host:port/database
# Set database config secara manual
heroku config:set DB_CONNECTION=mysql
heroku config:set DB_HOST=xxxxx.jawsdb.com
heroku config:set DB_PORT=3306
heroku config:set DB_DATABASE=xxxxx
heroku config:set DB_USERNAME=xxxxx
heroku config:set DB_PASSWORD=xxxxx
```

### 6. Deploy ke Heroku

```bash
# Push ke Heroku
git push heroku main

# Jika branch Anda bukan main
git push heroku master:main
```

### 7. Jalankan Migration

```bash
heroku run php artisan migrate --force
```

### 8. Seed Database (Opsional)

```bash
heroku run php artisan db:seed --force
```

### 9. Optimasi

```bash
heroku run php artisan config:cache
heroku run php artisan route:cache
heroku run php artisan view:cache
```

## 🔍 Perintah Berguna

### Cek Logs
```bash
# Real-time logs
heroku logs --tail

# Logs terakhir
heroku logs --num=200
```

### Buka Aplikasi
```bash
heroku open
```

### Restart Aplikasi
```bash
heroku restart
```

### Jalankan Artisan Commands
```bash
heroku run php artisan [command]
```

### SSH ke Server
```bash
heroku run bash
```

## 🔐 Environment Variables Penting

Pastikan set semua variable ini:

```bash
heroku config:set APP_NAME="Sistem Pertanian"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY="base64:xxxxx"
heroku config:set APP_URL=https://nama-app.herokuapp.com

heroku config:set DB_CONNECTION=mysql
heroku config:set DB_HOST=xxxxx.jawsdb.com
heroku config:set DB_PORT=3306
heroku config:set DB_DATABASE=xxxxx
heroku config:set DB_USERNAME=xxxxx
heroku config:set DB_PASSWORD=xxxxx

heroku config:set LOG_CHANNEL=stack
heroku config:set LOG_LEVEL=error
heroku config:set QUEUE_CONNECTION=database
heroku config:set SESSION_DRIVER=database
heroku config:set CACHE_DRIVER=database
```

## 📧 Email Configuration (Opsional)

Jika menggunakan email:

```bash
heroku config:set MAIL_MAILER=smtp
heroku config:set MAIL_HOST=smtp.gmail.com
heroku config:set MAIL_PORT=587
heroku config:set MAIL_USERNAME=your-email@gmail.com
heroku config:set MAIL_PASSWORD=your-app-password
heroku config:set MAIL_ENCRYPTION=tls
heroku config:set MAIL_FROM_ADDRESS=your-email@gmail.com
heroku config:set MAIL_FROM_NAME="Sistem Pertanian"
```

## 🔄 Update Aplikasi

Setiap kali ada perubahan:

```bash
# Commit perubahan
git add .
git commit -m "Update feature"

# Push ke Heroku
git push heroku main

# Clear cache jika perlu
heroku run php artisan config:clear
heroku run php artisan cache:clear
```

## ⚠️ Troubleshooting

### Error 500 Internal Server Error
```bash
# Cek logs
heroku logs --tail

# Clear cache
heroku run php artisan config:clear
heroku run php artisan cache:clear

# Set APP_DEBUG temporary
heroku config:set APP_DEBUG=true
# Setelah fix, set kembali ke false
heroku config:set APP_DEBUG=false
```

### Database Connection Error
```bash
# Verifikasi database credentials
heroku config

# Test connection
heroku run php artisan migrate:status
```

### Storage Issues
```bash
# Create storage link
heroku run php artisan storage:link

# Set proper permissions (sudah di post-install script)
```

## 📊 Monitoring

### Database Size
```bash
heroku addons:info jawsdb
```

### App Performance
```bash
heroku ps
heroku logs --tail
```

## 🎯 Tips Deployment

1. **Gunakan .gitignore** yang benar (jangan commit .env, node_modules, vendor)
2. **Set APP_DEBUG=false** di production
3. **Monitor logs** secara berkala
4. **Backup database** secara rutin
5. **Test di local** sebelum deploy
6. **Gunakan queue** untuk task berat
7. **Cache config, routes, views** untuk performa lebih baik

## 🆓 Free Tier Limitations

Heroku free tier (Eco dynos):
- 1000 jam/bulan
- Sleep setelah 30 menit tidak aktif
- Database: 5MB (JawsDB free)

**Note:** Untuk production, pertimbangkan upgrade ke paid plan.

## 📚 Resources

- [Heroku Laravel Docs](https://devcenter.heroku.com/articles/getting-started-with-laravel)
- [JawsDB Documentation](https://devcenter.heroku.com/articles/jawsdb)
- [Heroku CLI Commands](https://devcenter.heroku.com/articles/heroku-cli-commands)

## ✅ Checklist Deployment

- [ ] Login ke Heroku
- [ ] Buat aplikasi baru
- [ ] Tambahkan JawsDB MySQL addon
- [ ] Set APP_KEY
- [ ] Set environment variables
- [ ] Konfigurasi database credentials
- [ ] Push ke Heroku
- [ ] Run migrations
- [ ] Seed database (opsional)
- [ ] Cache config/routes/views
- [ ] Test aplikasi
- [ ] Monitor logs

## 🎉 Selesai!

Aplikasi Anda sekarang live di Heroku!

URL: `https://nama-app.herokuapp.com`

---

**Note:** File konfigurasi Heroku yang sudah dibuat:
- `Procfile` - Konfigurasi web server
- `app.json` - Metadata aplikasi dan addons
- `post-deploy.sh` - Script post-deployment
- `composer.json` - Script Composer untuk Heroku
