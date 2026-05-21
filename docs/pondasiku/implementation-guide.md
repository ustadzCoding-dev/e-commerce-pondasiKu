# Implementation Guide - PondasiKu

## Overview

Dokumen ini berisi panduan replikasi langkah demi langkah dari project existing (Sembako Digital) menjadi **PondasiKu** (Toko Material Bangunan).

---

## Ringkasan Status Implementasi

| Kategori | Jumlah | Persentase |
|----------|--------|------------|
| **Sudah Ada** (tinggal branding) | 23 fitur | 55% |
| **Perlu Modifikasi** | 5 fitur | 12% |
| **Perlu Dibuat Baru** | 14 fitur | 33% |

**Estimasi Total Effort:** ~50% dari development dari nol

---

## Fase 1: Setup & Branding (Sprint 1)

### 1.1 Update Environment

```bash
# Update .env
APP_NAME="PondasiKu"
APP_URL=http://pondasiku.test

# Database (gunakan yang sudah ada)
DB_DATABASE=pondasiku
```

### 1.2 Update Branding

#### File yang Perlu Diubah:

| File | Ubah Menjadi |
|------|--------------|
| `resources/js/Components/ApplicationLogo.vue` | Logo PondasiKu |
| `resources/js/Layouts/App.vue` | Warna primary jadi orange |
| `resources/js/Pages/User/components/Navbar.vue` | Logo + menu PondasiKu |
| `resources/js/Pages/User/components/Footer.vue` | Info PondasiKu |
| `tailwind.config.js` | Primary color: orange-500 |

#### Tailwind Config Update:
```javascript
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#F97316', // orange-500
          dark: '#EA580C',    // orange-600
          light: '#FDBA74',   // orange-300
        },
        secondary: {
          DEFAULT: '#0EA5E9', // sky-500
        }
      }
    }
  }
}
```

### 1.3 Tambah Field Material ke Products

#### Migration:
```bash
php artisan make:migration add_material_fields_to_products_table
```

```php
// database/migrations/xxxx_add_material_fields_to_products_table.php
Schema::table('products', function (Blueprint $table) {
    $table->integer('min_stock')->default(10)->after('quantity');
    $table->string('unit', 20)->default('pcs')->after('min_stock');
    $table->decimal('weight', 10, 2)->default(0)->after('unit');
});
```

```bash
php artisan migrate
```

#### Update Model:
```php
// app/Models/Product.php
protected $fillable = [
    'title', 'slug', 'price', 'quantity', 'description',
    'published', 'inStock', 'category_id', 'brand_id',
    'min_stock', 'unit', 'weight', // NEW
];

protected $casts = [
    'price' => 'decimal:2',
    'weight' => 'decimal:2',
];

// Accessor untuk display unit
public function getUnitDisplayAttribute(): string
{
    return match($this->unit) {
        'pcs' => 'pcs',
        'sak' => 'sak',
        'kg' => 'kg',
        'm' => 'm',
        'm2' => 'm²',
        'm3' => 'm³',
        'lbr' => 'lembar',
        'btg' => 'batang',
        default => $this->unit,
    };
}
```

#### Update Controller:
```php
// app/Http/Controllers/Admin/ProductController.php

// Di method store()
$product->min_stock = $request->min_stock ?? 10;
$product->unit = $request->unit ?? 'pcs';
$product->weight = $request->weight ?? 0;

// Di method update()
$product->min_stock = $request->min_stock;
$product->unit = $request->unit;
$product->weight = $request->weight;
```

---

## Fase 2: Update UI Components (Sprint 2)

### 2.1 Product Card - Tampilkan Unit

```vue
<!-- resources/js/Pages/User/Index.vue -->
<!-- Ubah display harga -->
<p class="text-sm font-medium text-gray-900">
    Rp {{ Number(product.price).toLocaleString() }} / {{ product.unit }}
</p>
```

