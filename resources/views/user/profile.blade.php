@extends('layouts.app')

@section('head')
    @vite('resources/js/profile/base.js')
@endsection

@section('content')
    @if(session('success'))
        <div id="success-message" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-100 text-green-700 border border-green-300 px-4 py-3 rounded-lg shadow-md transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif
    <div class="min-h-screen flex bg-gray-100 p-6">
        <div class="w-64 bg-white shadow-lg rounded-xl p-4 flex-shrink-0 space-y-4">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Dashboard</h2>
            @php
                $tabs = [
                    'my-requests' => 'My Requests',
                    'new-request' => 'New Request',
                    'city-map' => 'City Map',
                    'edit-profile' => 'Edit Profile',
                ];
            @endphp

            @foreach($tabs as $key => $label)
                <button class="tab-button w-full text-left p-4 rounded-lg hover:bg-cyan-100 transition duration-150" data-target="{{ $key }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div id="dashboard-content" class="flex-1 bg-white shadow-lg rounded-xl p-6 ml-6 overflow-auto">
            @foreach($tabs as $key => $label)
                <div id="{{ $key }}" class="tab-pane hidden">
                    @include('user.partials.' . $key, ['districts' => $districts, 'user' => auth()->user()])
                </div>
            @endforeach
        </div>
    </div>
@endsection