<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'admin@berandacoffee.com',
            'nama' => 'Super Admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'Updated_at' => '2025-12-22 17:00:00',
            'Created_at' => '2025-12-22 17:00:00',
        ]);
        
        User::create([
            'email' => 'user@berandacoffee.com',
            'nama' => 'User Test',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'Updated_at' => '2025-12-22 17:00:00',
            'Created_at' => '2025-12-22 17:00:00',
        ]);
    }
}