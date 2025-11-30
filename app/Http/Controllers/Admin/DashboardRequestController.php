<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\UserRequest;
use App\Services\UserRequestService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = UserRequest::with('user', 'city');

        $query->searchByTitle($request->get('title'))
            ->searchByCreator($request->get('created_by'))
            ->ofStatus($request->get('status'))
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
        $this->userRequestService->update($httpRequest, $request);

        return redirect()->route('dashboard.requests.index')->with('success', __('messages.dashboard.requests.updated_successfully'));
    }

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function destroy(UserRequest $request): RedirectResponse
    {
        $request->delete();

        return redirect()->route('dashboard.requests.index')->with('success', __('messages.dashboard.requests.deleted_successfully'));
    }

    /**
     * @return array
     */
    private function getFormOptions(): array
    {
        return [
            'allStatuses' => array_column(UserRequestStatus::cases(), 'value'),
        ];
    }
}