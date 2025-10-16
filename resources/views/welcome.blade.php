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
            Smart City Platform Overview
        </h1>
        <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-5 pt-4">
            Visualize and monitor key urban infrastructure components in real-time. Our platform provides a centralized, map-based interface for Guests, Operators, and Administrators.
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2" id="map-view-section">
            Interactive Infrastructure Map
        </h2>

        <div id="map-container" class="shadow-xl rounded-xl overflow-hidden">
            <div id="map"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @vite('resources/js/app.js')
    @vite('resources/js/map-initializer.js')
</body>
</html>