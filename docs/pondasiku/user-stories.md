# User Stories - PondasiKu

## Epic Overview

| Epic ID | Epic Name | Deskripsi |
|---------|-----------|-----------|
| E-01 | Authentication | Registrasi, login, logout, profil user |
| E-02 | Product Management | CRUD produk, kategori, brand, gambar, stok |
| E-03 | Catalog & Search | Tampilan produk, filter, pencarian |
| E-04 | Shopping Cart | Keranjang belanja, kalkulasi harga |
| E-05 | Checkout & Payment | Proses checkout, integrasi payment gateway |
| E-06 | Order Management | Status pesanan, tracking, history |
| E-07 | Admin Dashboard | Statistik, laporan, manajemen |
| E-08 | Delivery System | Pengaturan ongkir, area delivery |
| E-09 | PWA Features | Installable, offline, push notification |
| E-10 | Material Calculator | Kalkulator kebutuhan material bangunan |
| E-11 | Address Management | Manajemen alamat pengiriman |

---

## E-01: Authentication

### US-001: Registrasi Pelanggan Baru
**Sebagai** pelanggan baru, **saya ingin** mendaftar akun, **sehingga** saya bisa bertransaksi di toko.

**Acceptance Criteria:**
- Given saya di halaman registrasi
- When saya mengisi nama, email, password, nomor HP yang valid
- Then akun saya berhasil dibuat dan saya mendapat notifikasi sukses

**Acceptance Criteria (Negative):**
- Given saya mengisi email yang sudah terdaftar
- When saya submit form
- Then muncul pesan error "Email sudah terdaftar"

---

### US-002: Login User
**Sebagai** user terdaftar, **saya ingin** login ke akun, **sehingga** saya bisa mengakses fitur sesuai role saya.

**Acceptance Criteria:**
- Given saya memiliki akun yang valid
- When saya memasukkan email dan password yang benar
- Then saya berhasil login dan diarahkan ke halaman sesuai role

---

### US-003: Logout User
**Sebagai** user yang sedang login, **saya ingin** logout, **sehingga** akun saya aman dari akses tidak sah.

**Acceptance Criteria:**
- Given saya sedang login
- When saya klik tombol logout
- Then sesi saya berakhir dan diarahkan ke halaman utama

---

### US-004: Lupa Password
**Sebagai** user yang lupa password, **saya ingin** reset password via email, **sehingga** saya bisa mengakses akun kembali.

**Acceptance Criteria:**
- Given saya di halaman lupa password
- When saya memasukkan email terdaftar
- Then link reset password dikirim ke email saya

---

### US-005: Edit Profil
**Sebagai** user, **saya ingin** mengedit profil saya, **sehingga** data saya selalu up-to-date.

**Acceptance Criteria:**
- Given saya sedang login
- When saya mengubah nama, nomor HP, atau alamat
- Then data profil saya berhasil diperbarui

---

## E-02: Product Management

### US-006: Tambah Produk Baru
**Sebagai** admin, **saya ingin** menambahkan produk baru, **sehingga** produk tersedia di katalog.

**Acceptance Criteria:**
- Given saya di halaman admin produk
- When saya mengisi nama, kategori, brand, harga, stok, satuan, deskripsi, dan gambar
- Then produk baru berhasil ditambahkan dan muncul di katalog

---

### US-007: Edit Produk
**Sebagai** admin, **saya ingin** mengedit data produk, **sehingga** informasi produk selalu akurat.

**Acceptance Criteria:**
- Given saya memilih produk yang akan diedit
- When saya mengubah data produk
- Then perubahan berhasil disimpan

---

### US-008: Hapus Produk
**Sebagai** admin, **saya ingin** menghapus produk, **sehingga** produk yang tidak dijual tidak muncul di katalog.

**Acceptance Criteria:**
- Given saya memilih produk yang akan dihapus
- When saya konfirmasi penghapusan
- Then produk dihapus dari database dan tidak muncul di katalog

---

