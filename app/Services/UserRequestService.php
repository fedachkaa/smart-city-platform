<?php

namespace App\Services;

use App\Enums\UserRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\UserRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserRequestService
{
    /** @var string */
    protected string $n8nWebhookUrl;

    /** @var string */
    private const PATH_REQUEST_CREATED = '/user-request-created';
    private const PATH_STATUS_CHANGED = '/user-request-updated';

    public function __construct()
    {
        $this->n8nWebhookUrl = 'http://host.docker.internal:5678/webhook';
    }

    /**
     * @param Request $request
     * @return UserRequest
     */
    public function create(Request $request): UserRequest
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

        $userRequest = UserRequest::create($validated);

        $this->triggerN8nUserRequestCreated($userRequest);

        return $userRequest;
    }

    /**
     * @param Request $request
     * @param UserRequest $userRequest
     * @return UserRequest
     */
    public function update(Request $request, UserRequest $userRequest): UserRequest
    {
        $originalStatus = $userRequest->status->value;

        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', array_column(UserRequestStatus::cases(), 'value')),
            'infrastructure_object_id' => ['nullable', Rule::exists('infrastructure_objects', 'id')],
            'system_notes' => 'nullable|string',
        ]);

        $validated['system_notes'] = $validated['system_notes'] ?? '';

        $userRequest->update($validated);

        if (isset($validated['status']) && $validated['status'] !== $originalStatus) {
            $this->triggerN8nUserRequestUpdated($userRequest);
        }

        return $userRequest;
    }

    /**
     * @param UserRequest $request
     * @return void
     */
    private function triggerN8nUserRequestCreated(UserRequest $request): void
    {
        $payload = [
            'requestUrl' => route('dashboard.requests.edit', ['request' => $request]),
            'recipient' => config('notifications.admin_email'),
        ];

        try {
            Http::post($this->n8nWebhookUrl . self::PATH_REQUEST_CREATED, $payload);
        } catch (\Exception $e) {
            Log::error("Failed to trigger n8n for request created {$request->id}: " . $e->getMessage());
        }
    }

    /**
     * @param UserRequest $request
     * @return void
     */
    protected function triggerN8nUserRequestUpdated(UserRequest $request): void
    {
        $payload = [
            'id' => $request->id,
            'status' => $request->status,
            'requestTitle' => $request->title,
            'requestUrl' => route('profile.index', ['userRequestId' => $request->id]),
            'recipient' => $request->user->email,
            'name' => $request->user->first_name,
        ];

        try {
            Http::post($this->n8nWebhookUrl .  self::PATH_STATUS_CHANGED, $payload);
        } catch (\Exception $e) {
            Log::error("Failed to trigger n8n for request updated {$request->id}: " . $e->getMessage());
        }
    }
}
