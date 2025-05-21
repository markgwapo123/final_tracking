<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // ✅ This line is required

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::create([
            'name' => 'Mark Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // ✅ Hash now recognized
            'role' => 'admin',
        ]);
    }
}
