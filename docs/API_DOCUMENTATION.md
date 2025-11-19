# API Documentation - Sistem Pertanian

## Overview
RESTful API untuk Sistem Informasi Pertanian dengan autentikasi Laravel Sanctum, rate limiting, dan dokumentasi Swagger.

**Base URL:** `http://localhost:8000/api/v1`
**Version:** 1.0.0
**Authentication:** Bearer Token (Laravel Sanctum)

---

## Features

### ✅ Completed Features
1. **RESTful API CRUD untuk Laporan** - 7 endpoints (index, store, show, update, destroy, verify, reject)
2. **RESTful API CRUD untuk Bantuan** - 7 endpoints (index, store, show, update, destroy, approve, reject)
3. **API Authentication** - Laravel Sanctum dengan 5 endpoints (register, login, logout, logout-all, me)
4. **API Documentation** - Swagger UI dan Postman Collection
5. **API Rate Limiting** - 60 req/min untuk authenticated, 30 req/min untuk guest
6. **API Versioning** - Namespace v1 dengan struktur modular

---

## Authentication

### Register Petani
**POST** `/api/v1/auth/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "no_telepon": "081234567890",
    "alamat_desa": "Desa Makmur",
    "alamat_lengkap": "Jl. Raya Desa No. 123"
}
```

**Response (201):**
```json
{
    "message": "Registrasi berhasil. Silakan login.",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "petani",
        "is_verified": false
    }
}
```

---

### Login
**POST** `/api/v1/auth/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "token": "1|abcdefghijklmnopqrstuvwxyz",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "petani",
        "is_verified": true
    }
}
```

**Error Response (403) - Unverified:**
```json
{
    "message": "Akun Anda belum diverifikasi oleh admin"
}
```

---

### Get Current User
**GET** `/api/v1/auth/me`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "petani",
        "no_telepon": "081234567890",
        "alamat_desa": "Desa Makmur",
        "is_verified": true
    }
}
```

---

### Logout
**POST** `/api/v1/auth/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "message": "Logout berhasil"
}
```

---

### Logout All Devices
**POST** `/api/v1/auth/logout-all`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "message": "Logout dari semua perangkat berhasil"
}
```

---

## Laporan (Harvest Reports)

### Get All Laporan
**GET** `/api/v1/laporan`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `page` (integer, default: 1)
- `per_page` (integer, default: 15)
- `status` (string, optional: "pending", "terverifikasi", "ditolak")

**Access Control:**
- **Petani:** See only their own laporan
- **Petugas:** See laporan from their desa
- **Admin:** See all laporan

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com"
            },
            "komoditas": "Padi",
            "jenis_tanaman": "IR64",
            "luas_lahan": 2.5,
            "jumlah_panen": 5000,
            "tanggal_panen": "2025-11-10",
            "kualitas": "A",
            "harga_jual": 6000,
            "status": "pending",
            "catatan": null,
            "created_at": "2025-11-12T10:00:00.000000Z",
            "updated_at": "2025-11-12T10:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "per_page": 15,
        "total": 1
    }
}
```

---

### Create Laporan
**POST** `/api/v1/laporan`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "komoditas": "Padi",
    "jenis_tanaman": "IR64",
    "luas_lahan": 2.5,
    "jumlah_panen": 5000,
    "tanggal_panen": "2025-11-10",
    "kualitas": "A",
    "harga_jual": 6000,
    "catatan": "Panen pertama tahun ini"
}
```

**Validation Rules:**
- `komoditas`: required, string, max:255
- `jenis_tanaman`: required, string, max:255
- `luas_lahan`: required, numeric, min:0
- `jumlah_panen`: required, numeric, min:0
- `tanggal_panen`: required, date
- `kualitas`: required, in:A,B,C
- `harga_jual`: required, numeric, min:0
- `catatan`: nullable, string

**Access:** Petani only (verified required)

**Response (201):**
```json
{
    "message": "Laporan berhasil dibuat",
    "data": {
        "id": 1,
        "komoditas": "Padi",
        "status": "pending",
        ...
    }
}
```

---

### Get Laporan by ID
**GET** `/api/v1/laporan/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "data": {
        "id": 1,
        "komoditas": "Padi",
        ...
    }
}
```

**Error (403):**
```json
{
    "message": "Tidak memiliki akses"
}
```

---

### Update Laporan
**PUT** `/api/v1/laporan/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "jumlah_panen": 5500,
    "harga_jual": 6200,
    "catatan": "Updated information"
}
```

