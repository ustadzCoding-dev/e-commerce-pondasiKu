<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin
        User::create([
            'name' => 'Admin PondasiKu',
            'email' => 'admintesting@dollicons.com',
            'email_verified_at' => now(),
            'isAdmin' => 1,
            'password' => Hash::make('admin@12345'),
            'remember_token' => Str::random(10),
        ]);

        // Create customer
        User::create([
            'name' => 'Pelanggan Demo',
            'email' => 'customertesting@dollicons.com',
            'email_verified_at' => now(),
            'isAdmin' => 0,
            'password' => Hash::make('customer123456'),
            'remember_token' => Str::random(10),
        ]);
    }
}
