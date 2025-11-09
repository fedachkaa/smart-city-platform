<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\UserRequest;
use App\Services\UserRequestService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DashboardRequestController extends Controller
{
    protected UserRequestService $userRequestService;

    /**
     * @param UserRequestService $userRequestService
     */
    public function __construct(UserRequestService $userRequestService)
    {
        $this->userRequestService = $userRequestService;
    }

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

        return view('admin.requests.index', array_merge(compact('requests'), $this->getFormOptions()));
    }

    /**
     * @param UserRequest $request
     * @return View
     */
    public function edit(UserRequest $request): View
    {
        return view('admin.requests.edit', array_merge(compact('request'), $this->getFormOptions()));
    }

    /**
     * @param Request $httpRequest
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function update(Request $httpRequest, UserRequest $request): RedirectResponse
    {
        $validated = $httpRequest->validate([
            'status' => 'required|string|in:' . implode(',', array_column(UserRequestStatus::cases(), 'value')),
            'infrastructure_object_id' => ['nullable', Rule::exists('infrastructure_objects', 'id')],
            'system_notes' => 'nullable|string',
        ]);

        $this->userRequestService->update($request, $validated);

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

    /**
     * @return array
     */
    private function getFormOptions(): array
    {
        return [
            'allStatuses' => array_column(UserRequestStatus::cases(), 'value'),
            'allDistricts' =>  District::where('city_id', config('app.current_city_id'))
                ->get(['id', 'name'])
                ->toArray()
        ];
    }
}