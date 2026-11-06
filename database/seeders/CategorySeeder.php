<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'RAM Desktop', 'slug' => 'ram-desktop']);
        Category::create(['name' => 'RAM Laptop (SODIMM)', 'slug' => 'ram-laptop']);
        Category::create(['name' => 'SSD NVMe M.2', 'slug' => 'ssd-nvme']);
        Category::create(['name' => 'SSD SATA 2.5 Inch', 'slug' => 'ssd-sata']);
    }
}