### 2.2 Product List - Tampilkan Unit

```vue
<!-- resources/js/Pages/User/Product/Index.vue -->
<!-- Di product card -->
<div class="flex justify-between">
    <p class="text-gray-900 font-semibold">{{ product.title }}</p>
    <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ product.unit }}</span>
</div>
<p class="text-sm font-medium">
    Rp {{ Number(product.price).toLocaleString() }} / {{ product.unit_display }}
</p>
```

### 2.3 Cart List - Tampilkan Unit

```vue
<!-- resources/js/Pages/User/CartList.vue -->
<!-- Di cart item -->
<div class="flex items-center gap-2">
    <span class="font-semibold">{{ product.title }}</span>
    <span class="text-xs text-gray-500">({{ product.unit }})</span>
</div>
```

### 2.4 Admin Product Form - Input Unit

```vue
<!-- resources/js/Pages/Admin/Product/Create.vue (ataus di modal) -->
<div class="grid grid-cols-3 gap-4">
    <div>
        <InputLabel value="Harga" />
        <TextInput type="number" v-model="form.price" />
    </div>
    <div>
        <InputLabel value="Stok" />
        <TextInput type="number" v-model="form.quantity" />
    </div>
    <div>
        <InputLabel value="Satuan" />
        <select v-model="form.unit" class="border rounded-md px-3 py-2">
            <option value="pcs">Pcs (Pieces)</option>
            <option value="sak">Sak</option>
            <option value="kg">Kg (Kilogram)</option>
            <option value="m">m (Meter)</option>
            <option value="m2">m² (Meter Persegi)</option>
            <option value="m3">m³ (Meter Kubik)</option>
            <option value="lbr">Lembar</option>
            <option value="btg">Batang</option>
        </select>
    </div>
</div>
<div class="grid grid-cols-2 gap-4 mt-4">
    <div>
        <InputLabel value="Berat (kg)" />
        <TextInput type="number" step="0.01" v-model="form.weight" />
    </div>
    <div>
        <InputLabel value="Min. Stok Alert" />
        <TextInput type="number" v-model="form.min_stock" />
    </div>
</div>
```

---

## Fase 3: Material Calculator (Sprint 6)

### 3.1 Buat Controller

