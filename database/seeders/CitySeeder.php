<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $username = config('services.geonames.username');
        $country = 'UA';
        $minPopulation = 10000;

        $startRow = 0;
        $maxRows = 1000;
        do {
            $response = Http::get('http://api.geonames.org/searchJSON', [
                'country' => $country,
                'featureClass' => 'P',
                'minPopulation' => $minPopulation,
                'username' => $username,
                'maxRows' => $maxRows,
                'startRow' => $startRow,
            ]);

            if ($response->failed()) {
                $status = $response->status();
                $body = $response->body();

                $this->command->error("❌ Error occurred during GeoNames request (startRow {$startRow})");
                $this->command->warn("Status code: {$status}");
                $this->command->warn("Response body: " . mb_substr($body, 0, 500));
                break;
            }

            $data = $response->json();
            $geonames = $data['geonames'] ?? [];

            if (empty($geonames)) {
                break;
            }

            foreach ($geonames as $item) {
                City::updateOrCreate(
                    ['name' => $item['name']],
                    [
                        'region' => $item['adminName1'] ?? null,
                        'name' => $item['name'],
                        'latitude' => $item['lat'] ?? null,
                        'longitude' => $item['lng'] ?? null,
                        'population' => $item['population'],
                        'country_code' => $item['countryCode'],
                    ],
                );
            }

            $this->command->info('Saved ' . count($geonames) . ' cities with startRow ' . $startRow);
            $startRow += $maxRows;
            sleep(1);
        } while (true);

        $this->command->info("Finished: Ukraine cities (> {$minPopulation}) with GeoNames");
    }
}
