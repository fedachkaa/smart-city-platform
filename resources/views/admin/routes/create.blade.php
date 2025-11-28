@extends('layouts.app')

@section('head')
    @vite('resources/js/admin/routes/create.js')
@endsection

@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
            <a href="{{ route('dashboard.routes.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                ← Back to List
            </a>
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                Create Service Route
            </h1>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </header>

    <main class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form id="route-form" method="POST" action="{{ route('dashboard.routes.store') }}">

                @csrf

                <div class="space-y-1 mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Route Name</label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition duration-150 sm:text-sm"
                           value="{{ old('name') }}">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-1 mb-4">
                    <label class="block text-sm font-medium text-gray-700">Infrastructure Objects (max 5)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-64 overflow-y-auto border p-2 rounded-lg">
                        @foreach($objects as $object)
                            <label class="flex items-center space-x-2 p-2 border rounded hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="objects[]" value="{{ $object->id }}" class="js-object-checkbox">
                                <span>{{ $object->name }} ({{ $object->public_address ?? '' }})</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Select up to 5 objects</p>
                </div>

                <div class="space-y-1 mb-4">
                    <label for="start_address" class="block text-sm font-medium text-gray-700">Start Point (address)</label>
                    <input type="text" name="start_address" id="start_address"
                           placeholder="Enter start address or pick on map"
                           class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition duration-150 sm:text-sm"
                           value="{{ old('start_address') }}">
                    <input type="hidden" id="start_address_text" name="start_address_text">
                    @error('start_address')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-1 mb-4">
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" name="start_time" id="start_time"
                           class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition duration-150 sm:text-sm"
                           value="{{ old('start_time') }}">
                    @error('start_time')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700 mb-1">Route Map</label>
                    <div id="map" class="w-full h-96 rounded-lg border"></div>
                </div>

                <div class="flex space-x-4">
                    <button type="button" id="generate-route" class="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700">
                        Generate Optimized Route
                    </button>
                    <button type="submit" id="saveRouteBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Save Route
                    </button>
                </div>
            </form>
            </div>
        </div>
    </main>
@endsection

@php
    $city = config('app.current_city');

    $currentCityLat = $city->latitude;
    $currentCityLng = $city->longitude;

    $currentCityBounds = [
        [$city->bounds['south'], $city->bounds['west']],
        [$city->bounds['north'], $city->bounds['east']],
    ];
@endphp

@push('scripts')
    <script>
        const cityBounds = @json($currentCityBounds);
        const mapCenter = { lat: {{ $currentCityLat }}, lng: {{ $currentCityLng }} };
    </script>

    <script async src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places,marker,geometry&callback=initMap"></script>
@endpush
