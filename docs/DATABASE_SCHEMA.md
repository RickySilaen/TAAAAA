# Database Schema Documentation

**Project**: Sistem Informasi Pertanian Toba  
**Database**: SQLite / MySQL  
**Last Updated**: November 12, 2025

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Entity Relationship Diagram](#entity-relationship-diagram)
3. [Table Definitions](#table-definitions)
4. [Indexes & Performance](#indexes--performance)
5. [Foreign Key Constraints](#foreign-key-constraints)
6. [Migration History](#migration-history)

---

## Overview

Database sistem pertanian terdiri dari **12 tables utama** yang mengelola:
- User Management (users, admins, personal_access_tokens)
- Agricultural Data (laporans, bantuans)
- Content Management (beritas, galeris, newsletters, feedbacks)
- System (notifications, scheduled_notifications, cache, jobs)

**Total Tables**: 12  
**Total Columns**: ~150 columns  
**Storage Engine**: InnoDB (MySQL) / SQLite

---

## Entity Relationship Diagram

```
┌─────────────┐          ┌──────────────┐          ┌─────────────┐
│    users    │──────────│   laporans   │          │  bantuans   │
│             │ 1      * │              │          │             │
│ - id (PK)   │          │ - id (PK)    │          │ - id (PK)   │
│ - name      │          │ - user_id    │          │ - user_id   │
│ - email     │          │ - komoditas  │          │ - jenis_    │
│ - role      │          │ - jumlah_    │          │   bantuan   │
└─────────────┘          │   panen      │          │ - status    │
      │                  │ - status     │          └─────────────┘
      │                  └──────────────┘                 │
      │                                                   │
      │ 1                                              1  │
      │                                                   │
      │ *                  ┌──────────────┐         *    │
      └────────────────────│notifications │──────────────┘
                           │              │
                           │ - id (PK)    │
                           │ - notifiable_│
                           │   type       │
                           │ - data       │
                           └──────────────┘

┌─────────────┐          ┌──────────────┐          ┌─────────────┐
│   beritas   │          │   galeris    │          │newsletters  │
│             │          │              │          │             │
│ - id (PK)   │          │ - id (PK)    │          │ - id (PK)   │
│ - judul     │          │ - judul      │          │ - subject   │
│ - konten    │          │ - deskripsi  │          │ - content   │
│ - gambar    │          │ - foto       │          │ - recipients│
└─────────────┘          └──────────────┘          └─────────────┘

┌─────────────┐          ┌──────────────────────────┐
│  feedbacks  │          │ scheduled_notifications  │
│             │          │                          │
│ - id (PK)   │          │ - id (PK)                │
│ - nama      │          │ - user_id                │
│ - email     │          │ - notification_type      │
│ - pesan     │          │ - scheduled_at           │
└─────────────┘          └──────────────────────────┘
```

---

## Table Definitions

### 1. users

**Purpose**: Stores user accounts (petani, petugas, admin)

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| name | VARCHAR(255) | NO | - | Full name |
| email | VARCHAR(255) | NO | - | Email (unique) |
| email_verified_at | TIMESTAMP | YES | NULL | Email verification timestamp |
| password | VARCHAR(255) | NO | - | Hashed password |
| role | VARCHAR(50) | NO | 'petani' | User role: petani, petugas, admin |
| no_telepon | VARCHAR(20) | YES | NULL | Phone number |
| alamat_desa | VARCHAR(255) | YES | NULL | Village address |
| alamat_kecamatan | VARCHAR(255) | YES | NULL | District address |
| alamat_lengkap | TEXT | YES | NULL | Full address |
| profile_picture | VARCHAR(255) | YES | NULL | Profile photo path |
| is_verified | BOOLEAN | NO | 0 | Account verification status |
| verified_at | TIMESTAMP | YES | NULL | Verification timestamp |
| verified_by | BIGINT UNSIGNED | YES | NULL | Verified by user_id |
| notification_preferences | JSON | YES | NULL | Notification settings |
| remember_token | VARCHAR(100) | YES | NULL | Remember me token |
| created_at | TIMESTAMP | YES | NULL | Record creation time |
| updated_at | TIMESTAMP | YES | NULL | Last update time |

**Indexes**:
- PRIMARY KEY: `id`
- UNIQUE: `email`
- INDEX: `role` (for role-based queries)
- INDEX: `is_verified` (for verification filters)

**Relationships**:
- Has Many: `laporans`, `bantuans`, `notifications`

---

### 2. laporans

**Purpose**: Stores harvest reports submitted by farmers

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | YES | NULL | Foreign key to users |
| nama_petani | VARCHAR(255) | YES | NULL | Farmer name (for guest reports) |
| alamat_desa | VARCHAR(255) | YES | NULL | Village address (for guest reports) |
| komoditas | VARCHAR(100) | NO | - | Commodity type (kopi, padi, jagung, etc.) |
| jenis_tanaman | VARCHAR(100) | NO | - | Plant variety |
| luas_lahan | DECIMAL(10,2) | NO | - | Land area (hectares) |
| jumlah_panen | DECIMAL(10,2) | NO | - | Harvest amount (kg/ton) |
| tanggal_panen | DATE | NO | - | Harvest date |
| kualitas | ENUM | YES | NULL | Quality: baik, sedang, buruk |
| harga_jual | DECIMAL(12,2) | YES | NULL | Selling price per unit |
| foto | VARCHAR(255) | YES | NULL | Photo evidence path |
| status | VARCHAR(50) | NO | 'pending' | Status: pending, terverifikasi, ditolak |
| catatan | TEXT | YES | NULL | Additional notes |
| created_at | TIMESTAMP | YES | NULL | Record creation time |
| updated_at | TIMESTAMP | YES | NULL | Last update time |

**Indexes**:
- PRIMARY KEY: `id`
- FOREIGN KEY: `user_id` REFERENCES `users(id)` ON DELETE SET NULL
- INDEX: `user_id` (for user-specific queries)
- INDEX: `status` (for status filters)
- INDEX: `komoditas` (for commodity reports)
- INDEX: `tanggal_panen` (for date range queries)
- COMPOSITE INDEX: `(status, tanggal_panen)` (for dashboard statistics)

**Relationships**:
- Belongs To: `users` (nullable)

**Business Rules**:
- `user_id` can be NULL for guest submissions
- `luas_lahan` and `jumlah_panen` must be > 0
- `kualitas` enum: ['baik', 'sedang', 'buruk']
- `status` values: ['pending', 'terverifikasi', 'ditolak']

---

### 3. bantuans

**Purpose**: Stores aid/assistance requests from farmers

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | NO | - | Foreign key to users |
| jenis_bantuan | VARCHAR(100) | NO | - | Aid type: pupuk, bibit, pestisida, etc. |
| jumlah | INT | NO | - | Requested quantity |
| alasan | TEXT | NO | - | Reason for request |
| tanggal_permintaan | DATE | NO | - | Request date |
| status | VARCHAR(50) | NO | 'menunggu' | Status: menunggu, disetujui, ditolak |
| keterangan | TEXT | YES | NULL | Admin response/notes |
| catatan | TEXT | YES | NULL | Additional notes |
| dokumen | VARCHAR(255) | YES | NULL | Supporting document path |
| created_at | TIMESTAMP | YES | NULL | Record creation time |
| updated_at | TIMESTAMP | YES | NULL | Last update time |

**Indexes**:
- PRIMARY KEY: `id`
- FOREIGN KEY: `user_id` REFERENCES `users(id)` ON DELETE CASCADE
- INDEX: `user_id` (for user-specific queries)
- INDEX: `status` (for status filters)
- INDEX: `jenis_bantuan` (for aid type reports)
- COMPOSITE INDEX: `(status, tanggal_permintaan)` (for statistics)

**Relationships**:
- Belongs To: `users`

**Business Rules**:
- `jenis_bantuan` allowed values: ['pupuk', 'bibit', 'pestisida', 'alat_pertanian', 'dana_usaha', 'lainnya']
- `jumlah` must be > 0
- `status` values: ['menunggu', 'disetujui', 'ditolak']

---

### 4. beritas

**Purpose**: News/announcements for public information

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| judul | VARCHAR(255) | NO | - | News title |
| slug | VARCHAR(255) | NO | - | URL-friendly slug (unique) |
| konten | TEXT | NO | - | News content (HTML) |
| gambar | VARCHAR(255) | YES | NULL | Featured image path |
| penulis | VARCHAR(100) | YES | NULL | Author name |
| tanggal_publish | DATE | NO | - | Publication date |
| status | VARCHAR(50) | NO | 'draft' | Status: draft, published, archived |
| views | INT | NO | 0 | View count |
| created_at | TIMESTAMP | YES | NULL | Record creation time |
| updated_at | TIMESTAMP | YES | NULL | Last update time |

**Indexes**:
- PRIMARY KEY: `id`
- UNIQUE: `slug`
- INDEX: `status` (for published news filter)
- INDEX: `tanggal_publish` (for sorting)

**Business Rules**:
- `slug` auto-generated from `judul`
- `status` values: ['draft', 'published', 'archived']

---

### 5. galeris

**Purpose**: Photo gallery for agricultural activities

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| judul | VARCHAR(255) | NO | - | Photo title |
| deskripsi | TEXT | YES | NULL | Photo description |
| foto | VARCHAR(255) | NO | - | Photo file path |
| kategori | VARCHAR(100) | YES | NULL | Category: panen, pelatihan, etc. |
| tanggal | DATE | YES | NULL | Photo date |
| created_at | TIMESTAMP | YES | NULL | Record creation time |
| updated_at | TIMESTAMP | YES | NULL | Last update time |

**Indexes**:
- PRIMARY KEY: `id`
- INDEX: `kategori` (for category filters)

---

### 6. newsletters

**Purpose**: Email newsletter management

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| subject | VARCHAR(255) | NO | - | Email subject |
| content | TEXT | NO | - | Email content (HTML) |
| recipients | JSON | NO | - | Recipient email list |
| sent_at | TIMESTAMP | YES | NULL | Sent timestamp |
| status | VARCHAR(50) | NO | 'draft' | Status: draft, sent, failed |
| created_at | TIMESTAMP | YES | NULL | Record creation time |
| updated_at | TIMESTAMP | YES | NULL | Last update time |

**Indexes**:
- PRIMARY KEY: `id`
- INDEX: `status` (for filtering)

---

### 7. feedbacks

**Purpose**: User feedback and contact messages

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| nama | VARCHAR(255) | NO | - | Sender name |
| email | VARCHAR(255) | NO | - | Sender email |
| subjek | VARCHAR(255) | YES | NULL | Message subject |
| pesan | TEXT | NO | - | Message content |
| status | VARCHAR(50) | NO | 'unread' | Status: unread, read, replied |
| created_at | TIMESTAMP | YES | NULL | Record creation time |
| updated_at | TIMESTAMP | YES | NULL | Last update time |

**Indexes**:
- PRIMARY KEY: `id`
- INDEX: `status` (for unread filter)
- INDEX: `email` (for sender lookup)

---

### 8. notifications

**Purpose**: Laravel notification system table

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | CHAR(36) | NO | UUID | Primary key (UUID) |
| type | VARCHAR(255) | NO | - | Notification class name |
| notifiable_type | VARCHAR(255) | NO | - | Polymorphic type (User) |
| notifiable_id | BIGINT UNSIGNED | NO | - | Polymorphic ID (user_id) |
| data | TEXT | NO | - | Notification data (JSON) |
| read_at | TIMESTAMP | YES | NULL | Read timestamp |
| created_at | TIMESTAMP | YES | NULL | Record creation time |
| updated_at | TIMESTAMP | YES | NULL | Last update time |

**Indexes**:
- PRIMARY KEY: `id`
- INDEX: `(notifiable_type, notifiable_id)` (polymorphic index)

---

### 9. scheduled_notifications

**Purpose**: Scheduled notifications for future delivery

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | NO | - | Foreign key to users |
| notification_type | VARCHAR(255) | NO | - | Notification class |
| notification_data | JSON | NO | - | Notification payload |
| scheduled_at | TIMESTAMP | NO | - | Scheduled delivery time |
| sent_at | TIMESTAMP | YES | NULL | Actual sent time |
| status | VARCHAR(50) | NO | 'pending' | Status: pending, sent, failed |
| created_at | TIMESTAMP | YES | NULL | Record creation time |
| updated_at | TIMESTAMP | YES | NULL | Last update time |

**Indexes**:
- PRIMARY KEY: `id`
- FOREIGN KEY: `user_id` REFERENCES `users(id)` ON DELETE CASCADE
- INDEX: `user_id`
- INDEX: `(status, scheduled_at)` (for cron job queries)

---

### 10. personal_access_tokens

**Purpose**: Laravel Sanctum API token storage

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| tokenable_type | VARCHAR(255) | NO | - | Polymorphic type |
| tokenable_id | BIGINT UNSIGNED | NO | - | Polymorphic ID |
| name | VARCHAR(255) | NO | - | Token name |
| token | VARCHAR(64) | NO | - | Hashed token (unique) |
| abilities | TEXT | YES | NULL | Token abilities (JSON) |
| last_used_at | TIMESTAMP | YES | NULL | Last usage timestamp |
| expires_at | TIMESTAMP | YES | NULL | Expiration timestamp |
| created_at | TIMESTAMP | YES | NULL | Record creation time |
| updated_at | TIMESTAMP | YES | NULL | Last update time |

**Indexes**:
- PRIMARY KEY: `id`
- UNIQUE: `token`
- INDEX: `(tokenable_type, tokenable_id)`

---

### 11. cache

**Purpose**: Laravel cache storage

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| key | VARCHAR(255) | NO | - | Cache key (primary) |
| value | MEDIUMTEXT | NO | - | Cached value |
| expiration | INT | NO | - | Expiration timestamp |

**Indexes**:
- PRIMARY KEY: `key`

---

### 12. jobs

**Purpose**: Laravel queue job storage

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| queue | VARCHAR(255) | NO | - | Queue name |
| payload | LONGTEXT | NO | - | Job payload |
| attempts | TINYINT UNSIGNED | NO | - | Retry attempts |
| reserved_at | INT UNSIGNED | YES | NULL | Reserved timestamp |
| available_at | INT UNSIGNED | NO | - | Available timestamp |
| created_at | INT UNSIGNED | NO | - | Creation timestamp |

**Indexes**:
- PRIMARY KEY: `id`
- INDEX: `(queue, reserved_at)`

---

## Indexes & Performance

### Performance Indexes Added (Migration: 2025_11_11_231637)

**users table**:
- `idx_users_role` on `role` - For role-based filtering
- `idx_users_verified` on `is_verified` - For verification status queries

**laporans table**:
- `idx_laporans_user` on `user_id` - For user-specific reports
- `idx_laporans_status` on `status` - For status filtering
- `idx_laporans_komoditas` on `komoditas` - For commodity reports
- `idx_laporans_tanggal` on `tanggal_panen` - For date range queries
- `idx_laporans_status_tanggal` on `(status, tanggal_panen)` - For dashboard statistics

**bantuans table**:
- `idx_bantuans_user` on `user_id` - For user-specific requests
- `idx_bantuans_status` on `status` - For status filtering
- `idx_bantuans_jenis` on `jenis_bantuan` - For aid type reports
- `idx_bantuans_status_tanggal` on `(status, tanggal_permintaan)` - For statistics

**notifications table**:
- `idx_notifications_notifiable` on `(notifiable_type, notifiable_id)` - For user notifications

**scheduled_notifications table**:
- `idx_scheduled_status_time` on `(status, scheduled_at)` - For cron job queries

### Query Performance Tips

1. **Use eager loading** to prevent N+1 queries:
   ```php
   Laporan::with('user')->get();
   ```

2. **Use indexed columns** in WHERE clauses:
   ```php
   Laporan::where('status', 'terverifikasi')->get(); // Uses idx_laporans_status
   ```

3. **Use composite indexes** for multiple filters:
   ```php
   Laporan::where('status', 'terverifikasi')
          ->whereBetween('tanggal_panen', [$start, $end])
          ->get(); // Uses idx_laporans_status_tanggal
   ```

---

## Foreign Key Constraints

| Child Table | Column | Parent Table | Parent Column | On Delete | On Update |
|-------------|--------|--------------|---------------|-----------|-----------|
| laporans | user_id | users | id | SET NULL | CASCADE |
| bantuans | user_id | users | id | CASCADE | CASCADE |
| scheduled_notifications | user_id | users | id | CASCADE | CASCADE |
| personal_access_tokens | tokenable_id | users | id | CASCADE | CASCADE |

**Explanation**:
- **SET NULL**: When user deleted, laporan remains but user_id set to NULL (guest report)
- **CASCADE**: When user deleted, related records also deleted (bantuans, tokens, scheduled notifications)

---

## Migration History

| Migration File | Date | Description |
|----------------|------|-------------|
| 0001_01_01_000000_create_users_table.php | 2025-10-02 | Initial users table |
| 0001_01_01_000001_create_cache_table.php | 2025-10-02 | Cache storage |
| 0001_01_01_000002_create_jobs_table.php | 2025-10-02 | Queue jobs storage |
| 2025_10_02_065627_create_bantuans_table.php | 2025-10-02 | Bantuans table |
| 2025_10_02_065655_create_laporans_table.php | 2025-10-02 | Laporans table |
| 2025_10_02_071520_add_columns_to_users_table.php | 2025-10-02 | Add address, phone to users |
| 2025_10_09_134718_create_admin_table.php | 2025-10-09 | Admin users (deprecated) |
| 2025_10_15_012627_add_profile_picture_to_users_table.php | 2025-10-15 | Profile photo support |
| 2025_10_23_034347_add_notifications_table.php | 2025-10-23 | Laravel notifications |
| 2025_10_23_145637_add_catatan_to_bantuans_table.php | 2025-10-23 | Notes field for bantuans |
| 2025_10_30_031250_create_beritas_table.php | 2025-10-30 | News/announcements |
| 2025_10_30_031322_create_galeris_table.php | 2025-10-30 | Photo gallery |
| 2025_10_30_031402_create_newsletters_table.php | 2025-10-30 | Email newsletters |
| 2025_10_30_031430_create_feedbacks_table.php | 2025-10-30 | User feedback |
| 2025_10_31_030810_make_user_id_nullable_in_laporans_table.php | 2025-10-31 | Allow guest reports |
| 2025_10_31_030837_add_nama_petani_and_alamat_desa_to_laporans_table.php | 2025-10-31 | Guest report fields |
| 2025_11_10_093104_add_verification_columns_to_users_table.php | 2025-11-10 | User verification |
| 2025_11_10_094256_add_alamat_kecamatan_and_telepon_to_users_table.php | 2025-11-10 | Extended address |
| 2025_11_11_221330_create_personal_access_tokens_table.php | 2025-11-11 | API tokens (Sanctum) |
| 2025_11_11_231637_add_performance_indexes_to_all_tables.php | 2025-11-11 | Performance indexes |
| 2025_11_11_234145_add_notification_preferences_to_users_table.php | 2025-11-11 | Notification settings |
| 2025_11_11_234237_create_scheduled_notifications_table.php | 2025-11-11 | Scheduled notifications |

**Total Migrations**: 22

---

## Data Dictionary

### Enum Values

**users.role**:
- `petani` - Farmer user
- `petugas` - Field officer
- `admin` - System administrator

**laporans.kualitas**:
- `baik` - Good quality
- `sedang` - Medium quality
- `buruk` - Poor quality

**laporans.status**:
- `pending` - Awaiting verification
- `terverifikasi` - Verified by officer
- `ditolak` - Rejected

**bantuans.jenis_bantuan**:
- `pupuk` - Fertilizer
- `bibit` - Seeds
- `pestisida` - Pesticide
- `alat_pertanian` - Farming tools
- `dana_usaha` - Business capital
- `lainnya` - Other

**bantuans.status**:
- `menunggu` - Pending approval
- `disetujui` - Approved
- `ditolak` - Rejected

**beritas.status**:
- `draft` - Draft (not published)
- `published` - Published
- `archived` - Archived

**feedbacks.status**:
- `unread` - Not read yet
- `read` - Read by admin
- `replied` - Response sent

**scheduled_notifications.status**:
- `pending` - Waiting to send
- `sent` - Successfully sent
- `failed` - Failed to send

---

**Document Version**: 1.0  
**Last Updated**: November 12, 2025  
**Maintained By**: Development Team
