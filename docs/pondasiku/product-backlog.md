# Product Backlog - PondasiKu

## MoSCoW Prioritization

### Legend
- **Must Have** - Fitur wajib untuk MVP, tanpa ini produk tidak bisa beroperasi
- **Should Have** - Fitur penting tapi bisa ditunda ke sprint berikutnya
- **Could Have** - Fitur bagus jika ada, tapi tidak kritikal
- **Won't Have** - Fitur untuk versi future, tidak di scope saat ini

---

## Must Have (MVP - Sprint 1-4)

| Priority | Story ID | User Story | Story Points | Sprint |
|----------|----------|------------|--------------|--------|
| M-01 | US-001 | Registrasi Pelanggan | 3 | Sprint 1 |
| M-02 | US-002 | Login User | 2 | Sprint 1 |
| M-03 | US-003 | Logout User | 1 | Sprint 1 |
| M-04 | US-006 | Tambah Produk Baru | 5 | Sprint 1 |
| M-05 | US-007 | Edit Produk | 3 | Sprint 1 |
| M-06 | US-009 | Manajemen Kategori | 3 | Sprint 1 |
| M-07 | US-010 | Upload Gambar Produk | 5 | Sprint 1 |
| M-08 | US-043 | Manajemen Brand | 3 | Sprint 1 |
| M-09 | US-012 | Melihat Daftar Produk | 3 | Sprint 2 |
| M-10 | US-013 | Filter Produk by Kategori | 2 | Sprint 2 |
| M-11 | US-015 | Melihat Detail Produk | 2 | Sprint 2 |
| M-12 | US-016 | Tambah ke Keranjang | 3 | Sprint 2 |
| M-13 | US-017 | Lihat Isi Keranjang | 2 | Sprint 2 |
| M-14 | US-018 | Ubah Jumlah di Keranjang | 2 | Sprint 2 |
| M-15 | US-019 | Hapus dari Keranjang | 1 | Sprint 2 |
| M-16 | US-021 | Proses Checkout | 5 | Sprint 3 |
| M-17 | US-022 | Pilih Metode Pengiriman | 2 | Sprint 3 |
| M-18 | US-023 | Pembayaran via Payment Gateway (Sandbox) | 13 | Sprint 3 |
| M-19 | US-024 | Konfirmasi Pembayaran | 5 | Sprint 3 |
| M-20 | US-025 | Lihat Riwayat Pesanan | 3 | Sprint 3 |
| M-21 | US-027 | Update Status Pesanan | 2 | Sprint 4 |
| M-22 | US-011 | Update Stok Produk | 2 | Sprint 4 |
| M-23 | US-041 | Manajemen Alamat Pengiriman | 5 | Sprint 4 |

**Total Must Have: 77 Story Points**

---

## Should Have (Sprint 5-6)

| Priority | Story ID | User Story | Story Points | Sprint |
|----------|----------|------------|--------------|--------|
| S-01 | US-005 | Edit Profil | 2 | Sprint 5 |
| S-02 | US-008 | Hapus Produk | 2 | Sprint 5 |
| S-03 | US-014 | Pencarian Produk | 3 | Sprint 5 |
| S-04 | US-020 | Kalkulasi Ongkir | 8 | Sprint 5 |
| S-05 | US-026 | Tracking Status Pesanan | 3 | Sprint 5 |
| S-06 | US-029 | Dashboard Statistik | 8 | Sprint 5 |
| S-07 | US-032 | Alert Stok Minimum | 3 | Sprint 5 |
| S-08 | US-040 | Material Calculator | 13 | Sprint 6 |
| S-09 | US-033 | Atur Area Delivery | 5 | Sprint 6 |
| S-10 | US-034 | Assign Kurir ke Pesanan | 5 | Sprint 6 |
| S-11 | US-035 | Install PWA ke Home Screen | 3 | Sprint 6 |

**Total Should Have: 55 Story Points**

---

## Could Have (Future Enhancement)

| Priority | Story ID | User Story | Story Points | Catatan |
|----------|----------|------------|--------------|---------|
| C-01 | US-004 | Lupa Password | 5 | Bisa manual dulu |
| C-02 | US-028 | Batalkan Pesanan | 5 | Refund butuh koordinasi payment gateway |
| C-03 | US-030 | Laporan Penjualan | 8 | Manual export dulu |
| C-04 | US-031 | Manajemen User | 3 | Admin bisa kelola via DB |
| C-05 | US-036 | Akses Offline | 8 | PWA caching |
| C-06 | US-037 | Push Notification Pesanan | 8 | Web Push API |
| C-07 | US-038 | Push Notification Promo | 5 | Broadcast |
| C-08 | US-039 | Background Sync | 8 | Offline order sync |
| C-09 | US-023B | Payment Gateway Integration | 13 | BERBAYAR - Midtrans/Xendit production |
| C-10 | US-044 | Sistem Harga Grosir | 8 | Diskon untuk kontraktor |
| C-11 | US-045 | Manajemen Piutang | 13 | Pembayaran bertahap |
| C-12 | US-046 | Jadwal Pengiriman | 5 | Booking waktu kirim |

**Total Could Have: 89 Story Points**

---

## Won't Have (Out of Scope)

