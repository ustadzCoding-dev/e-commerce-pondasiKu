# Design System - PondasiKu

## Brand Identity

### Logo Variants
| File | Penggunaan |
|------|------------|
| `primary-logo.svg` | Logo utama untuk header website, email |
| `horizontal-logo.svg` | Logo horizontal untuk navbar, footer |
| `app-icon.svg` | Ikon aplikasi (mobile app, PWA) |
| `favicon.ico` | Favicon browser |

### Warna Brand (Material Bangunan Theme)

| Warna | Hex Code | Penggunaan |
|-------|----------|------------|
| **Primary** | `#F97316` | Button, accent, header (Orange - simbol energi & material) |
| **Primary Dark** | `#EA580C` | Hover state, active |
| **Primary Light** | `#FDBA74` | Background accent |
| **Secondary** | `#0EA5E9` | Badge, info, link (Blue - simbol kepercayaan) |
| **Background** | `#F8FAFC` | Page background |
| **Surface** | `#FFFFFF` | Card, modal background |
| **Text Primary** | `#1E293B` | Heading, body text |
| **Text Secondary** | `#64748B` | Description, placeholder |
| **Border** | `#E2E8F0` | Divider, border |
| **Success** | `#22C55E` | Success message, stock available |
| **Warning** | `#EAB308` | Warning, low stock |
| **Error** | `#EF4444` | Error, out of stock |

---

## Typography

### Font Family
- **Primary**: Inter (Google Fonts)
- **Fallback**: system-ui, sans-serif

### Font Sizes
| Name | Size | Weight | Penggunaan |
|------|------|--------|------------|
| Display | 36px | 700 | Hero title |
| H1 | 28px | 700 | Page title |
| H2 | 24px | 600 | Section title |
| H3 | 20px | 600 | Card title |
| H4 | 18px | 500 | Subsection |
| Body | 16px | 400 | Body text |
| Small | 14px | 400 | Caption, helper |
| XSmall | 12px | 400 | Badge, tag |

---

## Spacing System

| Name | Value | Penggunaan |
|------|-------|------------|
| xs | 4px | Icon spacing |
| sm | 8px | Compact padding |
| md | 16px | Default padding |
| lg | 24px | Section padding |
| xl | 32px | Container padding |
| 2xl | 48px | Large section |

---

## Border Radius

| Name | Value | Penggunaan |
|------|-------|------------|
| sm | 4px | Badge, tag |
| md | 8px | Button, input |
| lg | 12px | Card |
| xl | 16px | Modal, large card |
| full | 9999px | Pill button, avatar |

---

## Components

### 1. Navigation (Desktop)
```
┌─────────────────────────────────────────────────────────────────┐
│ [Logo] PondasiKu    Home  Produk  Kalkulator  Tentang  [Cart] [Login] │
└─────────────────────────────────────────────────────────────────┘
```
- Sticky on scroll
- Primary color on hover

### 2. Navigation (Mobile)
```
┌─────────────────────┐
│ [Logo]    [☰]       │
└─────────────────────┘

Hamburger Menu:
┌─────────────────────┐
│ Home                │
│ Produk              │
│ Kalkulator Material │
│ Tentang Kami        │
│ ─────────────────── │
│ Login / Register    │
└─────────────────────┘
```

### 3. Product Card
```
┌─────────────────────┐
│ [Product Image]     │
│                     │
│ Kategori            │
│ Nama Produk         │
│ Rp XX.XXX / unit    │
│ Stok: XX unit       │
│ [ + Keranjang ]     │
└─────────────────────┘
```
- Rounded corners (12px)
- Shadow: subtle
- Image aspect ratio: 1:1
- Unit display (pcs, sak, kg, m, m²)

### 4. Category Card
```
┌─────────────┐
│   [Icon]    │
│  Kategori   │
│   Nama      │
└─────────────┘
```
- Horizontal scroll on mobile
- Grid on tablet/desktop

### 5. Search Bar
```
┌─────────────────────────────────┐
│ 🔍 Cari material bangunan...    │
└─────────────────────────────────┘
```
- Fixed on top when scroll (optional)
- Rounded full

### 6. Cart Badge
```
    ┌───┐
🛒 │ 2 │
    └───┘
```
- Primary color background
- White text
- Positioned top-right of icon

### 7. Material Calculator Card
```
┌─────────────────────────────────┐
│ 🧮 Kalkulator Cat               │
│                                 │
│ Luas Dinding (m²): [______]     │
│ Jumlah Coating:    [______]     │
│                                 │
│ [ Hitung Kebutuhan ]            │
│                                 │
│ Hasil:                          │
│ • Cat: 5 kaleng (20L)           │
│ • Primer: 2 kaleng             │
│ [ Tambah ke Keranjang ]         │
└─────────────────────────────────┘
```

### 8. Order Status Timeline
```
┌─────────────────────────────────────────────────────────────┐
│  ✓ Pending    →  ✓ Paid    →  ○ Processing  →  ○ Shipped  →  ○ Delivered │
│     Mar 10        Mar 10                                                  │
└─────────────────────────────────────────────────────────────┘
```
- Active: Primary color with checkmark
- Pending: Gray with circle

