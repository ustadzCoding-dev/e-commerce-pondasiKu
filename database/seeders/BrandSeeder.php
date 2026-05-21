<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Tiga Roda', 'image' => '/images/brands/tiga-roda.webp'],
            ['name' => 'Semen Tiga Roda', 'image' => '/images/brands/semen-tiga-roda.webp'],
            ['name' => 'Dynamix', 'image' => '/images/brands/dynamix.webp'],
            ['name' => 'Semen Bima', 'image' => '/images/brands/semen-bima.webp'],
            ['name' => 'Krakatau Steel', 'image' => '/images/brands/krakatau-steel.webp'],
            ['name' => 'Iwaki Steel', 'image' => '/images/brands/iwaki-steel.webp'],
            ['name' => 'Dulux', 'image' => '/images/brands/dulux.webp'],
            ['name' => 'Nippon Paint', 'image' => '/images/brands/nippon-paint.webp'],
            ['name' => 'Avian', 'image' => '/images/brands/avian.webp'],
            ['name' => 'Wika', 'image' => '/images/brands/wika.webp'],
            ['name' => 'Rucika', 'image' => '/images/brands/rucika.webp'],
            ['name' => 'Roman', 'image' => '/images/brands/roman.webp'],
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $name = $brand['name'],
                'slug' => str($name)->slug(),
                'image' => $brand['image'],
            ]);
        }
    }
}
