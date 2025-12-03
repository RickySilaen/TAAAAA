# 🚂 Panduan Deploy ke Railway

Panduan lengkap untuk deploy aplikasi Sistem Pertanian ke Railway.

## 🌟 Kenapa Railway?

- ✅ **Gratis $5/bulan credit** (cukup untuk project kecil-menengah)
- ✅ **Setup super mudah** - tidak perlu CLI
- ✅ **Auto SSL** certificate (HTTPS gratis)
- ✅ **Database included** (MySQL/PostgreSQL)
- ✅ **Deploy dari GitHub** otomatis
- ✅ **Environment variables** mudah diatur
- ✅ **No sleep** seperti Heroku free tier

---

## 📋 Prasyarat

1. **Akun Railway** - Daftar di [railway.app](https://railway.app/) (bisa pakai GitHub)
2. **Repository GitHub** - Code sudah di push ke GitHub

---

## 🚀 Langkah-langkah Deployment

### 1. Login ke Railway

1. Buka [railway.app](https://railway.app/)
2. Klik **"Login"** atau **"Start a New Project"**
3. Login dengan **GitHub account**

### 2. Create New Project

1. Klik **"New Project"**
2. Pilih **"Deploy from GitHub repo"**
3. Pilih repository: **`vanchristjh/DPT`** atau **`RickySilaen/TAAAAA`**
4. Klik repository untuk deploy

### 3. Add Database

1. Klik **"+ New"** di project
2. Pilih **"Database"** → **"Add MySQL"**
3. Railway akan otomatis create MySQL database

### 4. Configure Environment Variables

1. Klik service **Laravel app** Anda
2. Klik tab **"Variables"**
3. Klik **"+ New Variable"** dan tambahkan:

```
APP_NAME=Sistem Pertanian
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-app-key-here
APP_URL=https://your-app.up.railway.app

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}

CACHE_DRIVER=database
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

BROADCAST_DRIVER=log
FILESYSTEM_DISK=local
```

**Catatan Penting untuk APP_KEY:**
```bash
# Generate di local
php artisan key:generate --show
# Copy hasilnya ke APP_KEY
```

### 5. Reference Database Variables (PENTING!)

Railway menggunakan reference variables. Pastikan database variables sudah benar:

1. Di tab Variables, MySQL akan otomatis tersedia sebagai:
   - `${{MySQL.MYSQL_HOST}}`
   - `${{MySQL.MYSQL_PORT}}`
   - `${{MySQL.MYSQL_DATABASE}}`
   - `${{MySQL.MYSQL_USER}}`
   - `${{MySQL.MYSQL_PASSWORD}}`

2. Railway akan otomatis replace dengan nilai sebenarnya

### 6. Deploy!

1. Railway akan **otomatis deploy** setelah setup
2. Lihat progress di tab **"Deployments"**
3. Tunggu hingga status menjadi **"Success"**

### 7. Run Migrations

**Option A: Menggunakan Railway Dashboard**

1. Klik tab **"Settings"**
2. Scroll ke **"Deploy"**
3. Di **"Custom Start Command"**, pastikan sudah ada:
   ```
   php artisan migrate --force && php artisan config:cache && php artisan serve --host=0.0.0.0 --port=$PORT
   ```

**Option B: Manual via Railway CLI (Opsional)**

```bash
# Install Railway CLI
npm install -g @railway/cli

# Login
railway login

# Link project
railway link

# Run migration
railway run php artisan migrate --force

# Seed database (opsional)
railway run php artisan db:seed --force
```

### 8. Get Your URL

1. Klik tab **"Settings"**
2. Scroll ke **"Domains"**
3. Klik **"Generate Domain"**
4. Copy URL: `https://your-app.up.railway.app`
5. Update `APP_URL` di environment variables dengan URL ini

### 9. Test Aplikasi

Buka URL Railway Anda dan test:
- Login page
- Dashboard
- Database connection

---

## 🔄 Auto Deploy dari GitHub

Railway sudah otomatis setup auto-deploy:

1. Push perubahan ke GitHub:
   ```bash
   git add .
   git commit -m "Update feature"
   git push origin main
   ```

2. Railway akan **otomatis detect** dan **re-deploy**
3. Monitor di tab **"Deployments"**

---

## ⚙️ Konfigurasi Lanjutan

### Custom Domain

1. Klik tab **"Settings"**
2. Scroll ke **"Domains"**
3. Klik **"Custom Domain"**
4. Masukkan domain Anda
5. Update DNS records sesuai instruksi

### Environment Groups

Untuk manage environment variables lebih mudah:

1. Klik **"+ New"** → **"Empty Service"**
2. Buat environment group
3. Share variables antar services

### Health Checks

Railway otomatis melakukan health check ke `/` endpoint.

### Logs & Monitoring

1. Klik tab **"Deployments"**
2. Klik deployment yang aktif
3. Lihat **real-time logs**
4. Monitor resource usage (CPU, Memory, Network)

---

## 🔍 Perintah Railway CLI (Opsional)

### Install CLI
```bash
npm install -g @railway/cli
```

### Login
```bash
railway login
```

### Link Project
```bash
railway link
```

### Run Commands
```bash
# Run migration
railway run php artisan migrate --force

# Seed database
railway run php artisan db:seed

# Clear cache
railway run php artisan cache:clear

# Run tinker
railway run php artisan tinker

# Check logs
railway logs
```

### Deploy Manual
```bash
railway up
```

---

## 💰 Pricing & Limits

### Free Tier ($5 credit/month)
- **$5 credit** gratis setiap bulan
- **512MB RAM** per service
- **1GB Disk** per service
- **100GB Bandwidth** per month
- **No sleep** - always online!

### Estimasi Biaya
- **Laravel App**: ~$3-4/month
- **MySQL Database**: ~$1-2/month
- **Total**: ~$5/month (masih dalam free tier!)

### Upgrade ke Pro ($20/month)
- **Unlimited projects**
- **Priority support**
- **Higher resource limits**

---

## ⚠️ Troubleshooting

### Error: "Application not responding"

```bash
# Check logs
railway logs

# Clear cache via CLI
railway run php artisan config:clear
railway run php artisan cache:clear
```

### Database Connection Error

1. Verify database variables di tab "Variables"
2. Pastikan menggunakan reference: `${{MySQL.MYSQL_HOST}}`
3. Check database status di service MySQL

### Migration Failed

```bash
# Run manual via CLI
railway run php artisan migrate:fresh --force
railway run php artisan db:seed --force
```

### 500 Internal Server Error

1. Set `APP_DEBUG=true` sementara
2. Check logs untuk error detail
3. Pastikan `APP_KEY` sudah di-set
4. Verify file permissions (storage, bootstrap/cache)

### Build Failed

1. Check `nixpacks.toml` configuration
2. Verify `composer.json` dan `package.json`
3. Check build logs untuk error spesifik

---

## 🎯 Best Practices

1. **Jangan commit `.env`** file
2. **Set `APP_DEBUG=false`** di production
3. **Monitor logs** secara berkala
4. **Backup database** reguler
5. **Use queue** untuk heavy tasks
6. **Cache everything** (config, routes, views)
7. **Monitor resource usage** di dashboard

---

## 📊 Monitoring & Maintenance

### Check Resource Usage
1. Dashboard → Service → **"Metrics"**
2. Monitor CPU, Memory, Network usage

### Database Backup
```bash
# Manual backup via CLI
railway run php artisan backup:run

# Or use Railway MySQL backup feature
# Dashboard → MySQL → Settings → Backups
```

### Scale Resources (Pro Plan)
1. Settings → **"Resources"**
2. Adjust RAM, CPU, Disk

---

## 🔐 Security Tips

1. **Enable 2FA** di Railway account
2. **Rotate APP_KEY** secara berkala
3. **Use strong passwords** untuk database
4. **Limit environment access** (team permissions)
5. **Monitor deployment logs** untuk suspicious activity

---

## 📚 Resources

- [Railway Documentation](https://docs.railway.app/)
- [Railway Discord](https://discord.gg/railway)
- [Railway Blog](https://blog.railway.app/)
- [Nixpacks Documentation](https://nixpacks.com/)

---

## ✅ Quick Checklist

- [ ] Login ke Railway dengan GitHub
- [ ] Create new project dari GitHub repo
- [ ] Add MySQL database
- [ ] Set environment variables (APP_KEY, APP_URL, dll)
- [ ] Reference database variables (`${{MySQL.*}}`)
- [ ] Wait for auto deployment
- [ ] Generate domain
- [ ] Update APP_URL dengan Railway URL
- [ ] Run migrations (otomatis via start command)
- [ ] Test aplikasi
- [ ] Monitor logs

---

## 🎉 Deployment Success!

Setelah semua langkah selesai, aplikasi Anda akan live di:

**URL:** `https://your-app.up.railway.app`

**Features:**
- ✅ Auto HTTPS/SSL
- ✅ Auto deploy dari GitHub
- ✅ MySQL database included
- ✅ Always online (no sleep)
- ✅ Real-time logs
- ✅ Easy scaling

---

## 🆚 Railway vs Heroku

| Feature | Railway | Heroku (Free) |
|---------|---------|---------------|
| **Price** | $5 credit/month | Deprecated |
| **Sleep** | Never | After 30 min |
| **Database** | Included | Addon required |
| **Deploy** | GitHub auto | Manual/GitHub |
| **SSL** | Auto | Auto |
| **Ease** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |

**Winner:** Railway! 🏆

---

**Support:** Jika ada pertanyaan, hubungi [Railway Discord](https://discord.gg/railway)