---

## Screen Layouts

### Home Screen
1. **Header**: Logo, navigation, cart, login
2. **Hero Section**: Banner carousel with CTA
3. **Categories**: Horizontal scroll / grid
4. **Featured Products**: Product grid
5. **Material Calculator CTA**: Card promoting calculator
6. **Footer**: Contact, links, copyright

### Product Listing
1. **Filter Sidebar** (desktop) / Filter Modal (mobile)
   - Kategori
   - Brand
   - Range Harga
2. **Sort Options**
   - Terbaru
   - Harga Terendah
   - Harga Tertinggi
   - Stok Terbanyak
3. **Product Grid**
4. **Pagination**

### Product Detail
1. **Image Gallery**: Main image + thumbnails
2. **Product Info**: Name, price, unit, stock
3. **Quantity Selector**: With unit display
4. **Description**: Collapsible
5. **Related Products**
6. **Sticky Footer**: Add to cart + Buy now

### Cart Screen
1. **Cart Items**: Swipe to delete (mobile)
2. **Quantity Control**: +/- buttons
3. **Price Summary**: Subtotal, shipping, total
4. **Checkout Button**: Sticky bottom

### Checkout Screen
1. **Shipping Address**: Select/add
2. **Delivery Options**: Pickup/delivery
3. **Order Summary**: Items + pricing
4. **Payment Method**: Select
5. **Place Order Button**

### Material Calculator
1. **Calculator Type Selector**: Tabs for different calculators
2. **Input Form**: Dimensions, options
3. **Result Display**: Material quantities
4. **Add to Cart Button**: Bulk add calculated materials

---

## Responsive Breakpoints

| Breakpoint | Width | Device |
|------------|-------|--------|
| sm | 640px | Mobile landscape |
| md | 768px | Tablet |
| lg | 1024px | Laptop |
| xl | 1280px | Desktop |
| 2xl | 1536px | Large screen |

---

## Animation Guidelines

| Animation | Duration | Easing |
|-----------|----------|--------|
| Fast | 150ms | ease-out |
| Normal | 300ms | ease-in-out |
| Slow | 500ms | ease-in-out |

### Usage
- Button hover: Fast
- Modal open/close: Normal
- Page transition: Slow
- Loading skeleton: Pulse animation

---

## Icon Set
Menggunakan **Heroicons** untuk konsistensi:
- `home` - Home navigation
- `shopping-cart` - Cart
- `calculator` - Material calculator
- `user` - Profile
- `cog-6-tooth` - Settings
- `magnifying-glass` - Search
- `plus` / `minus` - Quantity
- `trash` - Delete
- `pencil` - Edit
- `chevron-right` - Arrow
- `truck` - Delivery
- `map-pin` - Location
- `cube` - Products

---

## Asset Organization

```
resources/
├── images/
│   ├── logo/
│   │   ├── primary-logo.svg
│   │   ├── horizontal-logo.svg
│   │   └── app-icon.svg
│   ├── favicon.ico
│   └── banners/            # Promo banners
public/
├── images/
│   └── products/           # Uploaded product images
```

---

## Unit Display (Material Bangunan)

| Unit | Simbol | Contoh Produk |
|------|--------|---------------|
| Pieces | pcs | Baut, paku, keran |
| Sak | sak | Semen, plaster |
| Kilogram | kg | Besi, paku, kawat |
| Meter | m | Pipa, kabel, kayu |
| Meter Persegi | m² | Triplek, seng |
| Meter Kubik | m³ | Pasir, kerikil |
| Lembar | lbr | Triplek, seng |
| Batang | btg | Besi beton, kayu |

---

## Implementation Notes

1. **Mobile-first approach** - Desain utama untuk mobile, scale up ke desktop
2. **TailwindCSS** - Gunakan color palette di atas sebagai custom theme
3. **HeadlessUI / Element Plus** - Komponen base dengan customization sesuai brand
4. **Inertia.js** - SPA navigation tanpa full page reload
5. **Existing Stack** - Menggunakan komponen yang sudah ada (Flowbite, Element Plus)

---

## Komponen yang Sudah Ada (Existing)

### Layout Components
| File | Deskripsi | Status |
|------|-----------|--------|
| `resources/js/Layouts/App.vue` | Layout utama user dengan Navbar + Footer | ✓ Ada |
| `resources/js/Layouts/AdminLayout.vue` | Layout admin dengan sidebar | ✓ Ada |
| `resources/js/Layouts/GuestLayout.vue` | Layout untuk halaman auth | ✓ Ada |
| `resources/js/Layouts/AuthenticatedLayout.vue` | Layout untuk user terautentikasi | ✓ Ada |

