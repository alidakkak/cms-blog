<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ----------------------------
        // Admin User
        // ----------------------------
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('Admin@1234'),
                'role' => 'admin',
            ]
        );

        // ----------------------------
        // Editor User
        // ----------------------------
        User::updateOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Content Editor',
                'email' => 'editor@example.com',
                'password' => Hash::make('Editor@1234'),
                'role' => 'editor',
            ]
        );

        // ----------------------------
        // Normal User
        // ----------------------------
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('User@1234'),
                'role' => 'user',
            ]
        );
    }
}
