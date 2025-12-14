<?php

namespace App\Services;

use GuzzleHttp\Client;
use Google\Auth\ApplicationDefaultCredentials;
use GuzzleHttp\Exception\GuzzleException;


class RouteOptimizerService
{
    /** @var Client */
    private $client;

    /** @var string */
    private $token;

    /** @var string */
    private $projectId;

    public function __construct()
    {
        $credentials = ApplicationDefaultCredentials::getCredentials( ['https://www.googleapis.com/auth/cloud-platform']);

        $this->token = $credentials->fetchAuthToken()['access_token'];
        $this->client = new Client();
        $this->projectId = config('services.google.project_id');
    }

    /**
     * @param array $startLocation
     * @param string $startTime
     * @param $objects
     * @return array
     * @throws GuzzleException
     */
    public function buildOptimizedRoute(array $startLocation, string $startTime, $objects): array
    {
        $objectMap = $objects->keyBy(fn ($o) => 'object_' . $o->id);

        $shipments = [];
        foreach ($objects as $object) {
            $shipments[] = [
                'label' => 'object_' . $object->id,
                'pickups' => [
                    [
                        'arrivalWaypoint' => [
                            'location' => [
                                'latLng' => [
                                    'latitude' => $object->latitude,
                                    'longitude' => $object->longitude,
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }

        $body = [
            'timeout' => '10s',
            'model' => [
                'shipments' => $shipments,
                'vehicles' => [
                    [
                        'label' => 'vehicle_1',
                        'startWaypoint' => [
                            'location' => [
                                'latLng' => [
                                    'latitude' => $startLocation['lat'],
                                    'longitude' => $startLocation['lng'],
                                ]
                            ]
                        ],
                        'endWaypoint' => [
                            'location' => [
                                'latLng' => [
                                    'latitude' => $startLocation['lat'],
                                    'longitude' => $startLocation['lng'],
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->client->post(
            "https://routeoptimization.googleapis.com/v1/projects/{$this->projectId}:optimizeTours",
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/json',
                ],
                'json' => $body
            ]
        );

        $result = json_decode($response->getBody(), true);

        $orderedObjects = [];
        $optimizedOrder = [];

        foreach ($result['routes'][0]['visits'] as $visit) {
            $label = $visit['shipmentLabel'];
            if (isset($objectMap[$label])) {
                $orderedObjects[] = $objectMap[$label];
                $optimizedOrder[] = $objectMap[$label]->id;
            }
        }

        $route = $this->getRoutePolyline($startLocation, $orderedObjects);

        return [
            'optimized_order' => $optimizedOrder,
            'legs' => $route['legs'] ?? [],
            'polyline' => $route['polyline']['encodedPolyline'] ?? null,
        ];
    }

    /**
     * @param array $startLocation
     * @param array $orderedObjects
     * @return array
     * @throws GuzzleException
     */
    private function getRoutePolyline(array $startLocation, array $orderedObjects): array
    {
        $waypoints = array_map(fn($o) => [
            'location' => [
                'latLng' => [
                    'latitude' => $o->latitude,
                    'longitude' => $o->longitude,
                ]
            ]
        ], $orderedObjects);

        $routesResponse = $this->client->post(
            'https://routes.googleapis.com/directions/v2:computeRoutes',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/json',
                    'X-Goog-FieldMask' => 'routes.polyline.encodedPolyline,routes.legs'
                ],
                'json' => [
                    'origin' => [
                        'location' => [
                            'latLng' => [
                                'latitude' => $startLocation['lat'],
                                'longitude' => $startLocation['lng'],
                            ]
                        ]
                    ],
                    'destination' => [
                        'location' => [
                            'latLng' => [
                                'latitude' => $startLocation['lat'],
                                'longitude' => $startLocation['lng'],
                            ]
                        ]
                    ],
                    'intermediates' => $waypoints,
                    'travelMode' => 'DRIVE'
                ]
            ]
        );

        $data = json_decode($routesResponse->getBody(), true);

        return $data['routes'][0] ?? [];
    }
}