### US-009: Manajemen Kategori
**Sebagai** admin, **saya ingin** membuat dan mengelola kategori, **sehingga** produk terorganisir dengan baik.

**Acceptance Criteria:**
- Given saya di halaman kategori
- When saya menambah/edit/hapus kategori
- Then perubahan berhasil disimpan

---

### US-010: Upload Gambar Produk
**Sebagai** admin, **saya ingin** mengupload gambar produk, **sehingga** pelanggan bisa melihat tampilan produk.

**Acceptance Criteria:**
- Given saya sedang menambah/edit produk
- When saya upload gambar (format jpg/png, max 5MB)
- Then gambar berhasil diupload dan ditampilkan

---

### US-011: Update Stok Produk
**Sebagai** admin/karyawan, **saya ingin** mengupdate stok produk, **sehingga** ketersediaan produk akurat.

**Acceptance Criteria:**
- Given saya memilih produk
- When saya mengubah jumlah stok
- Then stok produk berhasil diperbarui

---

### US-043: Manajemen Brand
**Sebagai** admin, **saya ingin** mengelola brand/merk produk, **sehingga** pelanggan bisa filter berdasarkan brand.

**Acceptance Criteria:**
- Given saya di halaman brand
- When saya menambah/edit/hapus brand
- Then perubahan berhasil disimpan

---

## E-03: Catalog & Search

### US-012: Melihat Daftar Produk
**Sebagai** pelanggan, **saya ingin** melihat daftar produk, **sehingga** saya bisa memilih produk yang ingin dibeli.

**Acceptance Criteria:**
- Given saya di halaman katalog
- When halaman dimuat
- Then ditampilkan daftar produk dengan gambar, nama, harga, satuan, dan ketersediaan stok

---

### US-013: Filter Produk by Kategori
**Sebagai** pelanggan, **saya ingin** memfilter produk berdasarkan kategori, **sehingga** saya mudah menemukan produk yang dicari.

**Acceptance Criteria:**
- Given saya di halaman katalog
- When saya memilih kategori tertentu
- Then hanya produk dari kategori tersebut yang ditampilkan

---

### US-014: Pencarian Produk
**Sebagai** pelanggan, **saya ingin** mencari produk dengan kata kunci, **sehingga** saya cepat menemukan produk spesifik.

**Acceptance Criteria:**
- Given saya di halaman katalog
- When saya mengetik kata kunci di search bar
- Then ditampilkan produk yang namanya mengandung kata kunci tersebut

---

### US-015: Melihat Detail Produk
**Sebagai** pelanggan, **saya ingin** melihat detail produk, **sehingga** saya mendapat informasi lengkap sebelum membeli.

**Acceptance Criteria:**
- Given saya klik produk tertentu
- When halaman detail terbuka
- Then ditampilkan gambar lengkap, nama, harga, satuan, deskripsi, stok, dan tombol add to cart

---

## E-04: Shopping Cart

### US-016: Tambah ke Keranjang
**Sebagai** pelanggan, **saya ingin** menambahkan produk ke keranjang, **sehingga** saya bisa mengumpulkan produk yang akan dibeli.

**Acceptance Criteria:**
- Given saya di halaman detail produk
- When saya klik "Tambah ke Keranjang" dengan jumlah tertentu
- Then produk masuk ke keranjang dan badge keranjang terupdate

---

### US-017: Lihat Isi Keranjang
**Sebagai** pelanggan, **saya ingin** melihat isi keranjang, **sehingga** saya tahu produk apa saja yang akan dibeli.

**Acceptance Criteria:**
- Given saya klik ikon keranjang
- When halaman keranjang terbuka
- Then ditampilkan daftar produk, jumlah, harga satuan, dan subtotal

---

### US-018: Ubah Jumlah di Keranjang
**Sebagai** pelanggan, **saya ingin** mengubah jumlah produk di keranjang, **sehingga** saya bisa menyesuaikan pesanan.

**Acceptance Criteria:**
- Given saya di halaman keranjang
- When saya mengubah jumlah produk (tambah/kurang)
- Then total harga otomatis terupdate

---

### US-019: Hapus dari Keranjang
**Sebagai** pelanggan, **saya ingin** menghapus produk dari keranjang, **sehingga** saya bisa membatalkan pembelian produk tertentu.

**Acceptance Criteria:**
- Given saya di halaman keranjang
- When saya klik hapus pada produk tertentu
- Then produk dihapus dari keranjang dan total diupdate

---

### US-020: Kalkulasi Ongkir
**Sebagai** pelanggan, **saya ingin** melihat estimasi ongkir berdasarkan alamat, **sehingga** saya tahu total biaya sebelum checkout.

**Acceptance Criteria:**
- Given saya di halaman keranjang
- When saya memasukkan alamat pengiriman
- Then ditampilkan estimasi ongkir berdasarkan jarak

---

## E-05: Checkout & Payment

### US-021: Proses Checkout
**Sebagai** pelanggan, **saya ingin** melakukan checkout, **sehingga** pesanan saya diproses.

**Acceptance Criteria:**
- Given saya di halaman keranjang dengan produk di dalamnya
- When saya klik "Checkout" dan mengisi alamat pengiriman
- Then saya diarahkan ke halaman pembayaran

---

### US-022: Pilih Metode Pengiriman
**Sebagai** pelanggan, **saya ingin** memilih metode pengiriman, **sehingga** pesanan dikirim sesuai preferensi saya.

**Acceptance Criteria:**
- Given saya di halaman checkout
- When saya memilih "Delivery" atau "Pickup"
- Then metode pengiriman tersimpan dan ongkir ditampilkan (jika delivery)

---

### US-023: Pembayaran via Payment Gateway (Sandbox untuk Demo)
**Sebagai** pelanggan, **saya ingin** membayar via payment gateway, **sehingga** saya bisa test flow pembayaran lengkap untuk demo.

**Acceptance Criteria:**
- Given saya di halaman pembayaran
- When saya memilih metode (QRIS/VA/e-wallet) dan menyelesaikan pembayaran di sandbox
- Then status pesanan berubah menjadi "Paid" dan saya mendapat notifikasi

**Notes:** Menggunakan Midtrans Sandbox untuk demo. GRATIS, simulasi pembayaran lengkap.

---

### US-023B: Payment Gateway Production (Future)
**Sebagai** pelanggan, **saya ingin** membayar dengan uang sungguhan via payment gateway, **sehingga** transaksi real bisa diproses.

**Acceptance Criteria:**
- Given saya di halaman pembayaran
- When saya memilih metode (QRIS/VA/e-wallet) dan menyelesaikan pembayaran
- Then status pesanan otomatis berubah menjadi "Paid" dan uang masuk ke rekening toko

**Notes:** Memerlukan akun Midtrans/Xendit production, fee ~2% per transaksi.

---

### US-024: Konfirmasi Pembayaran
**Sebagai** pelanggan, **saya ingin** mendapat konfirmasi pembayaran, **sehingga** saya yakin transaksi berhasil.

**Acceptance Criteria:**
- Given pembayaran berhasil (sandbox atau production)
- When sistem menerima callback dari payment gateway
- Then saya mendapat notifikasi dengan detail pesanan

---

## E-06: Order Management

### US-025: Lihat Riwayat Pesanan
**Sebagai** pelanggan, **saya ingin** melihat riwayat pesanan, **sehingga** saya bisa tracking pesanan saya.

**Acceptance Criteria:**
- Given saya login sebagai pelanggan
- When saya buka halaman "Pesanan Saya"
- Then ditampilkan daftar pesanan dengan status terkini

---

### US-026: Tracking Status Pesanan
**Sebagai** pelanggan, **saya ingin** melihat status pesanan real-time, **sehingga** saya tahu progress pengiriman.

**Acceptance Criteria:**
- Given saya memilih pesanan tertentu
- When halaman detail pesanan terbuka
- Then ditampilkan timeline status (Pending → Paid → Processing → Shipped → Delivered)

