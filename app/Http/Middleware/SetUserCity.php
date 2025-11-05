<?php

namespace App\Http\Middleware;

use App\Models\City;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetUserCity
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $city = City::where('name', 'Kyiv')->first();

        if (Auth::check() && Auth::user()->city_id) {
            $city = Auth::user()->city;
        }

        config(['app.current_city_id' => $city->id]);
        view()->share('currentCityId', $city->id);
        view()->share('currentCity', $city);

        return $next($request);
    }
}
