<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@perpustakaan.test'],
            [
                'name' => 'Administrator',
                'password' => 'Admin123!',
                'role' => 'admin',
            ]
        );
    }
}