<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // helper to generate a random 10 digit number string
        $gen = function(){
            $n = '';
            for($i=0;$i<10;$i++){ $n .= mt_rand(0,9); }
            return $n; };

        // Create or update admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => $gen()
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
                    'phone' => $gen()
                ]
            );
        }
    }
}