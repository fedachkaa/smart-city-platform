<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\UserRequest;
use Illuminate\Support\Facades\Log;

class UserRequestService
{
    protected string $n8nWebhookUrl;

    public function __construct()
    {
        $this->n8nWebhookUrl = 'http://host.docker.internal:5678/webhook/new-user-request';
    }

    /**
     * Update a user request and trigger n8n if status changed
     */
    public function update(UserRequest $request, array $validated): void
    {
        $originalStatus = $request->status->value;

        $validated['system_notes'] = $validated['system_notes'] ?? '';

        $request->update($validated);

        if (isset($validated['status']) && $validated['status'] !== $originalStatus) {
            $this->triggerN8n($request);
        }
    }

    /**
     * @param UserRequest $request
     * @return void
     */
    protected function triggerN8n(UserRequest $request): void
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
            Http::post($this->n8nWebhookUrl, $payload);
        } catch (\Exception $e) {
            Log::error("Failed to trigger n8n for request {$request->id}: " . $e->getMessage());
        }
    }
}
