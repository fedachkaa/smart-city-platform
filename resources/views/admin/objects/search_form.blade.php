<div class="bg-white shadow-lg rounded-lg mb-8 p-6">
    <form method="GET" action="{{ route('dashboard.objects.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ request('name') }}" class="p-2  mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                    <option value="">All Statuses</option>
                    @foreach ($allStatuses as $status)
                        <option value="{{ $status }}" @if(request('status') === $status) selected @endif>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select name="type" id="type" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                    <option value="">All Types</option>
                    @foreach ($allTypes as $type)
                        <option value="{{ $type }}" @if(request('type') === $type) selected @endif>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="district" class="block text-sm font-medium text-gray-700">District</label>
                <input type="text" name="district" id="district" value="{{ request('district') }}" class="p-2  mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700">
                    Search
                </button>
                <a href="{{ route('dashboard.objects.index') }}" class="py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Clear
                </a>
            </div>
        </div>
    </form>
</div>