### UI Components
| File | Deskripsi | Status |
|------|-----------|--------|
| `resources/js/Components/ApplicationLogo.vue` | Logo aplikasi | ✓ Ada - perlu ganti |
| `resources/js/Components/Navbar.vue` | Navigasi user | ✓ Ada di Pages/User/components/ |
| `resources/js/Components/Footer.vue` | Footer | ✓ Ada di Pages/User/components/ |
| `resources/js/Components/Banner.vue` | Banner carousel | ✓ Ada di Pages/User/components/ |
| `resources/js/Components/Paginate.vue` | Pagination | ✓ Ada |
| `resources/js/Components/Select.vue` | Dropdown select | ✓ Ada |
| `resources/js/Components/Modal.vue` | Modal dialog | ✓ Ada |
| `resources/js/Components/Dropdown.vue` | Dropdown menu | ✓ Ada |
| `resources/js/Components/TextInput.vue` | Input text | ✓ Ada |
| `resources/js/Components/PrimaryButton.vue` | Button primary | ✓ Ada |
| `resources/js/Components/SecondaryButton.vue` | Button secondary | ✓ Ada |

### Page Components (User)
| File | Deskripsi | Status |
|------|-----------|--------|
| `resources/js/Pages/User/Index.vue` | Landing page | ✓ Ada |
| `resources/js/Pages/User/Dashboard.vue` | Dashboard user | ✓ Ada |
| `resources/js/Pages/User/CartList.vue` | Halaman keranjang | ✓ Ada |
| `resources/js/Pages/User/Product/Index.vue` | Katalog produk | ✓ Ada |
| `resources/js/Pages/User/Payment.vue` | Halaman pembayaran | ✓ Ada |
| `resources/js/Pages/User/Invoice.vue` | Invoice pesanan | ✓ Ada |

### Page Components (Admin)
| File | Deskripsi | Status |
|------|-----------|--------|
| `resources/js/Pages/Admin/Dashboard.vue` | Dashboard admin | ✓ Ada |
| `resources/js/Pages/Admin/Product/Index.vue` | Manajemen produk | ✓ Ada |
| `resources/js/Pages/Admin/Category/Index.vue` | Manajemen kategori | ✓ Ada |
| `resources/js/Pages/Admin/Brand/Index.vue` | Manajemen brand | ✓ Ada |
| `resources/js/Pages/Admin/Order/Index.vue` | Manajemen pesanan | ✓ Ada |

### Komponen yang Perlu Dibuat (NEW)
| File | Deskripsi | Sprint |
|------|-----------|--------|
| `resources/js/Components/CalculatorCard.vue` | Card kalkulator material | Sprint 6 |
| `resources/js/Pages/User/Calculator/Index.vue` | Halaman kalkulator | Sprint 6 |
| `resources/js/Components/UnitDisplay.vue` | Display satuan material | Sprint 2 |
| `resources/js/Components/StockBadge.vue` | Badge status stok | Sprint 2 |

---

## Page Structure (Inertia.js)

### Layout Components
```
layouts/
├── AppLayout.vue          # Layout utama dengan navbar
├── AdminLayout.vue        # Layout admin dengan sidebar
└── AuthLayout.vue         # Layout untuk login/register
```

### Page Components
```
pages/
├── Home.vue               # Landing page
├── Product/
│   ├── Index.vue          # Product listing
│   └── Show.vue           # Product detail
├── Cart/
│   └── Index.vue          # Cart page
├── Checkout/
│   └── Index.vue          # Checkout page
├── Dashboard.vue          # User dashboard
├── Calculator/
│   └── Index.vue          # Material calculator
└── Admin/
    ├── Dashboard.vue      # Admin dashboard
    ├── Product/
    │   └── Index.vue      # Product management
    ├── Category/
    │   └── Index.vue      # Category management
    ├── Brand/
    │   └── Index.vue      # Brand management
    └── Order/
        └── Index.vue      # Order management
```

---

## Color Usage Examples

### Button Variants
```vue
<!-- Primary Button -->
<button class="bg-orange-500 hover:bg-orange-600 text-white rounded-md px-4 py-2">
  Tambah ke Keranjang
</button>

<!-- Secondary Button -->
<button class="bg-sky-500 hover:bg-sky-600 text-white rounded-md px-4 py-2">
  Lihat Detail
</button>

<!-- Outline Button -->
<button class="border border-orange-500 text-orange-500 hover:bg-orange-50 rounded-md px-4 py-2">
  Batal
</button>
```

### Status Badges
```vue
<!-- Success -->
<span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Stok Tersedia</span>

<!-- Warning -->
<span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Stok Terbatas</span>

<!-- Error -->
<span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Stok Habis</span>
```

---

## Form Input Styles

```vue
<!-- Text Input -->
<input type="text" 
  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
  placeholder="Masukkan nilai"
/>

<!-- Select -->
<select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-orange-500">
  <option>Pilih opsi</option>
</select>

<!-- Number Input with Unit -->
<div class="flex">
  <input type="number" class="border border-gray-300 rounded-l-md px-3 py-2 flex-1" />
  <span class="bg-gray-100 border border-l-0 border-gray-300 rounded-r-md px-3 py-2 text-gray-600">m²</span>
</div>
```
