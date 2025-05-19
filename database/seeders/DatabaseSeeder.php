<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'user_name' => 'admin',
            'role_id' => 1,
            'full_name' => 'Admin',
            'address' => 'Dhaka',
            'email' => 'admin@example.com',
            'phone' => '01746693552',
            'password' => Hash::make('password'),
            'active' => 'YES'
        ]);
    }
}
