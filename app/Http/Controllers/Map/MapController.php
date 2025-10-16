<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Models\InfrastructureObject;
use Illuminate\Http\JsonResponse;

class MapController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $objects = InfrastructureObject::select([
            'id',
            'name',
            'type',
            'status',
            'latitude',
            'longitude',
            'description'
        ])->get();

        return response()->json($objects);
    }
}