<x-admin-layout>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Portfolios</h1>
        <span class="text-sm text-gray-500">
            {{ $portfolios->total() }} total portfolios
        </span>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.portfolios.index') }}"
          class="bg-white shadow rounded-lg p-4 mb-6
                 flex flex-wrap gap-3 items-end">

        <div class="flex-1 min-w-[200px]">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search by developer name..."
                   class="w-full border-gray-300 rounded-md shadow-sm text-sm
                          focus:ring-indigo-500 focus:border-indigo-500" />
        </div>

        <select name="status"
                class="border-gray-300 rounded-md shadow-sm text-sm
                       focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">All statuses</option>
            <option value="published"
                {{ request('status') === 'published' ? 'selected' : '' }}>
                Published
            </option>
            <option value="unpublished"
                {{ request('status') === 'unpublished' ? 'selected' : '' }}>
                Unpublished
            </option>
        </select>

        <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2
                       rounded-md text-sm hover:bg-indigo-700 transition">
            Filter
        </button>

        @if(request('search') || request('status'))
            <a href="{{ route('admin.portfolios.index') }}"
               class="text-sm text-gray-500 hover:underline">
                Clear
            </a>
        @endif
    </form>

    {{-- Portfolios table --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-5 py-3">Developer</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Projects</th>
                    <th class="text-left px-5 py-3">Views</th>
                    <th class="text-left px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($portfolios as $portfolio)
                    <tr class="hover:bg-gray-50">

                        <td class="px-5 py-3">
                            <a href="{{ route('admin.users.show', $portfolio->user) }}"
                               class="font-medium text-gray-900
                                      hover:text-indigo-600">
                                {{ $portfolio->user->name }}
                            </a>
                            <p class="text-xs text-gray-400 font-mono">
                                {{ $portfolio->user->username }}
                            </p>
                            @if($portfolio->headline)
                                <p class="text-xs text-indigo-500 mt-0.5">
                                    {{ Str::limit($portfolio->headline, 40) }}
                                </p>
                            @endif
                        </td>

                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $portfolio->is_published
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-gray-100 text-gray-500' }}">
                                {{ $portfolio->is_published
                                    ? 'Published' : 'Unpublished' }}
                            </span>
                        </td>

                        <td class="px-5 py-3 text-gray-600">
                            {{ $portfolio->projects_count }}
                        </td>

                        <td class="px-5 py-3 text-gray-600">
                            {{ number_format($portfolio->analytics_events_count) }}
                        </td>

                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">

                                {{-- View public portfolio --}}
                                @if($portfolio->is_published)
                                    <a href="{{ route('portfolio.show', $portfolio->user->username) }}"
                                       target="_blank"
                                       class="text-xs text-indigo-600 hover:underline">
                                        View ↗
                                    </a>
                                @endif

                                {{-- Force unpublish --}}
                                @if($portfolio->is_published)
                                    <form method="POST"
                                          action="{{ route('admin.portfolios.unpublish', $portfolio) }}"
                                          onsubmit="return confirm('Unpublish this portfolio?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="text-xs text-yellow-600
                                                       hover:underline">
                                            Unpublish
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="px-5 py-8 text-center text-gray-400 text-sm">
                            No portfolios found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-5 py-4 border-t border-gray-100">
            {{ $portfolios->appends(request()->query())->links() }}
        </div>
    </div>

</x-admin-layout>