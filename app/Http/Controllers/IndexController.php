<?php

namespace App\Http\Controllers;

use App\Models\InfrastructureObject;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class IndexController extends Controller
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

    /**
     * @param $lang
     * @return RedirectResponse
     */
    public function switchLanguage($lang): RedirectResponse
    {
        if (in_array($lang, ['en', 'uk'])) {
            session(['locale' => $lang]);
        }

        return redirect()->back();
    }
}