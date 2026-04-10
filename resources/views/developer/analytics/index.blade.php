<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Analytics
            </h2>

            {{-- Time range selector --}}
            <div class="flex gap-2">
                @foreach([7 => '7 days', 30 => '30 days', 90 => '90 days'] as $days => $label)
                    <a href="{{ route('developer.analytics.index', ['range' => $days]) }}"
                       class="text-sm px-3 py-1 rounded-full border transition
                              {{ $range === $days
                                 ? 'bg-indigo-600 text-white border-indigo-600'
                                 : 'text-gray-600 border-gray-300 hover:border-indigo-400' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ── STAT CARDS ───────────────────────────────── --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                {{-- Total views --}}
                <div class="bg-white shadow sm:rounded-lg p-5 text-center">
                    <p class="text-3xl font-bold text-indigo-600">
                        {{ number_format($stats['total_views']) }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Total Views</p>
                </div>

                {{-- Views in range --}}
                <div class="bg-white shadow sm:rounded-lg p-5 text-center">
                    <p class="text-3xl font-bold text-indigo-600">
                        {{ number_format($stats['views_in_range']) }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Views ({{ $range }} days)
                    </p>
                </div>

                {{-- Project clicks --}}
                <div class="bg-white shadow sm:rounded-lg p-5 text-center">
                    <p class="text-3xl font-bold text-indigo-600">
                        {{ number_format($stats['top_projects']['total_clicks']) }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Project Clicks</p>
                </div>

                {{-- Connection requests --}}
                <div class="bg-white shadow sm:rounded-lg p-5 text-center">
                    <p class="text-3xl font-bold text-indigo-600">
                        {{ number_format($stats['total_connections']) }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Connections
                        @if($stats['pending_connections'] > 0)
                            <span class="text-xs text-yellow-600">
                                ({{ $stats['pending_connections'] }} pending)
                            </span>
                        @endif
                    </p>
                </div>

            </div>

            {{-- ── PAGE VIEWS CHART ─────────────────────────── --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">
                    Page Views — Last {{ $range }} Days
                </h3>

                @if(array_sum($stats['views_per_day']) === 0)
                    <div class="text-center py-8 text-gray-400 text-sm">
                        No views recorded in this period yet.
                        <br />
                        Share your portfolio link to start getting visitors!
                    </div>
                @else
                    {{-- Chart container --}}
                    <div class="relative h-48">
                        <canvas id="viewsChart"></canvas>
                    </div>
                @endif
            </div>

            {{-- ── PROJECT CLICKS BREAKDOWN ─────────────────── --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">
                    Project Engagement
                </h3>

                <div class="grid grid-cols-2 gap-4">

                    <div class="bg-indigo-50 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold text-indigo-700">
                            {{ number_format($stats['top_projects']['demo_clicks']) }}
                        </p>
                        <p class="text-sm text-indigo-600 mt-1">
                            Live Demo Clicks
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold text-gray-700">
                            {{ number_format($stats['top_projects']['repo_clicks']) }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            GitHub Repo Clicks
                        </p>
                    </div>

                </div>
            </div>

            {{-- ── TOP REFERRERS ────────────────────────────── --}}
            @if(!empty($stats['referrers']))
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">
                        Top Referrers
                    </h3>

                    <div class="space-y-3">
                        @php
                            $maxCount = max($stats['referrers']);
                        @endphp

                        @foreach($stats['referrers'] as $referrer => $count)
                            <div class="flex items-center gap-3">

                                {{-- Referrer name --}}
                                <span class="text-sm text-gray-700 w-32
                                             truncate flex-shrink-0">
                                    {{ $referrer }}
                                </span>

                                {{-- Progress bar --}}
                                <div class="flex-1 bg-gray-100 rounded-full h-2">
                                    <div class="bg-indigo-500 h-2 rounded-full"
                                         style="width: {{ ($count / $maxCount) * 100 }}%">
                                    </div>
                                </div>

                                {{-- Count --}}
                                <span class="text-sm text-gray-500 w-8
                                             text-right flex-shrink-0">
                                    {{ $count }}
                                </span>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── SHARE YOUR PORTFOLIO ─────────────────────── --}}
            <div class="bg-indigo-50 border border-indigo-200
                        rounded-lg p-5">
                <p class="text-sm font-medium text-indigo-900 mb-2">
                    Your portfolio URL
                </p>
                <div class="flex items-center gap-2">
                    <code class="flex-1 bg-white border border-indigo-200
                                 rounded px-3 py-2 text-sm text-indigo-700
                                 truncate">
                        {{ route('portfolio.show', auth()->user()->username) }}
                    </code>
                    <button onclick="copyUrl()"
                            class="text-sm bg-indigo-600 text-white px-3 py-2
                                   rounded hover:bg-indigo-700 transition
                                   whitespace-nowrap">
                        Copy
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js via CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        // ── Page Views Chart ──────────────────────────────────
        @if(array_sum($stats['views_per_day']) > 0)

        // Pass PHP data to JavaScript using  directive
        //  safely encodes the PHP array as a JSON string
        const viewsData = {!! json_encode($stats['views_per_day']) !!};

        const labels = Object.keys(viewsData).map(date => {
            // Format date as "Mar 1" instead of "2026-03-01"
            const d = new Date(date);
            return d.toLocaleDateString('en-US', {
                month: 'short',
                day:   'numeric'
            });
        });

        const data = Object.values(viewsData);

        new Chart(document.getElementById('viewsChart'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label:           'Page Views',
                    data,
                    borderColor:     '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth:     2,
                    fill:            true,
                    tension:         0.4, // smooth curve
                    pointRadius:     3,
                    pointHoverRadius: 5,
                }],
            },
            options: {
                responsive:          true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        // Only show whole numbers on Y axis
                        ticks: {
                            stepSize: 1,
                            callback: value => Number.isInteger(value) ? value : null,
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' },
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            // Show fewer labels on small screens
                            maxTicksLimit: 10,
                        },
                    },
                },
            },
        });

        @endif

        // ── Copy URL to clipboard ─────────────────────────────
        function copyUrl() {
            const url = '{{ route('portfolio.show', auth()->user()->username) }}';

            navigator.clipboard.writeText(url).then(() => {
                // Temporarily change button text to confirm
                event.target.textContent = 'Copied!';
                setTimeout(() => {
                    event.target.textContent = 'Copy';
                }, 2000);
            });
        }
    </script>

</x-app-layout>