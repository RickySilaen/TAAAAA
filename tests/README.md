# 🧪 TESTING DOCUMENTATION - Sistem Pertanian

## 📚 Table of Contents
- [Overview](#overview)
- [Test Structure](#test-structure)
- [Running Tests](#running-tests)
- [Test Coverage](#test-coverage)
- [Writing Tests](#writing-tests)
- [Test Examples](#test-examples)
- [Troubleshooting](#troubleshooting)

---

## 🎯 Overview

Proyek ini menggunakan **PHPUnit** untuk automated testing dengan coverage yang komprehensif:

### Test Statistics
- **Total Test Files:** 17+
- **Total Test Cases:** 138+
- **Test Categories:** 
  - Unit Tests: 7 files
  - Feature Tests: 9 files
  - Integration Tests: 1 file
- **Target Coverage:** 70%+

### Test Pyramid
```
    /\
   /  \    Integration Tests (1 file)
  /____\   Feature Tests (9 files)
 /______\  Unit Tests (7 files)
```

---

## 📁 Test Structure

```
tests/
├── TestCase.php              # Base test class
├── Unit/                     # Unit tests for Models
│   ├── UserModelTest.php
│   ├── LaporanModelTest.php
│   ├── BantuanModelTest.php
│   ├── BeritaModelTest.php
│   ├── GaleriModelTest.php
│   ├── FeedbackModelTest.php
│   └── NewsletterModelTest.php
│
├── Feature/                  # Feature tests for Controllers
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   └── RegisterTest.php
│   ├── Admin/
│   │   ├── BeritaControllerTest.php
│   │   └── GaleriControllerTest.php
│   ├── Petugas/
│   │   ├── PetugasLaporanTest.php
│   │   └── PetugasPetaniTest.php
│   ├── Petani/
│   │   ├── PetaniLaporanTest.php
│   │   └── PetaniBantuanTest.php
│   └── Guest/
│       └── GuestControllerTest.php
│
└── IntegrationTest.php       # End-to-end integration tests
```

---

## 🚀 Running Tests

### Basic Commands

#### Run All Tests
```bash
php artisan test
```

#### Run Specific Test Suite
```bash
# Unit tests only
php artisan test --testsuite=Unit

# Feature tests only
php artisan test --testsuite=Feature
```

#### Run Specific Test File
```bash
php artisan test tests/Unit/UserModelTest.php
```

#### Run Specific Test Method
```bash
php artisan test --filter test_user_can_be_created
```

### Advanced Commands

#### Run Tests with Coverage
```bash
php artisan test --coverage
```

#### Run Tests with Minimum Coverage Threshold
```bash
php artisan test --coverage --min=70
```

#### Run Tests in Parallel (Faster)
```bash
php artisan test --parallel
```

#### Run Tests with Detailed Output
```bash
php artisan test --verbose
```

#### Stop on First Failure
```bash
php artisan test --stop-on-failure
```

---

## 📊 Test Coverage

### Generate HTML Coverage Report
```bash
php artisan test --coverage-html coverage-report
```

Then open `coverage-report/index.html` in your browser.

### Coverage by Component

| Component | Target | Status |
|-----------|--------|--------|
| Models | 90% | ✅ |
| Controllers | 80% | ✅ |
| Middleware | 70% | ✅ |
| Overall | 70% | ✅ |

---

## ✍️ Writing Tests

### Test Naming Convention

```php
// Good ✅
public function test_user_can_login_with_valid_credentials()

// Bad ❌
public function testLogin()
```

### AAA Pattern (Arrange, Act, Assert)

```php
public function test_petani_can_create_laporan(): void
{
    // Arrange - Setup test data
    $petani = User::factory()->create([
        'role' => 'petani',
        'is_verified' => true
    ]);

    // Act - Execute the action
    $response = $this->actingAs($petani)->post('/petani/laporan', [
        'jenis_tanaman' => 'Padi',
        'hasil_panen' => 1000,
        'tanggal_panen' => now()->format('Y-m-d'),
    ]);

    // Assert - Verify the result
    $this->assertDatabaseHas('laporans', [
        'user_id' => $petani->id,
        'jenis_tanaman' => 'Padi',
    ]);
    $response->assertRedirect();
    $response->assertSessionHas('success');
}
```

### Database Assertions

```php
// Assert record exists
$this->assertDatabaseHas('users', [
    'email' => 'test@example.com',
    'role' => 'petani',
]);

// Assert record doesn't exist
$this->assertDatabaseMissing('users', [
    'id' => $userId,
]);

// Assert count
$this->assertDatabaseCount('laporans', 5);
```

### Response Assertions

```php
// Status codes
$response->assertStatus(200);
$response->assertOk();
$response->assertCreated();
$response->assertNotFound();
$response->assertForbidden();

// Redirects
$response->assertRedirect('/dashboard');
$response->assertRedirectToRoute('home');

// Views
$response->assertViewIs('petani.dashboard');
$response->assertViewHas('laporans');

// Session
$response->assertSessionHas('success');
$response->assertSessionHasErrors('email');

// Content
$response->assertSeeText('Welcome');
$response->assertDontSeeText('Error');

// JSON
$response->assertJson(['success' => true]);
$response->assertJsonStructure(['data', 'message']);
```

### Authentication Assertions

```php
// Assert user is authenticated
$this->assertAuthenticated();

// Assert user is guest
$this->assertGuest();

// Assert authenticated as specific user
$this->assertAuthenticatedAs($user);
```

---

## 📝 Test Examples

### 1. Unit Test Example (Model)

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserModelTest extends TestCase
{
    public function test_user_can_be_created(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'petani',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'petani',
        ]);
    }
}
```

### 2. Feature Test Example (Controller)

```php
<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }
}
```

### 3. Integration Test Example

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class IntegrationTest extends TestCase
{
    public function test_complete_petani_registration_flow(): void
    {
        // Register
        $this->post('/register', [
            'name' => 'Test Petani',
            'email' => 'petani@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $petani = User::where('email', 'petani@example.com')->first();
        $this->assertFalse($petani->is_verified);

        // Verify
        $petugas = User::factory()->create(['role' => 'petugas']);
        $this->actingAs($petugas)
             ->post("/petugas/petani/{$petani->id}/verify");

        $petani->refresh();
        $this->assertTrue($petani->is_verified);
    }
}
```

---

## 🛠️ Troubleshooting

### Common Issues & Solutions

#### Issue: "User factory not found"
**Solution:**
```php
// Add HasFactory trait to User model
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
}
```

#### Issue: "Database table not found"
**Solution:**
```bash
# Run migrations in test environment
php artisan test
# Migrations run automatically with RefreshDatabase trait
```

#### Issue: "CSRF token mismatch"
**Solution:**
```php
// Tests automatically disable CSRF
// Use withoutMiddleware() if needed
$this->withoutMiddleware(VerifyCsrfToken::class);
```

#### Issue: "Session not working in tests"
**Solution:**
```php
// Already configured in phpunit.xml
<env name="SESSION_DRIVER" value="array"/>
```

#### Issue: "File upload tests failing"
**Solution:**
```php
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

Storage::fake('public');
$file = UploadedFile::fake()->image('test.jpg');
```

---

## 🎯 Best Practices

### 1. Use Factories
```php
// Good ✅
$user = User::factory()->create(['role' => 'admin']);

// Avoid ❌
$user = new User();
$user->name = 'Test';
$user->save();
```

### 2. Test One Thing Per Test
```php
// Good ✅
public function test_user_can_login() { /* ... */ }
public function test_user_cannot_login_with_wrong_password() { /* ... */ }

// Bad ❌
public function test_login() {
    // Testing multiple scenarios in one test
}
```

### 3. Use Descriptive Test Names
```php
// Good ✅
test_petani_can_create_laporan_with_valid_data()

// Bad ❌
test_laporan()
```

### 4. Clean Up After Tests
```php
// Use RefreshDatabase trait
class MyTest extends TestCase
{
    use RefreshDatabase;
}
```

### 5. Mock External Services
```php
use Illuminate\Support\Facades\Notification;

Notification::fake();
// Your code that sends notification
Notification::assertSentTo($user, PetaniVerified::class);
```

---

## 📈 CI/CD Integration

### GitHub Actions Example

Create `.github/workflows/tests.yml`:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
      - name: Install Dependencies
        run: composer install
      - name: Run Tests
        run: php artisan test --coverage
```

---

## 📚 Additional Resources

- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Test-Driven Development (TDD)](https://en.wikipedia.org/wiki/Test-driven_development)

---

## ✅ Test Checklist

Before pushing code, ensure:

- [ ] All tests pass (`php artisan test`)
- [ ] New features have tests
- [ ] Code coverage is above 70%
- [ ] No skip/incomplete tests
- [ ] Tests are named descriptively
- [ ] Tests follow AAA pattern

---

**Last Updated:** November 12, 2025
**Maintained by:** Development Team
