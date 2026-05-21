<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
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
            'password' => Hash::make('admin@12345'),
            'isAdmin' => 1,
            'email_verified_at' => now(),
        ]);

        // Create customer
        User::create([
            'name' => 'Pelanggan Demo',
            'email' => 'customertesting@dollicons.com',
            'password' => Hash::make('customer123456'),
            'isAdmin' => 0,
            'email_verified_at' => now(),
        ]);
    }
}