```php
// app/Http/Controllers/User/CalculatorController.php
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalculatorController extends Controller
{
    public function index()
    {
        return Inertia::render('User/Calculator/Index');
    }

    public function calculate(Request $request)
    {
        $type = $request->type;
        $result = match($type) {
            'cat' => $this->calculatePaint($request),
            'cement' => $this->calculateCement($request),
            'brick' => $this->calculateBrick($request),
            'steel' => $this->calculateSteel($request),
            'roof' => $this->calculateRoof($request),
            default => ['error' => 'Kalkulator tidak ditemukan']
        };

        return response()->json($result);
    }

    private function calculatePaint(Request $request): array
    {
        $luas = (float) $request->luas_dinding; // m²
        $coating = (int) $request->jumlah_coating; // 1-3

        $luas_per_liter = 10; // 1 liter = 10 m² (2 lapis)
        $jumlah_liter = ($luas / $luas_per_liter) * $coating;
        $jumlah_kaleng_20l = ceil($jumlah_liter / 20);
        $jumlah_kaleng_5l = ceil($jumlah_liter / 5);
        $jumlah_kaleng_1l = ceil($jumlah_liter);

        return [
            'type' => 'cat',
            'input' => ['luas' => $luas, 'coating' => $coating],
            'output' => [
                'total_liter' => round($jumlah_liter, 1),
                'kaleng_20l' => $jumlah_kaleng_20l,
                'kaleng_5l' => $jumlah_kaleng_5l,
                'kaleng_1l' => $jumlah_kaleng_1l,
            ],
            'tips' => 'Tambahkan 10% cadangan untuk antisipasi.',
        ];
    }

    private function calculateCement(Request $request): array
    {
        $luas = (float) $request->luas_area; // m²
        $tebal = (float) $request->ketebalan; // cm

        $volume = $luas * ($tebal / 100); // m³
        $semen_per_m3 = 7; // sak
        $pasir_per_m3 = 0.5; // m³

        return [
            'type' => 'semen',
            'input' => ['luas' => $luas, 'tebal' => $tebal],
            'output' => [
                'volume_m3' => round($volume, 2),
                'semen_sak' => ceil($volume * $semen_per_m3),
                'pasir_m3' => round($volume * $pasir_per_m3, 2),
            ],
        ];
    }

    private function calculateBrick(Request $request): array
    {
        $luas = (float) $request->luas_dinding; // m²

        $bata_per_m2 = 70;
        $jumlah_bata = $luas * $bata_per_m2;
        $semen = ceil($jumlah_bata / 100); // 1 sak per 100 bata
        $pasir = round($luas * 0.05, 2); // 0.05 m³ per m²

        return [
            'type' => 'bata',
            'input' => ['luas' => $luas],
            'output' => [
                'bata_pcs' => ceil($jumlah_bata),
                'semen_sak' => $semen,
                'pasir_m3' => $pasir,
            ],
        ];
    }

    private function calculateSteel(Request $request): array
    {
        $luas = (float) $request->luas_lantai; // m²
        $jenis = $request->jenis; // 'plat' atau 'pondasi'

        $besi_per_m2 = 8; // batang per m²
        $jumlah_besi = $luas * $besi_per_m2;

        return [
            'type' => 'besi',
            'input' => ['luas' => $luas, 'jenis' => $jenis],
            'output' => [
                'besi_batang' => ceil($jumlah_besi),
                'wire_mesh_m2' => $luas,
            ],
        ];
    }

    private function calculateRoof(Request $request): array
    {
        $luas = (float) $request->luas_atap; // m²
        $material = $request->material; // 'genteng' atau 'seng'

        if ($material === 'genteng') {
            $genteng_per_m2 = 15;
            $jumlah = ceil($luas * $genteng_per_m2 * 1.05); // +5% cadangan
            $unit = 'pcs';
        } else {
            $seng_per_m2 = 1.1; // dengan overlap
            $jumlah = ceil($luas * $seng_per_m2);
            $unit = 'lembar';
        }

        return [
            'type' => 'atap',
            'input' => ['luas' => $luas, 'material' => $material],
            'output' => [
                'material' => $material,
                'jumlah' => $jumlah,
                'unit' => $unit,
            ],
        ];
    }
}
```

### 3.2 Tambah Route

```php
// routes/web.php
Route::get('/calculator', [App\Http\Controllers\User\CalculatorController::class, 'index'])
    ->name('calculator.index');
Route::post('/calculator/calculate', [App\Http\Controllers\User\CalculatorController::class, 'calculate'])
    ->name('calculator.calculate');
```

### 3.3 Buat Vue Page

