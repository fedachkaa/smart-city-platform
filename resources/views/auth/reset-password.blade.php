@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-sm p-8 space-y-8 bg-white rounded-xl shadow-2xl transform transition duration-500 hover:shadow-cyan-400/50">
            @if (session('status'))
                <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <h2 class="text-3xl font-extrabold text-gray-900 text-center tracking-tight">
                Reset your password
            </h2>
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="relative group">
                    <label for="email" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">
                        Email Address
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm @error('email') border-red-500 @enderror transition duration-150 ease-in-out"
                               value="{{ old('email', request()->email) }}"
                               placeholder="you@example.com">
                    </div>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative group">
                    <label for="password" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">New Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                               class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm @error('password') border-red-500 @enderror transition duration-150 ease-in-out"
                               placeholder="••••••••">
                    </div>
                    @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative group">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 group-focus-within:text-cyan-600 transition duration-200">Confirm Password</label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                               class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm transition duration-150 ease-in-out"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="cursor-pointer w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-lg text-sm font-semibold text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transform transition duration-200 ease-in-out active:scale-95">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection