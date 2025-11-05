@extends('layouts.app')

@section('head')
    @vite('resources/js/admin/user-requests/edit.js')
@endsection

@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
            <a href="{{ route('dashboard.requests.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                ← Back to List
            </a>
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                View User Request
            </h1>
        </div>
    </header>

    <main class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('dashboard.requests.update', $request) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-gray-50 p-6 rounded-lg border-t-4 border-cyan-500 shadow-inner">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">General Information</h3>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-1">
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-lg border border-gray-200 bg-gray-100 shadow-sm p-2 text-gray-700 sm:text-sm cursor-not-allowed"
                                       value="{{ old('title', $request->title ?? '') }}" readonly>
                            </div>

                            <div class="space-y-1">
                                <label for="district_id" class="block text-sm font-medium text-gray-700">District</label>
                                <select name="district_id" id="district_id" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 sm:text-sm">
                                    <option value="">All Districts</option>
                                    @foreach ($allDistricts as $district)
                                        <option value="{{ $district['id'] }}" @if(old('district_id', $request->district_id ?? '') === $district['id']) selected @endif>
                                            {{ $district['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('district_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1 md:col-span-2">
                                <label for="infrastructure_object_id" class="block text-sm font-medium text-gray-700">Infrastructure Object</label>
                                <select name="infrastructure_object_id" id="infrastructure_object_id" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 bg-gray-100 sm:text-sm disabled:cursor-not-allowed">
                                    @if ($request->infrastructure_object_id)
                                        <option value="{{ $request->infrastructure_object_id }}" selected>{{ $request->infrastructureObject->name }}</option>
                                    @else
                                        <option value="">Select a district first</option>
                                    @endif
                                </select>
                                @error('infrastructure_object_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label for="description" class="block text-sm font-medium text-gray-700">Detailed Description</label>
                                <textarea id="description" rows="4" readonly class="mt-1 block w-full rounded-lg border border-gray-200 bg-gray-100 shadow-sm p-2 text-gray-700 sm:text-sm cursor-not-allowed"
                                          name="description">{{ old('description', $request->description ?? '') }}</textarea>
                            </div>

                            <div class="space-y-1">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 sm:text-sm">
                                    @foreach ($allStatuses as $status)
                                        <option value="{{ $status }}" @if(old('status', $request->status ?? '') === $status) selected @endif>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 bg-white p-6 rounded-lg shadow-md border-l-4 border-cyan-500">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">System Notes (Internal Use)</h3>
                        <label for="system_notes" class="block text-sm font-medium text-gray-700">System Notes</label>
                        <textarea id="system_notes" rows="3" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 sm:text-sm"
                                  name="system_notes">{{ old('system_notes', $request->system_notes ?? '') }}</textarea>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-xl mt-6 border-l-4 border-gray-400">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Request Metadata</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                            <div>
                                <label class="block text-gray-600 font-medium mb-1">Created By</label>
                                <p class="text-base font-semibold text-gray-900">
                                    {{ $request->user->full_name ?? 'Unknown' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $request->user->email ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-600 font-medium mb-1">Created At</label>
                                <p class="text-base font-semibold text-gray-900">
                                    {{ $request->created_at->format('M j, Y') }}
                                </p>
                                <p class="text-xs text-gray-500" title="{{ $request->created_at->diffForHumans() }}">
                                    ({{ $request->created_at->diffForHumans() }})
                                </p>
                            </div>

                            <div>
                                <label class="block text-gray-600 font-medium mb-1">Last Updated At</label>
                                <p class="text-base font-semibold text-gray-900">
                                    {{ $request->updated_at->format('M j, Y \a\t H:i') }}
                                </p>
                                <p class="text-xs text-gray-500" title="{{ $request->updated_at->diffForHumans() }}">
                                    ({{ $request->updated_at->diffForHumans() }})
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="submit" class="ml-3 cursor-pointer inline-flex justify-center py-2 px-6 border border-transparent shadow-lg text-lg font-semibold rounded-lg text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transform transition duration-150 ease-in-out active:scale-95">
                                Update Request
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection