# Technical Planning - PondasiKu

## System Architecture

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                         CLIENT LAYER                             │
├─────────────────────────────────────────────────────────────────┤
│  Vue 3 + Vite SPA (dengan Inertia.js)                           │
│  ├── TailwindCSS + HeadlessUI                                   │
│  ├── Pinia (State Management)                                   │
│  ├── Vue Router (via Inertia)                                   │
│  └── Axios (HTTP Client)                                        │
└─────────────────────────────────────────────────────────────────┘
                              │
                              │ Inertia.js Protocol
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                        API LAYER                                 │
├─────────────────────────────────────────────────────────────────┤
│  Laravel 10 (Backend API)                                       │
│  ├── Laravel Sanctum (Authentication)                          │
│  ├── Laravel Breeze (Auth Scaffold)                            │
│  ├── Middleware (CORS, Auth, Role)                              │
│  └── Controllers                                                │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                       SERVICE LAYER                              │
├─────────────────────────────────────────────────────────────────┤
│  ├── Product Service (CRUD, Stock Management)                   │
│  ├── Order Service (Order Processing)                           │
│  ├── Payment Service (Midtrans Integration)                      │
│  ├── Delivery Service (Shipping Calculation)                    │
│  ├── Calculator Service (Material Calculation)                  │
│  └── Notification Service (Email)                               │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                       DATA LAYER                                 │
├─────────────────────────────────────────────────────────────────┤
│  ├── MySQL/PostgreSQL (Primary Database)                        │
│  ├── File Cache (Laravel Cache)                                 │
│  └── Storage (Local/Cloudflare R2 for product images)           │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                     EXTERNAL SERVICES                            │
├─────────────────────────────────────────────────────────────────┤
│  ├── Payment Gateway (Midtrans Sandbox)                         │
│  ├── Email Service (Mailtrap)                                   │
│  └── RajaOngkir API (Cek Ongkir - Optional)                     │
└─────────────────────────────────────────────────────────────────┘
```

---

## Technology Stack

### Frontend
| Technology | Version | Purpose |
|------------|---------|---------|
| Vue.js | 3.x | Frontend Framework |
| Inertia.js | 1.x | SPA without API |
| Vite | 4.x | Build Tool |
| TailwindCSS | 3.x | CSS Framework |
| HeadlessUI | 1.x | UI Components |
| Pinia | 2.x | State Management |
| Axios | 1.x | HTTP Client |
| Heroicons | 2.x | Icons |
| Element Plus | 2.x | UI Components (existing) |
| Flowbite | 2.x | UI Components (existing) |

### Backend
| Technology | Version | Purpose |
|------------|---------|---------|
| Laravel | 10.x | PHP Framework |
| PHP | 8.1+ | Programming Language |
| Laravel Sanctum | 3.x | API Authentication |
| Laravel Breeze | 1.x | Auth Scaffold |
| MySQL | 8.x / PostgreSQL | Database |

### External Services
| Service | Purpose | Tier |
|---------|---------|------|
| Midtrans Sandbox | Payment Gateway (Demo) | FREE (sandbox mode) |
| Mailtrap | Email Service (Development) | FREE (1,000 emails/month) |
| RajaOngkir | Cek Ongkir (Optional) | FREE tier available |

### Hosting & Deployment (Free Tier)
| Service | Purpose | Tier |
|---------|---------|------|
| Vercel / Netlify | Frontend Hosting | FREE |
| Railway / Render | Backend Hosting | FREE ($5 credit/month) |
| Supabase / PlanetScale | Database | FREE (500MB - 5GB) |
| Cloudflare R2 | File Storage | FREE (10GB) |

### Development Tools (Free)
| Tool | Purpose | Tier |
|------|---------|------|
| GitHub | Version Control | FREE |
| GitHub Actions | CI/CD | FREE (2,000 minutes/month) |
| Mailtrap | Email Testing | FREE |
| ngrok | Local tunnel for webhook | FREE |

---

## Service Migration Path (Gratis → Berbayar)

### Phase 1: Development (Gratis)
```
┌─────────────────────────────────────────────────────────────────┐
│                    DEVELOPMENT ENVIRONMENT                       │
├─────────────────────────────────────────────────────────────────┤
│  Frontend: Local (npm run dev)                                  │
│  Backend: Local (php artisan serve)                             │
│  Database: MySQL Local / SQLite                                  │
│  Cache: File Cache (tanpa Redis)                                │
│  Email: Mailtrap (sandbox)                                      │
│  Payment: Midtrans Sandbox (GRATIS untuk demo)                  │
│  Storage: Local filesystem                                       │
└─────────────────────────────────────────────────────────────────┘
```

### Phase 2: Staging/Demo (Free Tier Cloud)
```
┌─────────────────────────────────────────────────────────────────┐
│                     STAGING/DEMO ENVIRONMENT                     │
├─────────────────────────────────────────────────────────────────┤
│  Frontend: Vercel / Netlify (FREE)                              │
│  Backend: Railway / Render (FREE $5 credit)                     │
│  Database: Supabase PostgreSQL (FREE 500MB)                    │
│  Cache: File Cache                                              │
│  Email: Mailtrap FREE (1,000 emails/month)                      │
│  Payment: Midtrans Sandbox (GRATIS untuk demo)                 │
│  Storage: Cloudflare R2 (FREE 10GB)                             │
└─────────────────────────────────────────────────────────────────┘
```

### Phase 3: Production (Berbayar - Future)
```
┌─────────────────────────────────────────────────────────────────┐
│                    PRODUCTION ENVIRONMENT                        │
├─────────────────────────────────────────────────────────────────┤
│  Frontend: Vercel Pro / Custom VPS                              │
│  Backend: VPS / Cloud Server                                    │
│  Database: Managed MySQL/PostgreSQL                             │
│  Cache: Redis Cloud                                              │
│  Email: Mailgun / SendGrid / Amazon SES                         │
│  Payment: Midtrans Production (~2% fee per transaksi)           │
│  Storage: S3 / Cloudflare R2                                    │
└─────────────────────────────────────────────────────────────────┘
```

---

## Database Schema

### Entity Relationship Diagram

```
┌──────────────┐       ┌──────────────┐       ┌──────────────┐
│    users     │       │   products   │       │  categories  │
├──────────────┤       ├──────────────┤       ├──────────────┤
│ id           │       │ id           │       │ id           │
│ name         │       │ name         │       │ name         │
│ email        │       │ slug         │       │ slug         │
│ password     │       │ category_id  │──────►│ image        │
│ phone        │       │ brand_id     │──────►│ is_active    │
│ role         │       │ price        │       │ created_at   │
│ is_active    │       │ stock        │       │ updated_at   │
│ created_at   │       │ min_stock    │       └──────────────┘
│ updated_at   │       │ unit         │              ▲
└──────────────┘       │ weight       │              │
       │               │ image        │       ┌──────────────┐
       │               │ description  │       │    brands    │
       │               │ is_active    │       ├──────────────┤
       │               │ created_at   │       │ id           │
       │               │ updated_at   │       │ name         │
       │               └──────────────┘       │ slug         │
       │                      │               │ image        │
       │                      │               │ is_active    │
       ▼                      ▼               │ created_at   │
