<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'status' => 'active'
        ]);

        User::create([
            'name' => 'Petugas',
            'username' => 'Ahmad Gunawan',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'petugas',
            'status' => 'active'
        ]);

        User::create([
            'name' => 'Pemimpin',
            'username' => 'pemimpin',
            'email' => 'pemimpin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'pemimpin',
            'status' => 'active'
        ]);
    }
}