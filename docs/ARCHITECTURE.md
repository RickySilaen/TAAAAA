# System Architecture Documentation

**Project**: Sistem Informasi Pertanian Toba  
**Architecture Style**: Layered Architecture with Repository Pattern  
**Last Updated**: November 12, 2025

---

## 📋 Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Layered Architecture](#layered-architecture)
3. [Design Patterns](#design-patterns)
4. [Component Diagram](#component-diagram)
5. [Data Flow](#data-flow)
6. [API Architecture](#api-architecture)
7. [Security Architecture](#security-architecture)
8. [Deployment Architecture](#deployment-architecture)

---

## Architecture Overview

Sistem Pertanian Toba menggunakan **Layered Architecture** dengan separation of concerns yang jelas:

```
┌─────────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │   Blade      │  │   Vue.js     │  │  REST API    │      │
│  │   Views      │  │  Components  │  │  Endpoints   │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    APPLICATION LAYER                         │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │ Controllers  │  │  Middleware  │  │   Routes     │      │
│  │   - Web      │  │ - Auth       │  │  - web.php   │      │
│  │   - API      │  │ - CSRF       │  │  - api.php   │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                     BUSINESS LAYER                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │   Services   │  │     DTOs     │  │    Events    │      │
│  │ - Dashboard  │  │ - Bantuan    │  │ - Status     │      │
│  │ - Notif      │  │ - Laporan    │  │   Changed    │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                  DATA ACCESS LAYER                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │ Repositories │  │    Models    │  │  Eloquent    │      │
│  │ - Bantuan    │  │  - User      │  │  Query       │      │
│  │ - Laporan    │  │  - Laporan   │  │  Builder     │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                     DATABASE LAYER                           │
│              MySQL / SQLite Database                         │
└─────────────────────────────────────────────────────────────┘
```

**Key Principles**:
- ✅ **Separation of Concerns**: Each layer has specific responsibility
- ✅ **Dependency Inversion**: Upper layers depend on abstractions
- ✅ **Single Responsibility**: Each class has one reason to change
- ✅ **DRY (Don't Repeat Yourself)**: Shared logic in base classes

---

## Layered Architecture

### 1. Presentation Layer

**Responsibilities**:
- Render UI (Blade templates, Vue components)
- Handle user input
- Display data from Application Layer

**Components**:
```
resources/
├── views/               # Blade templates
│   ├── admin/          # Admin panel views
│   ├── petani/         # Farmer dashboard
│   ├── petugas/        # Officer dashboard
│   ├── guest/          # Public pages
│   └── layouts/        # Layout templates
├── js/                 # JavaScript
│   ├── dashboard-charts.js
│   ├── notification-center.js
│   ├── maps-service.js
│   └── pwa-installer.js
└── css/                # Stylesheets
```

**Technologies**:
- **Blade**: Server-side templating
- **Alpine.js**: Lightweight JavaScript framework
- **Tailwind CSS**: Utility-first CSS
- **ApexCharts**: Interactive charts
- **Leaflet**: Maps integration

---

### 2. Application Layer

**Responsibilities**:
- Route HTTP requests
- Validate input
- Handle authentication/authorization
- Coordinate between layers

**Components**:

#### Controllers
```
app/Http/Controllers/
├── Controller.php                    # Base controller
├── Admin/
│   ├── BeritaController.php         # News management
│   ├── FeedbackController.php       # Feedback handling
│   ├── GaleriController.php         # Gallery management
│   ├── NewsletterController.php     # Newsletter system
│   └── PetugasController.php        # Officer management
├── Api/
│   ├── ApiController.php            # Base API controller
│   └── V1/
│       ├── AuthController.php       # API authentication
│       ├── BantuanController.php    # Aid API
│       └── LaporanController.php    # Report API
├── Auth/
│   ├── LoginController.php          # Login logic
│   └── RegisterController.php       # Registration logic
├── DashboardController.php          # Main dashboard
├── GuestController.php              # Public pages
├── LocaleController.php             # Language switching
├── NotificationController.php       # Notifications
├── PetaniController.php             # Farmer actions
└── PetugasController.php            # Officer actions
```

**Controller Design Rules**:
- ✅ Thin controllers (< 200 lines)
- ✅ Business logic in Services
- ✅ Data access via Repositories
- ✅ Return views or JSON responses

#### Middleware
```
app/Http/Middleware/
├── AddCacheHeaders.php          # HTTP caching
├── CheckRole.php                # Role-based access
├── DetectN1Queries.php          # Performance monitoring
├── SecurityHeaders.php          # Security headers
├── SetLocale.php                # Internationalization
├── VerifyCsrfToken.php          # CSRF protection
└── XssProtection.php            # XSS filtering
```

**Middleware Pipeline**:
```
Request → Web Middleware → Route Middleware → Controller
          ↓
      - CSRF Token
      - Session
      - Cookie Encryption
      - Security Headers
      - Locale Detection
```

#### Form Requests
```
app/Http/Requests/
├── StoreBantuanRequest.php      # Bantuan creation validation
├── UpdateBantuanRequest.php     # Bantuan update validation
├── StoreLaporanRequest.php      # Laporan creation validation
└── UpdateLaporanRequest.php     # Laporan update validation
```

---

### 3. Business Layer

**Responsibilities**:
- Implement business logic
- Orchestrate operations
- Dispatch events
- Transform data with DTOs

**Components**:

#### Services
```
app/Services/
├── BaseService.php              # Base service with error handling
├── ActivityLogger.php           # Activity tracking
├── BackupService.php            # Database backups
├── CacheService.php             # Cache management
├── DashboardService.php         # Dashboard analytics
├── NotificationService.php      # Notification system
└── SecureFileUploadService.php  # File upload handling
```

**Service Pattern Example**:
```php
class BantuanService extends BaseService {
    public function approveBantuan(int $id, string $keterangan): array {
        return $this->executeWithErrorHandling(function() use ($id, $keterangan) {
            // Business logic here
            $bantuan = $this->repo->findOrFail($id);
            $oldStatus = $bantuan->status;
            
            $bantuan->update([
                'status' => 'disetujui',
                'keterangan' => $keterangan
            ]);
            
            // Dispatch event
            event(new BantuanStatusChanged($bantuan, $oldStatus, 'disetujui'));
            
            return $bantuan;
        }, 'Failed to approve bantuan');
    }
}
```

#### DTOs (Data Transfer Objects)
```
app/DataTransferObjects/
├── BaseDTO.php             # Base DTO with validation
├── BantuanDTO.php          # Bantuan data container
└── LaporanDTO.php          # Laporan data container
```

**DTO Benefits**:
- ✅ Type safety with readonly properties
- ✅ Validation in one place
- ✅ Immutability (cannot be changed after creation)
- ✅ Easy conversion (fromArray, fromRequest, fromModel)

#### Events & Listeners
```
app/Events/
├── BantuanStatusChanged.php     # Aid status changed
├── LaporanStatusChanged.php     # Report status changed
└── DataExportRequested.php      # Export requested

app/Listeners/
├── HandleBantuanStatusChange.php    # Send notifications
├── HandleLaporanStatusChange.php    # Clear cache
└── HandleDataExportRequest.php      # Log activity
```

**Event-Driven Benefits**:
- ✅ Decoupled components
- ✅ Easy to add new listeners
- ✅ Async processing (queueable)
- ✅ Audit trail

---

### 4. Data Access Layer

**Responsibilities**:
- Abstract database queries
- Provide reusable query methods
- Manage relationships
- Handle transactions

**Components**:

#### Repositories
```
app/Repositories/
├── BaseRepository.php       # Base CRUD operations
├── BantuanRepository.php    # Bantuan data access
└── LaporanRepository.php    # Laporan data access
```

**Repository Pattern Benefits**:
- ✅ Centralized queries
- ✅ Easy to mock for testing
- ✅ Swap data sources (API, cache, database)
- ✅ Reusable across controllers

**Repository Methods**:
```php
// CRUD operations
all(), find(), findOrFail(), create(), update(), delete()

// Query helpers
findBy(), findWhere(), paginate(), count(), exists()

// Specialized methods
getByStatus(), getByUser(), getByDateRange(), search()

// Statistics
getStatistics(), getHarvestSummary()
```

#### Models
```
app/Models/
├── User.php                # User model
├── Bantuan.php             # Aid request model
├── Laporan.php             # Harvest report model
├── Berita.php              # News model
├── Galeri.php              # Gallery model
├── Newsletter.php          # Newsletter model
└── Feedback.php            # Feedback model
```

**Model Responsibilities**:
- Define table name
- Define fillable/guarded attributes
- Define relationships
- Define casts
- Define accessors/mutators

---

### 5. Database Layer

**See**: [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md) for complete schema

**Tables**: 12 tables
- **Core**: users, laporans, bantuans
- **Content**: beritas, galeris, newsletters, feedbacks
- **System**: notifications, scheduled_notifications, cache, jobs, personal_access_tokens

---

## Design Patterns

### 1. Repository Pattern

**Problem**: Direct database queries in controllers make code hard to test and maintain.

**Solution**: Abstract all database operations into Repository classes.

```php
// Bad: Controller queries database directly
public function index() {
    $bantuans = Bantuan::where('status', 'menunggu')->get();
}

// Good: Controller uses Repository
public function index(BantuanRepository $repo) {
    $bantuans = $repo->getPending();
}
```

**Benefits**:
- ✅ Testable (mock repository)
- ✅ Reusable queries
- ✅ Single source of truth

---

### 2. Service Layer Pattern

**Problem**: Business logic in controllers makes them fat and hard to test.

**Solution**: Move business logic to Service classes.

```php
// Bad: Business logic in controller
public function approve(Request $request, Bantuan $bantuan) {
    $bantuan->update(['status' => 'disetujui']);
    $bantuan->user->notify(new BantuanApproved($bantuan));
    Log::info("Bantuan approved");
    cache()->forget('dashboard_stats');
    return redirect()->back();
}

// Good: Business logic in Service
public function approve(Request $request, Bantuan $bantuan, BantuanService $service) {
    $result = $service->approveBantuan($bantuan->id, $request->keterangan);
    return redirect()->back();
}
```

**Benefits**:
- ✅ Thin controllers
- ✅ Reusable business logic
- ✅ Easier to test

---

### 3. Data Transfer Object (DTO) Pattern

**Problem**: Passing arrays between layers is not type-safe.

**Solution**: Use immutable DTOs with validation.

```php
// Bad: Array with no type safety
public function create(array $data) {
    // What fields are in $data? Unknown!
}

// Good: DTO with type safety
public function create(BantuanDTO $dto) {
    $dto->validateForCreate();
    $bantuan = $this->repo->create($dto->toDatabase());
}
```

**Benefits**:
- ✅ Type safety (IDE autocomplete)
- ✅ Validation in DTO
- ✅ Immutability

---

### 4. Event-Driven Pattern

**Problem**: Tight coupling between actions and side effects.

**Solution**: Dispatch events, handle in listeners.

```php
// Bad: Tight coupling
public function approve(Bantuan $bantuan) {
    $bantuan->update(['status' => 'disetujui']);
    $bantuan->user->notify(...);  // Coupled
    Log::info(...);                // Coupled
    cache()->forget(...);          // Coupled
}

// Good: Event-driven
public function approve(Bantuan $bantuan) {
    $oldStatus = $bantuan->status;
    $bantuan->update(['status' => 'disetujui']);
    event(new BantuanStatusChanged($bantuan, $oldStatus, 'disetujui'));
}
```

**Benefits**:
- ✅ Decoupled
- ✅ Easy to add listeners
- ✅ Async processing

---

### 5. Dependency Injection Pattern

**Problem**: Hard-coded dependencies make testing difficult.

**Solution**: Inject dependencies via constructor or method parameters.

```php
// Bad: Hard-coded dependency
public function index() {
    $repo = new BantuanRepository(new Bantuan);
    $bantuans = $repo->getAll();
}

// Good: Injected dependency
public function index(BantuanRepository $repo) {
    $bantuans = $repo->getAll();
}
```

**Benefits**:
- ✅ Testable (inject mocks)
- ✅ Flexible (swap implementations)
- ✅ Laravel's service container handles it

---

## Component Diagram

```
┌──────────────────────────────────────────────────────────────┐
│                        CLIENT LAYER                           │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐          │
│  │   Browser   │  │ Mobile App  │  │ API Client  │          │
│  │   (HTML)    │  │    (PWA)    │  │  (Postman)  │          │
│  └─────────────┘  └─────────────┘  └─────────────┘          │
└──────────────────────────────────────────────────────────────┘
         │                  │                  │
         └──────────────────┼──────────────────┘
                            ↓
┌──────────────────────────────────────────────────────────────┐
│                      WEB SERVER                               │
│                  Nginx / Apache                               │
│               (Reverse Proxy + SSL)                           │
└──────────────────────────────────────────────────────────────┘
                            ↓
┌──────────────────────────────────────────────────────────────┐
│                   APPLICATION SERVER                          │
│                      PHP-FPM 8.2+                             │
│                   Laravel Framework                           │
│                                                               │
│  ┌────────────────┐  ┌────────────────┐  ┌────────────────┐ │
│  │  Controllers   │  │   Middleware   │  │    Routes      │ │
│  └────────────────┘  └────────────────┘  └────────────────┘ │
│           ↓                                                   │
│  ┌────────────────┐  ┌────────────────┐  ┌────────────────┐ │
│  │    Services    │  │      DTOs      │  │     Events     │ │
│  └────────────────┘  └────────────────┘  └────────────────┘ │
│           ↓                                                   │
│  ┌────────────────┐  ┌────────────────┐                     │
│  │  Repositories  │  │     Models     │                     │
│  └────────────────┘  └────────────────┘                     │
└──────────────────────────────────────────────────────────────┘
                            ↓
┌──────────────────────────────────────────────────────────────┐
│                     DATABASE SERVER                           │
│               MySQL 8.0+ / SQLite                             │
└──────────────────────────────────────────────────────────────┘
                            ↓
┌──────────────────────────────────────────────────────────────┐
│                    EXTERNAL SERVICES                          │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐          │
│  │    Email    │  │    Redis    │  │   Storage   │          │
│  │   (SMTP)    │  │   (Cache)   │  │   (S3/DO)   │          │
│  └─────────────┘  └─────────────┘  └─────────────┘          │
└──────────────────────────────────────────────────────────────┘
```

---

## Data Flow

### Example: Create Harvest Report (Laporan)

```
1. USER SUBMITS FORM
   └─> Browser sends POST /petani/laporan/store
   
2. MIDDLEWARE PIPELINE
   ├─> CSRF Token verification
   ├─> Session authentication
   ├─> XSS protection
   └─> Route to controller
   
3. CONTROLLER (PetaniController@storeLaporan)
   ├─> Create DTO from request
   │   └─> LaporanDTO::fromRequest($request)
   ├─> Validate DTO
   │   └─> $dto->validateForCreate()
   └─> Call Repository
       └─> $repo->create($dto->toDatabase())
       
4. REPOSITORY (LaporanRepository@create)
   ├─> Insert into database via Model
   │   └─> Laporan::create($data)
   └─> Return Laporan model
   
5. CONTROLLER DISPATCHES EVENT
   └─> event(new LaporanCreated($laporan))
   
6. EVENT LISTENER (HandleLaporanCreated)
   ├─> Send notification to petugas
   │   └─> Petugas::notify(new NewLaporanNotification)
   ├─> Log activity
   │   └─> Log::info("New laporan created")
   └─> Clear dashboard cache
       └─> cache()->forget('dashboard_stats')
       
7. CONTROLLER RETURNS RESPONSE
   └─> redirect()->route('petani.laporan')->with('success', 'Laporan created')
   
8. VIEW RENDERED
   └─> resources/views/petani/laporan/index.blade.php
```

---

## API Architecture

### REST API Versioning

```
Base URL: /api/v1
```

**Endpoints**:
```
Authentication:
POST   /api/v1/auth/register         # Register new user
POST   /api/v1/auth/login            # Login (get token)
POST   /api/v1/auth/logout           # Logout (revoke token)
GET    /api/v1/auth/user             # Get authenticated user

Bantuans:
GET    /api/v1/bantuans              # List bantuans (paginated)
POST   /api/v1/bantuans              # Create bantuan
GET    /api/v1/bantuans/{id}         # Get bantuan detail
PUT    /api/v1/bantuans/{id}         # Update bantuan
DELETE /api/v1/bantuans/{id}         # Delete bantuan
GET    /api/v1/bantuans/statistics   # Get statistics

Laporans:
GET    /api/v1/laporans              # List laporans (paginated)
POST   /api/v1/laporans              # Create laporan
GET    /api/v1/laporans/{id}         # Get laporan detail
PUT    /api/v1/laporans/{id}         # Update laporan
DELETE /api/v1/laporans/{id}         # Delete laporan
GET    /api/v1/laporans/statistics   # Get statistics
```

### API Response Format

**Success Response**:
```json
{
    "success": true,
    "data": {
        "id": 1,
        "komoditas": "Kopi Arabika",
        "jumlah_panen": 500
    },
    "message": "Laporan created successfully",
    "meta": {
        "timestamp": "2025-11-12T10:30:00Z",
        "version": "v1"
    }
}
```

**Error Response**:
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "komoditas": ["The komoditas field is required."]
    },
    "meta": {
        "timestamp": "2025-11-12T10:30:00Z",
        "version": "v1"
    }
}
```

### API Authentication

**Method**: Laravel Sanctum (Token-based)

```
Authorization: Bearer {access_token}
```

**Token Expiration**: 24 hours (configurable)

---

## Security Architecture

### Authentication Flow

```
1. User enters credentials
   ↓
2. Laravel Auth validates
   ↓
3. Session created (for web)
   ↓
4. Token issued (for API)
   ↓
5. User authenticated
```

### Authorization (Role-Based Access Control)

```
app/Http/Middleware/CheckRole.php
```

**Roles**:
- `admin` - Full system access
- `petugas` - Verification & management
- `petani` - Submit reports & requests

**Permission Matrix**:
| Action | Admin | Petugas | Petani |
|--------|-------|---------|--------|
| Create Laporan | ✅ | ✅ | ✅ |
| Verify Laporan | ✅ | ✅ | ❌ |
| Delete Any Laporan | ✅ | ❌ | ❌ |
| Approve Bantuan | ✅ | ✅ | ❌ |
| Manage Users | ✅ | ❌ | ❌ |

### Security Layers

1. **CSRF Protection** (`VerifyCsrfToken.php`)
   - Token validation for all POST/PUT/DELETE requests
   
2. **XSS Protection** (`XssProtection.php`)
   - Input sanitization
   - Output escaping
   
3. **SQL Injection Prevention**
   - Eloquent ORM (parameterized queries)
   - Validation rules
   
4. **Security Headers** (`SecurityHeaders.php`)
   - `X-Frame-Options: DENY`
   - `X-Content-Type-Options: nosniff`
   - `Strict-Transport-Security: max-age=31536000`
   - `Content-Security-Policy`

5. **Rate Limiting**
   - API: 60 requests/minute per user
   - Login: 5 attempts/minute per IP

---

## Deployment Architecture

### Production Environment

```
┌─────────────────────────────────────────────────────┐
│                  LOAD BALANCER                      │
│              (Nginx / Cloudflare)                   │
└─────────────────────────────────────────────────────┘
                         │
         ┌───────────────┼───────────────┐
         ↓               ↓               ↓
┌─────────────┐  ┌─────────────┐  ┌─────────────┐
│  App Server │  │  App Server │  │  App Server │
│     #1      │  │     #2      │  │     #3      │
│ PHP-FPM 8.2 │  │ PHP-FPM 8.2 │  │ PHP-FPM 8.2 │
└─────────────┘  └─────────────┘  └─────────────┘
         │               │               │
         └───────────────┼───────────────┘
                         ↓
┌─────────────────────────────────────────────────────┐
│              DATABASE CLUSTER                       │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐│
│  │   Master    │  │   Replica   │  │   Replica   ││
│  │   (Write)   │  │   (Read)    │  │   (Read)    ││
│  └─────────────┘  └─────────────┘  └─────────────┘│
└─────────────────────────────────────────────────────┘
                         ↓
┌─────────────────────────────────────────────────────┐
│              CACHE LAYER (Redis)                    │
│  Session | Queue | Cache | Real-time Data          │
└─────────────────────────────────────────────────────┘
                         ↓
┌─────────────────────────────────────────────────────┐
│          FILE STORAGE (S3 / DigitalOcean)           │
│  Photos | Documents | Backups                       │
└─────────────────────────────────────────────────────┘
```

### Deployment Process

```
1. Developer commits code to Git
   ↓
2. GitHub Actions CI/CD pipeline triggered
   ├─> Run tests (PHPUnit)
   ├─> Run static analysis (PHPStan)
   ├─> Run code formatting check (Pint)
   └─> Build Docker image
   ↓
3. Push Docker image to registry
   ↓
4. Deploy to staging environment
   ├─> Run migrations
   ├─> Run smoke tests
   └─> Manual QA approval
   ↓
5. Deploy to production (zero-downtime)
   ├─> Blue-green deployment
   ├─> Health check
   └─> Switch traffic
   ↓
6. Rollback strategy available
```

---

## Technology Stack

### Backend
- **Framework**: Laravel 11.x
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+ / SQLite (dev)
- **Cache**: Redis / Memcached
- **Queue**: Redis / Database

### Frontend
- **Templating**: Blade
- **JavaScript**: Alpine.js, Vanilla JS
- **CSS**: Tailwind CSS
- **Charts**: ApexCharts
- **Maps**: Leaflet.js
- **PWA**: Service Workers

### DevOps
- **CI/CD**: GitHub Actions
- **Containerization**: Docker
- **Orchestration**: Docker Compose / Kubernetes
- **Monitoring**: Laravel Telescope, Log Viewer
- **Backup**: Automated database backups

### Third-Party Services
- **Email**: SMTP (Gmail, Mailgun, SendGrid)
- **Storage**: AWS S3 / DigitalOcean Spaces
- **CDN**: Cloudflare
- **Monitoring**: Sentry (error tracking)

---

## Performance Optimization

### Database Optimization
- ✅ Indexes on frequently queried columns
- ✅ Eager loading to prevent N+1 queries
- ✅ Query caching
- ✅ Database connection pooling

### Application Optimization
- ✅ Opcache enabled
- ✅ Route caching (`php artisan route:cache`)
- ✅ Config caching (`php artisan config:cache`)
- ✅ View caching (`php artisan view:cache`)

### Frontend Optimization
- ✅ Asset minification (CSS, JS)
- ✅ Image optimization
- ✅ Lazy loading
- ✅ Service Worker caching (PWA)
- ✅ Gzip compression

### Caching Strategy
```
- Config: Cache forever (until deployment)
- Views: Cache until file changes
- Queries: Cache 5-60 minutes
- API Responses: Cache 1-5 minutes
- Static Assets: CDN cache (1 year)
```

---

**Document Version**: 1.0  
**Last Updated**: November 12, 2025  
**Maintained By**: Development Team