┌──────────────┐       ┌──────────────┐       │ updated_at   │
│user_addresses│       │ product_images│      └──────────────┘
├──────────────┤       ├──────────────┤
│ id           │       │ id           │
│ user_id      │──────►│ product_id   │
│ label        │       │ image        │
│ recipient    │       │ is_primary   │
│ phone        │       │ created_at   │
│ province_id  │       └──────────────┘
│ city_id      │
│ address      │       ┌──────────────┐
│ postal_code  │       │    carts     │
│ is_default   │       ├──────────────┤
│ created_at   │       │ id           │
│ updated_at   │       │ user_id      │──────► users
└──────────────┘       │ product_id   │──────► products
                       │ quantity     │
┌──────────────┐       │ created_at   │
│    orders    │       │ updated_at   │
├──────────────┤       └──────────────┘
│ id           │
│ user_id      │──────►┌──────────────┐
│ order_number │       │ order_items  │
│ total        │       ├──────────────┤
│ shipping_fee │◄──────│ id           │
│ grand_total  │       │ order_id     │
│ status       │       │ product_id   │──────► products
│ payment_type │       │ product_name │
│ payment_id   │       │ price        │
│ shipping_type│       │ quantity     │
│ address_id   │       │ unit         │
│ notes        │       │ subtotal     │
│ delivered_at │       │ created_at   │
│ created_at   │       │ updated_at   │
│ updated_at   │       └──────────────┘
└──────────────┘
       │
       ▼
