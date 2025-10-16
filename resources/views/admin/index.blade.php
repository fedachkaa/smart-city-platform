@extends('layouts.app')

@section('head')
    @vite('resources/js/admin-dashboard.js')
@endsection

@section('content')
    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">

                @foreach(['total_objects' => 'Total Objects', 'active_objects' => 'Active Objects', 'maintenance_objects' => 'In Maintenance', 'error_objects' => 'Objects with Error'] as $key => $title)
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg transform hover:scale-105 transition duration-300">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($key == 'total_objects') <span class="text-2xl text-cyan-600">🏙️</span>
                                    @elseif($key == 'active_objects') <span class="text-2xl text-green-600">✅</span>
                                    @elseif($key == 'maintenance_objects') <span class="text-2xl text-yellow-600">🛠️</span>
                                    @else <span class="text-2xl text-red-600">🚨</span>
                                    @endif
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        {{ $title }}
                                    </dt>
                                    <dd class="text-2xl font-extrabold text-gray-900">
                                        {{ $stats[$key] }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
                <div class="bg-white shadow-lg rounded-lg p-6 lg:col-span-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Objects by Type</h3>
                    <div style="height: 300px;">
                        <canvas id="objectsByTypeChart"></canvas>
                    </div>
                </div>

                <div class="bg-white shadow-lg rounded-lg p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Status Distribution & Quick Statistics</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div style="max-height: 300px;">
                            <canvas id="objectsByStatusChart"></canvas>
                        </div>

                        <div>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Metric</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                <tr><td class="px-4 py-2 font-medium">Total Active</td><td class="px-4 py-2 text-green-600">{{ $stats['active_objects'] }}</td></tr>
                                <tr><td class="px-4 py-2 font-medium">Total Errors</td><td class="px-4 py-2 text-red-600">{{ $stats['error_objects'] }}</td></tr>
                                <tr><td class="px-4 py-2 font-medium">Under Maintenance</td><td class="px-4 py-2 text-yellow-600">{{ $stats['maintenance_objects'] }}</td></tr>
                                <tr><td class="px-4 py-2 font-medium">Total Registered</td><td class="px-4 py-2 font-bold">{{ $stats['total_objects'] }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Recently Added Infrastructure Objects
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="divide-y divide-gray-200">
                        @forelse ($recentObjects as $object)
                            <li class="py-3 flex justify-between items-center hover:bg-gray-50 transition duration-100 px-2 rounded-md">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $object->name }} ({{ $object->type->value ?? $object->type }})</p>
                                    <p class="text-xs text-gray-500">District: {{ $object->district }}</p>
                                </div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($object->status->value == 'Active') bg-green-100 text-green-800
                                @elseif($object->status->value == 'Maintenance') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $object->status->value ?? $object->status }}
                            </span>
                            </li>
                        @empty
                            <li class="py-3 text-gray-500 text-center">No objects to display.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof window.initializeCharts === 'function') {
                    window.initializeCharts(@json($chartData));
                }
            });
        </script>
    @endpush
@endsection