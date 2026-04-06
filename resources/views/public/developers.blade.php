<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Find Developers — DevPortfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <header class="bg-white border-b border-gray-200 py-6">
        <div class="max-w-6xl mx-auto px-6">
            <h1 class="text-2xl font-bold text-gray-900">Find Developers</h1>
            <p class="text-gray-500 text-sm mt-1">
                Browse {{ $portfolios->total() }} published portfolios
            </p>

            {{-- Search & Filter --}}
            <form method="GET" action="{{ route('developers.index') }}"
                  class="mt-4 flex flex-wrap gap-3">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by name or headline..."
                       class="flex-1 min-w-[200px] border-gray-300 rounded-md
                              shadow-sm text-sm focus:ring-indigo-500
                              focus:border-indigo-500" />

                <input type="text"
                       name="skill"
                       value="{{ request('skill') }}"
                       placeholder="Filter by skill (e.g. Laravel)"
                       class="flex-1 min-w-[200px] border-gray-300 rounded-md
                              shadow-sm text-sm focus:ring-indigo-500
                              focus:border-indigo-500" />

                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2
                               rounded-md text-sm hover:bg-indigo-700 transition">
                    Search
                </button>

                @if(request('search') || request('skill'))
                    <a href="{{ route('developers.index') }}"
                       class="text-sm text-gray-600 hover:underline
                              flex items-center">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8">

        @if($portfolios->isEmpty())
            <div class="text-center py-16 text-gray-500">
                No developers found matching your search.
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($portfolios as $portfolio)
                    <a href="{{ route('portfolio.show', $portfolio->user->username) }}"
                       class="bg-white rounded-xl border border-gray-200 p-5
                              hover:shadow-md hover:border-indigo-200 transition
                              block">

                        {{-- Avatar + Name --}}
                        <div class="flex items-center gap-3 mb-3">
                            @if($portfolio->avatar_path)
                                <img src="{{ Storage::url($portfolio->avatar_path) }}"
                                     alt="{{ $portfolio->user->name }}"
                                     class="w-12 h-12 rounded-full object-cover" />
                            @else
                                <div class="w-12 h-12 rounded-full bg-indigo-100
                                            flex items-center justify-center
                                            text-indigo-600 font-bold text-lg">
                                    {{ strtoupper(substr($portfolio->user->name, 0, 1)) }}
                                </div>
                            @endif

                            <div>
                                <p class="font-semibold text-gray-900 text-sm">
                                    {{ $portfolio->user->name }}
                                </p>
                                @if($portfolio->location)
                                    <p class="text-xs text-gray-400">
                                        📍 {{ $portfolio->location }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Headline --}}
                        @if($portfolio->headline)
                            <p class="text-sm text-indigo-600 font-medium mb-2">
                                {{ $portfolio->headline }}
                            </p>
                        @endif

                        {{-- Top skills --}}
                        @if($portfolio->skills->isNotEmpty())
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach($portfolio->skills->take(4) as $skill)
                                    <span class="text-xs bg-gray-100 text-gray-600
                                                 px-2 py-0.5 rounded-full">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                                @if($portfolio->skills->count() > 4)
                                    <span class="text-xs text-gray-400">
                                        +{{ $portfolio->skills->count() - 4 }} more
                                    </span>
                                @endif
                            </div>
                        @endif

                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $portfolios->appends(request()->query())->links() }}
            </div>
        @endif
    </main>

</body>
</html>