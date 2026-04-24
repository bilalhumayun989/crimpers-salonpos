<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default Branch
        \App\Models\Branch::firstOrCreate(['id' => 1], [
            'name' => 'Main Branch',
            'address' => 'Headquarters',
            'phone' => '0000000000',
            'opening_time' => '09:00:00',
            'closing_time' => '21:00:00',
            'is_active' => true
        ]);
        // Admin
        User::updateOrCreate(['email' => 'Sa40560@gmail.com'], [
            'name' => 'Admin Manager',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

        // Employee
        User::updateOrCreate(['email' => 'user@gmail.com'], [
            'name' => 'Staff Member',
            'password' => bcrypt('12345678'),
            'role' => 'employee',
        ]);

        // Categories
        $hair = Category::updateOrCreate(['slug' => 'hair-services'], ['name' => 'Hair Services', 'type' => 'service']);
        $skin = Category::updateOrCreate(['slug' => 'skin-care'], ['name' => 'Skin Care', 'type' => 'service']);
        $products = Category::updateOrCreate(['slug' => 'retail-products'], ['name' => 'Retail Products', 'type' => 'product']);

        // Services
        Service::updateOrCreate(['name' => 'Men\'s Haircut'], [
            'category_id' => $hair->id,
            'price' => 25.00,
            'duration' => 30,
            'is_popular' => true
        ]);
        
        Service::updateOrCreate(['name' => 'Express Facial'], [
            'category_id' => $skin->id,
            'price' => 45.00,
            'duration' => 45,
            'is_popular' => true
        ]);

        // Products
        Product::updateOrCreate(['barcode' => '123456789'], [
            'category_id' => $products->id,
            'name' => 'Herbal Shampoo 250ml',
            'price' => 15.00,
            'stock' => 50,
        ]);
    }
}
