# ⚙️ QUEUE & CACHE CONFIGURATION GUIDE

## Overview
Panduan lengkap konfigurasi Queue dan Cache untuk Sistem Pertanian Toba.

---

## 📋 Table of Contents
1. [Queue Configuration](#queue-configuration)
2. [Cache Configuration](#cache-configuration)
3. [Session Configuration](#session-configuration)
4. [Redis Setup](#redis-setup)
5. [Performance Optimization](#performance-optimization)

---

## 1. QUEUE CONFIGURATION

### Current Setup
✅ **Queue Driver:** Database  
✅ **Status:** Working  
✅ **Use Case:** Development & Small Production

### Queue Drivers Comparison

| Driver | Best For | Pros | Cons |
|--------|----------|------|------|
| **sync** | Testing | Simple, immediate | No background processing |
| **database** | Small apps | No extra service | Slower, DB overhead |
| **redis** | Production | Fast, reliable | Requires Redis |
| **beanstalkd** | High volume | Very fast | Extra service |
| **sqs** | AWS | Scalable | AWS dependency |

---

### A. Database Queue (Current) ✅

#### Configuration (.env)
```env
QUEUE_CONNECTION=database
```

#### Setup
```powershell
# Already created via migrations
# Tables: jobs, failed_jobs

# Start queue worker
php artisan queue:work

# With options
php artisan queue:work --tries=3 --timeout=90
```

#### Pros & Cons
✅ No additional service required  
✅ Works out of the box  
✅ Good for development  
✅ Easy to debug (view jobs in database)  
❌ Slower than Redis  
❌ Database overhead  
❌ Not ideal for high-volume production  

#### When to Use
- Development environment
- Low traffic applications
- Less than 100 jobs/minute
- Simple deployment

---

### B. Redis Queue (Production Recommended) 🚀

#### Installation
```powershell
# Install Redis for Windows
# Download from: https://github.com/microsoftarchive/redis/releases
# Or use Docker:
docker run -d -p 6379:6379 redis:alpine

# Install PHP Redis extension
# Download from: https://pecl.php.net/package/redis
# Add to php.ini: extension=redis
```

#### Configuration (.env)
```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_QUEUE=default
REDIS_RETRY_AFTER=90
REDIS_BLOCK_FOR=null
```

#### Setup
```powershell
# Test Redis connection
php artisan tinker
Redis::ping() // Should return "PONG"

# Start queue worker
php artisan queue:work redis --tries=3

# Multiple workers
php artisan queue:work redis --queue=high,default,low

# Background worker (Windows)
Start-Job -ScriptBlock { php artisan queue:work redis }
```

#### Pros & Cons
✅ **Very fast** (10-100x faster than database)  
✅ Low latency  
✅ Handles high volume  
✅ Industry standard  
✅ Good for real-time features  
❌ Requires Redis service  
❌ More complex setup  

#### When to Use
- Production environment
- High traffic applications
- More than 100 jobs/minute
- Real-time features
- Scalable architecture

---

### Queue Worker Management

#### Supervisor Configuration (Linux Production)
```ini
# /etc/supervisor/conf.d/laravel-worker.conf
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/path/to/worker.log
stopwaitsecs=3600
```

#### Windows Service
```powershell
# Using NSSM (Non-Sucking Service Manager)
# Download from: https://nssm.cc/download

nssm install LaravelQueue "C:\php\php.exe" "C:\path\to\artisan queue:work --tries=3"
nssm start LaravelQueue
```

#### Systemd (Linux)
```ini
# /etc/systemd/system/laravel-queue.service
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/html/artisan queue:work redis --sleep=3 --tries=3

[Install]
WantedBy=multi-user.target
```

---

### Queue Monitoring

#### Check Queue Status
```powershell
# View failed jobs
php artisan queue:failed

# Retry failed job
php artisan queue:retry {id}

# Retry all failed jobs
php artisan queue:retry all

# Flush failed jobs
php artisan queue:flush

# List queued jobs
php artisan queue:listen --timeout=60
```

#### Laravel Horizon (Redis Only)
```powershell
# Install Horizon
composer require laravel/horizon

# Publish configuration
php artisan horizon:install

# Start Horizon
php artisan horizon

# Access dashboard: http://localhost/horizon
```

---

## 2. CACHE CONFIGURATION

### Current Setup
✅ **Cache Driver:** Database  
✅ **Status:** Working  
✅ **Use Case:** Development

### Cache Drivers Comparison

| Driver | Speed | Best For | Persistence |
|--------|-------|----------|-------------|
| **array** | Fastest | Testing only | No |
| **file** | Slow | Development | Yes |
| **database** | Medium | Small apps | Yes |
| **redis** | Fast | Production | Configurable |
| **memcached** | Fast | Production | No |

---

### A. Database Cache (Current) ✅

#### Configuration (.env)
```env
CACHE_STORE=database
CACHE_PREFIX=pertanian_
```

#### Setup
```powershell
# Migration already exists
# Table: cache, cache_locks

# Test cache
php artisan tinker
Cache::put('test', 'value', 60);
Cache::get('test'); // Returns 'value'
```

#### Pros & Cons
✅ No extra service  
✅ Persistent storage  
✅ Easy debugging  
❌ Slower than Redis  
❌ Database overhead  
❌ Not recommended for production  

---

### B. Redis Cache (Production Recommended) 🚀

#### Configuration (.env)
```env
CACHE_STORE=redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CACHE_DB=1
CACHE_PREFIX=pertanian_
```

#### Setup
```powershell
# Test Redis cache
php artisan tinker
Cache::store('redis')->put('test', 'value', 60);
Cache::store('redis')->get('test');

# Clear cache
php artisan cache:clear
```

#### Pros & Cons
✅ **Very fast** (microsecond response)  
✅ Low latency  
✅ Supports multiple databases  
✅ TTL support  
✅ Industry standard  
❌ Requires Redis  
❌ Data not persistent by default  

---

### C. File Cache

#### Configuration (.env)
```env
CACHE_STORE=file
CACHE_PREFIX=pertanian_
```

#### Good For
- Development without database
- Simple applications
- When Redis not available

---

### Cache Usage Examples

#### Basic Caching
```php
// Store
Cache::put('key', 'value', 3600); // 1 hour

// Retrieve
$value = Cache::get('key');

// Retrieve or store
$value = Cache::remember('users', 3600, function () {
    return User::all();
});

// Forever
Cache::forever('key', 'value');

// Delete
Cache::forget('key');

// Check existence
if (Cache::has('key')) {
    //
}
```

#### Cache Tags (Redis/Memcached only)
```php
Cache::tags(['people', 'artists'])->put('John', $john, 60);
Cache::tags(['people', 'authors'])->put('Anne', $anne, 60);

// Flush tagged cache
Cache::tags(['people'])->flush();
```

#### Model Caching
```php
// In model
public function getActiveUsersAttribute()
{
    return Cache::remember('active_users', 3600, function () {
        return $this->where('active', true)->get();
    });
}
```

---

## 3. SESSION CONFIGURATION

### Current Setup
✅ **Session Driver:** Database  
✅ **Status:** Working  
✅ **Security:** Configured

### Session Drivers

| Driver | Best For | Scalability |
|--------|----------|-------------|
| **file** | Single server | Low |
| **cookie** | Stateless apps | High |
| **database** | Multiple servers | Medium |
| **redis** | High traffic | High |
| **memcached** | High traffic | High |

---

### A. Database Sessions (Current) ✅

#### Configuration (.env)
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=false
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

#### Pros & Cons
✅ Works across multiple servers  
✅ Persistent storage  
✅ Easy to query and debug  
❌ Database overhead  
❌ Slower than Redis  

---

### B. Redis Sessions (Production)

#### Configuration (.env)
```env
SESSION_DRIVER=redis
SESSION_CONNECTION=default
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=strict
```

#### Pros & Cons
✅ Very fast  
✅ Scales well  
✅ Low overhead  
❌ Requires Redis  

---

### Session Security (Production)

```env
# HTTPS Only (Production)
SESSION_SECURE_COOKIE=true

# Prevent XSS
SESSION_HTTP_ONLY=true

# CSRF Protection
SESSION_SAME_SITE=strict

# Encrypt session data
SESSION_ENCRYPT=true
```

---

## 4. REDIS SETUP FOR WINDOWS

### Installation

#### Option 1: Windows Build
```powershell
# Download Redis for Windows
# https://github.com/microsoftarchive/redis/releases

# Extract and run
cd C:\Redis
redis-server.exe

# Test
redis-cli.exe
ping # Should return PONG
```

#### Option 2: Docker (Recommended)
```powershell
# Install Docker Desktop
# https://www.docker.com/products/docker-desktop

# Run Redis
docker run -d --name redis -p 6379:6379 redis:alpine

# Test
docker exec -it redis redis-cli ping
```

#### Option 3: WSL2 (Windows Subsystem for Linux)
```bash
# Install Redis on WSL
sudo apt update
sudo apt install redis-server

# Start Redis
sudo service redis-server start

# Test
redis-cli ping
```

---

### Redis Configuration

#### config/database.php
```php
'redis' => [
    'client' => env('REDIS_CLIENT', 'phpredis'),

    'options' => [
        'cluster' => env('REDIS_CLUSTER', 'redis'),
        'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
    ],

    'default' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'username' => env('REDIS_USERNAME'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_DB', '0'),
    ],

    'cache' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'username' => env('REDIS_USERNAME'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_CACHE_DB', '1'),
    ],

    'queue' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'username' => env('REDIS_USERNAME'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_QUEUE_DB', '2'),
    ],
],
```

---

## 5. PERFORMANCE OPTIMIZATION

### Recommended Production Setup

```env
# PRODUCTION CONFIGURATION
APP_ENV=production
APP_DEBUG=false

# Cache
CACHE_STORE=redis
REDIS_CACHE_DB=1

# Queue
QUEUE_CONNECTION=redis
REDIS_QUEUE_DB=2

# Session
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true

# Redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=strong-password-here
```

### Optimization Commands

```powershell
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache events
php artisan event:cache

# Clear all caches
php artisan optimize:clear
```

### Performance Testing

```powershell
# Benchmark cache
php artisan tinker
$start = microtime(true);
for ($i = 0; $i < 1000; $i++) {
    Cache::put("key_$i", "value_$i", 60);
}
$end = microtime(true);
echo ($end - $start) * 1000 . "ms";
```

---

## 📊 Configuration Matrix

| Environment | Cache | Queue | Session |
|-------------|-------|-------|---------|
| **Local** | file/database | database/sync | file |
| **Development** | database | database | database |
| **Staging** | redis | redis | database |
| **Production** | redis | redis | redis |

---

## ✅ Setup Checklist

### Development
- [ ] CACHE_STORE=database
- [ ] QUEUE_CONNECTION=database
- [ ] SESSION_DRIVER=database
- [ ] Run: php artisan queue:work

### Production
- [ ] Install Redis
- [ ] CACHE_STORE=redis
- [ ] QUEUE_CONNECTION=redis
- [ ] SESSION_DRIVER=redis
- [ ] SESSION_SECURE_COOKIE=true
- [ ] Setup queue worker service
- [ ] Configure Redis password
- [ ] Setup monitoring
- [ ] Test failover

---

**Last Updated:** November 12, 2025  
**Status:** ✅ Database Queue/Cache Working, Redis Ready for Production
