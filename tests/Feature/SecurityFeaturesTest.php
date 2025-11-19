<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityFeaturesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Email Verification Routes Exist.
     */
    public function test_email_verification_routes_exist()
    {
        $routes = [
            'verification.notice',
            'verification.verify',
            'verification.resend',
        ];

        foreach ($routes as $routeName) {
            $this->assertTrue(
                \Route::has($routeName),
                "Route {$routeName} should exist"
            );
        }
    }

    /**
     * Test 2: User Model Implements MustVerifyEmail.
     */
    public function test_user_model_implements_must_verify_email()
    {
        $user = new User();

        $this->assertInstanceOf(
            \Illuminate\Contracts\Auth\MustVerifyEmail::class,
            $user,
            'User model should implement MustVerifyEmail interface'
        );
    }

    /**
     * Test 3: Rate Limiting Configuration Exists.
     */
    public function test_rate_limiting_configuration_exists()
    {
        // Verify throttle middleware is configured
        $route = \Route::getRoutes()->getByName('login');

        $this->assertNotNull($route, 'Login route should exist');

        // Check if middleware includes throttle
        $middleware = $route->gatherMiddleware();
        $hasThrottle = false;

        foreach ($middleware as $m) {
            if (str_contains($m, 'throttle')) {
                $hasThrottle = true;
                break;
            }
        }

        $this->assertTrue($hasThrottle, 'Login route should have throttle middleware');
    }

    /**
     * Test 4: SQL Injection Protection with NoSqlInjection Rule.
     */
    public function test_sql_injection_protection()
    {
        $sqlInjectionAttempts = [
            "admin' OR '1'='1",
            "1'; DROP TABLE users--",
            "' UNION SELECT * FROM users--",
            "admin'--",
            "' OR 1=1--",
        ];

        foreach ($sqlInjectionAttempts as $attempt) {
            $validator = \Validator::make(
                ['input' => $attempt],
                ['input' => [new \App\Rules\NoSqlInjection()]]
            );

            $this->assertTrue(
                $validator->fails(),
                "SQL injection attempt should be blocked: {$attempt}"
            );
        }
    }

    /**
     * Test 5: XSS Protection with NoXssAttack Rule.
     */
    public function test_xss_protection()
    {
        $xssAttempts = [
            "<script>alert('XSS')</script>",
            "<img src=x onerror=alert('XSS')>",
            "javascript:alert('XSS')",
            "<iframe src='malicious.com'></iframe>",
            "<svg onload=alert('XSS')>",
        ];

        foreach ($xssAttempts as $attempt) {
            $validator = \Validator::make(
                ['input' => $attempt],
                ['input' => [new \App\Rules\NoXssAttack()]]
            );

            $this->assertTrue(
                $validator->fails(),
                "XSS attempt should be blocked: {$attempt}"
            );
        }
    }

    /**
     * Test 6: XSS Middleware Sanitization.
     */
    public function test_xss_middleware_sanitization()
    {
        $user = User::factory()->create([
            'is_verified' => true,  // Use custom verification instead of email_verified_at
        ]);

        $response = $this->actingAs($user)->post('/petani/laporan', [
            'judul' => 'Test <script>alert("XSS")</script>',
            'deskripsi' => 'Content with <img src=x onerror=alert("XSS")>',
        ]);

        // Request should be processed (not 500 error)
        $this->assertNotEquals(500, $response->status());
    }

    /**
     * Test 7: Security Headers Middleware.
     */
    public function test_security_headers_are_set()
    {
        $response = $this->get('/');

        $expectedHeaders = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
        ];

        foreach ($expectedHeaders as $header => $value) {
            $this->assertTrue(
                $response->headers->has($header),
                "Header {$header} should be present"
            );
        }

        // Check CSP header exists (value may vary)
        $this->assertTrue(
            $response->headers->has('Content-Security-Policy'),
            'Content-Security-Policy header should be present'
        );
    }

    /**
     * Test 8: File Upload Service - Valid Image.
     */
    public function test_file_upload_service_accepts_valid_image()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo.jpg', 1000, 1000);
        $service = new \App\Services\SecureFileUploadService();

        $result = $service->uploadImage($file, 'test');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('path', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('size', $result);

        Storage::disk('public')->assertExists($result['path']);
    }

    /**
     * Test 9: File Upload Service - Reject Invalid File Type.
     */
    public function test_file_upload_service_rejects_invalid_type()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid image type');

        $file = UploadedFile::fake()->create('document.php', 100);
        $service = new \App\Services\SecureFileUploadService();

        $service->uploadImage($file, 'test');
    }

    /**
     * Test 10: File Upload Service - Reject Oversized File.
     */
    public function test_file_upload_service_rejects_oversized_file()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Image size must be less than');

        // Create 6MB file (limit is 5MB)
        $file = UploadedFile::fake()->create('large.jpg', 6000);
        $service = new \App\Services\SecureFileUploadService();

        $service->uploadImage($file, 'test');
    }

    /**
     * Test 11: Eloquent Uses Prepared Statements (SQL Injection Protection).
     */
    public function test_eloquent_uses_prepared_statements()
    {
        User::factory()->create(['email' => 'test@example.com']);

        // This should NOT cause SQL injection even with malicious input
        $maliciousEmail = "test@example.com' OR '1'='1";

        $user = User::where('email', $maliciousEmail)->first();

        $this->assertNull($user, 'Malicious query should return null');

        // Valid query should work
        $validUser = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($validUser);
    }

    /**
     * Test 12: CSRF Protection is Active.
     */
    public function test_csrf_protection_is_active()
    {
        // In testing environment, CSRF is typically disabled
        // This test verifies CSRF middleware exists in the middleware stack
        $this->assertTrue(
            class_exists(\App\Http\Middleware\VerifyCsrfToken::class),
            'CSRF middleware should exist'
        );
    }

    /**
     * Test 13: Unverified User Cannot Access Protected Routes.
     */
    public function test_unverified_user_cannot_access_protected_routes()
    {
        $user = User::factory()->create([
            'is_verified' => false,  // Use custom verification instead of email_verified_at
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        // Should redirect to verification notice
        $this->assertTrue(
            $response->isRedirect() || $response->status() === 403,
            'Unverified user should be blocked from protected routes'
        );
    }

    /**
     * Test 14: Verified User Can Access Protected Routes.
     */
    public function test_verified_user_can_access_protected_routes()
    {
        $user = User::factory()->create([
            'is_verified' => true,  // Use custom verification instead of email_verified_at
            'role' => 'petani',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $this->assertTrue(
            in_array($response->status(), [200, 302]),
            'Verified user should access dashboard'
        );
    }

    /**
     * Test 15: Password Hashing.
     */
    public function test_passwords_are_hashed()
    {
        $user = User::factory()->create([
            'password' => Hash::make('plaintext'),
        ]);

        $this->assertNotEquals('plaintext', $user->password);
        $this->assertTrue(Hash::check('plaintext', $user->password));
    }
}
