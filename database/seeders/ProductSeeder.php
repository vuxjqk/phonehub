<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::insert([
            ['name' => 'Apple',   'slug' => 'apple',   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Samsung', 'slug' => 'samsung', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Xiaomi',  'slug' => 'xiaomi',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'OPPO',    'slug' => 'oppo',    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vivo',    'slug' => 'vivo',    'created_at' => now(), 'updated_at' => now()],
        ]);

        Product::factory(20)->create();
    }
}
