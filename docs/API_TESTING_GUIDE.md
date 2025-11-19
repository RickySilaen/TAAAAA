# API Testing Guide - Quick Start

## Server Status
✅ Laravel server running on: http://127.0.0.1:8000

## Quick Test Commands

### 1. Test Swagger Documentation
Open in browser:
```
http://127.0.0.1:8000/api/documentation
```

### 2. Test API Endpoints with cURL

#### Register a New Petani
```powershell
curl.exe -X POST http://127.0.0.1:8000/api/v1/auth/register `
  -H "Content-Type: application/json" `
  -H "Accept: application/json" `
  -d '{\"name\":\"Test Petani\",\"email\":\"test@petani.com\",\"password\":\"password123\",\"password_confirmation\":\"password123\",\"no_telepon\":\"081234567890\",\"alamat_desa\":\"Desa Makmur\",\"alamat_lengkap\":\"Jl. Test No. 123\"}'
```

#### Login (after verifying account via web UI)
```powershell
curl.exe -X POST http://127.0.0.1:8000/api/v1/auth/login `
  -H "Content-Type: application/json" `
  -H "Accept: application/json" `
  -d '{\"email\":\"test@petani.com\",\"password\":\"password123\"}'
```

**Save the token from login response!**

#### Get Current User
```powershell
curl.exe -X GET http://127.0.0.1:8000/api/v1/auth/me `
  -H "Authorization: Bearer YOUR_TOKEN_HERE" `
  -H "Accept: application/json"
```

#### Create Laporan
```powershell
curl.exe -X POST http://127.0.0.1:8000/api/v1/laporan `
  -H "Authorization: Bearer YOUR_TOKEN_HERE" `
  -H "Content-Type: application/json" `
  -H "Accept: application/json" `
  -d '{\"komoditas\":\"Padi\",\"jenis_tanaman\":\"IR64\",\"luas_lahan\":2.5,\"jumlah_panen\":5000,\"tanggal_panen\":\"2025-11-10\",\"kualitas\":\"A\",\"harga_jual\":6000}'
```

#### Get All Laporan
```powershell
curl.exe -X GET http://127.0.0.1:8000/api/v1/laporan `
  -H "Authorization: Bearer YOUR_TOKEN_HERE" `
  -H "Accept: application/json"
```

#### Create Bantuan
```powershell
curl.exe -X POST http://127.0.0.1:8000/api/v1/bantuan `
  -H "Authorization: Bearer YOUR_TOKEN_HERE" `
  -H "Content-Type: application/json" `
  -H "Accept: application/json" `
  -d '{\"jenis_bantuan\":\"Pupuk Organik\",\"jumlah\":100,\"alasan\":\"Untuk meningkatkan produksi\"}'
```

#### Get All Bantuan
```powershell
curl.exe -X GET http://127.0.0.1:8000/api/v1/bantuan `
  -H "Authorization: Bearer YOUR_TOKEN_HERE" `
  -H "Accept: application/json"
```

---

## Using Postman

### 1. Import Collection
- Open Postman
- Click **Import**
- Select file: `docs/Sistem_Pertanian_API_v1.postman_collection.json`

### 2. Test Flow
1. **Authentication** → **Register Petani** (run this)
2. Go to web UI and verify the account (admin/petugas login)
3. **Authentication** → **Login** (token auto-saved to collection variable)
4. **Laporan** → **Create Laporan**
5. **Laporan** → **Get All Laporan**
6. **Bantuan** → **Create Bantuan**
7. **Bantuan** → **Get All Bantuan**

---

## Testing Checklist

### ✅ Authentication
- [ ] Register new petani account
- [ ] Login with credentials
- [ ] Get current user info
- [ ] Logout from current device
- [ ] Test login with unverified account (should fail)

### ✅ Laporan
- [ ] Create laporan (petani)
- [ ] List all laporan (role-based filtering)
- [ ] Get laporan by ID
- [ ] Update laporan (owner only, pending status)
- [ ] Verify laporan (petugas/admin)
- [ ] Reject laporan (petugas/admin)
- [ ] Delete laporan (owner only, pending status)

