<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create or update admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Create 5 regular users
        for ($i = 1; $i <= 5; $i++) {
            User::updateOrCreate(
                ['email' => 'user' . $i . '@example.com'],
                [
                    'name' => 'User ' . $i,
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                ]
            );
        }
    }
}