**Access:** Owner only (status must be "pending")

**Response (200):**
```json
{
    "message": "Laporan berhasil diperbarui",
    "data": {
        "id": 1,
        "jumlah_panen": 5500,
        ...
    }
}
```

**Error (403):**
```json
{
    "message": "Laporan yang sudah diverifikasi tidak dapat diedit"
}
```

---

### Verify Laporan (Petugas/Admin)
**POST** `/api/v1/laporan/{id}/verify`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "catatan": "Data terverifikasi dengan baik"
}
```

**Access:** Petugas (same desa) or Admin

**Response (200):**
```json
{
    "message": "Laporan diverifikasi",
    "data": {
        "id": 1,
        "status": "terverifikasi",
        "catatan": "Data terverifikasi dengan baik"
    }
}
```

---

### Reject Laporan (Petugas/Admin)
**POST** `/api/v1/laporan/{id}/reject`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "alasan": "Data tidak sesuai dengan kondisi lapangan"
}
```

**Access:** Petugas (same desa) or Admin

**Response (200):**
```json
{
    "message": "Laporan ditolak",
    "data": {
        "id": 1,
        "status": "ditolak",
        "catatan": "Data tidak sesuai dengan kondisi lapangan"
    }
}
```

---

### Delete Laporan
**DELETE** `/api/v1/laporan/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Access:** Owner only (status must be "pending")

**Response (200):**
```json
{
    "message": "Laporan berhasil dihapus"
}
```

---

## Bantuan (Aid Requests)

### Get All Bantuan
**GET** `/api/v1/bantuan`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `page` (integer, default: 1)
- `per_page` (integer, default: 15)
- `status` (string, optional: "pending", "disetujui", "ditolak")

**Access Control:**
- **Petani:** See only their own bantuan
- **Petugas:** See bantuan from their desa
- **Admin:** See all bantuan

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "user": {
                "id": 1,
                "name": "John Doe"
            },
            "jenis_bantuan": "Pupuk Organik",
            "jumlah": 100,
            "alasan": "Untuk meningkatkan produksi",
            "tanggal_permintaan": "2025-11-12",
            "status": "pending",
            "keterangan": "Sangat dibutuhkan",
            "catatan": null,
            "created_at": "2025-11-12T10:00:00.000000Z"
        }
    ]
}
```

---

### Create Bantuan
**POST** `/api/v1/bantuan`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "jenis_bantuan": "Pupuk Organik",
    "jumlah": 100,
    "alasan": "Untuk meningkatkan produksi padi",
    "tanggal_permintaan": "2025-11-12",
    "keterangan": "Sangat dibutuhkan untuk musim tanam"
}
```

**Validation Rules:**
- `jenis_bantuan`: required, string, max:255
- `jumlah`: required, numeric, min:0
- `alasan`: required, string
- `tanggal_permintaan`: nullable, date
- `keterangan`: nullable, string

**Access:** Petani only (verified required)

**Response (201):**
```json
{
    "message": "Permintaan bantuan berhasil dibuat",
    "data": {
        "id": 1,
        "jenis_bantuan": "Pupuk Organik",
        "status": "pending",
        ...
    }
}
```

---

### Get Bantuan by ID
**GET** `/api/v1/bantuan/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "data": {
        "id": 1,
        "jenis_bantuan": "Pupuk Organik",
        ...
    }
}
```

---

### Update Bantuan
**PUT** `/api/v1/bantuan/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "jumlah": 150,
    "keterangan": "Membutuhkan lebih banyak"
}
```

**Access:** Owner only (status must be "pending")

**Response (200):**
```json
{
    "message": "Bantuan berhasil diperbarui",
    "data": {
        "id": 1,
        "jumlah": 150,
        ...
    }
}
```

---

### Approve Bantuan (Petugas/Admin)
**POST** `/api/v1/bantuan/{id}/approve`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "catatan": "Bantuan disetujui"
}
```

**Access:** Petugas (same desa) or Admin

**Response (200):**
```json
{
    "message": "Bantuan disetujui",
    "data": {
        "id": 1,
        "status": "disetujui",
        "catatan": "Bantuan disetujui"
    }
}
```

---

### Reject Bantuan (Petugas/Admin)
**POST** `/api/v1/bantuan/{id}/reject`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "alasan": "Kuota bantuan sudah habis"
}
```

**Access:** Petugas (same desa) or Admin

**Response (200):**
```json
{
    "message": "Bantuan ditolak",
    "data": {
        "id": 1,
        "status": "ditolak",
        "catatan": "Kuota bantuan sudah habis"
    }
}
```

---

### Delete Bantuan
**DELETE** `/api/v1/bantuan/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Access:** Owner only (status must be "pending")

