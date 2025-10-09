<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $adminRole = UserRole::where('name', 'Administrator')->first();

        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'role_id' => $adminRole->id,
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}