<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin
        \App\Models\User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@store.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // 2. Panggil Seeder Kategori dan Produk
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}