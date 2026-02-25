<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'icon' => 'fa-laptop'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => 'fa-tshirt'],
            ['name' => 'Handphone & Tablet', 'slug' => 'handphone-tablet', 'icon' => 'fa-mobile-alt'],
            ['name' => 'Komputer & Laptop', 'slug' => 'komputer-laptop', 'icon' => 'fa-desktop'],
            ['name' => 'Rumah Tangga', 'slug' => 'rumah-tangga', 'icon' => 'fa-home'],
            ['name' => 'Olahraga', 'slug' => 'olah-raga', 'icon' => 'fa-running'],
            ['name' => 'Hobi & Koleksi', 'slug' => 'hobi-koleksi', 'icon' => 'fa-gamepad'],
            ['name' => 'Kendaraan', 'slug' => 'kendaraan', 'icon' => 'fa-car'],
            ['name' => 'Makanan & Minuman', 'slug' => 'makanan-minuman', 'icon' => 'fa-utensils'],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'icon' => 'fa-box'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@marketplace.com',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567891',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
