<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Semen & Beton', 'image' => '/images/categories/semen-beton.webp'],
            ['name' => 'Bata & Batu', 'image' => '/images/categories/bata-batu.webp'],
            ['name' => 'Besi & Baja', 'image' => '/images/categories/besi-baja.webp'],
            ['name' => 'Kayu & Triplek', 'image' => '/images/categories/kayu-triplek.webp'],
            ['name' => 'Cat & Pelapis', 'image' => '/images/categories/cat-pelapis.webp'],
            ['name' => 'Atap & Genteng', 'image' => '/images/categories/atap-genteng.webp'],
            ['name' => 'Pipa & Sanitasi', 'image' => '/images/categories/pipa-sanitasi.webp'],
            ['name' => 'Keramik & Lantai', 'image' => '/images/categories/keramik-lantai.webp'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $name = $cat['name'],
                'slug' => str($name)->slug(),
                'image' => $cat['image'],
            ]);
        }
    }
}