| Priority | Story ID | User Story | Catatan |
|----------|----------|------------|---------|
| W-01 | - | Multi-toko / Franchise | Versi 2.0 |
| W-02 | - | Marketplace Multi-seller | Di luar bisnis model |
| W-03 | - | Integrasi POS/Kasir Fisik | Butuh hardware |
| W-04 | - | Mobile App Native | Menggunakan PWA sebagai alternatif |
| W-05 | - | Integrasi Software Akuntansi | Future enhancement |
| W-06 | - | Inventory Multi-Gudang | Sprint 7+ |
| W-07 | - | Loyalty Points System | Future enhancement |

---

## Sprint Allocation

### Sprint 1: Foundation (22 SP)
- Autentikasi dasar (login, register, logout)
- CRUD Produk & Kategori
- Upload gambar
- Manajemen Brand

**File yang sudah ada (tinggal modifikasi branding):**
- `app/Http/Controllers/Admin/ProductController.php` ✓
- `app/Http/Controllers/Admin/CategoryController.php` ✓
- `app/Http/Controllers/Admin/BrandController.php` ✓
- `resources/js/Pages/Admin/Product/Index.vue` ✓
- `resources/js/Pages/Admin/Category/Index.vue` ✓
- `resources/js/Pages/Admin/Brand/Index.vue` ✓

**File yang perlu dibuat:**
- Migration: `add_material_fields_to_products_table.php`

### Sprint 2: Catalog & Cart (13 SP)
- Tampilan katalog
- Filter kategori
- Detail produk
- Keranjang belanja (CRUD)

**File yang sudah ada:**
- `app/Http/Controllers/User/ProductController.php` ✓
- `app/Http/Controllers/User/CartController.php` ✓
- `resources/js/Pages/User/Product/Index.vue` ✓
- `resources/js/Pages/User/CartList.vue` ✓
- `app/Helper/CartHelper.php` ✓ (Cookie vs DB cart)

**Modifikasi yang diperlukan:**
- Tambah tampilan `unit` di product card dan cart

### Sprint 3: Checkout & Payment (28 SP)
- Checkout flow
- Pilih pengiriman
- Payment Gateway (Midtrans Sandbox - GRATIS untuk demo)
- Konfirmasi pembayaran
- Riwayat pesanan

**File yang sudah ada:**
- `app/Http/Controllers/User/CheckoutController.php` ✓
- `app/Http/Controllers/User/DashboardController.php` ✓
- `resources/js/Pages/User/Checkout/` ✓
- `resources/js/Pages/User/Payment.vue` ✓
- `resources/js/Pages/User/Invoice.vue` ✓
- `resources/js/Pages/User/Dashboard.vue` ✓

**Konfigurasi yang sudah ada:**
- Midtrans Sandbox sudah terkonfigurasi di `config/midtrans.php`
- RajaOngkir API untuk ongkir sudah ada

### Sprint 4: Order Management (7 SP)
- Update status pesanan
- Update stok
- Manajemen alamat

**File yang sudah ada:**
- `app/Http/Controllers/Admin/OrderController.php` ✓
- `app/Http/Controllers/User/AddressController.php` ✓
- `resources/js/Pages/Admin/Order/` ✓

### Sprint 5: Enhancement (29 SP)
- Edit profil
- Pencarian
- Kalkulasi ongkir
- Tracking pesanan
- Dashboard statistik
- Alert stok

**File yang sudah ada:**
- `resources/js/Pages/Profile/` ✓
- Search sudah ada di `ProductController@index`
- Dashboard admin sudah ada

### Sprint 6: Material Calculator + Delivery + PWA (26 SP)
- Material Calculator (fitur khusus)
- Area delivery
- Assign kurir
- PWA installable

**File yang PERLU DIBUAT:**
- `app/Http/Controllers/User/CalculatorController.php` (NEW)
- `resources/js/Pages/User/Calculator/Index.vue` (NEW)
- `resources/js/Components/CalculatorCard.vue` (NEW)
- `database/migrations/..._create_delivery_areas_table.php` (NEW)
- `app/Http/Controllers/Admin/DeliveryAreaController.php` (NEW)
- PWA manifest & service worker (NEW)

---

## Velocity Calculation

| Sprint | Story Points | Team Capacity |
|--------|--------------|---------------|
| Sprint 1 | 22 | 25 SP/sprint |
| Sprint 2 | 13 | 20 SP/sprint |
| Sprint 3 | 28 | 30 SP/sprint |
| Sprint 4 | 7 | 20 SP/sprint |
| Sprint 5 | 29 | 30 SP/sprint |
| Sprint 6 | 26 | 30 SP/sprint |

**Total: 125 Story Points dalam 6 Sprint (~12 minggu)**

**Notes:**
- MVP menggunakan Midtrans Sandbox (GRATIS untuk demo)
- Payment Gateway Production (US-023B) masuk Could Have untuk fase future

---

## Definition of Ready (DoR)

Sebuah User Story siap dikerjakan jika:
- [ ] User story sudah ditulis dengan format standar
- [ ] Acceptance criteria sudah terdefinisi dengan jelas
- [ ] Story points sudah diestimasi
- [ ] Dependencies sudah teridentifikasi
- [ ] Technical approach sudah didiskusikan
- [ ] UI mockup sudah tersedia (jika ada UI)

---

## Backlog Status

| Status | Jumlah Story | Story Points |
|--------|--------------|--------------|
| Ready for Sprint | 23 | 132 |
| In Backlog | 12 | 89 |
| Future Consideration | 7 | - |
| **Total** | **42** | **221** |

**MVP (Must Have + Should Have): 132 SP**
