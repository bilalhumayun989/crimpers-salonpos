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

        // Employee (Optional fallback account)
        User::updateOrCreate(['email' => 'user@gmail.com'], [
            'name' => 'Staff Member',
            'password' => bcrypt('12345678'),
            'role' => 'employee',
        ]);
    }
}
