# 🔒 Security Quick Reference Guide

## ✅ Implemented Security Features

### 1. Email Verification ✅
```php
// Model
class User implements MustVerifyEmail { }

// Route Protection
Route::middleware(['auth', 'verified'])->group(function () {
    // Protected routes
});
```

### 2. Rate Limiting ✅
```php
// Auth routes: 5 requests/minute
Route::middleware(['guest', 'throttle:5,1'])->group(function () {
    Route::post('/login', ...);
    Route::post('/register', ...);
});

// API routes: 60 requests/minute (auth), 30 (guest)
Route::middleware('throttle:60,1')->group(function () {
    //  API endpoints
});
```

### 3. SQL Injection Protection ✅
```php
use App\Rules\NoSqlInjection;

$request->validate([
    'email' => ['required', 'email', new NoSqlInjection],
    'name' => ['required', new NoSqlInjection],
]);

// Always use query builder (auto-protected)
User::where('email', $email)->first(); // ✅ SAFE
DB::select("SELECT * FROM users WHERE id = ?", [$id]); // ✅ SAFE
```

### 4. XSS Protection ✅
```php
use App\Rules\NoXssAttack;

$request->validate([
    'comment' => ['required', new NoXssAttack],
    'description' => ['required', new NoXssAttack],
]);

// Blade auto-escapes
{{ $userInput }} // ✅ SAFE
{!! $userInput !!} // ❌ DANGEROUS
```

### 5. File Upload Security ✅
```php
use App\Services\SecureFileUploadService;

public function __construct(SecureFileUploadService $fileService)
{
    $this->fileService = $fileService;
}

public function store(Request $request)
{
    try {
        $result = $this->fileService->uploadImage(
            $request->file('foto'),
            'images'
        );
        
        // Use $result['path'] to save to database
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}
```

### 6. Security Headers ✅
Automatically applied to all responses:
- Content-Security-Policy (CSP)
- X-Content-Type-Options: nosniff
- X-Frame-Options: SAMEORIGIN
- X-XSS-Protection: 1; mode=block
- Strict-Transport-Security (HSTS)
- Referrer-Policy
- Permissions-Policy

---

## ⏳ Pending Features (Network Required)

### 7. Two-Factor Authentication
```powershell
# Install when network available:
composer require laravel/fortify
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
php artisan migrate
```

### 8. Google reCAPTCHA
```powershell
# Install when network available:
composer require google/recaptcha

# Add to .env:
RECAPTCHA_SITE_KEY=your_key
RECAPTCHA_SECRET_KEY=your_secret
```

---

## 🎯 Usage Examples

### Secure Controller Example
```php
<?php

namespace App\Http\Controllers;

use App\Rules\NoSqlInjection;
use App\Rules\NoXssAttack;
use App\Services\SecureFileUploadService;
use Illuminate\Http\Request;

class SecureController extends Controller
{
    protected $fileService;
    
    public function __construct(SecureFileUploadService $fileService)
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('throttle:60,1');
        $this->fileService = $fileService;
    }
    
    public function store(Request $request)
    {
        // Comprehensive validation
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'min:5',
                'max:200',
                new NoSqlInjection,
                new NoXssAttack
            ],
            'content' => [
                'required',
                'string',
                new NoXssAttack
            ],
            'image' => [
                'nullable',
                'image',
                'max:5120' // 5MB
            ]
        ]);
        
        // Secure file upload
        if ($request->hasFile('image')) {
            try {
                $result = $this->fileService->uploadImage(
                    $request->file('image'),
                    'posts/images'
                );
                $validated['image_path'] = $result['path'];
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }
        
        // Create record (auto-protected by Eloquent)
        $post = Post::create($validated);
        
        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully!');
    }
}
```

