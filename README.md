# PondasiKu - Toko Material Bangunan Online

E-commerce platform untuk material bangunan dengan fitur kalkulator material, shipping, dan payment gateway.

## 🏗️ Fitur Utama

- **Katalog Produk** - Produk material bangunan dengan satuan (sak, kg, m², dll)
- **Kalkulator Material** - Hitung kebutuhan cat, semen, bata, besi, atap
- **Shipping** - Integrasi RajaOngkir (dengan mock data untuk demo)
- **Payment** - Integrasi Midtrans
- **Admin Dashboard** - Kelola produk, kategori, brand, order

## 🛠️ Tech Stack

| Backend | Frontend |
|---------|----------|
| Laravel 10 | Vue 3 + Vite |
| MySQL | TailwindCSS |
| Sanctum API | Inertia.js |
| Midtrans | Element Plus |

## 📥 Instalasi

```bash
# Clone repository
git clone https://github.com/USERNAME/pondasi-ku.git
cd pondasi-ku

# Install dependencies
composer install
npm install

# Setup environment
copy .env.example .env
php artisan key:generate

# Edit .env - sesuaikan database
# DB_DATABASE=pondasiku_db
# DB_USERNAME=root
# DB_PASSWORD=

# Run migration & seeder
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=BrandSeeder

# Build frontend
npm run build

# Jalankan aplikasi
php artisan serve
```

## 🔐 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@pondasiku.com` | `password` |
| Customer | `user@pondasiku.com` | `password` |

## ⚙️ Konfigurasi API

### RajaOngkir (Opsional)
Daftar gratis di [rajaongkir.com](https://rajaongkir.com) untuk mendapatkan API key:
```env
RAJAONGKIR_API_KEY=your_api_key_here
SHIPPING_PROVIDER=mock
```
**Tanpa API key:** Aplikasi menggunakan mock data shipping untuk demo.

### Midtrans
Sudah terkonfigurasi dengan sandbox mode untuk testing.

## 📂 Struktur Folder

```
pondasi-ku/
├── app/Http/Controllers/
│   ├── Admin/          # Controller admin
│   └── User/           # Controller user + CalculatorController
├── database/seeders/   # Seeder untuk demo
├── resources/js/
│   ├── Pages/          # Halaman Vue (Inertia)
│   └── Components/     # Komponen Vue
└── routes/web.php      # Routing
```

## 🧮 Kalkulator Material

Akses di `/calculator` - 5 jenis kalkulator:
- **Cat** - Hitung kebutuhan cat berdasarkan luas dinding
- **Semen** - Hitung semen, pasir, kerikil untuk beton
- **Bata** - Hitung bata merah untuk dinding
- **Besi** - Hitung besi tulangan untuk plat/pondasi
- **Atap** - Hitung genteng/seng dan rangka atap

## 📝 License

MIT License - Silakan gunakan untuk keperluan pembelajaran dan pengembangan.