---

### US-027: Update Status Pesanan (Admin/Karyawan)
**Sebagai** admin/karyawan, **saya ingin** mengupdate status pesanan, **sehingga** pelanggan tahu progress pesanannya.

**Acceptance Criteria:**
- Given saya memilih pesanan
- When saya mengubah status pesanan
- Then status berhasil diupdate dan pelanggan mendapat notifikasi

---

### US-028: Batalkan Pesanan
**Sebagai** pelanggan, **saya ingin** membatalkan pesanan, **sehingga** saya tidak jadi membeli.

**Acceptance Criteria:**
- Given pesanan masih status "Pending" atau "Paid" dan belum dikirim
- When saya klik "Batalkan Pesanan"
- Then pesanan dibatalkan dan uang dikembalikan (jika sudah bayar)

---

## E-07: Admin Dashboard

### US-029: Dashboard Statistik
**Sebagai** admin, **saya ingin** melihat statistik penjualan, **sehingga** saya bisa analisa performa toko.

**Acceptance Criteria:**
- Given saya login sebagai admin
- When saya buka halaman dashboard
- Then ditampilkan total penjualan, pesanan, produk terlaris, dan grafik

---

### US-030: Laporan Penjualan
**Sebagai** admin, **saya ingin** melihat dan mengunduh laporan penjualan, **sehingga** saya bisa analisa lebih lanjut.

**Acceptance Criteria:**
- Given saya di halaman laporan
- When saya memilih periode dan klik "Export"
- Then laporan terdownload dalam format PDF/Excel

---

### US-031: Manajemen User
**Sebagai** admin, **saya ingin** melihat dan mengelola user, **sehingga** saya bisa kontrol akses sistem.

**Acceptance Criteria:**
- Given saya di halaman manajemen user
- When saya melihat daftar user atau mengubah role
- Then perubahan berhasil disimpan

---

### US-032: Alert Stok Minimum
**Sebagai** admin, **saya ingin** mendapat notifikasi stok minimum, **sehingga** saya bisa restock tepat waktu.

**Acceptance Criteria:**
- Given ada produk dengan stok di bawah threshold
- When saya buka dashboard
- Then ditampilkan daftar produk dengan stok rendah

---

## E-08: Delivery System

### US-033: Atur Area Delivery
**Sebagai** admin, **saya ingin** mengatur area dan biaya delivery, **sehingga** ongkir dihitung otomatis.

**Acceptance Criteria:**
- Given saya di halaman pengaturan delivery
- When saya mengatur radius dan tarif per km
- Then pengaturan berhasil disimpan

---

### US-034: Assign Kurir ke Pesanan
**Sebagai** admin, **saya ingin** menugaskan kurir ke pesanan, **sehingga** pengiriman terorganisir.

**Acceptance Criteria:**
- Given ada pesanan dengan metode delivery
- When saya assign karyawan sebagai kurir
- Then kurir mendapat notifikasi dan pelanggan bisa tracking

---

## E-09: PWA Features

### US-035: Install Aplikasi ke Home Screen
**Sebagai** pelanggan, **saya ingin** menginstall aplikasi ke home screen HP, **sehingga** saya bisa akses cepat tanpa buka browser.

**Acceptance Criteria:**
- Given saya mengakses web app via browser
- When muncul prompt install PWA
- Then aplikasi terinstall dan muncul di home screen

---

### US-036: Akses Offline
**Sebagai** pelanggan, **saya ingin** mengakses aplikasi dalam mode offline, **sehingga** saya tetap bisa lihat katalog meski tidak ada internet.

**Acceptance Criteria:**
- Given saya sudah pernah mengakses aplikasi
- When saya buka aplikasi tanpa koneksi internet
- Then ditampilkan halaman katalog dari cache

---

### US-037: Push Notification Pesanan
**Sebagai** pelanggan, **saya ingin** menerima push notification untuk update pesanan, **sehingga** saya tahu status pesanan secara real-time.

