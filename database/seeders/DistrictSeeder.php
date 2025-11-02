<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\City;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $username = config('services.geonames.username');

        if (!$username) {
            $this->command->error('GeoNames username not set. Add GEONAMES_USERNAME to .env');
            return;
        }

        $response = Http::get('http://api.geonames.org/searchJSON', [
            'country' => 'UA',
            'featureCode' => 'ADM2',
            'maxRows' => 1000,
            'username' => $username,
        ]);

        if ($response->failed()) {
            $status = $response->status();
            $body = $response->body();

            $this->command->error("❌ GeoNames request failed for ADM2 districts");
            $this->command->warn("Status code: {$status}");
            $this->command->warn("Response body: " . mb_substr($body, 0, 500));
            return;
        }

        $data = $response->json();

        foreach ($data['geonames'] as $item) {
            $districtName = $item['name'] ?? null;
            $region = $item['adminName1'] ?? null;

            if (!$districtName) {
                continue;
            }

            $city = City::where('region', $region)->first();

            District::updateOrCreate(
                ['name' => $districtName, 'city_id' => $city?->id],
                []
            );
        }

        $this->command->info('✅ Districts imported successfully!');
    }
}
