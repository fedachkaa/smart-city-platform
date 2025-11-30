@extends('layouts.app')

@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-end">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                Edit Admin
            </h1>
        </div>
    </header>

    <main class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                     role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="bg-gray-50 p-6 rounded-lg border-t-4 border-cyan-500 shadow-inner">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">General Information</h3>

                        <div class="flex items-center justify-between">
                            <div class="w-4/5 space-y-4">

                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $admin->first_name) }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-cyan-500">
                                    @error('first_name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $admin->last_name) }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-cyan-500">
                                    @error('last_name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-cyan-500">
                                    @error('email') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Password</label>
                                    <input type="password" name="password" placeholder="Leave blank to keep current" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 bg-white focus:ring-cyan-500 focus:border-cyan-500">
                                </div>

                            </div>

                            <div class="w-1/5 flex flex-col items-center space-y-4">
                                <img src="{{ $admin->photo->secure_url ?? asset('images/avatar-placeholder.png') }}" alt="Avatar" class="w-32 h-32 rounded-full object-cover border border-gray-300 shadow">

                                <input type="file" name="photo" class="block w-3/4 text-sm text-gray-600">
                                @error('photo') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-xl border-l-4 border-gray-400 mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Metadata</h3>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Created At</label>
                                <p class="mt-1 text-base font-semibold text-gray-900">
                                    {{ $admin->created_at->format('M j, Y H:i') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    ({{ $admin->created_at->diffForHumans() }})
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                <p class="mt-1 text-base font-semibold text-gray-900">
                                    {{ $admin->updated_at->format('M j, Y H:i') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    ({{ $admin->updated_at->diffForHumans() }})
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="submit" class="cursor-pointer inline-flex justify-center py-2 px-6 border border-transparent shadow-lg text-lg font-semibold rounded-lg text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-cyan-500 transition active:scale-95">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection