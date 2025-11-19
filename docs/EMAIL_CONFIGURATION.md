# 📧 EMAIL CONFIGURATION GUIDE

## Overview
Panduan lengkap konfigurasi email untuk Sistem Pertanian Toba dengan support multiple providers dan failover.

---

## 📋 Table of Contents
1. [Gmail SMTP](#gmail-smtp)
2. [Mailgun API](#mailgun-api)
3. [SendGrid API](#sendgrid-api)
4. [Mailtrap (Testing)](#mailtrap-testing)
5. [Local Testing](#local-testing)
6. [Multiple Mailers Setup](#multiple-mailers-setup)
7. [Testing Email](#testing-email)

---

## 1. Gmail SMTP Configuration

### Setup Steps:

#### A. Enable Gmail SMTP Access
1. Go to Google Account: https://myaccount.google.com/
2. Security → 2-Step Verification → App Passwords
3. Generate App Password for "Mail"
4. Copy the 16-character password

#### B. .env Configuration
```env
# Gmail SMTP Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Sistem Pertanian Toba"
```

### Limits:
- **Free:** 500 emails/day
- **Google Workspace:** 2,000 emails/day
- **Rate:** 100 emails/second (burst)

### Pros & Cons:
✅ Free and reliable  
✅ Easy setup  
✅ Good deliverability  
❌ Low daily limit  
❌ May flag as spam for bulk emails  

---

## 2. Mailgun API Configuration

### Setup Steps:

#### A. Create Mailgun Account
1. Sign up: https://www.mailgun.com/
2. Add and verify your domain
3. Get API Key from Settings → API Keys
4. Get Domain from Sending → Domains

#### B. Install Mailgun Package
```powershell
composer require symfony/mailgun-mailer symfony/http-client
```

#### C. .env Configuration
```env
# Mailgun API Configuration
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.yourdomain.com
MAILGUN_SECRET=your-api-key
MAILGUN_ENDPOINT=api.mailgun.net
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Sistem Pertanian Toba"
```

### Limits:
- **Free Trial:** 5,000 emails/month (3 months)
- **Flex Plan:** Pay-as-you-go $0.80/1000 emails
- **Foundation:** $35/month (50,000 emails)

### Pros & Cons:
✅ High deliverability  
✅ Detailed analytics  
✅ Webhook support  
✅ Good for production  
❌ Requires domain verification  
❌ Paid after trial  

---

## 3. SendGrid API Configuration

### Setup Steps:

#### A. Create SendGrid Account
1. Sign up: https://sendgrid.com/
2. Create API Key: Settings → API Keys → Create API Key
3. Verify sender email/domain

#### B. Install SendGrid Package
```powershell
composer require symfony/sendgrid-mailer symfony/http-client
```

#### C. .env Configuration
```env
# SendGrid API Configuration
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your-sendgrid-api-key
MAIL_FROM_ADDRESS=verified@yourdomain.com
MAIL_FROM_NAME="Sistem Pertanian Toba"
```

#### D. Add to config/services.php
```php
'sendgrid' => [
    'api_key' => env('SENDGRID_API_KEY'),
],
```

### Limits:
- **Free:** 100 emails/day forever
- **Essentials:** $19.95/month (50,000 emails)
- **Pro:** $89.95/month (1.5M emails)

### Pros & Cons:
✅ Generous free tier  
✅ Excellent analytics  
✅ High deliverability  
✅ Email validation API  
❌ Requires sender verification  
❌ Complex dashboard  

---

## 4. Mailtrap (Testing)

### Setup Steps:

#### A. Create Mailtrap Account
1. Sign up: https://mailtrap.io/
2. Go to Inbox → SMTP Settings
3. Copy credentials

#### B. .env Configuration (Development)
```env
# Mailtrap Configuration (Testing Only)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="Sistem Pertanian Toba"
```

### Benefits:
✅ Safe testing (emails don't send to real users)  
✅ Email preview and debugging  
✅ HTML/Text inspection  
✅ Spam score analysis  

---

## 5. Local Testing (Log Driver)

### Current Configuration
```env
# Local Testing (Default)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Sistem Pertanian Toba"
```

### View Sent Emails
Emails are logged to: `storage/logs/laravel.log`

Search for email content:
```powershell
Get-Content storage/logs/laravel.log | Select-String "mail" -Context 5
```

### Benefits:
✅ No external service required  
✅ Fast testing  
✅ No rate limits  
❌ Cannot verify actual delivery  
❌ Cannot test email templates visually  

---

## 6. Multiple Mailers Setup

### Configuration File: config/mail.php

```php
<?php

return [
    'default' => env('MAIL_MAILER', 'log'),

    'mailers' => [
        
        // Gmail SMTP
        'gmail' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.gmail.com'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
        ],

        // Mailgun API
        'mailgun' => [
            'transport' => 'mailgun',
            'domain' => env('MAILGUN_DOMAIN'),
            'secret' => env('MAILGUN_SECRET'),
            'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        ],

        // SendGrid API
        'sendgrid' => [
            'transport' => 'sendgrid',
            'api_key' => env('SENDGRID_API_KEY'),
        ],

        // Mailtrap (Testing)
        'mailtrap' => [
            'transport' => 'smtp',
            'host' => env('MAILTRAP_HOST', 'sandbox.smtp.mailtrap.io'),
            'port' => env('MAILTRAP_PORT', 2525),
            'encryption' => 'tls',
            'username' => env('MAILTRAP_USERNAME'),
            'password' => env('MAILTRAP_PASSWORD'),
        ],

        // Log Driver (Development)
        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        // Array Driver (Unit Testing)
        'array' => [
            'transport' => 'array',
        ],

        // Failsafe/Failover
        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'mailgun',
                'sendgrid',
                'gmail',
            ],
        ],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Laravel'),
    ],
];
```

### Using Specific Mailer
```php
// Send via Gmail
Mail::mailer('gmail')
    ->to('user@example.com')
    ->send(new WelcomeEmail($user));

// Send via Mailgun
Mail::mailer('mailgun')
    ->to('user@example.com')
    ->send(new VerificationEmail($user));

// Use failover (tries mailgun, then sendgrid, then gmail)
Mail::mailer('failover')
    ->to('user@example.com')
    ->send(new ImportantEmail($data));
```

---

## 7. Testing Email Configuration

### A. Test Command
```powershell
php artisan tinker
```

```php
// Test email sending
Mail::raw('This is a test email from Sistem Pertanian Toba', function ($message) {
    $message->to('test@example.com')
            ->subject('Test Email');
});

// Check if email was sent
echo "Email sent successfully!";
```

### B. Test with Artisan Command
Create test command:

```powershell
php artisan make:command SendTestEmail
```

**app/Console/Commands/SendTestEmail.php:**
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'email:test {email}';
    protected $description = 'Send test email to verify configuration';

    public function handle()
    {
        $email = $this->argument('email');
        
        try {
            Mail::raw('Test email from Sistem Pertanian Toba', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email - ' . now());
            });
            
            $this->info("✅ Email sent successfully to {$email}");
            $this->info("Check your inbox!");
            
        } catch (\Exception $e) {
            $this->error("❌ Email failed: " . $e->getMessage());
        }
    }
}
```

**Usage:**
```powershell
php artisan email:test your@email.com
```

### C. Test Email Verification
```powershell
# Register new user
# Check email for verification link
# Click link to verify
```

---

## 8. Production Recommendations

### Recommended Setup by Environment:

#### Local Development
```env
MAIL_MAILER=log
# OR
MAIL_MAILER=mailtrap
```

#### Staging/Testing
```env
MAIL_MAILER=mailtrap
# OR
MAIL_MAILER=gmail
```

#### Production
```env
MAIL_MAILER=mailgun
# OR
MAIL_MAILER=sendgrid
# With failover configured
```

### Best Practices:

1. **Use Dedicated Service for Production**
   - Don't use Gmail for production (low limits)
   - Use Mailgun, SendGrid, or Amazon SES

2. **Configure Failover**
   - Primary: Mailgun
   - Backup: SendGrid
   - Emergency: Gmail

3. **Monitor Email Deliverability**
   - Track bounce rates
   - Monitor spam complaints
   - Check delivery rates

4. **Use Queues for Bulk Emails**
   ```php
   Mail::to($user)->queue(new WelcomeEmail($user));
   ```

5. **Verify Sender Domain**
   - Add SPF record
   - Add DKIM record
   - Add DMARC record

6. **Rate Limiting**
   ```php
   // Limit emails per user
   RateLimiter::for('emails', function (Request $request) {
       return Limit::perMinute(5)->by($request->user()?->id);
   });
   ```

---

## 9. Troubleshooting

### Common Issues:

#### 1. SMTP Connection Timeout
```
Solution:
- Check firewall allows port 587/465
- Verify MAIL_HOST is correct
- Try different MAIL_PORT (587, 465, 25)
- Check MAIL_ENCRYPTION (tls, ssl)
```

#### 2. Authentication Failed
```
Solution:
- Verify MAIL_USERNAME and MAIL_PASSWORD
- Gmail: Use App Password, not account password
- Check for typos in credentials
```

#### 3. Emails Going to Spam
```
Solution:
- Verify sender domain (SPF, DKIM, DMARC)
- Use reputable email service (Mailgun, SendGrid)
- Avoid spam trigger words
- Include unsubscribe link
```

#### 4. Emails Not Sending
```
Debug:
- Check storage/logs/laravel.log
- Verify MAIL_MAILER is not 'log'
- Test with php artisan tinker
- Check queue is processing (if using queues)
```

---

## 10. Quick Setup Commands

### For Gmail (Quick Start)
```powershell
# Update .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME="Sistem Pertanian Toba"

# Clear config cache
php artisan config:clear

# Test
php artisan tinker
Mail::raw('Test', fn($msg) => $msg->to('test@example.com')->subject('Test'));
```

### For Mailgun (Production)
```powershell
# Install package
composer require symfony/mailgun-mailer symfony/http-client

# Update .env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.yourdomain.com
MAILGUN_SECRET=your-api-key
MAIL_FROM_ADDRESS=noreply@yourdomain.com

# Clear config
php artisan config:clear

# Test
php artisan email:test test@example.com
```

---

## 11. Environment-Specific .env Examples

### .env.local (Development)
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=dev@pertanian-toba.local
MAIL_FROM_NAME="Pertanian Toba DEV"
```

### .env.staging
```env
MAIL_MAILER=mailtrap
MAILTRAP_HOST=sandbox.smtp.mailtrap.io
MAILTRAP_PORT=2525
MAILTRAP_USERNAME=your-username
MAILTRAP_PASSWORD=your-password
MAIL_FROM_ADDRESS=staging@pertanian-toba.com
MAIL_FROM_NAME="Pertanian Toba STAGING"
```

### .env.production
```env
MAIL_MAILER=failover
MAILGUN_DOMAIN=mg.pertanian-toba.com
MAILGUN_SECRET=your-mailgun-key
SENDGRID_API_KEY=your-sendgrid-key
MAIL_FROM_ADDRESS=noreply@pertanian-toba.com
MAIL_FROM_NAME="Sistem Pertanian Toba"
```

---

## 📧 Next Steps

1. Choose email provider based on your needs
2. Configure .env with credentials
3. Test email sending with `php artisan email:test`
4. Monitor deliverability in production
5. Configure queue for bulk emails
6. Set up domain verification (SPF/DKIM/DMARC)

---

**Last Updated:** November 12, 2025  
**Status:** ✅ Ready for Configuration
