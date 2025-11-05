<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\District;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InfrastructureObject>
 */
class InfrastructureObjectFactory extends Factory
{
    /**
     * @return array
     */
    public function definition(): array
    {
        $types = ['Lighting', 'TrashBin', 'Parking', 'Sensor', 'Road'];
        $statuses = ['Active', 'Maintenance', 'Inactive', 'Error'];

        $creator = User::first();
        $city = City::where('name', 'Uzhhorod')->first();
        $district = District::where('city_id', $city->id)->inRandomOrder()->first();

        return [
            'name' => fake()->unique()->words(2, true) . ' ' . fake()->randomNumber(2),
            'type' => fake()->randomElement($types),
            'status' => fake()->randomElement($statuses),
            'latitude' => fake()->latitude(48.61, 48.63),
            'longitude' => fake()->longitude(22.29, 22.31),
            'description' => fake()->sentence(),
            'city_id' => $city->id,
            'district_id' => $district?->id,
            'created_by' => $creator->id,
            'created_at' => fake()->dateTimeBetween('-1 year'),
            'updated_at' => fake()->dateTimeBetween('-1 month'),
        ];
    }
}
