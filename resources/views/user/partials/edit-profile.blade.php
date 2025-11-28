<h2 class="text-2xl font-bold text-gray-900 pb-3">{{ __('messages.profile.menu.my_profile') }}</h2>

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div class="flex items-center space-x-6">
        <div class="relative">
            <img src="{{ $user->photo->secure_url ?? asset('images/avatar-placeholder.png') }}" alt="Profile photo" class="w-40 h-40 rounded-full object-cover border-4 border-gray-300 shadow-lg">
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('messages.profile.my_profile.profile_photo') }}
            </label>

            <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-cyan-600 file:text-white hover:file:bg-cyan-700 cursor-pointer">

            @error('photo')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex space-x-4">
        <div class="flex-1">
            <label for="first_name" class="block text-sm font-medium text-gray-700">{{ __('fields.first_name') }}</label>
            <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
            @error('first_name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex-1">
            <label for="last_name" class="block text-sm font-medium text-gray-700">{{ __('fields.last_name') }}</label>
            <input id="last_name" type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
            @error('last_name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="relative group">
        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('fields.email_address') }}</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
        @error('email')
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex space-x-4">
        <div class="flex-1">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('fields.new_password') }}</label>
            <input id="password" type="password" name="password" placeholder="{{ __('messages.profile.my_profile.new_password_placeholder') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
            @error('password')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex-1">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('fields.password_confirmation') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
        </div>
    </div>

    <div class="pt-2 flex justify-end">
        <button type="submit" class="py-2.5 px-4 rounded-lg bg-cyan-600 text-white font-semibold hover:bg-cyan-700 transition duration-200">
            {{ __('fields.save') }}
        </button>
    </div>
</form>