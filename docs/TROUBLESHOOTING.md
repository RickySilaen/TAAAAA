# 🔧 Troubleshooting Guide

> **Common issues and solutions for Sistem Pertanian Toba**

**Last Updated**: 2025-11-12  
**Version**: 1.0.0

---

## 📋 Table of Contents

- [Installation Issues](#installation-issues)
- [Database Issues](#database-issues)
- [Redis Issues](#redis-issues)
- [Cache Issues](#cache-issues)
- [Session Issues](#session-issues)
- [Performance Issues](#performance-issues)
- [Security Issues](#security-issues)
- [Common Error Messages](#common-error-messages)

---

## 🔧 Installation Issues

### Issue: Composer Dependencies Fail to Install

**Symptom**: Error during `composer install`

**Solution**:
```bash
# Update Composer to latest version
composer self-update

# Clear Composer cache
composer clear-cache

# Install with verbose output
composer install -vvv

# If still fails, try installing without dev dependencies first
composer install --no-dev
composer install
```

### Issue: NPM Dependencies Fail to Install

**Symptom**: Error during `npm install`

**Solution**:
```bash
# Clear NPM cache
npm cache clean --force

# Delete node_modules and package-lock.json
rm -rf node_modules package-lock.json

# Reinstall
npm install

# Or use npm ci for clean install
npm ci
```

### Issue: Missing PHP Extensions

**Symptom**: `ext-xxx is missing from your system`

**Solution**:
```bash
# Check installed extensions
php -m

# For Windows (XAMPP/WAMP), edit php.ini and uncomment:
extension=pdo_mysql
extension=mbstring
extension=openssl
extension=curl
extension=fileinfo
extension=gd

# Restart Apache/PHP-FPM
```

---

## 💾 Database Issues

### Issue: Database Connection Failed

**Symptom**: `SQLSTATE[HY000] [2002] Connection refused`

**Solution**:

1. **Check MySQL/MariaDB is running**:
```bash
# Windows
net start mysql

# Linux/Mac
sudo systemctl start mysql
# or
brew services start mysql
```

2. **Verify database credentials in `.env`**:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pertanian_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

3. **Create database if not exists**:
```sql
CREATE DATABASE pertanian_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. **Test connection**:
```bash
php artisan migrate:status
```

### Issue: Migration Failed

**Symptom**: Error during `php artisan migrate`

**Solution**:
```bash
# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback

# Fresh migration (CAUTION: Deletes all data!)
php artisan migrate:fresh

# Fresh with seeding
php artisan migrate:fresh --seed
```

### Issue: Foreign Key Constraint Error

**Symptom**: `SQLSTATE[23000]: Integrity constraint violation`

**Solution**:
```bash
# Disable foreign key checks temporarily (MySQL)
SET FOREIGN_KEY_CHECKS=0;

# Run your operation
# ...

# Re-enable
SET FOREIGN_KEY_CHECKS=1;

# Or use fresh migration
php artisan migrate:fresh --seed
```

---

## 🔴 Redis Issues

### Issue: Class "Redis" not found

**Symptom**: `Class "Redis" not found` when accessing application

**Root Cause**: Application trying to use Redis but PHP Redis extension not installed

**Solution 1: Install Predis Package** (Recommended - Easiest):

```bash
# Install Predis (Pure PHP Redis client)
composer require predis/predis

# Clear cache
php artisan config:clear
php artisan cache:clear
```

This installs Predis, a pure PHP implementation of Redis client that doesn't require PHP extension.

**Solution 2: Use Database/File Cache Instead** (Alternative for Development):

1. **Update `.env`**:
```env
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# Comment out Redis configuration
# REDIS_CLIENT=predis
# REDIS_HOST=127.0.0.1
# REDIS_PASSWORD=null
# REDIS_PORT=6379
```

2. **Clear cache**:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

**Solution 3: Install Redis Extension** (For Production with phpredis):

**Windows**:
1. Download php_redis.dll from [PECL](https://pecl.php.net/package/redis)
2. Copy to `php/ext/` directory
3. Add to `php.ini`: `extension=redis`
4. Restart Apache/PHP

**Linux**:
```bash
# Install Redis server
sudo apt install redis-server

# Install PHP Redis extension
sudo apt install php-redis

# Or compile from source
pecl install redis

# Restart PHP-FPM
sudo systemctl restart php-fpm
```

**Mac**:
```bash
# Install Redis
brew install redis

# Install PHP Redis extension
pecl install redis

# Start Redis
brew services start redis
```

### Issue: Class "Predis\Client" not found

**Symptom**: `Class "Predis\Client" not found` error

**Root Cause**: Predis package not installed but configured to use it

**Solution**:

```bash
# Install Predis package
composer require predis/predis

# Clear caches
php artisan config:clear
php artisan cache:clear

# Verify installation
composer show predis/predis
```

**Alternative**: Switch to database cache if you don't need Redis:
```env
# In .env
CACHE_STORE=database
SESSION_DRIVER=database
```

### Issue: Redis Connection Refused

**Symptom**: `Connection refused [tcp://127.0.0.1:6379]`

**Solution**:
```bash
# Check if Redis is running
redis-cli ping
# Should return: PONG

# Start Redis
# Windows (if installed via MSI)
redis-server

# Linux
sudo systemctl start redis

# Mac
brew services start redis

# Check Redis status
redis-cli info server
```

---

## 📦 Cache Issues

### Issue: Cache Not Clearing

**Symptom**: Changes not reflected, old data still showing

**Solution**:
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear compiled classes
php artisan clear-compiled

# Regenerate autoload files
composer dump-autoload
```

### Issue: Cache Permission Denied

**Symptom**: `Failed to clear cache. Make sure you have the appropriate permissions.`

**Solution**:
```bash
# Linux/Mac - Fix permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Windows - Run as Administrator
# Right-click Command Prompt -> Run as Administrator
php artisan cache:clear

# Or delete cache manually
rm -rf storage/framework/cache/*
rm -rf storage/framework/views/*
rm -rf storage/framework/sessions/*
```

---

## 🔐 Session Issues

### Issue: Session Not Persisting

**Symptom**: User logged out immediately, session data lost

**Solution**:

1. **Check session configuration in `.env`**:
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

2. **Create sessions table if using database driver**:
```bash
# Create sessions table
php artisan session:table
php artisan migrate
```

3. **Clear session cache**:
```bash
php artisan cache:clear
php artisan config:clear
```

4. **Check storage permissions**:
```bash
# Linux/Mac
chmod -R 775 storage/framework/sessions

# Check session files
ls -la storage/framework/sessions/
```

### Issue: "419 Page Expired" Error

**Symptom**: Form submission fails with 419 error

**Solution**:

1. **Ensure CSRF token is included in forms**:
```blade
<form method="POST" action="/login">
    @csrf
    <!-- form fields -->
</form>
```

2. **Check session lifetime**:
```env
SESSION_LIFETIME=120  # Increase if needed (in minutes)
```

3. **Clear cache**:
```bash
php artisan config:clear
php artisan cache:clear
```

---

## ⚡ Performance Issues

### Issue: Slow Page Load

**Symptom**: Pages take > 3 seconds to load

**Solution**:

1. **Enable query logging to find slow queries**:
```php
// In AppServiceProvider::boot()
if (config('app.debug')) {
    \DB::listen(function($query) {
        if ($query->time > 1000) { // Queries > 1 second
            \Log::warning('Slow query detected', [
                'sql' => $query->sql,
                'time' => $query->time,
            ]);
        }
    });
}
```

2. **Check for N+1 query problems**:
```bash
# Install Laravel Debugbar
composer require barryvdh/laravel-debugbar --dev

# Access your page and check the Debugbar
```

3. **Optimize queries**:
```php
// Bad (N+1 problem)
$laporans = Laporan::all();
foreach ($laporans as $laporan) {
    echo $laporan->user->nama_lengkap; // N queries!
}

// Good (Eager loading)
$laporans = Laporan::with('user')->get();
foreach ($laporans as $laporan) {
    echo $laporan->user->nama_lengkap; // No extra queries
}

// Best (With scopes)
$laporans = Laporan::withUser()->get();
```

4. **Enable caching**:
```php
// Cache expensive queries
$statistics = Cache::remember('dashboard_stats', 3600, function() {
    return [
        'total_laporans' => Laporan::count(),
        'pending_laporans' => Laporan::pending()->count(),
    ];
});
```

5. **Optimize Composer autoload**:
```bash
composer dump-autoload --optimize
```

### Issue: High Memory Usage

**Symptom**: PHP fatal error - memory limit exhausted

**Solution**:

1. **Increase PHP memory limit**:
```ini
; In php.ini
memory_limit = 256M  ; Or higher
```

2. **Use chunking for large datasets**:
```php
// Bad - loads all into memory
$laporans = Laporan::all();

// Good - processes in chunks
Laporan::chunk(100, function($laporans) {
    foreach ($laporans as $laporan) {
        // Process
    }
});

// Best - lazy collection
Laporan::lazy()->each(function($laporan) {
    // Process
});
```

---

## 🔒 Security Issues

### Issue: CSRF Token Mismatch

**Symptom**: `CSRF token mismatch` error on form submission

**Solution**:

1. **Add CSRF token to forms**:
```blade
<form method="POST">
    @csrf
    <!-- fields -->
</form>
```

2. **For AJAX requests**:
```javascript
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

3. **Add meta tag to layout**:
```blade
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
```

### Issue: Unauthorized Access

**Symptom**: Users accessing restricted pages

**Solution**:

1. **Use middleware properly**:
```php
// In routes/web.php
Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});
```

2. **Check permissions in controllers**:
```php
public function index()
{
    $this->authorize('viewAny', Laporan::class);
    // ... rest of code
}
```

---

## ❌ Common Error Messages

### "Class not found"

**Cause**: Autoload not updated

**Solution**:
```bash
composer dump-autoload
```

### "Target class [Controller] does not exist"

**Cause**: Missing namespace in routes

**Solution**:
```php
// Old Laravel syntax (won't work in Laravel 11)
Route::get('/login', 'LoginController@showLoginForm');

// Correct syntax
Route::get('/login', [LoginController::class, 'showLoginForm']);
```

### "No application encryption key has been specified"

**Cause**: Missing APP_KEY in `.env`

**Solution**:
```bash
php artisan key:generate
```

### "SQLSTATE[42S02]: Base table or view not found"

**Cause**: Migrations not run

**Solution**:
```bash
php artisan migrate
```

### "File could not be uploaded"

**Cause**: Storage directory not linked or permission issues

**Solution**:
```bash
# Create symbolic link
php artisan storage:link

# Fix permissions (Linux/Mac)
sudo chmod -R 775 storage
sudo chown -R www-data:www-data storage
```

---

## 🆘 Quick Fix Commands

When in doubt, run these commands to fix most common issues:

```bash
# Clear all caches
php artisan optimize:clear

# Or run individually:
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Regenerate autoload
composer dump-autoload

# Fix permissions (Linux/Mac)
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Restart queue workers if using queues
php artisan queue:restart
```

---

## 📚 Additional Resources

### Laravel Documentation
- [Laravel 11 Documentation](https://laravel.com/docs/11.x)
- [Database](https://laravel.com/docs/11.x/database)
- [Cache](https://laravel.com/docs/11.x/cache)
- [Redis](https://laravel.com/docs/11.x/redis)

### Community Support
- [Laravel GitHub Issues](https://github.com/laravel/framework/issues)
- [Laracasts Forum](https://laracasts.com/discuss)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/laravel)

### Project Documentation
- [Database Optimization Guide](./DATABASE_OPTIMIZATION.md)
- [Security Hardening Guide](./SECURITY_HARDENING.md)
- [Deployment Guide](./DEPLOYMENT_GUIDE.md)

---

## 💡 Getting Help

If you encounter an issue not covered here:

1. **Check error logs**:
   - `storage/logs/laravel.log`
   - PHP error log
   - Web server error log

2. **Enable debug mode** (development only):
   ```env
   APP_DEBUG=true
   ```

3. **Search existing documentation**:
   - Check `docs/` directory
   - Review Laravel documentation

4. **Contact development team** with:
   - Error message (full stack trace)
   - Steps to reproduce
   - Environment details (PHP version, OS, etc.)

---

**Last Updated**: 2025-11-12  
**Maintained By**: Development Team
