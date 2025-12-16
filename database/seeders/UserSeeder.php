<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@inventory.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Petugas',
            'email' => 'petugas@inventory.com',
            'password' => bcrypt('petugas123'),
            'role' => 'petugas',
        ]);
    }
}
