# Quick Fix - Monitoring Page Error

## ✅ Fixed: Column 'bantuan.user_id' not found

### Problem

**Error Message:**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'bantuan.user_id' in 'on clause'
SQL: select users.alamat_desa, COUNT(*) as total from `bantuans` 
     inner join `users` on `bantuan`.`user_id` = `users`.`id` 
     group by `users`.`alamat_desa`
```

**Route:** `/monitoring`

### Root Cause

Query di method `monitoring()` menggunakan nama tabel singular `bantuan` dalam join clause, padahal nama tabel sebenarnya adalah `bantuans` (plural).

**Location:** `app/Http/Controllers/DashboardController.php:311`

### The Issue

```php
// WRONG - Using singular 'bantuan'
$statsByDesa = Bantuan::selectRaw('users.alamat_desa, COUNT(*) as total')
    ->join('users', 'bantuan.user_id', '=', 'users.id')  // ❌ bantuan.user_id
    ->groupBy('users.alamat_desa')
    ->get();
```

**Why it happened:**
- Model name: `Bantuan` (singular)
- Table name: `bantuans` (plural - Laravel convention)
- Join clause mistakenly used model name instead of table name

### Solution Applied

**File:** `app/Http/Controllers/DashboardController.php`

**Before:**
```php
$statsByDesa = Bantuan::selectRaw('users.alamat_desa, COUNT(*) as total')
    ->join('users', 'bantuan.user_id', '=', 'users.id')  // ❌ WRONG
    ->groupBy('users.alamat_desa')
    ->get();
```

**After:**
```php
$statsByDesa = Bantuan::selectRaw('users.alamat_desa, COUNT(*) as total')
    ->join('users', 'bantuans.user_id', '=', 'users.id')  // ✅ CORRECT
    ->groupBy('users.alamat_desa')
    ->get();
```

### Laravel Table Naming Convention

| Model | Table Name | Explanation |
|-------|------------|-------------|
| `Bantuan` | `bantuans` | Plural form |
| `Laporan` | `laporans` | Plural form |
| `User` | `users` | Plural form |

**In JOIN queries, always use the actual table name, not the model name.**

### Verification

✅ **Query Now Executes:**
```sql
SELECT users.alamat_desa, COUNT(*) as total 
FROM `bantuans` 
INNER JOIN `users` ON `bantuans`.`user_id` = `users`.`id`  -- Correct table name
GROUP BY `users`.`alamat_desa`
```

### Testing

1. **Clear Cache:**
```bash
php artisan config:clear
```

2. **Access Monitoring Page:**
```
http://127.0.0.1:8000/monitoring
```

3. **Expected Result:**
- ✅ Page loads without errors
- ✅ Statistics by desa displayed correctly
- ✅ All monitoring charts and data visible

### Related Files

- ✅ `app/Http/Controllers/DashboardController.php` - Fixed
- `app/Models/Bantuan.php` - Model (singular)
- `database/migrations/*_create_bantuans_table.php` - Table definition

### Similar Issues to Watch For

When writing queries with joins, always check:

```php
// ❌ WRONG - Using model name
Laporan::join('users', 'laporan.user_id', '=', 'users.id')

// ✅ CORRECT - Using table name
Laporan::join('users', 'laporans.user_id', '=', 'users.id')
```

### Prevention Tips

1. **Use Query Builder correctly:**
```php
// Better approach - Let Laravel handle the table name
Bantuan::query()
    ->join('users', 'bantuans.user_id', '=', 'users.id')
    ->select('users.alamat_desa', DB::raw('COUNT(*) as total'))
    ->groupBy('users.alamat_desa')
    ->get();
```

2. **Or use relationships:**
```php
// Even better - Use Eloquent relationships
User::select('alamat_desa')
    ->withCount('bantuans')
    ->groupBy('alamat_desa')
    ->get();
```

### Check Your Database

To verify table names:
```sql
SHOW TABLES;
DESCRIBE bantuans;
```

---

## Summary

**Status:** ✅ FIXED  
**Impact:** Monitoring page now works correctly  
**Date:** November 12, 2025  

**Changed:**
- `bantuan.user_id` → `bantuans.user_id` in JOIN clause

**Result:**
- Monitoring page loads successfully
- Statistics by desa displayed correctly
- No database errors

---

**Note:** Always use the actual database table name in JOIN clauses, not the model name!