**Acceptance Criteria:**
- Given saya sudah subscribe notification
- When ada perubahan status pesanan saya
- Then saya menerima push notification di device

---

### US-038: Push Notification Promo
**Sebagai** pelanggan, **saya ingin** menerima notifikasi promo, **sehingga** saya tidak ketinggalan diskon.

**Acceptance Criteria:**
- Given admin mengirim broadcast promo
- When saya termasuk target audience
- Then saya menerima notifikasi promo

---

### US-039: Background Sync
**Sebagai** pelanggan, **saya ingin** pesanan saya tersinkronisasi saat online kembali, **sehingga** data tidak hilang saat offline.

**Acceptance Criteria:**
- Given saya membuat pesanan saat offline
- When koneksi internet tersedia kembali
- Then pesanan otomatis terkirim ke server

---

## E-10: Material Calculator

### US-040: Material Calculator
**Sebagai** pelanggan, **saya ingin** menghitung kebutuhan material otomatis, **sehingga** saya tahu berapa banyak material yang harus dibeli.

**Acceptance Criteria:**
- Given saya di halaman kalkulator material
- When saya memilih jenis kalkulator dan menginput dimensi/luas
- Then ditampilkan jumlah material yang dibutuhkan dan saya bisa langsung tambah ke keranjang

**Kalkulator yang tersedia:**
- Kalkulator Cat (input: luas dinding → output: jumlah kaleng cat)
- Kalkulator Semen (input: luas area → output: jumlah sak semen)
- Kalkulator Bata (input: luas dinding → output: jumlah bata)
- Kalkulator Besi (input: luas lantai → output: jumlah besi beton)
- Kalkulator Atap (input: luas atap → output: jumlah genteng/seng)

---

## E-11: Address Management

### US-041: Manajemen Alamat Pengiriman
**Sebagai** pelanggan, **saya ingin** mengelola beberapa alamat pengiriman, **sehingga** saya bisa kirim ke lokasi proyek yang berbeda.

**Acceptance Criteria:**
- Given saya sedang login
- When saya menambah/edit/hapus alamat
- Then alamat berhasil disimpan dan bisa dipilih saat checkout

---

### US-042: Pilih Alamat saat Checkout
**Sebagai** pelanggan, **saya ingin** memilih alamat pengiriman saat checkout, **sehingga** pesanan dikirim ke lokasi yang tepat.

**Acceptance Criteria:**
- Given saya di halaman checkout
- When saya memilih alamat dari daftar atau menambah alamat baru
- Then alamat terpilih dan ongkir terupdate

---

## Story Point Estimation (Fibonacci)

| Story ID | Story Points | Alasan |
|----------|--------------|--------|
| US-001 | 3 | Form validasi + email verification |
| US-002 | 2 | Simple auth |
| US-003 | 1 | Logout simple |
| US-004 | 5 | Email service integration |
| US-005 | 2 | CRUD profil |
| US-006 | 5 | CRUD + image upload |
| US-007 | 3 | CRUD edit |
| US-008 | 2 | Soft delete |
| US-009 | 3 | CRUD kategori |
| US-010 | 5 | File upload handling |
| US-011 | 2 | Update field |
| US-012 | 3 | List + pagination |
| US-013 | 2 | Filter query |
| US-014 | 3 | Search functionality |
| US-015 | 2 | Detail page |
| US-016 | 3 | Cart logic |
| US-017 | 2 | Display cart |
| US-018 | 2 | Update quantity |
| US-019 | 1 | Remove item |
| US-020 | 8 | Distance calculation + pricing |
| US-021 | 5 | Checkout flow |
| US-022 | 2 | Radio selection |
| US-023 | 13 | Payment Gateway (Sandbox - GRATIS untuk demo) |
| US-023B | 13 | Payment Gateway Production (FUTURE - berbayar) |
| US-024 | 5 | Callback handling + notification |
| US-025 | 3 | List orders |
| US-026 | 3 | Status timeline |
| US-027 | 2 | Update status |
| US-028 | 5 | Cancel + refund logic |
| US-029 | 8 | Dashboard + charts |
| US-030 | 8 | Report generation |
| US-031 | 3 | User management |
| US-032 | 3 | Alert system |
| US-033 | 5 | Delivery config |
| US-034 | 5 | Assignment system |
| US-035 | 3 | PWA manifest + install prompt |
| US-036 | 8 | Service worker + caching strategy |
| US-037 | 8 | Web Push API integration |
| US-038 | 5 | Broadcast notification |
| US-039 | 8 | Background sync implementation |
| US-040 | 13 | Multiple calculator formulas + UI |
| US-041 | 5 | CRUD alamat + provinsi/kota API |
| US-042 | 2 | Select alamat |
| US-043 | 3 | CRUD brand |

