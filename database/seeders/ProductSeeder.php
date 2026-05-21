<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Semen & Beton
            [
                'title' => 'Semen Tiga Roda 50kg',
                'description' => 'Semen portland berkualitas tinggi untuk konstruksi bangunan. Cocok untuk pengecoran, plesteran, dan pembuatan beton.',
                'category' => 'Semen & Beton',
                'brand' => 'Tiga Roda',
                'price' => 75000,
                'quantity' => 500,
                'unit' => 'sak',
                'weight' => 50,
                'min_stock' => 50,
                'image' => '/images/products/semen-tiga-roda.webp',
            ],
            [
                'title' => 'Semen Dynamix 50kg',
                'description' => 'Semen tahan air ideal untuk area lembab, kolam, dan konstruksi di bawah tanah.',
                'category' => 'Semen & Beton',
                'brand' => 'Dynamix',
                'price' => 85000,
                'quantity' => 300,
                'unit' => 'sak',
                'weight' => 50,
                'min_stock' => 30,
                'image' => '/images/products/semen-dynamix.webp',
            ],
            
            // Bata & Batu
            [
                'title' => 'Bata Merah Press',
                'description' => 'Bata merah berkualitas untuk dinding bangunan. Ukuran standar 20x10x5 cm.',
                'category' => 'Bata & Batu',
                'brand' => 'Wika',
                'price' => 1200,
                'quantity' => 10000,
                'unit' => 'pcs',
                'weight' => 2.5,
                'min_stock' => 1000,
                'image' => '/images/products/batu-merah-press.webp',
            ],
            [
                'title' => 'Batako Ringan (Hebel)',
                'description' => 'Batako ringan untuk dinding hemat energi. Ukuran 60x20x10 cm. Mudah dipotong dan dipasang.',
                'category' => 'Bata & Batu',
                'brand' => 'Wika',
                'price' => 11000,
                'quantity' => 2000,
                'unit' => 'pcs',
                'weight' => 8,
                'min_stock' => 200,
                'image' => '/images/products/batako-ringan.webp',
            ],
            
            // Besi & Baja
            [
                'title' => 'Besi Beton 10mm',
                'description' => 'Besi tulangan beton diameter 10mm. Panjang 12 meter. SNI standar.',
                'category' => 'Besi & Baja',
                'brand' => 'Krakatau Steel',
                'price' => 125000,
                'quantity' => 200,
                'unit' => 'btg',
                'weight' => 7.4,
                'min_stock' => 50,
                'image' => '/images/products/besi-beton.webp',
            ],
            [
                'title' => 'Besi Hollow 40x40',
                'description' => 'Besi hollow untuk rangka atap, kanopi, dan konstruksi ringan. Tebal 1.2mm.',
                'category' => 'Besi & Baja',
                'brand' => 'Iwaki Steel',
                'price' => 95000,
                'quantity' => 150,
                'unit' => 'btg',
                'weight' => 5.5,
                'min_stock' => 30,
                'image' => '/images/products/besi-hollow.webp',
            ],
            
            // Kayu & Triplek
            [
                'title' => 'Kayu Meranti 6x12',
                'description' => 'Kayu meranti untuk konstruksi atap dan rangka. Panjang 4 meter. Kering dan awet.',
                'category' => 'Kayu & Triplek',
                'brand' => 'Wika',
                'price' => 185000,
                'quantity' => 100,
                'unit' => 'btg',
                'weight' => 25,
                'min_stock' => 20,
                'image' => '/images/products/kayu-meranti.webp',
            ],
            [
                'title' => 'Triplek 9mm',
                'description' => 'Plywood triplek tebal 9mm untuk furniture, partisi, dan interior. Ukuran 122x244 cm.',
                'category' => 'Kayu & Triplek',
                'brand' => 'Roman',
                'price' => 175000,
                'quantity' => 80,
                'unit' => 'lbr',
                'weight' => 15,
                'min_stock' => 15,
                'image' => '/images/products/triplek.webp',
            ],
            
            // Cat & Pelapis
            [
                'title' => 'Cat Tembok Dulux 20L',
                'description' => 'Cat tembok interior premium dengan daya tutup tinggi. Tahan cuaca dan tidak mudah pudar.',
                'category' => 'Cat & Pelapis',
                'brand' => 'Dulux',
                'price' => 650000,
                'quantity' => 50,
                'unit' => 'pcs',
                'weight' => 25,
                'min_stock' => 10,
                'image' => '/images/products/cat-tembok-dulux.webp',
            ],
            [
                'title' => 'Cat Besi Nippon Paint',
                'description' => 'Cat anti karat untuk besi dan logam. Daya rekat kuat, tahan lama. Pilihan warna lengkap.',
                'category' => 'Cat & Pelapis',
                'brand' => 'Nippon Paint',
                'price' => 285000,
                'quantity' => 100,
                'unit' => 'pcs',
                'weight' => 4,
                'min_stock' => 20,
                'image' => '/images/products/cat-besi-nippon-paint.webp',
            ],
            [
                'title' => 'Pelapis Lantai Epoxy',
                'description' => 'Coating epoxy untuk lantai garasi, gudang, dan area industri. Tahan kimia dan aus.',
                'category' => 'Cat & Pelapis',
                'brand' => 'Avian',
                'price' => 450000,
                'quantity' => 30,
                'unit' => 'pcs',
                'weight' => 5,
                'min_stock' => 5,
                'image' => '/images/products/pelapis-lantai-epoxy.webp',
            ],
            
            // Atap & Genteng
            [
                'title' => 'Genteng Keramik Glazur',
                'description' => 'Genteng keramik dengan lapisan glazur mengkilap. Tahan air dan tahan cuaca. Warna merah natural.',
                'category' => 'Atap & Genteng',
                'brand' => 'Roman',
                'price' => 8500,
                'quantity' => 5000,
                'unit' => 'pcs',
                'weight' => 2.5,
                'min_stock' => 500,
                'image' => '/images/products/genteng-keramik-glazur.webp',
            ],
            [
                'title' => 'Seng Gelombang BJLS',
                'description' => 'Seng gelombang untuk atap gudang dan kanopi. Tebal 0.3mm. Tahan karat.',
                'category' => 'Atap & Genteng',
                'brand' => 'Wika',
                'price' => 75000,
                'quantity' => 200,
                'unit' => 'lbr',
                'weight' => 4,
                'min_stock' => 30,
                'image' => '/images/products/seng-gelombang-bjls.webp',
            ],
            
            // Pipa & Sanitasi
            [
                'title' => 'Pipa PVC 3 inch',
                'description' => 'Pipa PVC untuk saluran air dan drainase. Diameter 3 inch. Panjang 4 meter. SNI standar.',
                'category' => 'Pipa & Sanitasi',
                'brand' => 'Rucika',
                'price' => 65000,
                'quantity' => 300,
                'unit' => 'btg',
                'weight' => 3,
                'min_stock' => 50,
                'image' => '/images/products/pipa-pvc.webp',
            ],
            [
                'title' => 'Pipa Galvanis 1.5 inch',
                'description' => 'Pipa besi galvanis untuk instalasi air bersih. Tahan karat dan tahan lama.',
                'category' => 'Pipa & Sanitasi',
                'brand' => 'Wika',
                'price' => 95000,
                'quantity' => 150,
                'unit' => 'btg',
                'weight' => 5,
                'min_stock' => 25,
                'image' => '/images/products/pipa-galvanis.webp',
            ],
            
            // Keramik & Lantai
            [
                'title' => 'Keramik Lantai 60x60',
                'description' => 'Keramik lantai motif granit. Ukuran 60x60 cm. Permukaan mengkilap anti slip.',
                'category' => 'Keramik & Lantai',
                'brand' => 'Roman',
                'price' => 75000,
                'quantity' => 500,
                'unit' => 'pcs',
                'weight' => 3,
                'min_stock' => 50,
                'image' => '/images/products/keramik-lantai.webp',
            ],
            [
                'title' => 'Keramik Dinding 30x60',
                'description' => 'Keramik dinding motif marmer untuk kamar mandi dan dapur. Mudah dibersihkan.',
                'category' => 'Keramik & Lantai',
                'brand' => 'Roman',
                'price' => 55000,
                'quantity' => 600,
                'unit' => 'pcs',
                'weight' => 2,
                'min_stock' => 60,
                'image' => '/images/products/keramik-dinding.webp',
            ],
        ];

        foreach ($products as $item) {
            $category = Category::where('name', $item['category'])->first();
            $brand = Brand::where('name', $item['brand'])->first();

            if ($category && $brand) {
                $product = Product::create([
                    'title' => $item['title'],
                    'slug' => Str::slug($item['title']),
                    'description' => $item['description'],
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                    'weight' => $item['weight'],
                    'min_stock' => $item['min_stock'],
                    'inStock' => $item['quantity'] > 0 ? 1 : 0,
                    'published' => 1,
                ]);

                // Create product image record
                $product->product_images()->create([
                    'image' => $item['image'],
                ]);
            }
        }
    }
}
