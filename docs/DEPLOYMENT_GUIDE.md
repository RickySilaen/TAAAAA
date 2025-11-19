# Deployment Guide - Sistem Pertanian Toba

> **Comprehensive guide for deploying the agricultural management system to production**

## Table of Contents
- [Server Requirements](#server-requirements)
- [Initial Server Setup](#initial-server-setup)
- [Docker Deployment](#docker-deployment)
- [SSL/HTTPS Setup](#sslhttps-setup)
- [Nginx Optimization](#nginx-optimization)
- [Database Optimization](#database-optimization)
- [CDN Integration](#cdn-integration)
- [Monitoring & Logging](#monitoring--logging)
- [Backup Strategy](#backup-strategy)
- [Maintenance](#maintenance)

---

## Server Requirements

### Minimum Specifications
- **OS**: Ubuntu 22.04 LTS (recommended) or Debian 11+
- **CPU**: 2 cores (4+ cores recommended for production)
- **RAM**: 4GB (8GB+ recommended for production)
- **Storage**: 40GB SSD (100GB+ for production with logs/backups)
- **Network**: 100Mbps connection

### Software Requirements
- Docker Engine 24.0+
- Docker Compose 2.20+
- UFW/iptables firewall
- Certbot for SSL certificates

---

## Initial Server Setup

### 1. Create Non-Root User

```bash
# Login as root
ssh root@your-server-ip

# Create new user
adduser deployer
usermod -aG sudo deployer
usermod -aG docker deployer

# Switch to new user
su - deployer
```

### 2. SSH Key Setup

```bash
# On your local machine
ssh-keygen -t ed25519 -C "deployer@pertanian-toba"

# Copy public key to server
ssh-copy-id deployer@your-server-ip

# Test SSH access
ssh deployer@your-server-ip
```

### 3. Secure SSH Configuration

```bash
sudo nano /etc/ssh/sshd_config
```

Update the following:
```
PermitRootLogin no
PasswordAuthentication no
PubkeyAuthentication yes
Port 2222  # Change from default 22
```

Restart SSH:
```bash
sudo systemctl restart sshd
```

### 4. Firewall Setup

```bash
# Install UFW
sudo apt update
sudo apt install ufw

# Default policies
sudo ufw default deny incoming
sudo ufw default allow outgoing

# Allow SSH (use your custom port)
sudo ufw allow 2222/tcp

# Allow HTTP/HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Enable firewall
sudo ufw enable
sudo ufw status verbose
```

---

## Docker Deployment

### 1. Install Docker & Docker Compose

```bash
# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Add user to docker group
sudo usermod -aG docker $USER
newgrp docker

# Install Docker Compose
sudo apt install docker-compose-plugin

# Verify installation
docker --version
docker compose version
```

### 2. Clone Repository

```bash
cd /var/www
sudo mkdir pertanian-toba
sudo chown deployer:deployer pertanian-toba
cd pertanian-toba

# Clone from GitHub
git clone https://github.com/your-org/sistem-pertanian.git .
```

### 3. Environment Configuration

```bash
# Copy Docker environment file
cp .env.docker .env

# Generate Laravel application key
docker run --rm -v $(pwd):/app composer:latest \
  sh -c "cd /app && php artisan key:generate --show"

# Edit .env with production values
nano .env
```

Update the following in `.env`:
```env
APP_NAME="Sistem Pertanian Toba"
APP_ENV=production
APP_KEY=base64:your-generated-key-here
APP_DEBUG=false
APP_URL=https://pertanian-toba.com

DB_PASSWORD=your-strong-database-password
REDIS_PASSWORD=your-strong-redis-password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@pertanian-toba.com
```

### 4. Build & Deploy

```bash
# Build Docker images
docker compose build --no-cache

# Start services
docker compose up -d

# Check service status
docker compose ps

# View logs
docker compose logs -f app

# Run migrations
docker compose exec app php artisan migrate --force

# Create admin user
docker compose exec app php artisan db:seed --class=AdminPetugasSeeder
```

### 5. Verify Deployment

```bash
# Test health endpoint
curl http://localhost/health

# Test detailed health
curl http://localhost/health/detailed

# Access application
curl -I http://localhost
```

---

## SSL/HTTPS Setup

### 1. Install Certbot

```bash
sudo apt update
sudo apt install certbot python3-certbot-nginx
```

### 2. Obtain SSL Certificate

```bash
# Stop nginx proxy temporarily
docker compose stop nginx-proxy

# Get certificate
sudo certbot certonly --standalone \
  -d pertanian-toba.com \
  -d www.pertanian-toba.com \
  --email admin@pertanian-toba.com \
  --agree-tos \
  --non-interactive

# Restart nginx proxy
docker compose start nginx-proxy
```

### 3. Update Nginx Configuration

Create SSL configuration:
```bash
sudo nano /var/www/pertanian-toba/docker/nginx-proxy/nginx-ssl.conf
```

```nginx
server {
    listen 80;
    server_name pertanian-toba.com www.pertanian-toba.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name pertanian-toba.com www.pertanian-toba.com;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/pertanian-toba.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/pertanian-toba.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;

    # HSTS Header
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;

    # Proxy configuration
    location / {
        proxy_pass http://pertanian_backend;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        
        proxy_connect_timeout 60s;
        proxy_send_timeout 60s;
        proxy_read_timeout 60s;
    }
}
```

Update `docker-compose.yml` to mount SSL certificates:
```yaml
nginx-proxy:
  volumes:
    - ./docker/nginx-proxy/nginx-ssl.conf:/etc/nginx/nginx.conf:ro
    - /etc/letsencrypt:/etc/letsencrypt:ro
```

Restart services:
```bash
docker compose down
docker compose up -d
```

### 4. Auto-Renewal Setup

```bash
# Test renewal
sudo certbot renew --dry-run

# Create renewal script
sudo nano /usr/local/bin/renew-ssl.sh
```

```bash
#!/bin/bash
certbot renew --quiet
docker compose -f /var/www/pertanian-toba/docker-compose.yml exec nginx-proxy nginx -s reload
```

Make executable and add to crontab:
```bash
sudo chmod +x /usr/local/bin/renew-ssl.sh

# Add to crontab (runs daily at 2am)
sudo crontab -e
0 2 * * * /usr/local/bin/renew-ssl.sh
```

---

## Nginx Optimization

### 1. Enable Gzip Compression

Already configured in `docker/nginx/nginx.conf`:
```nginx
gzip on;
gzip_vary on;
gzip_comp_level 6;
gzip_types text/plain text/css application/json application/javascript;
```

### 2. Browser Caching

Add to `docker/nginx/default.conf`:
```nginx
location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff2?)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
    access_log off;
}
```

### 3. Rate Limiting

Configure in `docker/nginx-proxy/nginx.conf`:
```nginx
# Limit requests per IP
limit_req_zone $binary_remote_addr zone=general:10m rate=10r/s;
limit_req_zone $binary_remote_addr zone=api:10m rate=60r/m;

server {
    location / {
        limit_req zone=general burst=20 nodelay;
    }
    
    location /api/ {
        limit_req zone=api burst=5 nodelay;
    }
}
```

---

## Database Optimization

### 1. MySQL Performance Tuning

Already configured in `docker/mysql/my.cnf`:
```ini
[mysqld]
innodb_buffer_pool_size = 1G          # 70% of available RAM
innodb_log_file_size = 256M
max_connections = 200
query_cache_size = 64M
```

### 2. Enable Slow Query Log

```bash
# Access MySQL container
docker compose exec db mysql -uroot -p

# Enable slow query log
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;
```

### 3. Regular Maintenance

Create maintenance script:
```bash
nano /usr/local/bin/db-maintenance.sh
```

```bash
#!/bin/bash
CONTAINER=$(docker compose -f /var/www/pertanian-toba/docker-compose.yml ps -q db)

# Optimize tables
docker exec $CONTAINER mysqloptimize -u root -p pertanian_toba --all-databases

# Analyze tables
docker exec $CONTAINER mysqlcheck -u root -p pertanian_toba --analyze --all-databases
```

Add to crontab (weekly):
```bash
0 3 * * 0 /usr/local/bin/db-maintenance.sh
```

---

## CDN Integration

### 1. Cloudflare Setup

1. **Add Domain to Cloudflare**:
   - Go to Cloudflare dashboard
   - Add site: `pertanian-toba.com`
   - Update nameservers at domain registrar

2. **Configure DNS**:
   ```
   Type: A
   Name: @
   Content: your-server-ip
   Proxy: Enabled (orange cloud)
   
   Type: A
   Name: www
   Content: your-server-ip
   Proxy: Enabled
   ```

3. **SSL/TLS Settings**:
   - SSL/TLS encryption mode: Full (strict)
   - Enable Always Use HTTPS
   - Enable HTTP Strict Transport Security (HSTS)

4. **Caching Rules**:
   - Browser Cache TTL: Respect Existing Headers
   - Cache Level: Standard
   
   Create page rule for static assets:
   ```
   URL: *pertanian-toba.com/build/*
   Settings: Cache Level = Cache Everything, Edge Cache TTL = 1 month
   ```

5. **Performance Settings**:
   - Enable Auto Minify (JavaScript, CSS, HTML)
   - Enable Brotli compression
   - Enable Rocket Loader (test first)

### 2. Update Laravel Configuration

```php
// config/filesystems.php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('CDN_URL', env('APP_URL').'/storage'),
        'visibility' => 'public',
    ],
],
```

Update `.env`:
```env
CDN_URL=https://cdn.pertanian-toba.com
```

---

## Monitoring & Logging

### 1. Application Monitoring

Install Laravel Telescope (development only):
```bash
docker compose exec app composer require laravel/telescope --dev
docker compose exec app php artisan telescope:install
docker compose exec app php artisan migrate
```

### 2. Server Monitoring

Install monitoring tools:
```bash
# Install htop
sudo apt install htop

# Install Netdata (real-time monitoring)
bash <(curl -Ss https://my-netdata.io/kickstart.sh)

# Access Netdata dashboard at http://your-server-ip:19999
```

### 3. Log Management

Configure log rotation:
```bash
sudo nano /etc/logrotate.d/pertanian-toba
```

```
/var/www/pertanian-toba/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0644 www-data www-data
    sharedscripts
}
```

### 4. Error Tracking

Add Sentry integration:
```bash
docker compose exec app composer require sentry/sentry-laravel
```

Update `.env`:
```env
SENTRY_LARAVEL_DSN=your-sentry-dsn
SENTRY_TRACES_SAMPLE_RATE=0.2
```

---

## Backup Strategy

### 1. Database Backup Script

```bash
sudo nano /usr/local/bin/backup-database.sh
```

```bash
#!/bin/bash
BACKUP_DIR="/var/backups/pertanian-toba"
DATE=$(date +%Y%m%d_%H%M%S)
CONTAINER=$(docker compose -f /var/www/pertanian-toba/docker-compose.yml ps -q db)

mkdir -p $BACKUP_DIR

# Backup database
docker exec $CONTAINER mysqldump -u root -p"${DB_ROOT_PASSWORD}" \
  pertanian_toba | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz

# Keep only last 7 days
find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +7 -delete

echo "Database backup completed: $BACKUP_DIR/db_backup_$DATE.sql.gz"
```

Make executable:
```bash
sudo chmod +x /usr/local/bin/backup-database.sh
```

### 2. File Backup Script

```bash
sudo nano /usr/local/bin/backup-files.sh
```

```bash
#!/bin/bash
BACKUP_DIR="/var/backups/pertanian-toba"
DATE=$(date +%Y%m%d_%H%M%S)
SOURCE="/var/www/pertanian-toba"

mkdir -p $BACKUP_DIR

# Backup uploads
tar -czf $BACKUP_DIR/uploads_backup_$DATE.tar.gz -C $SOURCE public/uploads

# Keep only last 7 days
find $BACKUP_DIR -name "uploads_backup_*.tar.gz" -mtime +7 -delete

echo "File backup completed: $BACKUP_DIR/uploads_backup_$DATE.tar.gz"
```

Make executable:
```bash
sudo chmod +x /usr/local/bin/backup-files.sh
```

### 3. Automated Backup Schedule

```bash
sudo crontab -e
```

Add:
```cron
# Database backup (daily at 1am)
0 1 * * * /usr/local/bin/backup-database.sh

# File backup (daily at 2am)
0 2 * * * /usr/local/bin/backup-files.sh
```

### 4. Off-Site Backup (Optional)

Install rclone for cloud backup:
```bash
curl https://rclone.org/install.sh | sudo bash

# Configure cloud storage
rclone config
```

Create cloud backup script:
```bash
sudo nano /usr/local/bin/backup-to-cloud.sh
```

```bash
#!/bin/bash
# Upload to cloud storage (after local backup)
rclone sync /var/backups/pertanian-toba remote:pertanian-backups
```

---

## Maintenance

### 1. Update Application

```bash
cd /var/www/pertanian-toba

# Pull latest code
git pull origin main

# Rebuild and restart
docker compose build --no-cache
docker compose down
docker compose up -d

# Run migrations
docker compose exec app php artisan migrate --force

# Clear caches
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
```

### 2. Update Docker Images

```bash
# Pull latest base images
docker compose pull

# Rebuild containers
docker compose up -d --build
```

### 3. Clean Up Docker Resources

```bash
# Remove unused images
docker image prune -a

# Remove unused volumes
docker volume prune

# Remove unused containers
docker container prune
```

### 4. Monitor Disk Usage

```bash
# Check disk usage
df -h

# Check Docker disk usage
docker system df

# Clean up if needed
docker system prune -a
```

---

## Troubleshooting

### Application Not Accessible

1. Check container status:
```bash
docker compose ps
```

2. Check logs:
```bash
docker compose logs -f app
docker compose logs -f nginx-proxy
```

3. Verify health endpoint:
```bash
curl http://localhost/health
```

### Database Connection Issues

1. Check database container:
```bash
docker compose logs db
```

2. Test database connection:
```bash
docker compose exec app php artisan db:show
```

3. Verify credentials in `.env`

### Performance Issues

1. Check resource usage:
```bash
docker stats
```

2. Check slow queries:
```bash
docker compose exec db mysql -uroot -p -e "SELECT * FROM mysql.slow_log LIMIT 10;"
```

3. Clear application cache:
```bash
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear
```

---

## Security Checklist

- [ ] SSH secured (key-based, non-standard port)
- [ ] Firewall enabled (UFW)
- [ ] SSL/HTTPS configured with Let's Encrypt
- [ ] HSTS header enabled
- [ ] Security headers configured
- [ ] Database password strong and unique
- [ ] Redis password configured
- [ ] APP_DEBUG=false in production
- [ ] Regular backups configured
- [ ] Log rotation configured
- [ ] Monitoring enabled

---

## Support

For issues or questions:
- **Documentation**: `/docs/`
- **GitHub Issues**: https://github.com/your-org/sistem-pertanian/issues
- **Email**: support@pertanian-toba.com

---

**Last Updated**: $(date +%Y-%m-%d)
**Version**: 1.0.0
