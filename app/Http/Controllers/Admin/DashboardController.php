<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $roleName = $user->role->name ?? UserRole::USER_ROLE_GUEST;

        $data = [
            'userName' => $user->name,
            'userEmail' => $user->email,
            'userRole' => $roleName,
        ];

        return view('dashboard.index', $data);
    }
}