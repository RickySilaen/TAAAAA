# 💾 BACKUP & RESTORE CONFIGURATION GUIDE

## Overview
Panduan lengkap backup dan restore untuk Sistem Pertanian Toba.

---

## 📋 Table of Contents
1. [Database Backup](#database-backup)
2. [File Backup](#file-backup)
3. [Full System Backup](#full-system-backup)
4. [Automated Backup](#automated-backup)
5. [Restore Procedures](#restore-procedures)
6. [Backup Best Practices](#backup-best-practices)

---

## 1. DATABASE BACKUP

### ✅ Custom Database Backup (No mysqldump required)

#### Quick Start
```powershell
# JSON backup (recommended for restore)
php artisan db:backup

# SQL backup
php artisan db:backup --sql

# Compressed backup
php artisan db:backup --sql --compress

# Specific tables
php artisan db:backup --tables=users,laporans,bantuans
```

#### Features
✅ Works without mysqldump  
✅ JSON and SQL format support  
✅ Automatic compression  
✅ Progress indicator  
✅ Selective table backup  
✅ Human-readable file size  

#### Backup Location
```
storage/app/backups/
├── backup_pertanian_db_2025-11-11_230639.json
├── backup_pertanian_db_2025-11-11_230644.sql.zip
└── backup_pertanian_db_2025-11-11_230713.sql.zip
```

---

### Spatie Laravel Backup (Advanced)

#### Requirements
```powershell
# Install mysqldump (if not available)
# For XAMPP: Add to PATH: C:\xampp\mysql\bin\
# For Laragon: Add to PATH: C:\laragon\bin\mysql\mysql-8.0.x\bin\

# Verify
mysqldump --version
```

#### Configuration
Package already installed and configured in `config/backup.php`

#### Usage
```powershell
# Full backup (database + files)
php artisan backup:run

# Database only
php artisan backup:run --only-db

# Files only
php artisan backup:run --only-files

# List backups
php artisan backup:list

# Clean old backups
php artisan backup:clean

# Monitor backup health
php artisan backup:monitor
```

#### Configuration Details

**config/backup.php:**
- ✅ App name configured
- ✅ Vendor/node_modules excluded
- ✅ Storage/cache excluded
- ✅ Database connections set

**Excluded Directories:**
- vendor/
- node_modules/
- storage/framework/cache/
- storage/framework/sessions/
- storage/framework/views/
- storage/logs/

---

## 2. FILE BACKUP

### Manual File Backup

#### Important Directories to Backup
```
📁 Critical Files:
├── .env (configuration)
├── storage/app/public/ (uploaded files)
├── public/uploads/ (legacy uploads)
├── database/database.sqlite (if using SQLite)
└── config/ (custom configurations)
```

#### PowerShell Backup Script
```powershell
# Create backup directory
$backupDir = "C:\Backups\sistem_pertanian_" + (Get-Date -Format "yyyy-MM-dd_HHmmss")
New-Item -ItemType Directory -Path $backupDir

# Backup files
Copy-Item -Path "storage\app\public\*" -Destination "$backupDir\uploads" -Recurse
Copy-Item -Path ".env" -Destination "$backupDir\.env"
Copy-Item -Path "config\" -Destination "$backupDir\config" -Recurse

Write-Host "✅ File backup completed: $backupDir"
```

### Automated File Sync

#### Using Robocopy (Windows)
```powershell
# Sync to external drive
robocopy "C:\path\to\sistem_pertanian\storage\app\public" "D:\Backups\uploads" /MIR /Z /LOG:backup.log

# Schedule with Task Scheduler
# Create .bat file:
@echo off
robocopy "C:\path\to\sistem_pertanian\storage\app\public" "D:\Backups\uploads" /MIR /Z
```

---

## 3. FULL SYSTEM BACKUP

### Complete Backup Strategy

#### What to Backup
```
✅ Database (MySQL dump or JSON)
✅ Uploaded files (storage/app/public/)
✅ Configuration (.env file)
✅ Custom code (app/, routes/, resources/)
✅ Dependencies list (composer.lock, package-lock.json)
```

#### What NOT to Backup
```
❌ vendor/ (reinstall with composer)
❌ node_modules/ (reinstall with npm)
❌ storage/logs/ (temporary)
❌ storage/framework/cache/ (temporary)
❌ storage/framework/sessions/ (temporary)
❌ public/build/ (rebuild with npm)
```

### Full Backup Script

**PowerShell Script:**
```powershell
# backup.ps1
$timestamp = Get-Date -Format "yyyy-MM-dd_HHmmss"
$backupRoot = "C:\Backups\sistem_pertanian"
$backupDir = "$backupRoot\backup_$timestamp"
$projectPath = "C:\Users\Lenovo\Downloads\RICKY\sistem_pertanian"

Write-Host "🔄 Starting full system backup..." -ForegroundColor Cyan

# Create backup directory
New-Item -ItemType Directory -Path $backupDir -Force | Out-Null

# 1. Database Backup
Write-Host "📦 Backing up database..." -ForegroundColor Yellow
Set-Location $projectPath
php artisan db:backup --sql --compress
Copy-Item "storage\app\backups\*" "$backupDir\database\" -Force

# 2. Files Backup
Write-Host "📁 Backing up files..." -ForegroundColor Yellow
Copy-Item ".env" "$backupDir\.env" -Force
Copy-Item "storage\app\public\" "$backupDir\uploads\" -Recurse -Force
Copy-Item "public\uploads\" "$backupDir\public_uploads\" -Recurse -Force -ErrorAction SilentlyContinue

# 3. Configuration Backup
Write-Host "⚙️  Backing up configuration..." -ForegroundColor Yellow
Copy-Item "config\" "$backupDir\config\" -Recurse -Force
Copy-Item "composer.lock" "$backupDir\composer.lock" -Force
Copy-Item "package.json" "$backupDir\package.json" -Force

# 4. Custom Code Backup
Write-Host "💻 Backing up custom code..." -ForegroundColor Yellow
Copy-Item "app\" "$backupDir\app\" -Recurse -Force
Copy-Item "routes\" "$backupDir\routes\" -Recurse -Force
Copy-Item "resources\views\" "$backupDir\views\" -Recurse -Force

# 5. Create backup info file
$info = @"
Backup Information
==================
Timestamp: $timestamp
Date: $(Get-Date)
Project: Sistem Pertanian Toba
Database: pertanian_db
PHP Version: $(php -v | Select-String -Pattern "PHP \d+\.\d+\.\d+")

Backup Contents:
- Database (SQL compressed)
- Uploaded files
- Configuration files
- Custom application code

Restore Instructions:
1. Extract backup to project directory
2. Restore .env file
3. Run: php artisan db:restore backup.sql
4. Copy uploads back to storage/app/public/
5. Run: composer install
6. Run: php artisan migrate
7. Run: php artisan storage:link
"@

$info | Out-File "$backupDir\README.txt"

# 6. Compress entire backup
Write-Host "🗜️  Compressing backup..." -ForegroundColor Yellow
Compress-Archive -Path $backupDir -DestinationPath "$backupRoot\backup_$timestamp.zip" -Force
Remove-Item $backupDir -Recurse -Force

$size = (Get-Item "$backupRoot\backup_$timestamp.zip").Length / 1MB
Write-Host "✅ Backup completed successfully!" -ForegroundColor Green
Write-Host "📦 Location: $backupRoot\backup_$timestamp.zip" -ForegroundColor Cyan
Write-Host "📊 Size: $([math]::Round($size, 2)) MB" -ForegroundColor Cyan
```

**Usage:**
```powershell
# Run backup
.\backup.ps1

# Schedule daily at 2 AM
# Task Scheduler → Create Basic Task → Daily → 2:00 AM → PowerShell script
```

---

## 4. AUTOMATED BACKUP

### Schedule Backup with Laravel Scheduler

**app/Console/Kernel.php:**
```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Database backup daily at 2 AM
        $schedule->command('db:backup --sql --compress')
                 ->daily()
                 ->at('02:00')
                 ->appendOutputTo(storage_path('logs/backup.log'));

        // Full backup weekly on Sunday at 3 AM
        $schedule->command('backup:run --only-db')
                 ->weekly()
                 ->sundays()
                 ->at('03:00')
                 ->appendOutputTo(storage_path('logs/backup.log'));

        // Clean old backups monthly
        $schedule->command('backup:clean')
                 ->monthly()
                 ->at('04:00');

        // Database backup every 6 hours (production)
        $schedule->command('db:backup')
                 ->cron('0 */6 * * *')
                 ->appendOutputTo(storage_path('logs/backup.log'));
    }
}
```

### Start Scheduler

#### Windows - Task Scheduler
```powershell
# Create scheduler.bat
@echo off
cd C:\path\to\sistem_pertanian
php artisan schedule:run >> NUL 2>&1

# Task Scheduler:
# - Trigger: Daily
# - Start time: 12:00 AM
# - Repeat every: 1 minute
# - Action: Run scheduler.bat
```

#### Linux - Cron
```bash
# Edit crontab
crontab -e

# Add this line
* * * * * cd /path/to/sistem_pertanian && php artisan schedule:run >> /dev/null 2>&1
```

---

## 5. RESTORE PROCEDURES

### Database Restore

#### From JSON Backup
```powershell
# Manual restore (requires custom script)
php artisan db:restore backup_pertanian_db_2025-11-11_230639.json
```

#### From SQL Backup
```powershell
# Option 1: MySQL CLI
mysql -u root -p pertanian_db < backup_pertanian_db_2025-11-11_230713.sql

# Option 2: phpMyAdmin
# 1. Login to phpMyAdmin
# 2. Select database "pertanian_db"
# 3. Click "Import"
# 4. Choose SQL file
# 5. Click "Go"

# Option 3: Artisan command (requires custom implementation)
php artisan db:restore storage/app/backups/backup_pertanian_db_2025-11-11_230713.sql
```

### File Restore

```powershell
# Restore uploaded files
Copy-Item "D:\Backups\uploads\*" "storage\app\public\" -Recurse -Force

# Restore .env
Copy-Item "D:\Backups\.env" ".env" -Force

# Recreate storage link
php artisan storage:link
```

### Full System Restore

```powershell
# 1. Extract backup
Expand-Archive backup_2025-11-11_230713.zip -DestinationPath restore_temp

# 2. Restore database
mysql -u root -p pertanian_db < restore_temp\database\backup.sql

# 3. Restore files
Copy-Item restore_temp\uploads\* storage\app\public\ -Recurse -Force
Copy-Item restore_temp\.env .env -Force

# 4. Restore dependencies
composer install
npm install

# 5. Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 6. Regenerate key if needed
php artisan key:generate

# 7. Run migrations (if schema changed)
php artisan migrate

# 8. Create storage link
php artisan storage:link

# 9. Build frontend assets
npm run build

# 10. Test application
php artisan serve
```

---

## 6. BACKUP BEST PRACTICES

### 3-2-1 Backup Rule
```
3 = Keep 3 copies of your data
2 = Store copies on 2 different media types
1 = Keep 1 copy off-site
```

### Implementation
```
✅ Copy 1: Production server
✅ Copy 2: External hard drive
✅ Copy 3: Cloud storage (Google Drive, Dropbox, S3)
```

### Backup Frequency

| Environment | Database | Files | Full System |
|-------------|----------|-------|-------------|
| **Development** | Weekly | Monthly | Monthly |
| **Staging** | Daily | Weekly | Weekly |
| **Production** | Every 6 hours | Daily | Weekly |

### Retention Policy

```
Daily backups: Keep for 7 days
Weekly backups: Keep for 4 weeks
Monthly backups: Keep for 12 months
Yearly backups: Keep forever
```

### Security

```powershell
# Encrypt backups
# Using 7-Zip with password
7z a -p"strong-password" backup.7z backup_folder\

# Using Windows built-in encryption
cipher /E backup_folder

# Encrypt .env file separately
openssl enc -aes-256-cbc -salt -in .env -out .env.encrypted -k "password"
```

### Testing Restores

```
✅ Test restore monthly
✅ Document restore procedures
✅ Verify backup integrity
✅ Check backup file sizes
✅ Monitor backup success/failure
```

---

## 📊 Backup Checklist

### Daily
- [ ] Automated database backup runs
- [ ] Check backup logs for errors
- [ ] Verify backup file created

### Weekly
- [ ] Test database restore
- [ ] Backup uploaded files
- [ ] Clean old backups
- [ ] Copy to external drive

### Monthly
- [ ] Full system backup
- [ ] Test full restore procedure
- [ ] Review backup strategy
- [ ] Update backup documentation

### Quarterly
- [ ] Verify cloud backups
- [ ] Test disaster recovery
- [ ] Review storage capacity
- [ ] Update backup scripts

---

## 🚨 Disaster Recovery Plan

### Scenario 1: Database Corruption
```
1. Stop application: php artisan down
2. Restore latest backup: mysql -u root -p < backup.sql
3. Verify data integrity
4. Bring application online: php artisan up
5. Monitor for issues
```

### Scenario 2: Server Failure
```
1. Provision new server
2. Install dependencies (PHP, MySQL, etc.)
3. Clone repository
4. Restore latest backup
5. Configure environment (.env)
6. Test thoroughly
7. Update DNS/Load balancer
```

### Scenario 3: Accidental Data Deletion
```
1. Identify affected data
2. Find backup before deletion
3. Extract specific data
4. Restore selectively
5. Verify restoration
6. Update application
```

---

## 📁 Backup Storage Recommendations

### Local Storage
```
C:\Backups\sistem_pertanian\
├── daily\
├── weekly\
├── monthly\
└── archived\
```

### Cloud Storage Options

#### Google Drive
```powershell
# Using rclone
rclone copy storage/app/backups gdrive:sistem_pertanian/backups
```

#### Amazon S3
```env
AWS_BACKUP_BUCKET=sistem-pertanian-backups
AWS_BACKUP_REGION=ap-southeast-1
```

#### Dropbox
```powershell
# Using Dropbox CLI
dropbox upload storage/app/backups/* /sistem_pertanian/backups/
```

---

## ✅ Quick Commands Reference

```powershell
# Database Backup
php artisan db:backup                    # JSON format
php artisan db:backup --sql              # SQL format
php artisan db:backup --sql --compress   # SQL compressed
php artisan db:backup --tables=users     # Specific tables

# Spatie Backup
php artisan backup:run                   # Full backup
php artisan backup:run --only-db         # Database only
php artisan backup:list                  # List backups
php artisan backup:clean                 # Clean old backups

# Database Restore
mysql -u root -p pertanian_db < backup.sql

# File Operations
Copy-Item source destination -Recurse    # Copy files
Compress-Archive source dest.zip         # Compress
Expand-Archive backup.zip destination    # Extract
```

---

**Last Updated:** November 12, 2025  
**Status:** ✅ Backup System Ready  
**Tested:** Database backup working (JSON & SQL formats)
