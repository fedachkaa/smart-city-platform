<h2 class="text-2xl font-bold text-gray-900 pb-3">My Requests</h2>

<div id="requests-container" class="space-y-4"></div>

<div class="flex justify-between items-center mt-4">
    <p id="pagination-info" class="text-gray-600 text-sm"></p>

    <div class="space-x-2">
        <button id="prev-btn" class="bg-gray-200 px-3 py-1 rounded disabled:opacity-50">Prev</button>
        <button id="next-btn" class="bg-gray-200 px-3 py-1 rounded disabled:opacity-50">Next</button>
    </div>
</div>

@push('scripts')
    @vite('resources/js/profile/requests-list.js')
@endpush