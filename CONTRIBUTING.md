# Contributing to Sistem Informasi Pertanian

Terima kasih atas minat Anda untuk berkontribusi! Dokumen ini berisi panduan untuk berkontribusi pada project ini.

## 📋 Daftar Isi

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Process](#development-process)
- [Coding Standards](#coding-standards)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)
- [Testing](#testing)

---

## Code of Conduct

### Our Pledge

Kami berkomitmen untuk menjadikan partisipasi dalam project ini pengalaman yang bebas dari harassment untuk semua orang.

### Our Standards

- Gunakan bahasa yang ramah dan inklusif
- Hormati sudut pandang dan pengalaman yang berbeda
- Terima kritik konstruktif dengan lapang dada
- Fokus pada yang terbaik untuk komunitas

---

## Getting Started

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18.x
- Git

### Setup Development Environment

1. **Fork & Clone**
   ```bash
   git clone https://github.com/YOUR_USERNAME/TAAAAA.git
   cd TAAAAA
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   php artisan migrate --seed
   ```

5. **Run Development Server**
   ```bash
   php artisan serve
   npm run dev
   ```

---

## Development Process

### Branching Strategy

Kami menggunakan **Git Flow** workflow:

- `main` - Production-ready code
- `develop` - Development branch
- `feature/*` - New features
- `bugfix/*` - Bug fixes
- `hotfix/*` - Urgent production fixes

### Creating a New Branch

```bash
# For new feature
git checkout -b feature/nama-fitur

# For bug fix
git checkout -b bugfix/nama-bug

# For hotfix
git checkout -b hotfix/nama-hotfix
```

---

## Coding Standards

### PHP (PSR-12)

Ikuti [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)

```php
<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    public function index(): View
    {
        return view('example.index');
    }
}
```

### Laravel Best Practices

- Gunakan Eloquent ORM, hindari raw queries
- Gunakan Route Model Binding
- Gunakan Form Requests untuk validation
- Gunakan Resource Controllers
- Gunakan Service Layer untuk business logic
- Gunakan Repository Pattern untuk data access

### Blade Templates

```blade
{{-- Good --}}
@if ($user->isAdmin())
    <p>Welcome, Admin!</p>
@endif

{{-- Avoid --}}
<?php if ($user->isAdmin()): ?>
    <p>Welcome, Admin!</p>
<?php endif; ?>
```

### JavaScript/CSS

- Gunakan ES6+ syntax
- Gunakan const/let, hindari var
- Follow BEM naming convention untuk CSS

---

## Commit Guidelines

### Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, etc)
- `refactor`: Code refactoring
- `test`: Adding tests
- `chore`: Maintenance tasks

### Examples

```bash
feat(laporan): add export to PDF feature

Added functionality to export laporan panen to PDF format.
Includes styling and proper data formatting.

Closes #123
```

```bash
fix(auth): resolve login redirect issue

Fixed bug where unverified users could access dashboard.
Now properly redirects to verification page.

Fixes #456
```

---

## Pull Request Process

### Before Submitting

1. ✅ Update your branch with latest `develop`
   ```bash
   git checkout develop
   git pull origin develop
   git checkout feature/your-feature
   git merge develop
   ```

2. ✅ Run tests
   ```bash
   php artisan test
   ```

3. ✅ Run code quality checks
   ```bash
   ./vendor/bin/phpstan analyse
   ./vendor/bin/pint
   ```

4. ✅ Update documentation if needed

### Pull Request Template

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] All tests passing
- [ ] New tests added
- [ ] Manual testing completed

## Screenshots (if applicable)
Add screenshots here

## Checklist
- [ ] Code follows project standards
- [ ] Self-reviewed code
- [ ] Commented complex code
- [ ] Updated documentation
- [ ] No new warnings
```

### Review Process

1. At least 1 approval required
2. All checks must pass
3. No merge conflicts
4. Up-to-date with base branch

---

## Testing

### Running Tests

```bash
# All tests
php artisan test

# Specific suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Specific file
php artisan test tests/Feature/Auth/LoginTest.php

# With coverage
php artisan test --coverage
```

### Writing Tests

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    public function test_example_feature(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200);
    }
}
```

### Test Coverage Requirements

- Unit tests for models and services
- Feature tests for controllers
- Integration tests for workflows
- Minimum 80% code coverage

---

## Database Migrations

### Creating Migrations

```bash
php artisan make:migration create_example_table
```

### Best Practices

- Always create rollback (down method)
- Use descriptive names
- Keep migrations small and focused
- Test both up and down migrations

```php
public function up(): void
{
    Schema::create('examples', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('examples');
}
```

---

## Code Review Checklist

### For Reviewers

- [ ] Code follows project standards
- [ ] Tests are adequate
- [ ] No security vulnerabilities
- [ ] Performance considerations
- [ ] Error handling is proper
- [ ] Documentation is updated
- [ ] No unnecessary complexity

### For Authors

- [ ] Self-reviewed code
- [ ] Tests added/updated
- [ ] Documentation updated
- [ ] No console errors/warnings
- [ ] Responsive design checked
- [ ] Browser compatibility tested

---

## Getting Help

- 📧 Email: support@pertanian.com
- 💬 GitHub Discussions
- 🐛 GitHub Issues
- 📚 Documentation: [Wiki](https://github.com/RickySilaen/TAAAAA/wiki)

---

## Recognition

Contributors will be recognized in:
- README.md
- CHANGELOG.md
- GitHub contributors page

Thank you for contributing! 🙏
