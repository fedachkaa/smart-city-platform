@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-sm p-8 space-y-8 bg-white shadow-2xl rounded-xl transform transition duration-500 hover:shadow-cyan-400/50">

            <h2 class="text-3xl font-extrabold text-gray-900 text-center tracking-tight">
                Welcome Back!
            </h2>

            <p class="text-center text-sm text-gray-500">
                Sign in to access your account.
            </p>

            @if ($errors->has('loginError'))
                <p class="text-sm text-red-700 bg-red-100 p-3 rounded-lg border border-red-300 text-center transition duration-300">
                    {{ $errors->first('loginError') }}
                </p>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <div class="relative group">
                    <label for="email" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-cyan-500 focus:border-cyan-500 focus:ring-1 sm:text-sm transition duration-150 ease-in-out">
                    @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative group">
                    <label for="password" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-cyan-500 focus:border-cyan-500 focus:ring-1 sm:text-sm transition duration-150 ease-in-out">
                    @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="cursor-pointer w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-lg text-sm font-semibold text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transform transition duration-200 ease-in-out active:scale-95">
                        Login
                    </button>
                </div>
            </form>

            <div class="text-center text-sm text-gray-600 border-t pt-4">
                <a href="/forget-password" class="font-medium text-cyan-600 hover:text-cyan-800 transition duration-150">
                    Trouble logging in?
                </a>
            </div>
        </div>
    </div>
@endsection