<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin — DevPortfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Admin top bar --}}
    <nav class="bg-gray-900 text-white px-6 py-3 flex items-center
                justify-between">
        <div class="flex items-center gap-6">
            <span class="font-bold text-indigo-400">
                DevPortfolio Admin
            </span>

            <div class="flex gap-4 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                   class="hover:text-indigo-400 transition
                          {{ request()->routeIs('admin.dashboard')
                             ? 'text-indigo-400' : 'text-gray-300' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="hover:text-indigo-400 transition
                          {{ request()->routeIs('admin.users.*')
                             ? 'text-indigo-400' : 'text-gray-300' }}">
                    Users
                </a>
                <a href="{{ route('admin.portfolios.index') }}"
                   class="hover:text-indigo-400 transition
                          {{ request()->routeIs('admin.portfolios.*')
                             ? 'text-indigo-400' : 'text-gray-300' }}">
                    Portfolios
                </a>
            </div>
        </div>

        <div class="flex items-center gap-4 text-sm text-gray-300">
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="hover:text-white transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    {{-- Flash messages --}}
    <div class="max-w-7xl mx-auto px-6 mt-4">
        @foreach(['success' => 'green', 'error' => 'red', 'info' => 'blue'] as $type => $color)
            @if(session($type))
                <div class="mb-4 bg-{{ $color }}-50 border border-{{ $color }}-200
                            text-{{ $color }}-700 rounded-lg p-4 text-sm">
                    {{ session($type) }}
                </div>
            @endif
        @endforeach
    </div>

    {{-- Page content --}}
    <main class="max-w-7xl mx-auto px-6 py-6">
        {{ $slot }}
    </main>

</body>
</html>