<div class="bg-gray-50 p-6 rounded-lg border-t-4 border-cyan-500 shadow-inner">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">General Information</h3>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <div class="space-y-1">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $object->name ?? '') }}" required class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition duration-150 sm:text-sm">
            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1">
            <label for="district" class="block text-sm font-medium text-gray-700">District</label>
            <input type="text" name="district" id="district" value="{{ old('district', $object->district ?? '') }}" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition duration-150 sm:text-sm">
            @error('district')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1">
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select name="type" id="type" required class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 sm:text-sm">
                @foreach ($types as $type)
                    <option value="{{ $type->value }}" @if(old('type', $object->type->value ?? '') === $type->value) selected @endif>
                        {{ $type->value }}
                    </option>
                @endforeach
            </select>
            @error('type')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" required class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 sm:text-sm">
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @if(old('status', $object->status->value ?? '') === $status->value) selected @endif>
                        {{ $status->value }}
                    </option>
                @endforeach
            </select>
            @error('status')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-xl mt-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Geographical Coordinates</h3>
    <p class="text-sm text-gray-500 mb-4">Coordinates must be highly accurate (up to 8 decimal places).</p>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <div class="space-y-1">
            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
            <input type="number" step="0.00000001" name="latitude" id="latitude" value="{{ old('latitude', $object->latitude ?? '') }}" required class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 sm:text-sm">
            @error('latitude')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1">
            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
            <input type="number" step="0.00000001" name="longitude" id="longitude" value="{{ old('longitude', $object->longitude ?? '') }}" required class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 sm:text-sm">
            @error('longitude')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

<div class="mt-6 bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Description</h3>
    <label for="description" class="block text-sm font-medium text-gray-700">Detailed Description</label>
    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 sm:text-sm">
        {{ old('description', $object->description ?? '') }}
    </textarea>
    @error('description')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
</div>

@if(isset($object) && $object->exists)
    <div class="bg-white p-6 rounded-lg shadow-xl mt-6 border-l-4 border-gray-400">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Object Metadata</h3>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            {{-- Created By --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Created By</label>
                <p class="mt-1 text-base font-semibold text-gray-900">
                    {{ $object->creator->name ?? 'System' }}
                </p>
                <p class="text-xs text-gray-500">
                    {{ $object->creator->email ?? 'N/A' }}
                </p>
            </div>

            {{-- Created At --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Created At</label>
                <p class="mt-1 text-base font-semibold text-gray-900">
                    {{ $object->created_at->format('M j, Y') }}
                </p>
                <p class="text-xs text-gray-500" title="{{ $object->created_at->diffForHumans() }}">
                    ({{ $object->created_at->diffForHumans() }})
                </p>
            </div>

            {{-- Last Updated At --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Last Updated At</label>
                <p class="mt-1 text-base font-semibold text-gray-900">
                    {{ $object->updated_at->format('M j, Y \a\t H:i') }}
                </p>
                <p class="text-xs text-gray-500" title="{{ $object->updated_at->diffForHumans() }}">
                    ({{ $object->updated_at->diffForHumans() }})
                </p>
            </div>

        </div>
    </div>
@endif

<div class="mt-8 pt-5 border-t border-gray-200">
    <div class="flex justify-end">
        <button type="submit" class="ml-3 cursor-pointer inline-flex justify-center py-2 px-6 border border-transparent shadow-lg text-lg font-semibold rounded-lg text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transform transition duration-150 ease-in-out active:scale-95">
            {{ $buttonText ?? 'Save Object' }}
        </button>
    </div>
</div>