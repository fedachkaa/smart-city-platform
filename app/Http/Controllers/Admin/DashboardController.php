<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfrastructureObject;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard.
     */
    public function index()
    {
        $user = Auth::user()->load('role');
        $userRoleName = $user->role->name ?? 'User';

        $stats = [
            'total_objects' => InfrastructureObject::count(),
            'active_objects' => InfrastructureObject::where('status', 'Active')->count(),
            'maintenance_objects' => InfrastructureObject::where('status', 'Maintenance')->count(),
            'error_objects' => InfrastructureObject::where('status', 'Error')->count(),
        ];

        $recentObjects = InfrastructureObject::orderBy('created_at', 'desc')->take(5)->get();

        $data = [
            'userName' => $user->name,
            'userRole' => $userRoleName,
            'stats' => $stats,
            'recentObjects' => $recentObjects,
        ];

        return view('admin.index', $data);
    }
}