┌──────────────┐       ┌──────────────┐
│   payments   │       │delivery_areas│
├──────────────┤       ├──────────────┤
│ id           │       │ id           │
│ order_id     │       │ name         │
│ payment_type │       │ radius_km    │
│ payment_id   │       │ fee_per_km   │
│ gross_amount │       │ min_fee      │
│ status       │       │ is_active    │
│ transaction_ │       │ created_at   │
│ time         │       │ updated_at   │
│ raw_response │       └──────────────┘
│ created_at   │
│ updated_at   │       ┌──────────────┐
└──────────────┘       │   banners    │
                       ├──────────────┤
                       │ id           │
                       │ title        │
                       │ image        │
                       │ link         │
                       │ is_active    │
                       │ order        │
                       │ created_at   │
                       │ updated_at   │
                       └──────────────┘
```

---

### Table Definitions

#### users
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin', 'employee', 'customer', 'contractor') DEFAULT 'customer',
    is_active BOOLEAN DEFAULT TRUE,
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### categories
```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    image VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### brands
```sql
CREATE TABLE brands (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    image VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### products
```sql
CREATE TABLE products (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(400) UNIQUE NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT DEFAULT 0,              -- stok (existing: quantity)
    min_stock INT DEFAULT 10,            -- alert stok minimum (NEW)
    unit VARCHAR(20) DEFAULT 'pcs',      -- satuan: pcs, sak, kg, m, m2, m3 (NEW)
    weight DECIMAL(10,2) DEFAULT 0,      -- berat dalam kg (NEW)
    description LONGTEXT NULLABLE,
    published BOOLEAN DEFAULT FALSE,     -- existing field
    inStock BOOLEAN DEFAULT FALSE,       -- existing field
    category_id BIGINT UNSIGNED NULL,
    brand_id BIGINT UNSIGNED NULL,
    created_by BIGINT UNSIGNED NULL,     -- audit trail
    updated_by BIGINT UNSIGNED NULL,     -- audit trail
    deleted_by BIGINT UNSIGNED NULL,     -- soft delete audit
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,           -- soft delete
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE SET NULL
);

