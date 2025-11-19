# Security Hardening Guide - Sistem Pertanian Toba

> **Comprehensive security measures for production deployment**

## Table of Contents
- [Server Security](#server-security)
- [Application Security](#application-security)
- [Database Security](#database-security)
- [Network Security](#network-security)
- [SSL/TLS Security](#ssltls-security)
- [Access Control](#access-control)
- [Monitoring & Incident Response](#monitoring--incident-response)
- [Security Audit Checklist](#security-audit-checklist)

---

## Server Security

### 1. Operating System Hardening

#### Update System Packages
```bash
# Update package lists
sudo apt update

# Upgrade installed packages
sudo apt upgrade -y

# Enable automatic security updates
sudo apt install unattended-upgrades
sudo dpkg-reconfigure --priority=low unattended-upgrades
```

#### Disable Unnecessary Services
```bash
# List all running services
systemctl list-units --type=service --state=running

# Disable unnecessary services (example)
sudo systemctl disable bluetooth.service
sudo systemctl disable cups.service
```

#### Configure System Limits
```bash
sudo nano /etc/security/limits.conf
```

Add:
```
* soft nofile 65536
* hard nofile 65536
* soft nproc 4096
* hard nproc 4096
```

### 2. SSH Hardening

#### Create Strong SSH Configuration
```bash
sudo nano /etc/ssh/sshd_config
```

Recommended settings:
```
# Basic settings
Port 2222                          # Non-standard port
Protocol 2                         # Use SSH Protocol 2 only
PermitRootLogin no                 # Disable root login
PasswordAuthentication no          # Key-based auth only
PubkeyAuthentication yes           # Enable public key auth
PermitEmptyPasswords no            # No empty passwords
MaxAuthTries 3                     # Limit authentication attempts
LoginGraceTime 20                  # Reduce login grace time

# Security enhancements
X11Forwarding no                   # Disable X11 forwarding
AllowTcpForwarding no              # Disable TCP forwarding
AllowAgentForwarding no            # Disable agent forwarding
PermitUserEnvironment no           # Disable user environment
ClientAliveInterval 300            # 5 minutes timeout
ClientAliveCountMax 2              # Disconnect after 2 failed checks

# Allowed users
AllowUsers deployer                # Only allow specific users

# Strong cryptography
Ciphers aes256-gcm@openssh.com,aes128-gcm@openssh.com
MACs hmac-sha2-512-etm@openssh.com,hmac-sha2-256-etm@openssh.com
KexAlgorithms curve25519-sha256,diffie-hellman-group-exchange-sha256
```

Restart SSH:
```bash
sudo systemctl restart sshd
```

#### SSH Key Management
```bash
# Generate strong SSH key (if not done)
ssh-keygen -t ed25519 -a 100 -C "deployer@pertanian-toba"

# Set proper permissions
chmod 700 ~/.ssh
chmod 600 ~/.ssh/authorized_keys
chmod 600 ~/.ssh/id_ed25519
chmod 644 ~/.ssh/id_ed25519.pub
```

### 3. Install Fail2Ban

Protect against brute-force attacks:

```bash
# Install Fail2Ban
sudo apt install fail2ban -y

# Create local configuration
sudo nano /etc/fail2ban/jail.local
```

Configuration:
```ini
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 3
destemail = admin@pertanian-toba.com
sendername = Fail2Ban
action = %(action_mwl)s

[sshd]
enabled = true
port = 2222
logpath = /var/log/auth.log
maxretry = 3
bantime = 86400

[nginx-http-auth]
enabled = true
filter = nginx-http-auth
port = http,https
logpath = /var/log/nginx/error.log

[nginx-limit-req]
enabled = true
filter = nginx-limit-req
port = http,https
logpath = /var/log/nginx/error.log
```

Start and enable:
```bash
sudo systemctl enable fail2ban
sudo systemctl start fail2ban

# Check status
sudo fail2ban-client status
sudo fail2ban-client status sshd
```

### 4. Firewall Configuration

#### UFW (Uncomplicated Firewall)
```bash
# Install UFW
sudo apt install ufw -y

# Default policies
sudo ufw default deny incoming
sudo ufw default allow outgoing

# Allow SSH (custom port)
sudo ufw allow 2222/tcp comment 'SSH'

# Allow HTTP/HTTPS
sudo ufw allow 80/tcp comment 'HTTP'
sudo ufw allow 443/tcp comment 'HTTPS'

# Allow from specific IP only (optional)
# sudo ufw allow from 123.456.789.0 to any port 2222

# Enable firewall
sudo ufw enable

# Check status
sudo ufw status verbose
sudo ufw status numbered
```

#### iptables Rules (Advanced)
```bash
# Flush existing rules
sudo iptables -F

# Default policies
sudo iptables -P INPUT DROP
sudo iptables -P FORWARD DROP
sudo iptables -P OUTPUT ACCEPT

# Allow loopback
sudo iptables -A INPUT -i lo -j ACCEPT

# Allow established connections
sudo iptables -A INPUT -m conntrack --ctstate ESTABLISHED,RELATED -j ACCEPT

# Allow SSH (custom port)
sudo iptables -A INPUT -p tcp --dport 2222 -m conntrack --ctstate NEW,ESTABLISHED -j ACCEPT

# Allow HTTP/HTTPS
sudo iptables -A INPUT -p tcp --dport 80 -m conntrack --ctstate NEW,ESTABLISHED -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 443 -m conntrack --ctstate NEW,ESTABLISHED -j ACCEPT

# Rate limiting
sudo iptables -A INPUT -p tcp --dport 80 -m limit --limit 25/minute --limit-burst 100 -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 443 -m limit --limit 25/minute --limit-burst 100 -j ACCEPT

# Drop invalid packets
sudo iptables -A INPUT -m conntrack --ctstate INVALID -j DROP

# Protection against port scanning
sudo iptables -N port-scanning
sudo iptables -A port-scanning -p tcp --tcp-flags SYN,ACK,FIN,RST RST -m limit --limit 1/s --limit-burst 2 -j RETURN
sudo iptables -A port-scanning -j DROP

# Save rules
sudo apt install iptables-persistent
sudo netfilter-persistent save
```

---

## Application Security

### 1. Environment Configuration

#### Secure .env File
```bash
# Set proper permissions
chmod 600 /var/www/pertanian-toba/.env
chown deployer:deployer /var/www/pertanian-toba/.env
```

Required security settings in `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-strong-32-character-key

# Session security
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=strict

# HTTPS enforcement
FORCE_HTTPS=true
```

### 2. Laravel Security Configuration

#### config/app.php
```php
'debug' => env('APP_DEBUG', false),
'env' => env('APP_ENV', 'production'),
```

#### config/session.php
```php
'secure' => env('SESSION_SECURE_COOKIE', true),
'http_only' => true,
'same_site' => 'strict',
'lifetime' => 120,
```

#### Middleware Security

Create security headers middleware:
```bash
docker compose exec app php artisan make:middleware SecurityHeaders
```

```php
<?php
// app/Http/Middleware/SecurityHeaders.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        
        // Content Security Policy
        $response->headers->set('Content-Security-Policy', 
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
            "font-src 'self' https://fonts.gstatic.com; " .
            "img-src 'self' data: https:; " .
            "connect-src 'self';"
        );
        
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 
                'max-age=31536000; includeSubDomains; preload'
            );
        }
        
        return $response;
    }
}
```

Register in `app/Http/Kernel.php`:
```php
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\SecurityHeaders::class,
        // ... other middleware
    ],
];
```

### 3. Input Validation & Sanitization

#### Form Request Validation
```php
// Always use Form Requests for validation
class StoreLaporanRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'judul' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\-]+$/'],
            'deskripsi' => ['required', 'string', 'max:1000'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
}
```

#### Protect Against Mass Assignment
```php
// app/Models/User.php
protected $fillable = [
    'nama_lengkap',
    'email',
    'no_telepon',
];

protected $guarded = [
    'id',
    'role',
    'is_verified',
    'verification_token',
];
```

### 4. CSRF Protection

Ensure CSRF protection is enabled (default in Laravel):
```php
// config/app.php - VerifyCsrfToken middleware
protected $except = [
    // Only add exceptions if absolutely necessary
    // 'webhook/*',
];
```

### 5. SQL Injection Prevention

Always use Eloquent or Query Builder with parameter binding:
```php
// ✅ GOOD - Use Eloquent
$user = User::where('email', $email)->first();

// ✅ GOOD - Use Query Builder with bindings
DB::table('users')->where('email', $email)->first();

// ❌ BAD - Never use raw SQL with concatenation
// DB::select("SELECT * FROM users WHERE email = '$email'");
```

### 6. XSS Prevention

Always escape output in Blade templates:
```blade
{{-- ✅ GOOD - Escaped by default --}}
{{ $user->nama_lengkap }}

{{-- ⚠️ DANGEROUS - Only use for trusted HTML --}}
{!! $trustedHtml !!}

{{-- ✅ GOOD - Escape JavaScript --}}
<script>
    var userName = @json($user->nama_lengkap);
</script>
```

### 7. File Upload Security

Validate and sanitize file uploads:
```php
public function store(Request $request)
{
    $request->validate([
        'foto' => [
            'required',
            'image',
            'mimes:jpeg,png,jpg',
            'max:2048', // 2MB
            'dimensions:min_width=100,min_height=100,max_width=4000,max_height=4000',
        ],
    ]);
    
    if ($request->hasFile('foto')) {
        // Generate unique filename
        $filename = Str::uuid() . '.' . $request->file('foto')->extension();
        
        // Store with validated extension
        $path = $request->file('foto')->storeAs(
            'public/uploads',
            $filename
        );
        
        // Verify file type (additional check)
        $mimeType = mime_content_type(storage_path('app/' . $path));
        if (!in_array($mimeType, ['image/jpeg', 'image/png'])) {
            Storage::delete($path);
            abort(422, 'Invalid file type');
        }
    }
}
```

---

## Database Security

### 1. User Privileges

Create dedicated database user with minimal privileges:

```sql
-- Connect to MySQL as root
docker compose exec db mysql -uroot -p

-- Create application user
CREATE USER 'pertanian_user'@'%' IDENTIFIED BY 'strong-password-here';

-- Grant only necessary privileges
GRANT SELECT, INSERT, UPDATE, DELETE 
ON pertanian_toba.* 
TO 'pertanian_user'@'%';

-- Do NOT grant DROP, CREATE, ALTER unless needed

FLUSH PRIVILEGES;
```

### 2. Disable Remote Root Access

```sql
-- Delete remote root access
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');
FLUSH PRIVILEGES;
```

### 3. Secure MySQL Configuration

Update `docker/mysql/my.cnf`:
```ini
[mysqld]
# Security settings
local-infile=0                     # Disable LOAD DATA LOCAL INFILE
skip-symbolic-links=1              # Disable symbolic links
secure-file-priv=/var/lib/mysql    # Restrict file operations

# Connection security
max_connect_errors=10
max_connections=200

# Log security
log-error=/var/log/mysql/error.log
log-warnings=2
```

### 4. Encrypt Database Backups

```bash
# Backup with encryption
docker compose exec db mysqldump -u root -p pertanian_toba | \
  gpg --encrypt --recipient admin@pertanian-toba.com > \
  /var/backups/pertanian-toba/db_$(date +%Y%m%d).sql.gpg

# Restore encrypted backup
gpg --decrypt /var/backups/pertanian-toba/db_20250115.sql.gpg | \
  docker compose exec -T db mysql -u root -p pertanian_toba
```

---

## Network Security

### 1. Docker Network Isolation

Update `docker-compose.yml` to isolate services:
```yaml
networks:
  frontend:
    driver: bridge
  backend:
    driver: bridge
    internal: true  # No external access

services:
  nginx-proxy:
    networks:
      - frontend
      
  app:
    networks:
      - frontend
      - backend
      
  db:
    networks:
      - backend  # Database not accessible from outside
      
  redis:
    networks:
      - backend  # Redis not accessible from outside
```

### 2. Rate Limiting

Already configured in `docker/nginx-proxy/nginx.conf`:
```nginx
# General rate limiting
limit_req_zone $binary_remote_addr zone=general:10m rate=10r/s;

# API rate limiting
limit_req_zone $binary_remote_addr zone=api:10m rate=60r/m;

# Login rate limiting
limit_req_zone $binary_remote_addr zone=login:10m rate=5r/m;

server {
    location /login {
        limit_req zone=login burst=2 nodelay;
    }
    
    location /api/ {
        limit_req zone=api burst=5 nodelay;
    }
}
```

### 3. DDoS Protection

```nginx
# Connection limiting
limit_conn_zone $binary_remote_addr zone=conn_limit_per_ip:10m;
limit_conn conn_limit_per_ip 10;

# Request body size limit
client_max_body_size 20M;
client_body_buffer_size 128k;

# Timeouts
client_body_timeout 10s;
client_header_timeout 10s;
keepalive_timeout 5s 5s;
send_timeout 10s;
```

### 4. Geo-Blocking (Optional)

Block traffic from specific countries:
```nginx
# Install GeoIP module first
# sudo apt install nginx-module-geoip

geo $blocked_country {
    default 0;
    # Block specific countries (example)
    # CN 1;  # China
    # RU 1;  # Russia
}

server {
    if ($blocked_country) {
        return 403;
    }
}
```

---

## SSL/TLS Security

### 1. Strong SSL Configuration

Update `docker/nginx-proxy/nginx-ssl.conf`:
```nginx
# SSL protocols (TLS 1.2 and 1.3 only)
ssl_protocols TLSv1.2 TLSv1.3;

# Strong ciphers
ssl_ciphers 'ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384';
ssl_prefer_server_ciphers on;

# Session caching
ssl_session_cache shared:SSL:50m;
ssl_session_timeout 1d;
ssl_session_tickets off;

# OCSP Stapling
ssl_stapling on;
ssl_stapling_verify on;
ssl_trusted_certificate /etc/letsencrypt/live/pertanian-toba.com/chain.pem;
resolver 8.8.8.8 8.8.4.4 valid=300s;
resolver_timeout 5s;

# HSTS (31536000 seconds = 1 year)
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
```

### 2. Certificate Monitoring

Create script to check certificate expiry:
```bash
sudo nano /usr/local/bin/check-ssl-expiry.sh
```

```bash
#!/bin/bash
DOMAIN="pertanian-toba.com"
DAYS_WARNING=30

EXPIRY_DATE=$(echo | openssl s_client -servername $DOMAIN -connect $DOMAIN:443 2>/dev/null | \
  openssl x509 -noout -enddate | cut -d= -f2)

EXPIRY_EPOCH=$(date -d "$EXPIRY_DATE" +%s)
NOW_EPOCH=$(date +%s)
DAYS_LEFT=$(( ($EXPIRY_EPOCH - $NOW_EPOCH) / 86400 ))

if [ $DAYS_LEFT -lt $DAYS_WARNING ]; then
    echo "WARNING: SSL certificate expires in $DAYS_LEFT days!"
    # Send notification email
    echo "SSL certificate for $DOMAIN expires in $DAYS_LEFT days" | \
      mail -s "SSL Certificate Expiry Warning" admin@pertanian-toba.com
fi
```

Add to crontab (daily check):
```bash
0 9 * * * /usr/local/bin/check-ssl-expiry.sh
```

### 3. Perfect Forward Secrecy

Ensure Diffie-Hellman parameters are strong:
```bash
# Generate strong DH parameters (takes time)
sudo openssl dhparam -out /etc/ssl/certs/dhparam.pem 4096
```

Add to Nginx SSL config:
```nginx
ssl_dhparam /etc/ssl/certs/dhparam.pem;
```

---

## Access Control

### 1. Role-Based Access Control (RBAC)

Ensure proper role checks in controllers:
```php
// app/Http/Controllers/BantuanController.php
public function store(Request $request)
{
    // Check role
    if (!auth()->user()->hasRole(['admin', 'petugas'])) {
        abort(403, 'Unauthorized action.');
    }
    
    // Process request...
}
```

### 2. Two-Factor Authentication (Optional)

Install Laravel Fortify with 2FA:
```bash
docker compose exec app composer require laravel/fortify
docker compose exec app php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
docker compose exec app php artisan migrate
```

Enable in `config/fortify.php`:
```php
'features' => [
    Features::twoFactorAuthentication([
        'confirmPassword' => true,
    ]),
],
```

### 3. API Authentication

Use Laravel Sanctum for API security:
```php
// routes/web.php or api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/api/laporans', [LaporanController::class, 'index']);
    Route::post('/api/laporans', [LaporanController::class, 'store']);
});
```

Rate limiting for API:
```php
// app/Providers/RouteServiceProvider.php
protected function configureRateLimiting()
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });
}
```

---

## Monitoring & Incident Response

### 1. Security Logging

Enable comprehensive logging:
```php
// config/logging.php
'channels' => [
    'security' => [
        'driver' => 'daily',
        'path' => storage_path('logs/security.log'),
        'level' => 'info',
        'days' => 90,
    ],
],
```

Log security events:
```php
// app/Http/Middleware/LogAuthentication.php
use Illuminate\Support\Facades\Log;

Log::channel('security')->info('Login attempt', [
    'email' => $request->input('email'),
    'ip' => $request->ip(),
    'user_agent' => $request->userAgent(),
    'success' => $success,
]);
```

### 2. Intrusion Detection

Monitor suspicious activities:
```bash
# Install AIDE (Advanced Intrusion Detection Environment)
sudo apt install aide -y

# Initialize AIDE database
sudo aideinit

# Check for changes
sudo aide --check
```

### 3. Log Monitoring with Logwatch

```bash
# Install logwatch
sudo apt install logwatch -y

# Configure daily email reports
sudo nano /etc/cron.daily/00logwatch
```

```bash
#!/bin/bash
/usr/sbin/logwatch --output mail --mailto admin@pertanian-toba.com --detail high
```

### 4. Incident Response Plan

Create incident response procedure:

**Step 1: Detection**
- Monitor logs for unusual activity
- Set up alerts for failed login attempts
- Monitor system resources

**Step 2: Containment**
- Block malicious IPs with `sudo ufw deny from <IP>`
- Disable compromised accounts
- Take affected services offline if necessary

**Step 3: Investigation**
- Review logs: `/var/log/auth.log`, `/var/log/nginx/access.log`
- Check Docker logs: `docker compose logs`
- Identify attack vector

**Step 4: Recovery**
- Restore from clean backups
- Patch vulnerabilities
- Reset compromised credentials

**Step 5: Post-Incident**
- Document incident
- Update security measures
- Conduct post-mortem analysis

---

## Security Audit Checklist

### Server Security
- [ ] Operating system fully updated
- [ ] Unnecessary services disabled
- [ ] SSH hardened (key-based, non-standard port)
- [ ] Fail2Ban installed and configured
- [ ] Firewall enabled (UFW/iptables)
- [ ] Automatic security updates enabled
- [ ] Server timezone set correctly
- [ ] NTP configured for time synchronization

### Application Security
- [ ] APP_DEBUG=false in production
- [ ] APP_ENV=production
- [ ] Strong APP_KEY generated
- [ ] .env file permissions set to 600
- [ ] CSRF protection enabled
- [ ] XSS protection enabled
- [ ] SQL injection prevention (parameterized queries)
- [ ] File upload validation enabled
- [ ] Security headers middleware active
- [ ] Session security configured (secure, httpOnly, sameSite)
- [ ] Input validation on all forms
- [ ] Output escaping in all templates

### Database Security
- [ ] Database user has minimal privileges
- [ ] Root remote access disabled
- [ ] Strong database password
- [ ] Database backups encrypted
- [ ] Slow query log enabled
- [ ] Binary logging disabled (if not needed)
- [ ] Database connection over internal network only

### Network Security
- [ ] Docker networks isolated
- [ ] Rate limiting configured
- [ ] DDoS protection enabled
- [ ] Unused ports closed
- [ ] Services bound to localhost where possible

### SSL/TLS Security
- [ ] Valid SSL certificate installed
- [ ] TLS 1.2+ only
- [ ] Strong cipher suites configured
- [ ] HSTS header enabled
- [ ] OCSP stapling enabled
- [ ] Certificate auto-renewal configured
- [ ] Perfect forward secrecy enabled

### Access Control
- [ ] Role-based access control implemented
- [ ] Strong password policy enforced
- [ ] Account lockout after failed attempts
- [ ] Session timeout configured
- [ ] API authentication enabled
- [ ] API rate limiting configured

### Monitoring & Logging
- [ ] Security logging enabled
- [ ] Log rotation configured
- [ ] Failed login attempts logged
- [ ] Intrusion detection installed
- [ ] Log monitoring with alerts
- [ ] Incident response plan documented

### Backups
- [ ] Automated daily backups
- [ ] Off-site backup configured
- [ ] Backup encryption enabled
- [ ] Backup restoration tested
- [ ] Backup retention policy defined

### Compliance
- [ ] Privacy policy published
- [ ] Terms of service published
- [ ] GDPR compliance (if applicable)
- [ ] Data protection measures documented
- [ ] Security audit conducted

---

## Security Tools

### Recommended Tools

1. **Vulnerability Scanning**
   - Nmap: `sudo apt install nmap`
   - Nikto: `sudo apt install nikto`
   - OWASP ZAP: Web application security scanner

2. **SSL Testing**
   - SSL Labs: https://www.ssllabs.com/ssltest/
   - testssl.sh: `git clone https://github.com/drwetter/testssl.sh.git`

3. **Penetration Testing**
   - Metasploit Framework
   - Burp Suite
   - SQLMap

4. **Security Headers Testing**
   - SecurityHeaders.com: https://securityheaders.com/
   - Mozilla Observatory: https://observatory.mozilla.org/

---

## Regular Security Tasks

### Daily
- [ ] Review security logs
- [ ] Check failed login attempts
- [ ] Monitor system resources

### Weekly
- [ ] Review user accounts
- [ ] Check SSL certificate expiry
- [ ] Review firewall logs
- [ ] Test backup restoration

### Monthly
- [ ] Update all packages
- [ ] Review access permissions
- [ ] Audit user privileges
- [ ] Test incident response plan
- [ ] Security awareness training

### Quarterly
- [ ] Full security audit
- [ ] Penetration testing
- [ ] Review and update security policies
- [ ] Disaster recovery drill

---

## Emergency Contacts

- **System Administrator**: admin@pertanian-toba.com
- **Security Team**: security@pertanian-toba.com
- **Emergency Hotline**: +62-xxx-xxxx-xxxx

---

## References

- OWASP Top 10: https://owasp.org/www-project-top-ten/
- CIS Benchmarks: https://www.cisecurity.org/cis-benchmarks/
- Laravel Security: https://laravel.com/docs/security
- Docker Security: https://docs.docker.com/engine/security/

---

**Last Updated**: $(date +%Y-%m-%d)
**Version**: 1.0.0
