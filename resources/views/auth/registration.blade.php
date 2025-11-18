@extends('layouts.app')

@section('head')
    @vite('resources/js/registration.js')
@endsection

@section('content')
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-3xl p-8 space-y-8 bg-white shadow-2xl rounded-xl transform transition duration-500 hover:shadow-cyan-400/50">

            <h2 class="text-3xl font-extrabold text-gray-900 text-center tracking-tight">
                {{ __('messages.register.title') }}
            </h2>

            <p class="text-center text-sm text-gray-500">
                {{ __('messages.register.subtitle') }}
            </p>

            @if ($errors->any())
                <div class="text-sm text-red-700 bg-red-100 p-3 rounded-lg border border-red-300 text-center transition duration-300">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative group">
                        <label for="first_name" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">
                            {{ __('messages.register.first_name') }}
                        </label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-cyan-500 focus:border-cyan-500 focus:ring-1 sm:text-sm transition duration-150 ease-in-out">
                        @error('first_name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative group">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">
                            {{ __('messages.register.last_name') }}
                        </label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-cyan-500 focus:border-cyan-500 focus:ring-1 sm:text-sm transition duration-150 ease-in-out">
                        @error('last_name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative group">
                        <label for="email" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">
                            {{ __('messages.register.email_address') }}
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-cyan-500 focus:border-cyan-500 focus:ring-1 sm:text-sm transition duration-150 ease-in-out">
                        @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative group">
                        <label for="city" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">
                            {{ __('messages.register.city') }}
                        </label>
                        <input id="city" type="text" name="city" value="{{ old('city') }}" autocomplete="off" placeholder="{{ __('messages.register.city_placeholder') }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-cyan-500 focus:border-cyan-500 focus:ring-1 sm:text-sm transition duration-150 ease-in-out">
                        <ul id="city-results" class="absolute bg-white border border-gray-300 rounded-md w-full hidden z-10"></ul>
                        <input type="hidden" name="city_id" id="city_id" value="{{ old('city_id') }}">
                        @error('city_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative group">
                        <label for="password" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">
                            {{ __('messages.register.password') }}
                        </label>
                        <input id="password" type="password" name="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-cyan-500 focus:border-cyan-500 focus:ring-1 sm:text-sm transition duration-150 ease-in-out">
                        @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative group">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">
                            {{ __('messages.register.password_confirmation') }}
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-cyan-500 focus:border-cyan-500 focus:ring-1 sm:text-sm transition duration-150 ease-in-out">
                        @error('password_confirmation')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="cursor-pointer w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-lg text-sm font-semibold text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transform transition duration-200 ease-in-out active:scale-95">
                        {{ __('messages.register.register') }}
                    </button>
                </div>
            </form>

            <div class="text-center text-sm text-gray-600 border-t pt-4">
                <a href="{{ route('login') }}" class="font-medium text-cyan-600 hover:text-cyan-800 transition duration-150">
                    {{ __('messages.register.already_have_account') }}
                </a>
            </div>
        </div>
    </div>
@endsection