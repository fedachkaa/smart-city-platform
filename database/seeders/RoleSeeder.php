<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class RoleSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        UserRole::firstOrCreate(['name' => 'Administrator']);
        UserRole::firstOrCreate(['name' => 'Operator']);
        UserRole::firstOrCreate(['name' => 'Guest']);
    }
}