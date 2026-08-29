<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Rino Firmansyah',
            'email' => 'rino.f@untan.ac.id',
            'password' => Hash::make('password'), // ubah jika perlu
            'role' => 'admin', // pastikan field role ada di migrations / model
        ]);

        // User biasa
        User::create([
            'name' => 'Staff User',
            'email' => 'user@mail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
