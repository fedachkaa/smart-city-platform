<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InfrastructureObjectStatus;
use App\Http\Controllers\Controller;
use App\Models\InfrastructureObject;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard.
     */
    public function index()
    {
        $user = Auth::user()->load('role');
        $userRoleName = $user->role->name;
        $cityId = config('app.current_city_id');

        $stats = [
            'total_objects' => InfrastructureObject::where('city_id', $cityId)->count(),
            'active_objects' => InfrastructureObject::where('city_id', $cityId)->where('status', InfrastructureObjectStatus::Active)->count(),
            'maintenance_objects' => InfrastructureObject::where('city_id', $cityId)->where('status', InfrastructureObjectStatus::Maintenance)->count(),
            'error_objects' => InfrastructureObject::where('city_id', $cityId)->where('status', InfrastructureObjectStatus::Error)->count(),
        ];

        $chartDataByType = InfrastructureObject::where('city_id', $cityId)
            ->selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        $chartDataByStatus = InfrastructureObject::where('city_id', $cityId)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $data = [
            'userName' => $user->name,
            'userRole' => $userRoleName,
            'stats' => $stats,
            'recentObjects' => InfrastructureObject::where('city_id', $cityId)->orderBy('created_at', 'desc')->take(5)->get(),
            'chartData' => [
                'byType' => $chartDataByType,
                'byStatus' => $chartDataByStatus,
            ],
        ];

        return view('admin.index', $data);
    }
}