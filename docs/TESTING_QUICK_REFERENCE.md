# 🚀 TESTING QUICK REFERENCE - Sistem Pertanian

## ⚡ Quick Commands

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific suite
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature

# Run specific file
php artisan test tests/Unit/UserModelTest.php

# Run specific test
php artisan test --filter test_user_can_login

# Stop on first failure
php artisan test --stop-on-failure

# Parallel execution (faster)
php artisan test --parallel
```

---

## 📊 Test Coverage Summary

| Category | Files | Tests | Coverage |
|----------|-------|-------|----------|
| Unit Tests | 7 | 45+ | 90% |
| Feature Tests | 9 | 89+ | 80% |
| Integration Tests | 1 | 4+ | 75% |
| **TOTAL** | **17** | **138+** | **~80%** |

---

## 📁 Test Structure Quick Map

```
tests/
├── Unit/               # Model tests (7 files)
│   ├── UserModelTest.php
│   ├── LaporanModelTest.php
│   ├── BantuanModelTest.php
│   ├── BeritaModelTest.php
│   ├── GaleriModelTest.php
│   ├── FeedbackModelTest.php
│   └── NewsletterModelTest.php
│
├── Feature/
│   ├── Auth/           # Login, Register (2 files)
│   ├── Admin/          # Berita, Galeri (2 files)
│   ├── Petugas/        # Petani, Laporan (2 files)
│   ├── Petani/         # Laporan, Bantuan (2 files)
│   └── Guest/          # Public features (1 file)
│
└── IntegrationTest.php  # E2E workflows
```

---

## ✅ What's Tested

### Authentication ✅
- [x] Login/Logout
- [x] Registration
- [x] Role-based redirects
- [x] Unverified petani blocking

### User Management ✅
- [x] CRUD operations
- [x] Role management
- [x] Petani verification
- [x] Access control

### Laporan (Reports) ✅
- [x] Create/Edit/Delete (Petani)
- [x] Verify/Reject (Petugas)
- [x] Ownership validation
- [x] Status management

### Bantuan (Assistance) ✅
- [x] Request bantuan (Petani)
- [x] Approve/Reject (Admin)
- [x] Status workflow

### Content ✅
- [x] Berita management (Admin)
- [x] Galeri management (Admin)
- [x] Newsletter subscription
- [x] Feedback submission

---

## 🎯 Test Coverage by Role

### Admin
- ✅ Manage berita
- ✅ Manage galeri
- ✅ View all laporans
- ✅ View all bantuans
- ✅ View feedbacks
- ✅ Manage newsletter

### Petugas
- ✅ Verify/reject petani
- ✅ Verify/reject laporans
- ✅ View petani list
- ✅ View laporan list

### Petani
- ✅ Create/edit/delete laporan
- ✅ Request/manage bantuan
- ✅ View own data

### Guest
- ✅ View public pages
- ✅ Subscribe newsletter
- ✅ Submit feedback
- ✅ View berita/galeri

---

## 📝 Test Writing Template

```php
public function test_description_of_what_is_tested(): void
{
    // Arrange - Setup
    $user = User::factory()->create(['role' => 'admin']);
    
    // Act - Execute
    $response = $this->actingAs($user)->get('/route');
    
    // Assert - Verify
    $response->assertStatus(200);
    $this->assertDatabaseHas('table', ['field' => 'value']);
}
```

---

## 🔍 Common Assertions

```php
// Database
$this->assertDatabaseHas('users', ['email' => 'test@test.com']);
$this->assertDatabaseMissing('users', ['id' => $userId]);
$this->assertDatabaseCount('laporans', 5);

// Response
$response->assertStatus(200);
$response->assertRedirect('/dashboard');
$response->assertViewIs('admin.index');
$response->assertSessionHas('success');
$response->assertSessionHasErrors('email');

// Authentication
$this->assertAuthenticated();
$this->assertGuest();
$this->assertAuthenticatedAs($user);
```

---

## 🐛 Debugging Tests

```bash
# Run with verbose output
php artisan test --verbose

# Stop on first failure
php artisan test --stop-on-failure

# Run single test
php artisan test --filter test_name

# Show full error trace
php artisan test --debug
```

---

## 📖 Documentation

- Full Guide: `tests/README.md`
- Summary: `docs/TESTING_SUMMARY.md`
- This Quick Ref: `docs/TESTING_QUICK_REFERENCE.md`

---

## ⚠️ Important Notes

1. **Database**: Tests use SQLite in-memory (auto-reset)
2. **Factories**: Use `User::factory()->create()` for test data
3. **Files**: Use `Storage::fake()` for file upload tests
4. **Notifications**: Use `Notification::fake()` for notification tests
5. **Refresh**: `RefreshDatabase` trait auto-runs migrations

---

## 🎓 Tips

### Before Committing
```bash
php artisan test --stop-on-failure
```

### Before Deploying
```bash
php artisan test --coverage --min=70
```

### Daily Development
```bash
php artisan test --parallel
```

---

## ✅ Checklist

Before pushing code:
- [ ] All tests pass
- [ ] New features have tests
- [ ] Coverage > 70%
- [ ] No skipped tests
- [ ] Descriptive test names

---

**Quick Reference Version:** 1.0  
**Last Updated:** November 12, 2025
