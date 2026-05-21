# Discovery Phase - PondasiKu

## Ringkasan Proyek
Aplikasi e-commerce untuk toko material bangunan dengan nama **PondasiKu**.

---

## Stakeholder

| Stakeholder | Peran |
|-------------|-------|
| Pemilik Toko | Mengelola semua aspek bisnis, melihat laporan, kelola produk & pesanan |
| Karyawan | Membantu proses pesanan, update status, packing & delivery |
| Pelanggan (Pemilik Rumah) | Membeli material untuk kebutuhan pribadi, konsultasi |
| Pelanggan (Kontraktor) | Pembelian bulk, harga khusus, piutang |

---

## Model Bisnis

### Pengiriman
- **Delivery lokal** - Radius 10-20km dengan armada toko sendiri
- **Pickup di toko** - Pelanggan ambil langsung
- **Jadwal pengiriman** - Booking waktu pengiriman sesuai kebutuhan proyek

### Pembayaran
- **Demo/Testing**: Midtrans Sandbox (GRATIS - untuk demo)
- **Production Future**: Payment Gateway (Midtrans/Xendit) - ~2% fee per transaksi
- **Piutang**: Sistem pembayaran bertahap untuk kontraktor terpercaya (manual dulu)

### Payment Methods (Demo)
- Midtrans Sandbox (simulasi QRIS, VA, e-wallet, kartu)

### Skala Produk
- **200-1000 produk** dengan multiple kategori dan variasi

---

## Kategori Produk Material Bangunan

1. **Bahan Dasar** - Semen, pasir, kerikil, batu bata, batako
2. **Besi & Logam** - Besi beton, hollow, seng, alumunium
3. **Kayu & Triplek** - Kayu bangunan, triplek, MDF, papan
4. **Atap & Plafon** - Genteng, spandek, plafon PVC, rangka atap
5. **Cat & Finishing** - Cat tembok, cat kayu, pelapis, thinner
6. **Pipa & Sanitasi** - Pipa PVC, pipa besi, sanitasi, keran
7. **Listrik & Elektronik** - Kabel, saklar, stop kontak, lampu
8. **Perkakas & Alat** - Alat bangunan, perkakas tangan, alat ukur
9. **Lainnya** - Kunci, engsel, baut, mur, paku

---

## Pain Points (Masalah yang Diharapkan Teratasi)

1. **Perhitungan manual** - Pelanggan bingung hitung kebutuhan material
2. **Stok tidak real-time** - Pelanggan datang tapi stok kosong
3. **Koordinasi pengiriman** - Jadwal pengiriman sering bentrok
4. **Harga tidak transparan** - Harga berbeda untuk pelanggan berbeda
5. **Piutang tidak terkelola** - Sulit tracking hutang kontraktor
6. **Jangkauan terbatas** - Hanya pelanggan yang datang ke toko

---

## Goals (Tujuan)

1. Menyediakan kalkulator kebutuhan material otomatis
2. Otomatisasi manajemen stok dengan update real-time
3. Memudahkan penjadwalan pengiriman
4. Menyediakan sistem harga transparan (normal vs grosir)
5. Menyediakan sistem manajemen piutang sederhana
6. Meningkatkan jangkauan pelanggan hingga radius 20km

---

## Non-Goals (Bukan Tujuan Saat Ini)

- Multi-toko / franchise system
- Marketplace untuk banyak penjual
- Integrasi dengan sistem kasir fisik (POS)
- Aplikasi mobile native (menggunakan PWA sebagai alternatif cross-platform)
- Desktop application
- Integrasi dengan software akuntansi
- Sistem inventory multi-gudang

---

## Fitur Khusus Material Bangunan

### Material Calculator
| Kalkulator | Input | Output |
|------------|-------|--------|
| Kalkulator Cat | Luas dinding (m²) | Jumlah kaleng cat, primer, thinner |
| Kalkulator Semen | Luas area, ketebalan | Jumlah sak semen, pasir |
| Kalkulator Bata | Luas dinding | Jumlah bata, semen, pasir |
| Kalkulator Besi | Luas lantai, jenis | Jumlah besi, wire mesh |
| Kalkulator Atap | Luas atap | Jumlah genteng/seng, rangka |

### Sistem Harga
| Tipe Pelanggan | Diskon |
|----------------|--------|
| Pelanggan Biasa | Harga normal |
| Kontraktor Terdaftar | Diskon 5-10% |
| Developer/Proyek Besar | Diskon 10-15% + piutang |

---

## Timeline Proyek (Demo)

| Fase | Durasi | Output | Status |
|------|--------|--------|--------|
| Sprint 1 | 2 minggu | Foundation (Auth, Product CRUD) - **SUDAH ADA** | Ready to modify |
| Sprint 2 | 2 minggu | Catalog & Cart - **SUDAH ADA** | Ready to modify |
| Sprint 3 | 2 minggu | Checkout & Payment - **SUDAH ADA** | Ready to modify |
| Sprint 4 | 2 minggu | Order Management - **SUDAH ADA** | Ready to modify |
| Sprint 5 | 2 minggu | Enhancement | Perlu tambahan |
| Sprint 6 | 2 minggu | Material Calculator + PWA | **BARU DIBUAT** |
| **Total** | **12 minggu** | **Demo Ready** | |

**Catatan Penting:**
- Sprint 1-4 sudah memiliki implementasi dasar dari project existing
- Fokus utama: Update branding + tambah field material (unit, weight, min_stock)
- Sprint 6 adalah fitur baru khusus PondasiKu (Material Calculator)

---

## Infrastruktur (FREE Tier)

| Komponen | Service | Tier |
|----------|---------|------|
| Frontend Hosting | Vercel / Netlify | FREE |
| Backend Hosting | Railway / Render | FREE ($5 credit) |
| Database | Supabase / PlanetScale | FREE (500MB-5GB) |
| File Storage | Cloudflare R2 | FREE (10GB) |
| Payment Gateway | Midtrans Sandbox | FREE (demo) |
| Email | Mailtrap | FREE (1,000/month) |
| CI/CD | GitHub Actions | FREE (2,000 min/month) |
