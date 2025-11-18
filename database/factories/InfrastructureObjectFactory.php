<?php

namespace Database\Factories;

use App\Enums\InfrastructureObjectStatus;
use App\Enums\InfrastructureObjectType;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

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
        $creator = User::first();
        $city = City::where('name', 'Uzhhorod')->first();

        $namePrefixes = ['Central', 'North', 'South', 'Old', 'New', 'Main', 'Green', 'Blue'];

        $latitude = fake()->latitude($city->latitude - 0.02, $city->latitude + 0.02);
        $longitude = fake()->longitude($city->longitude - 0.02, $city->longitude + 0.02);

        $publicAddress = fake()->streetAddress() . ', ' . $city->name;
        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'latlng' => "{$latitude},{$longitude}",
                'key' => config('services.google_maps.key'),
            ]);

            $results = $response->json()['results'] ?? [];
            if (!empty($results)) {
                $publicAddress = $results[0]['formatted_address'];
            }
        } catch (\Throwable $e) {}

        return [
            'name' => fake()->randomElement($namePrefixes) . ' ' . fake()->randomElement(InfrastructureObjectType::cases())->value,
            'type' => fake()->randomElement(InfrastructureObjectType::cases())->value,
            'status' => fake()->randomElement(InfrastructureObjectStatus::cases())->value,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'description' => fake()->sentence(10),
            'public_address' => $publicAddress,
            'city_id' => $city->id,
            'created_by' => $creator->id,
            'created_at' => fake()->dateTimeBetween('-1 year'),
            'updated_at' => fake()->dateTimeBetween('-1 month'),
        ];
    }
}
