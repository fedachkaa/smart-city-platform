<?php

namespace App\Http\Middleware;

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
            config(['app.current_city_id' => Auth::user()->city_id]);
            view()->share('currentCityId', Auth::user()->city_id);
        } else {
            config(['app.current_city_id' => null]);
        }

        return $next($request);
    }
}
