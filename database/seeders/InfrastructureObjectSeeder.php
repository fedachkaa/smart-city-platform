<?php

namespace Database\Seeders;

use App\Models\InfrastructureObject;
use Illuminate\Database\Seeder;

class InfrastructureObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InfrastructureObject::factory()->count(50)->create();
    }
}
