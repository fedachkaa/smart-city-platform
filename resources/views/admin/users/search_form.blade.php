<div class="bg-white shadow-lg rounded-lg mb-8 p-6">
    <form method="GET" action="{{ route('dashboard.users.index') }}" class="space-y-4">
        <div class="flex items-center justify-between">
            <div class="w-3/5">
                <label for="search" class="block text-sm font-medium text-gray-700">Search by first name, last name, email</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="p-2  mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700">
                    Search
                </button>
                <a href="{{ route('dashboard.users.index') }}" class="py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Clear
                </a>
            </div>
        </div>
    </form>
</div>