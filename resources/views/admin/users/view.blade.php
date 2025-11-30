@extends('layouts.app')

@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
            <a href="{{ route('dashboard.users.index') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                ← Back to List
            </a>

            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                User Details
            </h1>
        </div>
    </header>

    <main class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-gray-50 p-6 rounded-lg border-t-4 border-cyan-500 shadow-inner">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">General Information</h3>

                <div class="flex items-center justify-between">
                    <div class="w-4/5">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" value="{{ $user->first_name }}" readonly disabled class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 bg-gray-100">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" value="{{ $user->last_name }}" readonly disabled class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 bg-gray-100">
                        </div>

                        <div class="space-y-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="text" value="{{ $user->email }}" readonly disabled class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-2 bg-gray-100">
                        </div>
                    </div>

                    <div class="w-1/5 flex justify-center">
                        <img src="{{ $user->photo->secure_url ?? asset('images/avatar-placeholder.png') }}" alt="Avatar" class="w-32 h-32 rounded-full object-cover border border-gray-300 shadow">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-xl border-l-4 border-gray-400">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Metadata</h3>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Created At</label>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ $user->created_at->format('M j, Y H:i') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            ({{ $user->created_at->diffForHumans() }})
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ $user->updated_at->format('M j, Y H:i') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            ({{ $user->updated_at->diffForHumans() }})
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">User Requests</h3>

                @if ($user->requests->isEmpty())
                    <p class="text-gray-500">This user has no requests.</p>
                @else
                    <ul class="list-decimal ml-6 space-y-2">
                        @foreach ($user->requests as $req)
                            <li class="text-gray-800">
                                <a href="{{ route('dashboard.requests.edit', $req) }}" target="_blank" class="text-cyan-600 hover:underline font-medium">
                                    {{ $req->title }}
                                </a>
                                <span class="text-xs text-gray-500">
                                    — {{ $req->created_at->format('Y-m-d') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </main>
@endsection
