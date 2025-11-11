<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RouteOptimizerService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.key');
    }

    /**
     * @param array $startLocation
     * @param $objects
     * @return array
     * @throws \Exception
     */
    public function buildOptimizedRoute(array $startLocation, $objects): array
    {
        $origin = "{$startLocation['lat']},{$startLocation['lng']}";
        $waypoints = $objects->map(fn($o) => "{$o->latitude},{$o->longitude}")->implode('|');

        $response = Http::get('https://maps.googleapis.com/maps/api/directions/json', [
            'origin' => $origin,
            'destination' => $origin,
            'waypoints' => "optimize:true|{$waypoints}",
            'key' => $this->apiKey,
        ]);

        if ($response->failed()) {
            throw new \Exception('Не вдалося побудувати маршрут через Google Maps API');
        }

        $data = $response->json();

        $optimizedOrder = $data['routes'][0]['waypoint_order'] ?? [];
        $legs = $data['routes'][0]['legs'] ?? [];

        return [
            'optimized_order' => $optimizedOrder,
            'legs' => $legs,
            'polyline' => $data['routes'][0]['overview_polyline']['points'] ?? null,
        ];
    }
}