```vue
<!-- resources/js/Pages/User/Calculator/Index.vue -->
<script setup>
import App from "@/Layouts/App.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import axios from "axios";

const activeTab = ref('cat');
const result = ref(null);
const loading = ref(false);

const forms = {
    cat: { luas_dinding: '', jumlah_coating: 2 },
    cement: { luas_area: '', ketebalan: '' },
    brick: { luas_dinding: '' },
    steel: { luas_lantai: '', jenis: 'plat' },
    roof: { luas_atap: '', material: 'genteng' },
};

const currentForm = ref({ ...forms.cat });

const calculate = async () => {
    loading.value = true;
    try {
        const response = await axios.post(route('calculator.calculate'), {
            type: activeTab.value,
            ...currentForm.value
        });
        result.value = response.data;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};

const selectTab = (tab) => {
    activeTab.value = tab;
    currentForm.value = { ...forms[tab] };
    result.value = null;
};
</script>

<template>
    <App>
        <Head title="Kalkulator Material" />
        
        <div class="max-w-4xl mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">
                🧮 Kalkulator Material Bangunan
            </h1>
            
            <!-- Tabs -->
            <div class="flex gap-2 mb-6 overflow-x-auto">
                <button 
                    v-for="tab in ['cat', 'cement', 'brick', 'steel', 'roof']"
                    :key="tab"
                    @click="selectTab(tab)"
                    :class="[
                        'px-4 py-2 rounded-lg font-medium transition',
                        activeTab === tab 
                            ? 'bg-orange-500 text-white' 
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                    ]"
                >
                    {{ tab === 'cat' ? 'Cat' : tab === 'cement' ? 'Semen' : tab === 'brick' ? 'Bata' : tab === 'steel' ? 'Besi' : 'Atap' }}
                </button>
            </div>
            
            <!-- Form -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <!-- Cat Form -->
                <div v-if="activeTab === 'cat'" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Luas Dinding (m²)</label>
                        <input type="number" v-model="currentForm.luas_dinding" 
                            class="w-full border rounded-md px-3 py-2" placeholder="Contoh: 100" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Jumlah Coating</label>
                        <select v-model="currentForm.jumlah_coating" class="w-full border rounded-md px-3 py-2">
                            <option :value="1">1 Lapis</option>
                            <option :value="2">2 Lapis</option>
                            <option :value="3">3 Lapis</option>
                        </select>
                    </div>
                </div>
                
                <!-- Cement Form -->
                <div v-if="activeTab === 'cement'" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Luas Area (m²)</label>
                        <input type="number" v-model="currentForm.luas_area" 
                            class="w-full border rounded-md px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Ketebalan (cm)</label>
                        <input type="number" v-model="currentForm.ketebalan" 
                            class="w-full border rounded-md px-3 py-2" placeholder="Contoh: 10" />
                    </div>
                </div>
                
                <!-- Brick Form -->
                <div v-if="activeTab === 'brick'" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Luas Dinding (m²)</label>
                        <input type="number" v-model="currentForm.luas_dinding" 
                            class="w-full border rounded-md px-3 py-2" />
                    </div>
                </div>
                
                <!-- Steel Form -->
                <div v-if="activeTab === 'steel'" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Luas Lantai (m²)</label>
                        <input type="number" v-model="currentForm.luas_lantai" 
                            class="w-full border rounded-md px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Jenis</label>
                        <select v-model="currentForm.jenis" class="w-full border rounded-md px-3 py-2">
                            <option value="plat">Plat Lantai</option>
                            <option value="pondasi">Pondasi</option>
                        </select>
                    </div>
                </div>
                
                <!-- Roof Form -->
                <div v-if="activeTab === 'roof'" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Luas Atap (m²)</label>
                        <input type="number" v-model="currentForm.luas_atap" 
                            class="w-full border rounded-md px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Material</label>
                        <select v-model="currentForm.material" class="w-full border rounded-md px-3 py-2">
                            <option value="genteng">Genteng Keramik</option>
                            <option value="seng">Seng/Genteng Metal</option>
                        </select>
                    </div>
                </div>
                
                <button 
                    @click="calculate"
                    :disabled="loading"
                    class="mt-4 w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 rounded-md transition"
                >
                    {{ loading ? 'Menghitung...' : 'Hitung Kebutuhan' }}
                </button>
            </div>
            
            <!-- Result -->
            <div v-if="result" class="bg-green-50 border border-green-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-green-800 mb-4">✅ Hasil Perhitungan</h2>
                <div class="space-y-2">
                    <div v-for="(value, key) in result.output" :key="key" class="flex justify-between">
                        <span class="text-gray-600">{{ key.replace('_', ' ') }}:</span>
                        <span class="font-medium">{{ value }}</span>
                    </div>
                </div>
                <p v-if="result.tips" class="mt-4 text-sm text-gray-500 italic">
                    💡 {{ result.tips }}
                </p>
            </div>
        </div>
    </App>
</template>
```