-- NEW FIELDS FOR PONDASIKU (add via migration):
-- ALTER TABLE products ADD COLUMN min_stock INT DEFAULT 10 AFTER quantity;
-- ALTER TABLE products ADD COLUMN unit VARCHAR(20) DEFAULT 'pcs' AFTER min_stock;
-- ALTER TABLE products ADD COLUMN weight DECIMAL(10,2) DEFAULT 0 AFTER unit;
```

#### product_images
```sql
CREATE TABLE product_images (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    image VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```

#### user_addresses
```sql
CREATE TABLE user_addresses (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    label VARCHAR(50), -- 'Rumah', 'Kantor', 'Proyek A', etc.
    recipient VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    province_id INT,
    city_id INT,
    address TEXT NOT NULL,
    postal_code VARCHAR(10),
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### orders
```sql
CREATE TABLE orders (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id VARCHAR(255) UNIQUE NOT NULL,     -- format: order-YYYY{user_id}{Hm-s}{rand}
    user_id BIGINT UNSIGNED NOT NULL,
    gross_amount DECIMAL(20,2) NOT NULL,       -- total produk
    status ENUM('Unpaid', 'Paid') DEFAULT 'Unpaid',  -- existing: simple status
    paid_at DATETIME NULL,                     -- waktu pembayaran
    
    -- Shipping info (existing pattern)
    courir VARCHAR(50) NULL,                   -- nama kurir: jne, pos, tiki
    courir_type VARCHAR(50) NULL,              -- jenis layanan: REG, OKE, YES
    courir_price DECIMAL(20,2) DEFAULT 0,       -- ongkir
    
    -- Address
    user_address_id BIGINT UNSIGNED NULL,
    
    -- Audit trail
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user_address_id) REFERENCES user_addresses(id) ON DELETE CASCADE
);

-- FUTURE ENHANCEMENT: Extend status enum
-- ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled', 'Unpaid', 'Paid');
```

#### order_items
```sql
CREATE TABLE order_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,        -- harga saat order
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);
```

#### carts
```sql
CREATE TABLE carts (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY user_product_unique (user_id, product_id)
);
```

#### payments
```sql
CREATE TABLE payments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    status ENUM('pending', 'Success') DEFAULT 'pending',
    type VARCHAR(50) DEFAULT 'online',         -- online/manual
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE RESTRICT
);
```

#### delivery_areas
```sql
CREATE TABLE delivery_areas (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    radius_km DECIMAL(5,2) NOT NULL,
    fee_per_km DECIMAL(10,2) NOT NULL,
    min_fee DECIMAL(10,2) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### banners
```sql
CREATE TABLE banners (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    image VARCHAR(255) NOT NULL,
    link VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    `order` INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

---

## API Contract

### Base URL
```
Development: http://localhost:8000
Production: https://pondasiku.com
```

### Authentication
- Menggunakan Laravel Sanctum dengan session-based auth (Inertia.js)
- CSRF protection enabled

---

### API Endpoints (via Inertia.js)

#### Authentication (Laravel Breeze)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /login | Show login form | No |
| POST | /login | Login user | No |
| POST | /logout | Logout user | Yes |
| GET | /register | Show register form | No |
| POST | /register | Register new user | No |

---

#### Products (User)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /product | List products (pagination, filter) | Yes |
| GET | /product/view/{slug} | Get product detail | Yes |

---

#### Products (Admin)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /admin/product/index | List all products | Admin |
| POST | /admin/product/store | Create product | Admin |
| PUT | /admin/product/update/{id} | Update product | Admin |
| DELETE | /admin/product/destroy/{id} | Delete product | Admin |
| DELETE | /admin/product/image/{id} | Delete product image | Admin |

---

#### Categories (Admin)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /admin/category/index | List categories | Admin |
| POST | /admin/category/store | Create category | Admin |
| PUT | /admin/category/update/{id} | Update category | Admin |
| DELETE | /admin/category/destroy/{id} | Delete category | Admin |

---

#### Brands (Admin)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /admin/brand/index | List brands | Admin |
| POST | /admin/brand/store | Create brand | Admin |
| PUT | /admin/brand/update/{id} | Update brand | Admin |
| DELETE | /admin/brand/destroy/{id} | Delete brand | Admin |

---

#### Cart

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /cart/show | Get user cart | Yes |
| POST | /cart/store/{product} | Add item to cart | Yes |
| PATCH | /cart/update/{product} | Update cart item | Yes |
| DELETE | /cart/delete/{product} | Remove from cart | Yes |

---

#### Checkout

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| POST | /checkout/order | Create order | Yes |

---

#### Orders

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /dashboard | User orders list | Yes |
| GET | /invoice/{id} | Order invoice | Yes |
| POST | /pay | Process payment | Yes |

---

#### Admin Orders

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /admin/order/index | List all orders | Admin |
| GET | /admin/order/invoice/{id} | Order invoice | Admin |

---

#### Address

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /address | List addresses | Yes |
| POST | /address/store | Create address | Yes |
| PUT | /address/update/{id} | Update address | Yes |
| DELETE | /address/delete/{id} | Delete address | Yes |
| GET | /address/province | Get provinces | Yes |
| GET | /address/{prov_id}/city | Get cities | Yes |

---

#### Admin Dashboard

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /admin/dashboard | Dashboard statistics | Admin |

---

#### Material Calculator (New)

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /calculator | Show calculator page | Yes |
| POST | /calculator/calculate | Calculate material | Yes |

---

## Material Calculator Formulas

### Kalkulator Cat
```php
// Input: luas_dinding (m²), jumlah_coating
// Output: jumlah kaleng cat (liter)

$luas_per_liter = 10; // 1 liter cat menutupi ±10 m² (2 lapis)
$jumlah_liter = ($luas_dinding / $luas_per_liter) * $jumlah_coating;
$jumlah_kaleng = ceil($jumlah_liter / 20); // Asumsi kaleng 20L atau sesuai produk
```

### Kalkulator Semen
```php
// Input: luas_area (m²), ketebalan (cm)
// Output: jumlah sak semen

$volume = $luas_area * ($ketebalan / 100); // m³
$semen_per_m3 = 7; // 7 sak semen per m³ beton
$jumlah_sak = ceil($volume * $semen_per_m3);
```

### Kalkulator Bata
```php
// Input: luas_dinding (m²)
// Output: jumlah bata, semen, pasir

$bata_per_m2 = 70; // 70 bata per m²
$jumlah_bata = $luas_dinding * $bata_per_m2;
$semen_bata = ceil($jumlah_bata / 100); // 1 sak semen per 100 bata
$pasir_bata = ceil($luas_dinding * 0.05); // 0.05 m³ pasir per m² dinding
```

### Kalkulator Besi Beton
```php
// Input: luas_lantai (m²), jenis (plat/lantai)
// Output: jumlah besi (batang)

// Untuk plat lantai
$besi_per_m2 = 8; // 8 batang besi per m² (dengan jarak 15cm)
$jumlah_besi = $luas_lantai * $besi_per_m2;
```

### Kalkulator Atap
```php
// Input: luas_atap (m²), jenis_material (genteng/seng)
// Output: jumlah material

// Genteng
$genteng_per_m2 = 15; // 15 genteng per m²
$jumlah_genteng = $luas_atap * $genteng_per_m2 * 1.05; // +5% cadangan

// Seng/Genteng Metal
$seng_per_m2 = 1.1; // 1.1 lembar per m² (dengan overlap)
$jumlah_seng = $luas_atap * $seng_per_m2;
```

---

## Cost Estimation

### MVP (Demo dengan Sandbox)
| Item | Cost |
|------|------|
| Frontend Hosting | FREE (Vercel) |
| Backend Hosting | FREE (Railway credit) |
| Database | FREE (Supabase) |
| Storage | FREE (Cloudflare R2) |
| Email | FREE (Mailtrap) |
| Payment | FREE (Midtrans Sandbox) |
| **Total** | **Rp 0/bulan** |

### Production (Berbayar - Estimasi)
| Item | Cost |
|------|------|
| VPS/Cloud Server | Rp 200.000 - 400.000/bulan |
| Domain | Rp 150.000/tahun |
| SSL Certificate | FREE (Let's Encrypt) |
| Midtrans Fee | ~2% per transaksi |
| **Total** | **Rp 200.000 - 400.000/bulan** |

---

## Deployment Strategy

### Development Workflow
1. Developer membuat branch dari `develop`
2. Implementasi fitur + unit test
3. Pull Request ke `develop`
4. Code review oleh tim
5. Merge setelah approval
6. Auto deploy ke staging

### Staging Environment
- Branch `develop` auto-deploy ke Railway/Vercel
- Testing dengan data dummy
- Midtrans Sandbox untuk payment testing

### Production Environment (Future)
- Branch `main` deploy manual
- Database migration manual
- Monitoring & logging enabled

---

## Security Considerations

1. **Authentication**
   - Laravel Sanctum dengan CSRF protection
   - Password hashing dengan bcrypt
   - Session timeout configuration

2. **Authorization**
   - Role-based access control (admin, employee, customer, contractor)
   - Middleware protection for admin routes

3. **Data Protection**
   - Input validation dengan Form Request
   - SQL injection prevention via Eloquent ORM
   - XSS prevention via Vue auto-escaping

4. **Payment Security**
   - Midtrans signature verification
   - HTTPS required for payment callback
   - No sensitive data stored in frontend

---

## Monitoring & Logging

1. **Application Logs**
   - Laravel Monolog untuk error logging
   - opcodesio/log-viewer untuk melihat logs

2. **Performance Monitoring**
   - Laravel Telescope (development)
   - Query logging untuk N+1 detection

3. **Uptime Monitoring**
   - UptimeRobot (FREE) untuk staging/production

---

## Team Structure (3 Orang)

| Role | Tanggung Jawab |
|------|----------------|
| **Tech Lead / Full-stack** | Architecture, code review, deployment, backend kompleks |
| **Backend Developer** | API development, database, payment integration |
| **Frontend Developer** | UI/UX implementation, Vue components, PWA features |

### Sprint Rituals
- **Sprint Planning** - Setiap awal sprint (2 jam)
- **Daily Standup** - Setiap hari (15 menit)
- **Sprint Review** - Akhir sprint (1 jam)
- **Sprint Retrospective** - Akhir sprint (30 menit)

---

## Implementation Notes (Replikasi dari Project Existing)

### Struktur Folder yang Sudah Ada
```
c:\laragon\www\pondasi-ku\
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # AdminController, BrandController, CategoryController, ProductController, OrderController
│   │   └── User/           # AddressController, CartController, CheckoutController, DashboardController, ProductController
│   ├── Models/             # User, Product, Category, Brand, Order, OrderItem, Cart, Payment, UserAddress
│   └── Helper/             # CartHelper (cookie vs DB cart)
├── resources/js/
│   ├── Layouts/            # App.vue, AdminLayout.vue, AuthenticatedLayout.vue, GuestLayout.vue
│   ├── Pages/
│   │   ├── Admin/          # Dashboard, Product/, Category/, Brand/, Order/
│   │   ├── User/           # Index, Dashboard, CartList, Checkout, Invoice, Payment, Product/, components/
│   │   └── Auth/           # Login, Register
│   └── Components/         # Reusable Vue components
├── routes/web.php          # Route definitions
└── database/migrations/    # Existing migrations
```

### Pola Controller yang Digunakan

#### 1. Inertia Response Pattern
```php
// Semua controller mengembalikan Inertia::render()
return Inertia::render('User/CartList', [
    'carts' => $carts,
    'total' => $total,
    'provinces' => $provinces,
]);
```

#### 2. Admin Controller Pattern
```php
// Admin/ProductController.php
public function index(Request $request) {
    $products = Product::query()
        ->with(['category', 'brand', 'product_images'])
        ->when($request->search, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();
    
    return Inertia::render('Admin/Product/Index', [
        'products' => $products,
        'brands' => Brand::all(),
        'categories' => Category::all(),
    ]);
}
```

#### 3. User Controller Pattern
```php
// User/CartController.php
public function store(Request $request, Product $product) {
    $user = $request->user();
    if($user) {
        // Save to database
        Cart::create([...]);
    } else {
        // Save to cookie via CartHelper
        CartHelper::setCookieCartItems($cartItems);
    }
}
```

### Pola Frontend yang Digunakan

#### 1. Layout Wrapper
```vue
<script setup>
import App from "@/Layouts/App.vue";
</script>

<template>
    <App>
        <!-- Page content -->
    </App>
</template>
```

#### 2. Inertia Router
```vue
<script setup>
import { router } from '@inertiajs/vue3';

// POST request
router.post(route('cart.store', product), { quantity: 1 });

// GET with preserve state
router.get('product', { brands: selectedBrands }, {
    preserveState: true,
    replace: true
});
</script>
```

#### 3. Computed Props dari Inertia
```vue
<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const carts = computed(() => usePage().props.carts);
const auth = usePage().props.auth;
</script>
```

### Modifikasi yang Diperlukan untuk PondasiKu

#### 1. Product Model - Tambah field baru
```php
// Migration: add_material_fields_to_products_table.php
Schema::table('products', function (Blueprint $table) {
    $table->integer('min_stock')->default(10)->after('quantity');
    $table->string('unit', 20)->default('pcs')->after('min_stock');
    $table->decimal('weight', 10, 2)->default(0)->after('unit');
});
```

#### 2. Product Controller - Tambah unit display
```php
// Admin/ProductController.php - store()
$product->unit = $request->unit;           // NEW
$product->weight = $request->weight;       // NEW
$product->min_stock = $request->min_stock; // NEW
```

#### 3. Vue Component - Tampilkan unit
```vue
<!-- ProductCard.vue -->
<p class="text-sm font-medium">
    Rp {{ Number(product.price).toLocaleString() }} / {{ product.unit }}
</p>
```

#### 4. Controller Baru - Material Calculator
```php
// User/CalculatorController.php (NEW)
class CalculatorController extends Controller {
    public function index() {
        return Inertia::render('User/Calculator/Index');
    }
    
    public function calculate(Request $request) {
        $type = $request->type;
        $result = match($type) {
            'cat' => $this->calculatePaint($request),
            'cement' => $this->calculateCement($request),
            'brick' => $this->calculateBrick($request),
            default => null
        };
        
        return response()->json($result);
    }
}
```

### Route yang Perlu Ditambahkan
```php
// routes/web.php - Tambah untuk PondasiKu
Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator.index');
Route::post('/calculator/calculate', [CalculatorController::class, 'calculate'])->name('calculator.calculate');
```

### File Baru yang Perlu Dibuat

| File | Deskripsi |
|------|-----------|
| `app/Http/Controllers/User/CalculatorController.php` | Controller kalkulator material |
| `resources/js/Pages/User/Calculator/Index.vue` | Halaman kalkulator |
| `resources/js/Components/CalculatorCard.vue` | Komponen kalkulator |
| `database/migrations/..._add_material_fields_to_products_table.php` | Migration field baru |

### Checklist Replikasi Sprint 1

- [ ] Copy project structure (sudah ada)
- [ ] Update branding (logo, warna, nama)
- [ ] Tambah migration field baru (unit, weight, min_stock)
- [ ] Update Product model dengan field baru
- [ ] Update ProductController (admin) untuk handle field baru
- [ ] Update Vue components untuk tampilkan unit
- [ ] Buat CalculatorController dan halaman kalkulator
- [ ] Test flow: product → cart → checkout → payment
