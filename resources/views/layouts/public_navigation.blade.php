<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <a href="/" class="flex-shrink-0 text-xl font-bold text-cyan-600 hover:text-cyan-800 transition duration-150">
                Smart City Platform
            </a>

            <div class="flex items-center space-x-4">
                @auth
                    @if (in_array(Auth::user()?->role?->name, \App\Models\UserRole::ALLOWED_ADMIN_ROLES))
                        <a href="{{ route('dashboard.index') }}" class="text-sm font-medium text-gray-700 hover:text-cyan-600">
                            Dashboard
                        </a>
                    @else
                        <a href="#" class="text-sm font-medium text-gray-700 hover:text-cyan-600">
                            Profile
                        </a>
                    @endif

                    <form method="GET" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="py-1 px-3 border border-red-400 rounded-md text-sm text-red-500 hover:bg-red-50 transition duration-150 cursor-pointer">
                            Logout ({{ Auth::user()->name }})
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="py-1 px-3 border border-cyan-400 rounded-md text-sm text-cyan-600 hover:bg-cyan-50 transition duration-150">
                        Login
                    </a>
                    <a href="#" class="py-1 px-3 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-50 transition duration-150 hidden sm:inline-flex">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>