<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
            'name' => $name = 'Material Bangunan Berkualitas',
            'slug'=>str($name)->slug(),
            'image'=> '/images/products/semen-tiga-roda.webp'
        ]);
        Banner::create([
            'name' => $name = 'Besi dan Baja Konstruksi',
            'slug'=>str($name)->slug(),
            'image' => '/images/products/besi-beton.webp'
        ]);
        Banner::create([
            'name' => $name = 'Genteng dan Atap Premium',
            'slug'=>str($name)->slug(),
            'image' => '/images/products/genteng-keramik-glazur.webp'
        ]);
    }
}
