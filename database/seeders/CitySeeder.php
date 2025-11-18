<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\City;

class CitySeeder extends Seeder
{
    const FEATURE_CODES = ['PPLA', 'PPLC'];

    /**
     * @return void
     */
    public function run(): void
    {
        $username = config('services.geonames.username');
        $country = 'UA';

        foreach (self::FEATURE_CODES as $featureCode) {
            $responseEn = Http::get('http://api.geonames.org/searchJSON', [
                'country' => $country,
                'featureClass' => 'P',
                'featureCode' => $featureCode,
                'username' => $username,
                'lang' => 'en',
            ]);

            if ($responseEn->failed()) {
                $this->command->error("❌ Error occurred during GeoNames request");
                $this->command->warn("Status code: {$responseEn->status()}");
                $this->command->warn("Response body: " . mb_substr($responseEn->body(), 0, 500));
                return;
            }

            $this->command->info('GeoNames response total: ' . $responseEn->json()['totalResultsCount'] ?? 0);

            $responseUk = Http::get('http://api.geonames.org/searchJSON', [
                'country' => $country,
                'featureClass' => 'P',
                'featureCode' => $featureCode,
                'username' => $username,
                'lang' => 'uk',
            ]);

            if ($responseUk->failed()) {
                $this->command->error("❌ Error occurred during GeoNames request (UK)");
                return;
            }

            $geonamesEn = $responseEn->json()['geonames'] ?? [];
            $geonamesUk = $responseUk->json()['geonames'] ?? [];

            if (empty($geonamesEn)) {
                return;
            }

            foreach ($geonamesEn as $index => $itemEn) {
                $itemUk = $geonamesUk[$index] ?? [];

                City::updateOrCreate(
                    ['name' => $itemEn['name']],
                    [
                        'name_native' => $itemUk['name'] ?? $itemEn['name'],
                        'region' => $itemEn['adminName1'] ?? null,
                        'latitude' => $itemEn['lat'] ?? null,
                        'longitude' => $itemEn['lng'] ?? null,
                        'population' => $itemEn['population'] ?? null,
                        'country_code' => $itemEn['countryCode'],
                    ]
                );
            }

            $this->command->info('Saved ' . count($geonamesEn) . ' administrative cities');
        }

        $this->command->info("✅ Finished: Ukraine administrative centers");
    }
}
