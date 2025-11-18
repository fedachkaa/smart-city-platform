<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Smart City Platform</title>

    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        #map-container {
            height: 70vh;
        }

        #map {
            height: 100%;
        }    </style>
</head>
<body class="bg-gray-50">
    @include('layouts.public_navigation')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center bg-white shadow-sm mb-6 rounded-lg mt-4">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
            Smart City Platform
        </h1>
        <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-5 pt-4">
            {{ __('messages.home.about') }}
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between mb-4 border-b pb-2">
            <h2 class="text-2xl font-bold text-gray-800" id="map-view-section">
                {{ __('messages.home.map_title') }}
            </h2>

            <label class="flex items-center cursor-pointer">
                <span class="text-sm font-medium text-gray-700 mr-3"> {{ __('messages.home.heatmap') }}</span>
                <div class="relative">
                    <input id="heatmap-toggle" type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-cyan-600 transition-colors duration-200"></div>
                    <div class="absolute top-0 left-0 w-6 h-6 bg-white rounded-full border border-gray-300 transform transition-transform duration-200 peer-checked:translate-x-5 shadow"></div>
                </div>
            </label>
        </div>

        <div id="map-container" class="shadow-xl rounded-xl overflow-hidden border border-gray-200 relative">
            <div id="map" class="h-[600px] w-full"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>

    @vite('resources/js/app.js')
    @vite('resources/js/map-initializer.js')
</body>
</html>

<script>
    window.appConfig = {
        city: @json($city),
    };
</script>