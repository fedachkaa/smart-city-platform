<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-2xl rounded-xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Create New Request</h2>

        <form method="POST" action="{{ route('profile.requests.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="relative group">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                @error('title')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative group">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">{{ old('description') }}</textarea>
                @error('description')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative group">
                <input type="hidden" name="city_id" id="city_id" value="{{ $currentCityId }}">
            </div>

            <div class="relative group">
                <label for="district_id" class="block text-sm font-medium text-gray-700">District</label>
                <select id="district_id" name="district_id"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                    <option value="">Select District</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
                @error('district_id')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative group">
                <label for="infrastructure_object_id" class="block text-sm font-medium text-gray-700">Infrastructure Object</label>
                <select id="infrastructure_object_id" name="infrastructure_object_id"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                </select>
                @error('infrastructure_object_id')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative group">
                <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                <input type="file" name="photo" id="photo"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-lg file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                @error('photo')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-lg bg-cyan-600 text-white font-semibold hover:bg-cyan-700 transition duration-200">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    @vite('resources/js/profile/new-request.js')
@endpush
