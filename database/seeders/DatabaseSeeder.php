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
        // Branch 1: Lahore
        \App\Models\Branch::firstOrCreate(['id' => 1], [
            'name' => 'Lahore Branch',
            'address' => 'Lahore City',
            'phone' => '03000000001',
            'opening_time' => '09:00:00',
            'closing_time' => '21:00:00',
            'is_active' => true
        ]);

        // Branch 2: Faisalabad
        \App\Models\Branch::firstOrCreate(['id' => 2], [
            'name' => 'Faisalabad Branch',
            'address' => 'Faisalabad City',
            'phone' => '03000000002',
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
