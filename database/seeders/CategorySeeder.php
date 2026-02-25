<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'slug' => 'elektronik'],
            ['name' => 'Fashion', 'slug' => 'fashion'],
            ['name' => 'Handphone & Tablet', 'slug' => 'handphone-tablet'],
            ['name' => 'Komputer & Laptop', 'slug' => 'komputer-laptop'],
            ['name' => 'Rumah Tangga', 'slug' => 'rumah-tangga'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
            ['name' => 'Hobi & Koleksi', 'slug' => 'hobi-koleksi'],
            ['name' => 'Mobil', 'slug' => 'mobil'],
            ['name' => 'Motor', 'slug' => 'motor'],
            ['name' => 'Jasa', 'slug' => 'jasa'],
            ['name' => 'Perlengkapan Bayi', 'slug' => 'perlengkapan-bayi'],
            ['name' => 'Lainnya', 'slug' => 'lainnya'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
