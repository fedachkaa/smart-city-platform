@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex bg-gray-100 p-6">
        <div class="w-64 bg-white shadow-lg rounded-xl p-4 flex-shrink-0 space-y-4">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Dashboard</h2>
            @php
                $tabs = [
                    'new-report' => 'New Report',
                    'my-reports' => 'My Reports',
                    'city-map' => 'City Map',
                    'edit-profile' => 'Edit Profile',
                ];
            @endphp

            @foreach($tabs as $key => $label)
                <button class="w-full text-left p-4 rounded-lg hover:bg-cyan-100 transition duration-150" data-target="{{ $key }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div id="dashboard-content" class="flex-1 bg-white shadow-lg rounded-xl p-6 ml-6 overflow-auto">
            <p class="text-gray-500">Select a tile on the left to see content here.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('[data-target]');
            const content = document.getElementById('dashboard-content');

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.getAttribute('data-target');

                    content.innerHTML = '<p class="text-gray-500">Loading...</p>';

                    fetch(`/profile/partial/${target}`)
                        .then(res => res.text())
                        .then(html => {
                            content.innerHTML = html;
                        })
                        .catch(err => {
                            content.innerHTML = `<p class="text-red-500">Error loading content.</p>`;
                            console.error(err);
                        });

                    buttons.forEach(t => t.classList.remove('border-l-4', 'border-cyan-600', 'font-semibold'));
                    btn.classList.add('border-l-4', 'border-cyan-600', 'font-semibold');
                });
            });

            const defaultTab = document.querySelector('[data-target="city-map"]');
            if (defaultTab) {
                defaultTab.click();
            }
        });
    </script>
@endsection