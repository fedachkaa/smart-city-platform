<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @return View|RedirectResponse
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::user()) {
            return redirect()->to($this->getRedirectPath(Auth::user()->load('role'))); //($this->getRedirectPath(Auth::user()));
        }

        return view('auth.login');
    }

    /**
     * Handle the incoming authentication request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user()->load('role');

            return redirect()->intended($this->getRedirectPath($user));
        }

        return back()->withErrors([
            'loginError' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * @param User $user
     * @return string
     */
    private function getRedirectPath(User $user): string
    {
        return match ($user->role->name) {
            UserRole::USER_ROLE_ADMIN, UserRole::USER_ROLE_OPERATOR => '/dashboard',
            default => '/',
        };
    }
}