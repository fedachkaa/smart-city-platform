<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard.index') }}" class="flex-shrink-0 text-xl font-bold text-gray-900">
                    Smart City Platform
                </a>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard.index') }}" class="text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-cyan-500 font-medium leading-5 focus:outline-none focus:border-cyan-700 transition duration-150 ease-in-out">
                        Dashboard
                    </a>
                    <a href="{{ route('dashboard.objects.index') ?? '#' }}" class="text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent font-medium leading-5 transition duration-150 ease-in-out">
                        Infrastructure Management
                    </a>
                </div>
            </div>

            <div class="flex items-center">
                <span class="text-sm text-gray-600 mr-4">{{ Auth::user()->name }} ({{ Auth::user()->role->name ?? 'User' }})</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition duration-150 cursor-pointer">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>