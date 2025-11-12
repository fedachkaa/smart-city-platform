<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class CityBoundsSeeder extends Seeder
{
    /**
     * @return void
     * @throws ConnectionException
     */
    public function run(): void
    {
        $username = config('services.geonames.username');
        $country = 'UA';

        $cities = City::whereNull('bounds')->get();
        $this->command->info("Found {$cities->count()} cities without bounds.");

        foreach ($cities as $city) {
            $this->command->info("Fetching bounds for: {$city->name}");

            $bbox = null;

            $geoResponse = Http::get('http://api.geonames.org/searchJSON', [
                'q' => $city->name,
                'country' => $country,
                'maxRows' => 1,
                'username' => $username,
            ]);

            if ($geoResponse->ok()) {
                $geo = $geoResponse->json();
                $geoname = $geo['geonames'][0] ?? null;
                if ($geoname && isset($geoname['geonameId'])) {
                    $detailResponse = Http::get('http://api.geonames.org/getJSON', [
                        'geonameId' => $geoname['geonameId'],
                        'username' => $username,
                    ]);

                    if ($detailResponse->ok()) {
                        $detail = $detailResponse->json();
                        $bbox = $detail['bbox'] ?? null;
                    }
                }
            }

            if (!$bbox) {
                $nominatimResponse = Http::withHeaders([
                    'User-Agent' => 'YourAppName/1.0 (contact@example.com)',
                ])->get('https://nominatim.openstreetmap.org/search', [
                    'q' => "{$city->name}, {$country}",
                    'format' => 'json',
                    'limit' => 1,
                ]);

                if ($nominatimResponse->ok() && count($nominatimResponse->json()) > 0) {
                    $data = $nominatimResponse->json()[0];
                    if (!empty($data['boundingbox'])) {
                        $bbox = [
                            'south' => (float) $data['boundingbox'][0],
                            'north' => (float) $data['boundingbox'][1],
                            'west'  => (float) $data['boundingbox'][2],
                            'east'  => (float) $data['boundingbox'][3],
                        ];
                    }
                }
            }

            if ($bbox) {
                $city->bounds = $bbox;
                $city->save();
                $this->command->info("✅ Saved bounds for {$city->name}");
            } else {
                $this->command->warn("⚠️ Could not find bounds for {$city->name}");
            }

            sleep(1);
        }

        $this->command->info("Finished updating city bounds.");
    }
}