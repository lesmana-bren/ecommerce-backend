<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
   
    public function run(): void
{
    DB::table('products')->insert([
        [
            'name' => 'Corsair Vengeance LPX 16GB DDR4',
            'slug' => Str::slug('Corsair Vengeance LPX 16GB DDR4'),
            'description' => 'RAM PC DDR4 3200MHz Dual Channel Kit (2x8GB)',
            'category_id' => 1,
            'price' => 750000,
            'img' => 'products/ram-corsair.jpg',
            'stock' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);
}
}
