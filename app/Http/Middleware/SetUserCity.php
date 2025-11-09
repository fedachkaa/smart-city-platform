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
        if (Auth::check() && Auth::user()->city_id) {
            $city = Auth::user()->city;
        } else {
            $ip = $request->ip();
            $geo = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}?fields=lat,lon,city"), true);
            if ($geo && isset($geo['city'])) {
                $dbCity = City::where('name', $geo['city'])->first();

                if ($dbCity) {
                    $city = $dbCity;
                }
            }
        }

        if (empty($city)) {
            $city = City::where('name', 'Kyiv')->first();
        }

        config(['app.current_city_id' => $city->id]);
        config(['app.current_city' => $city]);
        view()->share('currentCityId', $city->id);
        view()->share('currentCity', $city);

        return $next($request);
    }
}
