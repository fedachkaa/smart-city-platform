<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\UserRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardRequestController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $query = UserRequest::with('user', 'city', 'district');

        $query->searchByTitle($request->get('title'))
            ->ofStatus($request->get('status'))
            ->ofDistrict($request->get('district_id'))
            ->where('city_id', config('app.current_city_id'));

        $requests = $query->paginate(15)->withQueryString();

        $allStatuses = array_column(UserRequestStatus::cases(), 'value');
        $allDistricts = District::where('city_id', config('app.current_city_id'))
            ->get(['id', 'name'])
            ->toArray();

        return view('admin.requests.index', array_merge(compact('requests'), ['allStatuses' => $allStatuses, 'allDistricts' => $allDistricts]));
    }

    /**
     * @param UserRequest $request
     * @return View
     */
    public function edit(UserRequest $request): View
    {
        return view('admin.requests.edit', compact('request'));
    }

    /**
     * @param Request $httpRequest
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function update(Request $httpRequest, UserRequest $request): RedirectResponse
    {
//        $validated = $httpRequest->validate([
//            'title' => 'required|string|max:255',
//            'description' => 'nullable|string',
//        ]);
//
//        $request->update($validated);

        return redirect()->route('dashboard.requests.index')->with('success', 'Request updated successfully.');
    }

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function destroy(UserRequest $request): RedirectResponse
    {
        $request->delete();

        return redirect()->route('dashboard.requests.index')->with('success', 'Request deleted successfully.');
    }
}