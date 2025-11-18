@extends('layouts.app')

@section('head')
    @vite('resources/js/admin/routes/edit.js')
@endsection

@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
            <a href="{{ route('dashboard.routes.index') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                ← Back to List
            </a>
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                {{ $route->name }}
            </h1>
        </div>
    </header>

    <main class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6 space-y-6">

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Route Information</h2>
                    <div class="grid sm:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <p><strong>Start Address:</strong></p>
                            <p>{{ $route->route['start_point']['address'] ?? '—' }}</p>
                        </div>
                        <div>
                            <p><strong>Start Time:</strong></p>
                            <p>{{ $route->start_time->format('H:i') ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Infrastructure Objects</h2>
                    @if($route->objects->count())
                        <ol class="list-decimal ml-4">
                            @foreach($route->objects as $object)
                                <li>
                                    <a href="{{ route('dashboard.objects.edit', $object->id) }}" target="_blank" class="text-cyan-600 hover:underline">
                                        {{ $object->name }}
                                    </a>
                                    <span class="text-gray-500 text-sm">
                                        ({{ $object->city->name ?? '' }})
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <p class="text-gray-500">No objects linked to this route.</p>
                    @endif
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Route Map</h2>
                    <div id="map" class="w-full h-96 rounded-lg border"></div>
                </div>
            </div>
        </div>
    </main>
@endsection

@php
    $currentCity = config('app.current_city');

    $currentCityLat = $currentCity->latitude;
    $currentCityLng = $currentCity->longitude;
@endphp

@push('scripts')
    <script>
        const savedRoute = @json($route->route);
        const mapCenter =  { lat: {{ $currentCityLat }}, lng: {{ $currentCityLng }} };
    </script>

    <script async src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=geometry,marker&callback=initMap"></script>
@endpush