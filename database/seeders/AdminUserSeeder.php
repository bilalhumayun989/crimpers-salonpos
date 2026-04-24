<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'Sa40560@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => \Hash::make('12345678'),
            ]
        );
    }
}