---

## Fase 4: PWA Setup (Sprint 6)

### 4.1 Buat Manifest

```json
// public/manifest.json
{
    "name": "PondasiKu - Toko Material Bangunan",
    "short_name": "PondasiKu",
    "description": "Belanja material bangunan online dengan kalkulator kebutuhan",
    "start_url": "/",
    "display": "standalone",
    "background_color": "#F8FAFC",
    "theme_color": "#F97316",
    "icons": [
        {
            "src": "/images/icons/icon-192.png",
            "sizes": "192x192",
            "type": "image/png"
        },
        {
            "src": "/images/icons/icon-512.png",
            "sizes": "512x512",
            "type": "image/png"
        }
    ]
}
```

### 4.2 Tambah ke Blade Layout

```blade
<!-- resources/views/app.blade.php -->
<head>
    <!-- ... existing ... -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#F97316">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
</head>
```

### 4.3 Service Worker (Basic)

```javascript
// public/sw.js
const CACHE_NAME = 'pondasiku-v1';
const urlsToCache = [
    '/',
    '/product',
    '/calculator',
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});
```

---

## Checklist Sprint 1

### Backend
- [ ] Migration: `add_material_fields_to_products_table`
- [ ] Update `Product.php` model dengan fillable baru
- [ ] Update `Admin/ProductController.php` untuk handle field baru
- [ ] Buat `User/CalculatorController.php`

### Frontend
- [ ] Update `ApplicationLogo.vue` dengan logo PondasiKu
- [ ] Update `tailwind.config.js` dengan warna primary orange
- [ ] Update `Navbar.vue` dengan menu PondasiKu
- [ ] Update `ProductCard` untuk tampilkan unit
- [ ] Update `CartList.vue` untuk tampilkan unit
- [ ] Buat `Calculator/Index.vue`

### Route
- [ ] Tambah route calculator di `web.php`

### Testing
- [ ] Test CRUD produk dengan field baru
- [ ] Test kalkulator material
- [ ] Test flow: product → cart → checkout → payment

---

## Quick Reference: File yang Perlu Diubah

| File | Perubahan |
|------|-----------|
| `.env` | APP_NAME=PondasiKu |
| `tailwind.config.js` | Primary color orange |
| `app/Models/Product.php` | Tambah fillable: unit, weight, min_stock |
| `app/Http/Controllers/Admin/ProductController.php` | Handle field baru |
| `resources/js/Components/ApplicationLogo.vue` | Logo baru |
| `resources/js/Pages/User/Index.vue` | Tampilkan unit |
| `resources/js/Pages/User/Product/Index.vue` | Tampilkan unit |
| `resources/js/Pages/User/CartList.vue` | Tampilkan unit |
| `routes/web.php` | Tambah route calculator |

---

## Quick Reference: File yang Perlu Dibuat

| File | Deskripsi |
|------|-----------|
| `database/migrations/..._add_material_fields_to_products_table.php` | Migration field baru |
| `app/Http/Controllers/User/CalculatorController.php` | Controller kalkulator |
| `resources/js/Pages/User/Calculator/Index.vue` | Halaman kalkulator |
| `public/manifest.json` | PWA manifest |
| `public/sw.js` | Service worker |

---

## Estimasi Timeline

| Sprint | Fokus | Durasi | Effort |
|--------|-------|--------|--------|
| 1 | Branding + Migration | 2 minggu | 20% |
| 2 | UI Updates (unit display) | 2 minggu | 15% |
| 3 | Testing existing flow | 2 minggu | 10% |
| 4 | Order Management | 2 minggu | 10% |
| 5 | Enhancement | 2 minggu | 20% |
| 6 | Calculator + PWA | 2 minggu | 25% |

**Total: 12 minggu untuk Demo Ready**