### Secure Blade Template
```blade
{{-- Auto-escaped output (SAFE) --}}
<h1>{{ $post->title }}</h1>
<p>{{ $post->content }}</p>

{{-- Image (validate path first) --}}
@if($post->image_path)
    <img src="{{ asset('storage/' . $post->image_path) }}" 
         alt="{{ $post->title }}">
@endif

{{-- Form with CSRF protection --}}
<form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
    @csrf
    
    <input type="text" name="title" value="{{ old('title') }}" required>
    
    <textarea name="content" required>{{ old('content') }}</textarea>
    
    <input type="file" name="image" accept="image/*">
    
    <button type="submit">Submit</button>
</form>

{{-- Display validation errors --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

---

## 🧪 Quick Tests

### Test Rate Limiting
```powershell
# Try 6 login attempts in 1 minute
for ($i=1; $i -le 6; $i++) {
    curl.exe -X POST http://localhost:8000/login `
      -d "email=test@test.com&password=wrong"
}
# 6th request should return 429
```

### Test SQL Injection Protection
```php
// This should be blocked:
$request = Request::create('/test', 'POST', [
    'name' => "admin' OR '1'='1"
]);

$request->validate([
    'name' => [new NoSqlInjection]
]);
// Error: "The name contains suspicious content."
```

### Test XSS Protection
```php
// This should be blocked:
$request = Request::create('/test', 'POST', [
    'comment' => "<script>alert('XSS')</script>"
]);

$request->validate([
    'comment' => [new NoXssAttack]
]);
// Error: "The comment contains invalid characters or code."
```

### Test File Upload
```php
// Valid image - PASS
$file = UploadedFile::fake()->image('photo.jpg', 1000, 1000);
$this->fileService->uploadImage($file); // ✅ Success

// Invalid type - FAIL
$file = UploadedFile::fake()->create('script.php');
$this->fileService->uploadImage($file); // ❌ Exception

// Too large - FAIL
$file = UploadedFile::fake()->image('huge.jpg')->size(6000);
$this->fileService->uploadImage($file); // ❌ Exception
```

---

## 📋 Security Checklist

### Before Every Deployment

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] HTTPS enabled (`SESSION_SECURE_COOKIE=true`)
- [ ] Strong `APP_KEY` generated
- [ ] Email configuration verified
- [ ] Rate limiting tested
- [ ] All inputs validated with security rules
- [ ] File upload limits configured
- [ ] Security headers verified
- [ ] Error logging configured (not displayed)
- [ ] Database backups configured
- [ ] Dependencies updated (`composer update`)
- [ ] Security audit run (`composer audit`)

### Regular Security Tasks

**Daily:**
- [ ] Check error logs for suspicious activity
- [ ] Monitor failed login attempts

**Weekly:**
- [ ] Review user permissions
- [ ] Check for unauthorized file uploads

**Monthly:**
- [ ] Update Laravel and dependencies
- [ ] Review security headers
- [ ] Test rate limiting
- [ ] Audit database for suspicious data

**Quarterly:**
- [ ] Full security audit
- [ ] Penetration testing
- [ ] Review and update security policies

---

## 🚨 Security Incident Response

### If You Detect an Attack

1. **Immediately:**
   - Enable maintenance mode: `php artisan down`
   - Review logs: `storage/logs/laravel.log`
   - Check database for unauthorized changes

2. **Investigate:**
   - Identify attack vector
   - Check affected users/data
   - Document timeline

3. **Mitigate:**
   - Patch vulnerability
   - Reset affected passwords
   - Revoke compromised tokens
   - Clear caches

4. **Recover:**
   - Restore from backup if needed
   - Verify data integrity
   - Test security fixes

5. **Learn:**
   - Update security documentation
   - Add new validation rules
   - Improve monitoring

---

## 📞 Emergency Contacts

**Security Team:**
- Email: security@tobapertanian.com
- Phone: [Add emergency contact]

**Hosting Provider:**
- Support: [Add hosting support contact]

**Laravel Security:**
- Report: security@laravel.com
- Advisory: https://laravel.com/docs/security

---

## 📖 Additional Resources

- Full Documentation: `docs/SECURITY_IMPLEMENTATION.md`
- Laravel Security: https://laravel.com/docs/security
- OWASP Top 10: https://owasp.org/www-project-top-ten/
- Security Headers: https://securityheaders.com/

---

**Last Updated:** November 12, 2025  
**Security Status:** ✅ 6/8 Features Implemented (75%)  
**Production Ready:** Yes (with pending features ready for installation)
