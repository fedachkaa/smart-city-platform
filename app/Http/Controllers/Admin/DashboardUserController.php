<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = User::with('requests');
        $guestRole = UserRole::where('name', UserRole::USER_ROLE_GUEST)->first();

        $query->searchByNameEmail($request->get('search'))
            ->where('role_id', $guestRole->id)
            ->where('city_id', config('app.current_city_id'));

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.users.view', compact('user'));
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('dashboard.users.index')->with('success', __('messages.dashboard.users.deleted_successfully'));
    }
}