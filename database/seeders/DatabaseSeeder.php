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
            'employee_id' => 1,
            'role_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'pin_number' => '10011',
            'phone' => '01746693552',
            'password' => Hash::make('password'),
            'active' => 'YES'
        ]);
    }
}
