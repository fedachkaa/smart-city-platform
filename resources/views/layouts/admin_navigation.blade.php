<nav class="bg-white border-b border-gray-200">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard.index') }}" class="flex items-center flex-shrink-0 text-xl font-bold text-gray-900 space-x-2">
                    <span>Smart City Platform</span>
                    @if(isset($currentCity))
                        <span class="px-2 py-1 text-sm font-semibold text-white bg-cyan-600 rounded-full shadow-sm">{{ $currentCity->name }}</span>
                    @endif
                </a>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('dashboard.index') ? 'text-gray-900 border-cyan-500' : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('dashboard.objects.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('dashboard.objects.*') ? 'text-gray-900 border-cyan-500' : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        Infrastructure Management
                    </a>

                    <a href="{{ route('dashboard.requests.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('dashboard.requests.*') ? 'text-gray-900 border-cyan-500' : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        User Requests
                    </a>

                    <a href="{{ route('dashboard.routes.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('dashboard.routes.*') ? 'text-gray-900 border-cyan-500' : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        Service Routes
                    </a>

                    <a href="{{ route('dashboard.users.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('dashboard.users.*') ? 'text-gray-900 border-cyan-500' : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        Users
                    </a>
                </div>
            </div>

            <div class="flex items-center">
                <span class="text-sm text-gray-600 mr-4">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                <a href="{{ route('logout') ?? '#' }}" class="text-sm text-red-500 hover:text-red-700 transition duration-150 cursor-pointer">Logout</a>
            </div>
        </div>
    </div>
</nav>