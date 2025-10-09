<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user()->load('role');
        $userRoleName = $user->role->name ?? UserRole::USER_ROLE_GUEST;

        if (in_array($userRoleName, $roles)) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You are not authorized to access the dashboard.');
    }
}