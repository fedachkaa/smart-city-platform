@php
    $localeLabels = [
        'en' => '🇬🇧 EN',
        'uk' => '🇺🇦 UKR'
    ];
@endphp

<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <a href="/" class="flex-shrink-0 text-xl font-bold text-cyan-600 hover:text-cyan-800 transition duration-150">
                Smart City Platform
            </a>

            <div class="flex items-center space-x-4">
                <div class="relative" id="languageDropdown">
                    <button id="langButton" class="flex items-center py-1 px-3 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-50 transition duration-150">
                        {{ $localeLabels[app()->getLocale()] ?? strtoupper(app()->getLocale()) }}
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="langMenu" class="absolute right-0 mt-2 w-28 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50" style="width: max-content;">
                        <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">🇬🇧 English</a>
                        <a href="{{ route('lang.switch', 'uk') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">🇺🇦 Українська</a>
                    </div>
                </div>

                @auth
                    @if (in_array(Auth::user()?->role?->name, \App\Models\UserRole::ALLOWED_ADMIN_ROLES))
                        <a href="{{ route('dashboard.index') }}" class="text-sm font-medium text-gray-700 hover:text-cyan-600">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('profile.index') }}" class="text-sm font-medium text-gray-700 hover:text-cyan-600">
                            Profile
                        </a>
                    @endif

                    <form method="GET" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="py-1 px-3 border border-red-400 rounded-md text-sm text-red-500 hover:bg-red-50 transition duration-150 cursor-pointer">
                            {{ __('messages.home.logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="py-1 px-3 border border-cyan-400 rounded-md text-sm text-cyan-600 hover:bg-cyan-50 transition duration-150">
                        {{ __('messages.home.login') }}
                    </a>
                    <a href="{{ route('register') }}" class="py-1 px-3 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-50 transition duration-150 hidden sm:inline-flex">
                        {{ __('messages.home.register') }}
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
<script>
    const button = document.getElementById('langButton');
    const menu = document.getElementById('langMenu');

    button.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!button.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>