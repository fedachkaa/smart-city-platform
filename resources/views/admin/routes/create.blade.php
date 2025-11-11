@extends('layouts.app')

@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
            <a href="{{ route('dashboard.routes.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                ← Back to List
            </a>
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                Edit Service Route
            </h1>
        </div>
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
                                <span>{{ $object->name }} ({{ $object->city->name ?? '' }}, {{ $object->district->name ?? '' }})</span>
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
    $currentCityLat = 48.6231;
    $currentCityLng = 22.2966;

    $currentCityBounds = [
        [48.5931, 22.2666],
        [48.6531, 22.3266],
    ];
@endphp

@push('scripts')
    <script>
        let map;
        let routePolyline;
        let markers = [];
        const cityBounds = @json($currentCityBounds);
        let allowToSetMarkers = true;
        let selectedObjects = [];
        generatedRoute = null;

        function initMap() {
            const center = { lat: {{ $currentCityLat }}, lng: {{ $currentCityLng }} };

            map = new google.maps.Map(document.getElementById('map'), {
                center,
                zoom: 12,
                mapId: 'createRoteMap'
            });

            const bounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(cityBounds[0][0], cityBounds[0][1]),
                new google.maps.LatLng(cityBounds[1][0], cityBounds[1][1])
            );
            map.setOptions({ restriction: { latLngBounds: bounds, strictBounds: false } });

            map.addListener('click', (e) => {
                if (allowToSetMarkers) {
                    const latLng = e.latLng;
                    document.getElementById('start_address').value = latLng.lat() + ',' + latLng.lng();
                    clearMarkers();

                    reverseGeocode(latLng, (address) => {
                        addMarker(latLng, 'Start Point', address); // now info window matches other stops
                    });
                }
            });
        }
    </script>

    <script async
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places,marker,geometry&callback=initMap">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('generate-route').addEventListener('click', async (e) => {
                e.preventDefault();
                selectedObjects = Array.from(document.querySelectorAll('.js-object-checkbox:checked')).map(el => el.value);
                if (selectedObjects.length === 0) {
                    alert('Select at least 1 object!');
                    return;
                }
                if (selectedObjects.length > 5) {
                    alert('Select maximum 5 objects!');
                    return;
                }

                const start = document.getElementById('start_address').value;
                if (!start) {
                    alert('Set a start point!');
                    return;
                }

                const response = await fetch("{{ route('dashboard.routes.preview') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type':'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        object_ids: selectedObjects,
                        start_point: start
                    })
                });
            const data = await response.json();
                if (data.route) {
                    generatedRoute = data.route;
                    renderRoute(data.route);
                }
                else {
                    alert('Failed to generate route');
                }
            });
            document.getElementById('saveRouteBtn').addEventListener('click', async (e) => {
                e.preventDefault();
                if (!generatedRoute) return alert('No route to save');

                const response = await fetch("{{ route('dashboard.routes.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type':'application/json',
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: document.getElementById('name').value,
                        start_point: document.getElementById('start_address').value,
                        object_ids: selectedObjects,
                        route_polyline: generatedRoute.polyline,
                        route_legs: generatedRoute.legs
                    })
                });

                const data = await response.json();
                if (data.success) alert('Route saved successfully!');
                else alert('Failed to save route');
            });

        });

        function addMarker(latLng, title = '', address = '') {
            const marker = new google.maps.marker.AdvancedMarkerElement({
                position: latLng,
                map,
                title: title,
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div>
                        <strong>${title}</strong><br>
                        ${address}
                    </div>
                `
            });

            marker.addListener('click', () => {
                infoWindow.open({
                    anchor: marker,
                    map,
                });
            });

            markers.push(marker);
        }

        function clearMarkers() {
            markers.forEach(m => m.setMap(null));
            markers = [];
        }

        function renderRoute(route) {
            clearMarkers();
            allowToSetMarkers = false;

            if (!route.polyline) {
                console.error('No polyline found in route');
                return;
            }

            const decodedPath = google.maps.geometry.encoding.decodePath(route.polyline);

            if (routePolyline) routePolyline.setMap(null);
            routePolyline = new google.maps.Polyline({
                path: decodedPath,
                strokeColor: '#06b6d4',
                strokeOpacity: 0.8,
                strokeWeight: 5,
                map
            });

            route.legs.forEach((leg, index) => {
                if (index === 0) {
                    addMarker(leg.start_location, 'Start', leg.start_address || '');
                }
                addMarker(leg.end_location, `Stop ${index + 1}`, leg.end_address || '');
            });

            const bounds = new google.maps.LatLngBounds();
            decodedPath.forEach(p => bounds.extend(p));
            map.fitBounds(bounds);
        }

        function reverseGeocode(latLng, callback) {
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: latLng }, (results, status) => {
                if (status === "OK" && results[0]) {
                    callback(results[0].formatted_address);
                } else {
                    callback(`${latLng.lat().toFixed(6)}, ${latLng.lng().toFixed(6)}`);
                }
            });
        }
    </script>
@endpush