### ✅ Bantuan
- [ ] Create bantuan (petani)
- [ ] List all bantuan (role-based filtering)
- [ ] Get bantuan by ID
- [ ] Update bantuan (owner only, pending status)
- [ ] Approve bantuan (petugas/admin)
- [ ] Reject bantuan (petugas/admin)
- [ ] Delete bantuan (owner only, pending status)

### ✅ Authorization Tests
- [ ] Petani cannot verify/approve (should get 403)
- [ ] User cannot edit others' data (should get 403)
- [ ] User cannot edit verified/approved items (should get 403)
- [ ] Petugas can only access their desa data
- [ ] Admin can access all data

### ✅ Rate Limiting
- [ ] Send 61 requests in 1 minute (should get 429 on 61st request)
- [ ] Check rate limit headers in response

---

## Expected Responses

### Successful Register (201)
```json
{
  "message": "Registrasi berhasil. Silakan login.",
  "data": {
    "id": 1,
    "name": "Test Petani",
    "email": "test@petani.com",
    "role": "petani",
    "is_verified": false
  }
}
```

### Successful Login (200)
```json
{
  "token": "1|abcdefghijklmnopqrstuvwxyz123456",
  "user": {
    "id": 1,
    "name": "Test Petani",
    "email": "test@petani.com",
    "role": "petani",
    "is_verified": true
  }
}
```

### Unverified Account Error (403)
```json
{
  "message": "Akun Anda belum diverifikasi oleh admin"
}
```

### Unauthorized Error (401)
```json
{
  "message": "Unauthenticated."
}
```

### Forbidden Error (403)
```json
{
  "message": "Tidak memiliki akses"
}
```

### Validation Error (422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "komoditas": ["The komoditas field is required."]
  }
}
```

### Rate Limit Exceeded (429)
```json
{
  "message": "Too Many Requests"
}
```

---

## Troubleshooting

### Issue: Token not working
**Solution:** Make sure to include "Bearer " prefix:
```
Authorization: Bearer 1|abcd1234...
```

### Issue: Unverified account
**Solution:** 
1. Login to web UI as admin/petugas
2. Go to User Management
3. Verify the petani account
4. Try API login again

### Issue: 403 Forbidden on verify/approve
**Solution:** These endpoints are only for petugas/admin roles

### Issue: Cannot edit laporan/bantuan
**Solution:** Can only edit items with "pending" status

---

## API URLs

- **Base URL:** http://127.0.0.1:8000/api/v1
- **Swagger Docs:** http://127.0.0.1:8000/api/documentation
- **Web UI:** http://127.0.0.1:8000

---

## Next Steps

1. ✅ Test all endpoints via Postman
2. ✅ Verify Swagger documentation is accessible
3. ✅ Test authorization rules
4. ✅ Test rate limiting
5. ✅ Verify error responses
6. ✅ Test with different user roles (petani, petugas, admin)

---

## Documentation Files

- **Full API Docs:** `docs/API_DOCUMENTATION.md`
- **Postman Collection:** `docs/Sistem_Pertanian_API_v1.postman_collection.json`
- **Implementation Summary:** `docs/API_IMPLEMENTATION_SUMMARY.md`
- **This Guide:** `docs/API_TESTING_GUIDE.md`

---

## Support

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Review API documentation: `docs/API_DOCUMENTATION.md`
3. Test with Swagger UI: http://127.0.0.1:8000/api/documentation
4. Verify database migrations are up to date: `php artisan migrate:status`

---

## ✅ Implementation Complete

All 19 API endpoints are ready for testing!

**Total Endpoints:** 19
- Authentication: 5
- Laporan: 7
- Bantuan: 7

**Features:**
✅ Laravel Sanctum authentication
✅ Role-based authorization
✅ Rate limiting (60/min auth, 30/min guest)
✅ API versioning (v1)
✅ Swagger documentation
✅ Postman collection
✅ Complete API docs

**Status:** 🎉 100% COMPLETE 🎉
