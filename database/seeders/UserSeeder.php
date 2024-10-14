<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Membuat user biasa
        User::create([
            'id' => (string) Str::uuid(),
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Ganti dengan password yang diinginkan
            'address' => 'Alamat Pengguna',
            'phone' => '1234567890',
            'role' => 'user',
        ]);

        // Membuat admin
        User::create([
            'id' => (string) Str::uuid(),
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Ganti dengan password yang diinginkan
            'address' => 'Alamat Admin',
            'phone' => '0987654321',
            'role' => 'admin',
        ]);
    }
}
