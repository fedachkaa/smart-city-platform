<?php

namespace App\Http\Controllers\User;

use App\Enums\UserRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\InfrastructureObject;
use App\Models\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RequestController extends Controller
{
    /**
     * @param UserRequest $userRequest
     * @return string
     */
    public function show(UserRequest $userRequest)
    {
        $userRequest->load(['city', 'district', 'infrastructureObject']);

        return view('user.partials.show-request', compact('userRequest'))->render();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'city_id' => ['required', Rule::exists('cities', 'id')],
            'district_id' => ['required', Rule::exists('districts', 'id')],
            'infrastructure_object_id' => ['nullable', Rule::exists('infrastructure_objects', 'id')],
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('requests', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = UserRequestStatus::New;

        UserRequest::create($validated);

        return redirect()->route('profile.index')->with('success', 'Your request has been submitted successfully!');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getRequests(Request $request): JsonResponse
    {
        $perPage = 10;
        $page = $request->input('page', 1);

        $requests = UserRequest::with(['city', 'district', 'infrastructureObject'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $requests->items(),
            'current_page' => $requests->currentPage(),
            'last_page' => $requests->lastPage(),
            'total' => $requests->total(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getInfrastructureObjectsList(Request $request): JsonResponse
    {
        $query = InfrastructureObject::query();

        $query->where('city_id', config('app.current_city_id'));

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        $objects = $query->select('id', 'name', 'public_address')->get();

        return response()->json([
            'success' => true,
            'data' => $objects,
        ]);
    }
}