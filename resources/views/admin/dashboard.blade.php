<x-admin-layout>

    <h1 class="text-2xl font-bold text-gray-900 mb-6">
        Platform Overview
    </h1>

    {{-- ── STAT CARDS ──────────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

        @foreach([
            ['label' => 'Total Users',        'value' => $stats['total_users'],          'color' => 'indigo'],
            ['label' => 'Developers',          'value' => $stats['total_developers'],     'color' => 'blue'],
            ['label' => 'Recruiters',          'value' => $stats['total_recruiters'],     'color' => 'purple'],
            ['label' => 'Suspended',           'value' => $stats['suspended_users'],      'color' => 'red'],
            ['label' => 'Total Portfolios',    'value' => $stats['total_portfolios'],     'color' => 'indigo'],
            ['label' => 'Published',           'value' => $stats['published_portfolios'],'color' => 'green'],
            ['label' => 'Total Views',         'value' => $stats['total_page_views'],     'color' => 'indigo'],
            ['label' => 'New Users (30 days)', 'value' => $stats['new_users_this_month'],'color' => 'indigo'],
        ] as $card)
            <div class="bg-white shadow rounded-lg p-5 text-center">
                <p class="text-3xl font-bold text-{{ $card['color'] }}-600">
                    {{ number_format($card['value']) }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $card['label'] }}
                </p>
            </div>
        @endforeach

    </div>

    {{-- ── CONNECTION STATS ─────────────────────────────────── --}}
    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-3xl font-bold text-indigo-600">
                {{ number_format($stats['total_connections']) }}
            </p>
            <p class="text-sm text-gray-500 mt-1">Total Connection Requests</p>
        </div>
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-3xl font-bold text-green-600">
                {{ number_format($stats['accepted_connections']) }}
            </p>
            <p class="text-sm text-gray-500 mt-1">Accepted Connections</p>
        </div>
    </div>

    {{-- ── RECENT USERS ─────────────────────────────────────── --}}
    <div class="bg-white shadow rounded-lg">
        <div class="px-5 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="font-semibold text-gray-800">Recent Registrations</h2>
            <a href="{{ route('admin.users.index') }}"
               class="text-sm text-indigo-600 hover:underline">
                View all →
            </a>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-5 py-3">Name</th>
                    <th class="text-left px-5 py-3">Email</th>
                    <th class="text-left px-5 py-3">Role</th>
                    <th class="text-left px-5 py-3">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($stats['recent_users'] as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-900">
                            <a href="{{ route('admin.users.show', $user) }}"
                               class="hover:text-indigo-600">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td class="px-5 py-3 text-gray-600">
                            {{ $user->email }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $user->role === 'developer'
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'bg-purple-100 text-purple-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-500">
                            {{ $user->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-admin-layout>