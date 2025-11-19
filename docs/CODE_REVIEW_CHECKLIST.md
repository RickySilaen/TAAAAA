# Code Review Checklist

## 📋 General

- [ ] Code follows Laravel coding standards (PSR-12)
- [ ] Code has been formatted with Laravel Pint
- [ ] PHPStan analysis passes with no errors
- [ ] No debugging statements (dd, dump, var_dump, etc.)
- [ ] No TODO/FIXME comments without tracking
- [ ] Git commit message is clear and descriptive

## 🏗️ Architecture

- [ ] Business logic is in Services, not Controllers
- [ ] Controllers are thin (< 200 lines)
- [ ] Repository pattern used for data access
- [ ] DTOs used for data transfer
- [ ] Events used instead of direct coupling
- [ ] Form Requests used for validation
- [ ] API Resources used for responses

## 📝 Documentation

- [ ] All public methods have PHPDoc comments
- [ ] Complex logic has inline comments
- [ ] Class-level PHPDoc is complete
- [ ] @param and @return types are specified
- [ ] @throws documented for exceptions
- [ ] README updated if needed

## 🧪 Testing

- [ ] Unit tests written for new logic
- [ ] Feature tests written for new endpoints
- [ ] Edge cases are tested
- [ ] Test coverage is acceptable (>80%)
- [ ] Tests pass locally
- [ ] No flaky tests

## 🔒 Security

- [ ] User input is validated
- [ ] SQL injection prevention (use Eloquent/Query Builder)
- [ ] XSS prevention (use {{ }} not {!! !!})
- [ ] CSRF tokens used for forms
- [ ] Authentication checked where needed
- [ ] Authorization (policies/gates) implemented
- [ ] Sensitive data is encrypted
- [ ] No secrets in code (use .env)

## 🚀 Performance

- [ ] No N+1 queries (use eager loading)
- [ ] Database queries are optimized
- [ ] Caching used appropriately
- [ ] Large datasets use pagination/chunking
- [ ] Heavy operations queued
- [ ] Assets optimized (minified)

## 🐛 Error Handling

- [ ] Exceptions are caught appropriately
- [ ] User-friendly error messages
- [ ] Errors are logged
- [ ] Failed jobs are handled
- [ ] Validation errors are clear

## 🎨 Frontend

- [ ] UI is responsive (mobile-first)
- [ ] Accessibility (ARIA labels, keyboard navigation)
- [ ] Forms have proper validation
- [ ] Loading states shown
- [ ] Error states handled
- [ ] Success feedback provided

## 📦 Dependencies

- [ ] New packages are necessary
- [ ] Packages are actively maintained
- [ ] composer.lock updated
- [ ] package-lock.json updated (if applicable)

## 🔄 Database

- [ ] Migrations are reversible
- [ ] Seeders updated if needed
- [ ] Foreign keys have proper constraints
- [ ] Indexes added where needed
- [ ] No breaking schema changes in production

## 🌐 API

- [ ] API versioning considered
- [ ] Proper HTTP status codes
- [ ] Consistent response format
- [ ] Rate limiting implemented
- [ ] API documentation updated

## ✅ Final Checks

- [ ] Code has been self-reviewed
- [ ] Code runs without errors locally
- [ ] Tests pass in CI/CD
- [ ] No merge conflicts
- [ ] Branch is up to date with main
- [ ] Breaking changes documented

---

## Reviewer Notes

**Reviewed by:** _________________

**Date:** _________________

**Approved:** [ ] Yes [ ] No

**Comments:**
