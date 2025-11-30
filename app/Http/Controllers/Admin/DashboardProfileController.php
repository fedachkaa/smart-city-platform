<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardProfileController extends Controller
{
    /** @var UserService */
    private $userService;

    /**
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    /**
     * @return View
     */
    public function edit(): View
    {
        $admin = auth()->user();

        return view('admin.profile.edit', compact('admin'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->userService->update(auth()->user(), $request);

        return redirect()->route('dashboard.profile.edit')->with('success', __('messages.dashboard.profile.updated_successfully'));
    }
}