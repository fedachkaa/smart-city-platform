<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Models\InfrastructureObject;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class MapController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $city = config('app.current_city');
        return view('welcome', compact('city'));
    }

    /**
     * @return JsonResponse
     */
    public function getMapData(): JsonResponse
    {
        $objects = InfrastructureObject::select([
            'id',
            'name',
            'type',
            'status',
            'latitude',
            'longitude',
            'description'
        ])->where('city_id', config('app.current_city_id'))->get();

        return response()->json($objects);
    }
}