**Total Story Points: 181**

**Notes:**
- US-023 (Payment Gateway Sandbox) = GRATIS untuk demo
- US-023B (Payment Gateway Production) = FUTURE, fee ~2% per transaksi
- US-040 (Material Calculator) = Fitur khusus untuk toko material bangunan

---

## Implementation Status (berdasarkan Project Existing)

### User Stories yang SUDAH ADA implementasinya

| Story ID | Status | File yang Sudah Ada |
|----------|--------|---------------------|
| US-001 | ✓ Ada | Laravel Breeze auth scaffold |
| US-002 | ✓ Ada | `app/Http/Controllers/Auth/*.php` |
| US-003 | ✓ Ada | Logout via Breeze |
| US-006 | ✓ Ada | `Admin/ProductController.php@store` |
| US-007 | ✓ Ada | `Admin/ProductController.php@update` |
| US-008 | ✓ Ada | `Admin/ProductController.php@destroy` |
| US-009 | ✓ Ada | `Admin/CategoryController.php` |
| US-010 | ✓ Ada | Image upload di ProductController |
| US-011 | ✓ Ada | Update quantity di ProductController |
| US-012 | ✓ Ada | `User/ProductController.php@index` |
| US-013 | ✓ Ada | Filter via `scopeFiltered` di Product model |
| US-015 | ✓ Ada | `User/ProductController.php@view` |
| US-016 | ✓ Ada | `User/CartController.php@store` |
| US-017 | ✓ Ada | `User/CartController.php@show` |
| US-018 | ✓ Ada | `User/CartController.php@update` |
| US-019 | ✓ Ada | `User/CartController.php@destroy` |
| US-021 | ✓ Ada | `User/CheckoutController.php@store` |
| US-023 | ✓ Ada | Midtrans di `User/DashboardController.php@store` |
| US-024 | ✓ Ada | Webhook `DashboardController@response` |
| US-025 | ✓ Ada | `User/DashboardController.php@index` |
| US-027 | ✓ Ada | Admin OrderController |
| US-041 | ✓ Ada | `User/CartController.php@addAddress` |
| US-043 | ✓ Ada | `Admin/BrandController.php` |

### User Stories yang PERLU DIMODIFIKASI

| Story ID | Modifikasi yang Diperlukan |
|----------|---------------------------|
| US-006 | Tambah field: unit, weight, min_stock |
| US-007 | Tambah field: unit, weight, min_stock |
| US-012 | Tampilkan unit di product card |
| US-015 | Tampilkan unit di detail produk |
| US-017 | Tampilkan unit di cart list |

### User Stories yang PERLU DIBUAT (NEW)

| Story ID | Deskripsi | Sprint |
|----------|-----------|--------|
| US-040 | Material Calculator | Sprint 6 |
| US-033 | Delivery Area Management | Sprint 6 |
| US-034 | Assign Kurir | Sprint 6 |
| US-035 | PWA Install | Sprint 6 |

### Quick Win - Estimasi Effort

| Kategori | Jumlah US | Effort |
|----------|-----------|--------|
| Sudah Ada (tinggal branding) | 23 US | ~20% effort |
| Perlu Modifikasi | 5 US | ~30% effort |
| Perlu Dibuat Baru | 14 US | ~50% effort |
