<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    /**
     * @return View|RedirectResponse
     */
    public function showRegistrationForm(): View|RedirectResponse
    {
        return view('auth.registration');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        $guestRole = UserRole::where('name', UserRole::USER_ROLE_GUEST)->first();

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|confirmed|min:8',
            'city_id' => ['required', 'integer', Rule::exists('cities', 'id')],
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['role_id'] = $guestRole->id;

        $user = User::create($validatedData);

        Auth::login($user);

        return redirect()->route('homepage')->with('success', 'You have been successfully registered!.');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function citiesList(Request $request): JsonResponse
    {
        $search = $request->get('q', '');
        $cities = City::where('name', 'like', $search . '%')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($cities);
    }
}