**Response (200):**
```json
{
    "message": "Bantuan berhasil dihapus"
}
```

---

## Rate Limiting

### Authenticated Users
- **Limit:** 60 requests per minute
- **Applies to:** All `/api/v1/laporan/*` and `/api/v1/bantuan/*` endpoints

### Guest Users
- **Limit:** 30 requests per minute
- **Applies to:** Public endpoints (register, login)

### Rate Limit Headers
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
```

### Rate Limit Exceeded Response (429)
```json
{
    "message": "Too Many Requests"
}
```

---

## Error Responses

### 401 Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

### 403 Forbidden
```json
{
    "message": "Tidak memiliki akses"
}
```

### 404 Not Found
```json
{
    "message": "Resource not found"
}
```

### 422 Validation Error
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password must be at least 8 characters."
        ]
    }
}
```

### 500 Internal Server Error
```json
{
    "message": "Server Error"
}
```

---

## Swagger UI

Access interactive API documentation at:
```
http://localhost:8000/api/documentation
```

---

## Postman Collection

Import the collection file: `docs/Sistem_Pertanian_API_v1.postman_collection.json`

**Collection Variables:**
- `base_url`: http://localhost:8000/api/v1
- `token`: (auto-set after login)
- `laporan_id`: (auto-set after creating laporan)
- `bantuan_id`: (auto-set after creating bantuan)

---

## Testing

### Using Postman
1. Import collection: `docs/Sistem_Pertanian_API_v1.postman_collection.json`
2. Run "Register Petani" request
3. Run "Login" request (token will be auto-saved)
4. Test CRUD operations for Laporan and Bantuan

### Using cURL

**Register:**
```bash
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "no_telepon": "081234567890",
    "alamat_desa": "Desa Makmur",
    "alamat_lengkap": "Jl. Raya Desa No. 123"
  }'
```

**Login:**
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

**Get Laporan:**
```bash
curl -X GET http://localhost:8000/api/v1/laporan \
  -H "Authorization: Bearer {your-token}" \
  -H "Accept: application/json"
```

---

## API Endpoints Summary

### Authentication (5 endpoints)
- POST `/auth/register` - Register petani
- POST `/auth/login` - Login user
- POST `/auth/logout` - Logout current device
- POST `/auth/logout-all` - Logout all devices
- GET `/auth/me` - Get current user

### Laporan (7 endpoints)
- GET `/laporan` - List laporan
- POST `/laporan` - Create laporan
- GET `/laporan/{id}` - Get laporan detail
- PUT `/laporan/{id}` - Update laporan
- DELETE `/laporan/{id}` - Delete laporan
- POST `/laporan/{id}/verify` - Verify laporan
- POST `/laporan/{id}/reject` - Reject laporan

### Bantuan (7 endpoints)
- GET `/bantuan` - List bantuan
- POST `/bantuan` - Create bantuan
- GET `/bantuan/{id}` - Get bantuan detail
- PUT `/bantuan/{id}` - Update bantuan
- DELETE `/bantuan/{id}` - Delete bantuan
- POST `/bantuan/{id}/approve` - Approve bantuan
- POST `/bantuan/{id}/reject` - Reject bantuan

**Total: 19 API Endpoints**

---

## Security

### Token Management
- Tokens are stored in `personal_access_tokens` table
- Tokens never expire by default (can be configured in `config/sanctum.php`)
- Use `logout-all` to revoke all tokens for security

### Password Hashing
- All passwords are hashed using Laravel's bcrypt
- Minimum password length: 8 characters

### CORS
- Configure allowed origins in `config/cors.php`
- Default: All origins allowed in development

### HTTPS
- Always use HTTPS in production
- Tokens transmitted via Authorization header

---

## Best Practices

1. **Always include Accept header:**
   ```
   Accept: application/json
   ```

2. **Store tokens securely** (LocalStorage/SessionStorage/Cookies)

3. **Handle token expiration** with 401 error

4. **Use pagination** to limit response size

5. **Validate all inputs** on client-side before sending

6. **Log out users** when they close the app

7. **Use HTTPS** in production environments

---

## Support

For questions or issues:
- Email: admin@sistempertanian.com
- Documentation: http://localhost:8000/api/documentation
- Postman Collection: `docs/Sistem_Pertanian_API_v1.postman_collection.json`
