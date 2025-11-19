# 🌍 ENVIRONMENT CONFIGURATION - COMPLETE GUIDE

## Overview
Panduan lengkap konfigurasi environment untuk Sistem Pertanian Toba di berbagai tahap deployment.

---

## 📋 Table of Contents
1. [Environment Types](#environment-types)
2. [Configuration Files](#configuration-files)
3. [Local Development Setup](#local-development-setup)
4. [Staging Environment](#staging-environment)
5. [Production Environment](#production-environment)
6. [Environment Variables Reference](#environment-variables-reference)
7. [Migration Between Environments](#migration-between-environments)

---

## 1. ENVIRONMENT TYPES

### Development (Local)
**Purpose:** Local development and testing  
**Characteristics:**
- Debug mode enabled
- Log driver for emails
- File/Database cache
- Database queue
- Relaxed security

### Staging
**Purpose:** Pre-production testing  
**Characteristics:**
- Debug mode optional
- Real email testing (Mailtrap/Gmail)
- Database/Redis cache
- Database/Redis queue
- Production-like security

### Production
**Purpose:** Live application  
**Characteristics:**
- Debug mode OFF
- Production email (Mailgun/SendGrid)
- Redis cache
- Redis queue
- Maximum security
- Monitoring enabled

---

## 2. CONFIGURATION FILES

### File Structure
```
.env                    # Current environment (NOT in git)
.env.example            # Template (in git)
.env.local              # Local development
.env.staging            # Staging environment
.env.production         # Production environment
.env.testing            # Testing environment
```

### Managing Multiple .env Files

```powershell
# Switch to development
Copy-Item .env.local .env -Force

# Switch to staging
Copy-Item .env.staging .env -Force

# Switch to production
Copy-Item .env.production .env -Force

# Clear config cache after switch
php artisan config:clear
```

---

## 3. LOCAL DEVELOPMENT SETUP

### .env.local (Complete Configuration)

```env
# ================================================
# LOCAL DEVELOPMENT ENVIRONMENT
# ================================================

# Application
APP_NAME="Sistem Pertanian Toba DEV"
APP_ENV=local
APP_KEY=base64:YOUR-LOCAL-KEY-HERE
APP_DEBUG=true
APP_URL=http://localhost:8000

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=debug

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pertanian_db
DB_USERNAME=root
DB_PASSWORD=

# Cache
CACHE_STORE=file
CACHE_PREFIX=pertanian_dev_

# Queue
QUEUE_CONNECTION=sync

# Session
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_SECURE_COOKIE=false

# Email (Log Driver)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=dev@pertanian-toba.local
MAIL_FROM_NAME="${APP_NAME}"

# Redis (Optional)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# File Storage
FILESYSTEM_DISK=local

# Broadcasting
BROADCAST_CONNECTION=log

# Vite
VITE_APP_NAME="${APP_NAME}"
```

### Setup Commands

```powershell
# 1. Copy environment
Copy-Item .env.example .env

# 2. Generate key
php artisan key:generate

# 3. Create database
# MySQL: CREATE DATABASE pertanian_db;

# 4. Run migrations
php artisan migrate:fresh --seed

# 5. Create storage link
php artisan storage:link

# 6. Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# 7. Start server
php artisan serve

# 8. (Optional) Start queue worker
php artisan queue:work
```

---

## 4. STAGING ENVIRONMENT

### .env.staging (Complete Configuration)

```env
# ================================================
# STAGING ENVIRONMENT
# ================================================

# Application
APP_NAME="Sistem Pertanian Toba STAGING"
APP_ENV=staging
APP_KEY=base64:YOUR-STAGING-KEY-HERE
APP_DEBUG=true
APP_URL=https://staging.pertanian-toba.com

APP_LOCALE=id
APP_FALLBACK_LOCALE=en

# Logging
LOG_CHANNEL=daily
LOG_LEVEL=info

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pertanian_staging
DB_USERNAME=staging_user
DB_PASSWORD=staging-password-here

# Cache (Redis Recommended)
CACHE_STORE=redis
CACHE_PREFIX=pertanian_staging_

# Queue (Redis Recommended)
QUEUE_CONNECTION=redis

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

# Email (Mailtrap or Gmail)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=staging@pertanian-toba.com
MAIL_FROM_NAME="${APP_NAME}"

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=staging-redis-password
REDIS_PORT=6379

# File Storage
FILESYSTEM_DISK=local

# Backup
BACKUP_DESTINATION=local

# Monitoring (Optional)
# SENTRY_LARAVEL_DSN=your-sentry-dsn
```

### Staging Setup

```bash
# 1. Clone repository
git clone https://github.com/yourusername/sistem_pertanian.git
cd sistem_pertanian

# 2. Install dependencies
composer install --no-dev
npm install

# 3. Configure environment
cp .env.staging .env
nano .env  # Edit as needed

# 4. Generate key
php artisan key:generate

# 5. Run migrations
php artisan migrate --seed

# 6. Build assets
npm run build

# 7. Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 8. Create storage link
php artisan storage:link

# 9. Start queue worker
php artisan queue:work redis --daemon

# 10. Setup cron for scheduler
# crontab -e
# * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 5. PRODUCTION ENVIRONMENT

### .env.production (Complete Configuration)

```env
# ================================================
# PRODUCTION ENVIRONMENT
# ================================================

# Application
APP_NAME="Sistem Pertanian Toba"
APP_ENV=production
APP_KEY=base64:YOUR-PRODUCTION-KEY-HERE
APP_DEBUG=false
APP_URL=https://pertanian-toba.com

APP_LOCALE=id
APP_FALLBACK_LOCALE=en

# Logging
LOG_CHANNEL=daily
LOG_LEVEL=error

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pertanian_production
DB_USERNAME=prod_user
DB_PASSWORD=SUPER-STRONG-PASSWORD-HERE

# Cache (Redis Required)
CACHE_STORE=redis
CACHE_PREFIX=pertanian_prod_

# Queue (Redis Required)
QUEUE_CONNECTION=redis

# Session (Redis Recommended)
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=strict

# Email (Mailgun or SendGrid)
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.pertanian-toba.com
MAILGUN_SECRET=your-mailgun-api-key
MAILGUN_ENDPOINT=api.mailgun.net
MAIL_FROM_ADDRESS=noreply@pertanian-toba.com
MAIL_FROM_NAME="${APP_NAME}"

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=SUPER-STRONG-REDIS-PASSWORD
REDIS_PORT=6379

# File Storage (S3 Recommended for scale)
FILESYSTEM_DISK=local
# For S3:
# FILESYSTEM_DISK=s3
# AWS_ACCESS_KEY_ID=your-access-key
# AWS_SECRET_ACCESS_KEY=your-secret-key
# AWS_DEFAULT_REGION=ap-southeast-1
# AWS_BUCKET=pertanian-toba-files

# Backup
BACKUP_DESTINATION=local
# For S3 backup:
# BACKUP_S3_BUCKET=pertanian-toba-backups
# BACKUP_S3_REGION=ap-southeast-1

# Security
BCRYPT_ROUNDS=12

# Monitoring
SENTRY_LARAVEL_DSN=https://your-sentry-dsn
SENTRY_TRACES_SAMPLE_RATE=0.2

# Google Analytics
GOOGLE_ANALYTICS_ID=GA-XXXXXXXXX

# Rate Limiting (configured in code)
# API: 60 requests/minute
# Auth: 5 attempts/minute
```

### Production Setup

```bash
# 1. Server requirements
# - PHP 8.3+
# - MySQL 8.0+
# - Redis
# - Composer
# - Node.js & NPM
# - SSL Certificate

# 2. Clone and install
git clone https://github.com/yourusername/sistem_pertanian.git
cd sistem_pertanian
composer install --optimize-autoloader --no-dev
npm install

# 3. Configure environment
cp .env.production .env
nano .env

# 4. Generate key
php artisan key:generate

# 5. Run migrations
php artisan migrate --force

# 6. Build assets
npm run build

# 7. Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 8. Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 9. Create storage link
php artisan storage:link

# 10. Setup queue worker (Supervisor)
# See Queue Configuration Guide

# 11. Setup cron
# * * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1

# 12. Configure web server (Nginx/Apache)
# See Web Server Configuration Guide

# 13. Install SSL certificate
# certbot --nginx -d pertanian-toba.com

# 14. Setup monitoring
# Configure Sentry, New Relic, etc.

# 15. Setup backups
# Configure automated backups

# 16. Test application
# Run smoke tests
# Check error logs
# Monitor performance
```

---

## 6. ENVIRONMENT VARIABLES REFERENCE

### Application Settings

| Variable | Local | Staging | Production | Description |
|----------|-------|---------|------------|-------------|
| APP_ENV | local | staging | production | Environment name |
| APP_DEBUG | true | true | **false** | Debug mode |
| APP_URL | localhost:8000 | staging URL | production URL | Base URL |

### Database

| Variable | Local | Staging | Production | Description |
|----------|-------|---------|------------|-------------|
| DB_DATABASE | pertanian_db | pertanian_staging | pertanian_production | Database name |
| DB_PASSWORD | (empty) | strong | **very strong** | Database password |

### Cache & Queue

| Variable | Local | Staging | Production | Description |
|----------|-------|---------|------------|-------------|
| CACHE_STORE | file | redis | **redis** | Cache driver |
| QUEUE_CONNECTION | sync | redis | **redis** | Queue driver |

### Email

| Variable | Local | Staging | Production | Description |
|----------|-------|---------|------------|-------------|
| MAIL_MAILER | log | mailtrap | **mailgun** | Email driver |

### Session

| Variable | Local | Staging | Production | Description |
|----------|-------|---------|------------|-------------|
| SESSION_DRIVER | file | database | **redis** | Session driver |
| SESSION_SECURE_COOKIE | false | true | **true** | HTTPS only |
| SESSION_ENCRYPT | false | false | **true** | Encrypt session |

### Security

| Variable | Local | Staging | Production | Required |
|----------|-------|---------|------------|----------|
| SESSION_SECURE_COOKIE | false | true | true | HTTPS |
| SESSION_HTTP_ONLY | true | true | true | XSS protection |
| SESSION_SAME_SITE | lax | lax | strict | CSRF protection |
| SESSION_ENCRYPT | false | false | true | Privacy |

---

## 7. MIGRATION BETWEEN ENVIRONMENTS

### Local → Staging

```powershell
# 1. Export database
php artisan db:backup --sql --compress

# 2. Commit code
git add .
git commit -m "Ready for staging"
git push origin develop

# 3. On staging server
git pull origin develop
composer install
php artisan migrate
php artisan config:cache

# 4. Import database
mysql -u user -p database < backup.sql

# 5. Test
curl https://staging.pertanian-toba.com
```

### Staging → Production

```bash
# 1. Create release branch
git checkout -b release/v1.0.0
git push origin release/v1.0.0

# 2. On production server
git fetch
git checkout release/v1.0.0

# 3. Backup production
php artisan db:backup --sql --compress
tar -czf backup_files.tar.gz storage/app/public/

# 4. Update dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# 5. Run migrations
php artisan down
php artisan migrate --force
php artisan up

# 6. Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Restart services
sudo supervisorctl restart laravel-worker:*
sudo systemctl restart php8.3-fpm
sudo systemctl restart nginx

# 8. Verify
curl https://pertanian-toba.com
php artisan health:check
```

---

## ✅ Environment Checklist

### Local Development
- [ ] .env.local configured
- [ ] Database created
- [ ] Migrations run
- [ ] Seeders run
- [ ] Storage link created
- [ ] Email log driver working
- [ ] Queue worker running (optional)

### Staging
- [ ] .env.staging configured
- [ ] SSL certificate installed
- [ ] Database configured
- [ ] Redis installed and running
- [ ] Queue worker running
- [ ] Scheduler configured
- [ ] Email testing (Mailtrap)
- [ ] Backups configured
- [ ] Monitoring enabled

### Production
- [ ] .env.production configured
- [ ] APP_DEBUG=false
- [ ] Strong passwords set
- [ ] SSL certificate installed
- [ ] Redis configured
- [ ] Queue worker running (Supervisor)
- [ ] Scheduler configured (cron)
- [ ] Production email (Mailgun/SendGrid)
- [ ] Backups automated
- [ ] Monitoring enabled (Sentry)
- [ ] Error logging configured
- [ ] Performance optimized
- [ ] Security headers configured
- [ ] Firewall configured
- [ ] Rate limiting active
- [ ] File permissions correct

---

## 🔧 Troubleshooting

### Common Issues

#### 1. Config Cache Not Updating
```bash
# Solution
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

#### 2. Queue Not Processing
```bash
# Check queue worker
ps aux | grep "queue:work"

# Restart queue
php artisan queue:restart

# Check failed jobs
php artisan queue:failed
```

#### 3. Email Not Sending
```bash
# Test configuration
php artisan tinker
Mail::raw('Test', fn($msg) => $msg->to('test@example.com')->subject('Test'));

# Check logs
tail -f storage/logs/laravel.log
```

#### 4. Session Issues
```bash
# Clear sessions
php artisan session:clear

# Check session driver
php artisan tinker
config('session.driver')
```

---

## 📚 Additional Resources

- [Email Configuration Guide](EMAIL_CONFIGURATION.md)
- [Queue & Cache Configuration](QUEUE_CACHE_CONFIGURATION.md)
- [Backup & Restore Guide](BACKUP_RESTORE_GUIDE.md)
- [Security Implementation](SECURITY_IMPLEMENTATION.md)

---

**Last Updated:** November 12, 2025  
**Status:** ✅ Complete Environment Configuration Ready  
**Environments:** Local ✅ | Staging ✅ | Production ✅
