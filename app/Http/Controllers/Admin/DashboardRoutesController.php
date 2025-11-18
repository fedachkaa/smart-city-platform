<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InfrastructureObjectStatus;
use App\Http\Controllers\Controller;
use App\Models\InfrastructureObject;
use App\Models\Route;
use App\Services\RouteOptimizerService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardRoutesController extends Controller
{
    protected RouteOptimizerService $routeOptimizerService;

    /**
     * @param RouteOptimizerService $routeOptimizerService
     */
    public function __construct(RouteOptimizerService $routeOptimizerService)
    {
        $this->routeOptimizerService = $routeOptimizerService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $query = Route::with('objects', 'creator')
            ->where('city_id', config('app.current_city_id'));

        $routes = $query->paginate(15)->withQueryString();

        return view('admin.routes.index', compact('routes'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $objects = InfrastructureObject::query()
            ->where('city_id', config('app.current_city_id'))
            ->where('status', InfrastructureObjectStatus::Error->value)
            ->select('id', 'name', 'public_address')
            ->get();

        return view('admin.routes.create', compact('objects'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_point' => 'required|string',
            'start_time' => 'required|string',
            'start_point_address' => 'required|string',
            'object_ids' => 'required|array|min:1|max:5',
            'object_ids.*' => 'exists:infrastructure_objects,id',
            'route_polyline' => 'required|string',
            'route_legs' => 'required|array',
            'optimized_order' => 'required|array',
        ]);

        [$lat, $lng] = array_map('trim', explode(',', $validated['start_point']));

        $route = Route::create([
            'city_id' => config('app.current_city_id'),
            'name' => $validated['name'],
            'created_by' => auth()->id(),
            'start_time' => $validated['start_time'],
            'route' => [
                'polyline' => $validated['route_polyline'],
                'legs' => $validated['route_legs'],
                'optimized_order' => $validated['optimized_order'],
                'start_point' => [
                    'lat' => (float) $lat,
                    'lng' => (float) $lng,
                    'address' => $validated['start_point_address'],
                ],
            ],
        ]);

        $route->objects()->attach($validated['object_ids']);

        InfrastructureObject::whereIn('id', $validated['object_ids'])->update(['status' => InfrastructureObjectStatus::Maintenance]);

        return response()->json(['success' => true, 'route_id' => $route->id]);
    }

    /**
     * @param Route $route
     * @return View
     */
    public function edit(Route $route): View
    {
        return view('admin.routes.edit', compact('route'));
    }

    /**
     * @param Route $route
     * @return RedirectResponse
     */
    public function destroy(Route $route): RedirectResponse
    {
        $route->delete();

        return redirect()->route('dashboard.routes.index')->with('success', 'Route deleted successfully.');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function previewRoute(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_point' => ['required', 'regex:/^-?\d{1,3}\.\d+,\s*-?\d{1,3}\.\d+$/'],
            'object_ids' => 'required|array|min:1|max:5',
            'object_ids.*' => 'exists:infrastructure_objects,id',
        ]);

        [$lat, $lng] = array_map('trim', explode(',', $validated['start_point']));
        $validated['start_location'] = [
            'lat' => (float) $lat,
            'lng' => (float) $lng,
        ];

        $objects = InfrastructureObject::whereIn('id', $validated['object_ids'])->get();

        try {
            $routeData = $this->routeOptimizerService->buildOptimizedRoute($validated['start_location'], $objects);
            return response()->json([
                'success' => true,
                'route' => $routeData,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.dashboard.route_build_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }
}