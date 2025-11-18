<?php
$statusColor = match($userRequest->status) {
    \App\Enums\UserRequestStatus::New => 'bg-blue-100 text-blue-800',
    \App\Enums\UserRequestStatus::InProgress => 'bg-yellow-100 text-yellow-800',
    \App\Enums\UserRequestStatus::Resolved => 'bg-green-100 text-green-800',
    default => 'bg-gray-100 text-gray-800',
}
?>
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-2xl rounded-xl p-8">
        <div class="flex justify-between items-center">
            <button id="back-to-list" class="inline-block mt-4 py-2 px-4 bg-gray-200 rounded hover:bg-gray-300">
                ← Back
            </button>

            <h2 class="text-2xl font-bold text-gray-900 my-6">Request Details</h2>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">Title</h3>
            <p>{{ $userRequest?->title }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">Description</h3>
            <p>{{ $userRequest->description ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">City</h3>
            <p>{{ $userRequest->city->name ?? ''}}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">
                Status
                <span class="px-2 py-1 rounded text-xs font-medium {{ $statusColor }}">
                    {{ str_replace('_', ' ', $userRequest->status->value) }}
                </span>
            </h3>
        </div>

        @if($userRequest->photo)
            <div class="mb-4">
                <h3 class="text-lg font-semibold">Photo</h3>
                <img src="{{ asset('storage/' . $userRequest->photo) }}" alt="Request Photo" class="mt-2 max-w-full rounded">
            </div>
        @endif
    </div>
</div>