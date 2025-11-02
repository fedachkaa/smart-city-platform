<h2 class="text-2xl font-bold text-gray-900 pb-3">Edit Profile</h2>

@if(session('success'))
    <p class="text-sm text-green-700 bg-green-100 p-3 rounded-lg border border-green-300 text-center">
        {{ session('success') }}
    </p>
@endif

<form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf

    <div class="flex space-x-4">
        <div class="flex-1">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
            @error('first_name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex-1">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input id="last_name" type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
            @error('last_name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="relative group">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
        @error('email')
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex space-x-4">
        <div class="flex-1">
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input id="password" type="password" name="password" placeholder="Leave blank to keep current"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
            @error('password')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex-1">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
        </div>
    </div>

    <div class="pt-2 flex justify-end">
        <button type="submit" class="py-2.5 px-4 rounded-lg bg-cyan-600 text-white font-semibold hover:bg-cyan-700 transition duration-200">
            Save Changes
        </button>
    </div>
</form>