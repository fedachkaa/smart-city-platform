<?php

namespace Database\Seeders;

use App\Models\City;
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
        $city = City::where('name', 'Uzhhorod')->first();

        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'role_id' => $adminRole->id,
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'city_id' => $city->id,
            ]
        );
    }
}