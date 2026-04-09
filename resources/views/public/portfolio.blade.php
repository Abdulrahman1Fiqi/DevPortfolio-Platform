<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Dynamic SEO title --}}
    <title>{{ $user->name }} — Portfolio</title>

    {{-- Meta description for search engines --}}
    <meta name="description"
          content="{{ $portfolio->headline ?? $user->name . '\'s developer portfolio' }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

    {{-- ── HEADER / HERO ─────────────────────────────────────── --}}
    <header class="bg-white border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-6 py-12 flex flex-col
                    sm:flex-row items-center sm:items-start gap-6">

            {{-- Avatar --}}
            @if($portfolio->avatar_path)
                <img src="{{ Storage::url($portfolio->avatar_path) }}"
                     alt="{{ $user->name }}"
                     class="w-24 h-24 rounded-full object-cover
                            ring-4 ring-indigo-50 flex-shrink-0" />
            @else
                <div class="w-24 h-24 rounded-full bg-indigo-100 flex-shrink-0
                            flex items-center justify-center
                            text-indigo-600 font-bold text-3xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif

            {{-- Info --}}
            <div class="text-center sm:text-left">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $user->name }}
                </h1>

                @if($portfolio->headline)
                    <p class="text-indigo-600 font-medium mt-1">
                        {{ $portfolio->headline }}
                    </p>
                @endif

                @if($portfolio->location)
                    <p class="text-gray-500 text-sm mt-1">
                        📍 {{ $portfolio->location }}
                    </p>
                @endif

                {{-- Social links --}}
                @if($portfolio->social_links)
                    <div class="mt-3 flex flex-wrap gap-3 justify-center sm:justify-start">
                        @foreach([
                            'github'   => ['label' => 'GitHub',   'prefix' => ''],
                            'linkedin' => ['label' => 'LinkedIn', 'prefix' => ''],
                            'website'  => ['label' => 'Website',  'prefix' => ''],
                            'twitter'  => ['label' => 'Twitter',  'prefix' => ''],
                        ] as $key => $meta)
                            @if(!empty($portfolio->social_links[$key]))
                                <a href="{{ $portfolio->social_links[$key] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="text-sm text-indigo-600 hover:underline
                                          border border-indigo-200 rounded-full
                                          px-3 py-0.5">
                                    {{ $meta['label'] }} ↗
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Owner actions (only visible to the portfolio owner) --}}
            @auth
                @if(auth()->id() === $user->id)
                    <div class="sm:ml-auto flex gap-2">
                        <a href="{{ route('developer.dashboard') }}"
                           class="text-sm bg-indigo-600 text-white px-4 py-2
                                  rounded-md hover:bg-indigo-700 transition">
                            Edit Portfolio
                        </a>
                    </div>
                @endif
            @endauth

        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-10 space-y-14">

        {{-- ── BIO ────────────────────────────────────────────── --}}
        @if($portfolio->bio)
            <section>
                <h2 class="text-lg font-semibold text-gray-900 mb-3
                           pb-2 border-b border-gray-200">
                    About
                </h2>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $portfolio->bio }}
                </p>
            </section>
        @endif

        {{-- ── PROJECTS ─────────────────────────────────────────── --}}
        @if($portfolio->projects->isNotEmpty())
            <section>
                <h2 class="text-lg font-semibold text-gray-900 mb-4
                           pb-2 border-b border-gray-200">
                    Projects
                </h2>

                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach($portfolio->projects as $project)
                        <div class="bg-white rounded-xl border border-gray-200
                                    overflow-hidden hover:shadow-md transition">

                            {{-- Thumbnail --}}
                            @if($project->thumbnail_path)
                                <img src="{{ Storage::url($project->thumbnail_path) }}"
                                     alt="{{ $project->title }}"
                                     class="w-full h-44 object-cover" />
                            @else
                                <div class="w-full h-44 bg-gradient-to-br
                                            from-indigo-50 to-indigo-100
                                            flex items-center justify-center
                                            text-indigo-300 text-4xl">
                                    &lt;/&gt;
                                </div>
                            @endif

                            <div class="p-4">
                                {{-- Title + featured badge --}}
                                <div class="flex items-start gap-2">
                                    <h3 class="font-semibold text-gray-900 flex-1">
                                        {{ $project->title }}
                                    </h3>
                                    @if($project->is_featured)
                                        <span class="text-xs bg-yellow-100
                                                     text-yellow-800 px-2 py-0.5
                                                     rounded-full whitespace-nowrap">
                                            ⭐ Featured
                                        </span>
                                    @endif
                                </div>

                                {{-- Description --}}
                                @if($project->description)
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                        {{ $project->description }}
                                    </p>
                                @endif

                                {{-- Tech stack tags --}}
                                @if($project->tech_stack)
                                    <div class="mt-3 flex flex-wrap gap-1">
                                        @foreach($project->tech_stack as $tag)
                                            <span class="text-xs bg-gray-100
                                                         text-gray-600 px-2 py-0.5
                                                         rounded-full">
                                                {{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Action buttons --}}
                                @if($project->demo_url || $project->repo_url)
                                    <div class="mt-4 flex gap-2">

                                        @if($project->demo_url)
                                            {{-- Records demo click analytics --}}
                                            <a href="{{ $project->demo_url }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               data-analytics="demo_click"
                                               data-portfolio="{{ $portfolio->id }}"
                                               class="flex-1 text-center text-sm
                                                      bg-indigo-600 text-white
                                                      py-1.5 rounded-lg
                                                      hover:bg-indigo-700 transition">
                                                Live Demo ↗
                                            </a>
                                        @endif

                                        @if($project->repo_url)
                                            <a href="{{ $project->repo_url }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               data-analytics="repo_click"
                                               data-portfolio="{{ $portfolio->id }}"
                                               class="flex-1 text-center text-sm
                                                      border border-gray-300
                                                      text-gray-700 py-1.5
                                                      rounded-lg hover:bg-gray-50
                                                      transition">
                                                GitHub ↗
                                            </a>
                                        @endif

                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ── SKILLS ──────────────────────────────────────────── --}}
        @if($groupedSkills->isNotEmpty())
            <section>
                <h2 class="text-lg font-semibold text-gray-900 mb-4
                           pb-2 border-b border-gray-200">
                    Skills
                </h2>

                <div class="space-y-4">
                    @foreach($groupedSkills as $category => $skills)
                        <div>
                            <h3 class="text-xs font-semibold text-gray-400
                                       uppercase tracking-wider mb-2">
                                {{ $category }}
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($skills as $skill)
                                    <span class="inline-flex items-center gap-1
                                                 bg-indigo-50 border border-indigo-200
                                                 text-indigo-800 text-sm
                                                 px-3 py-1 rounded-full">
                                        {{ $skill->name }}
                                        @if($skill->proficiency)
                                            <span class="text-indigo-400 text-xs">
                                                · {{ $skill->proficiency }}
                                            </span>
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ── EXPERIENCE ───────────────────────────────────────── --}}
        @if($portfolio->experiences->isNotEmpty())
            <section>
                <h2 class="text-lg font-semibold text-gray-900 mb-4
                           pb-2 border-b border-gray-200">
                    Experience
                </h2>

                <div class="space-y-6">
                    @foreach($portfolio->experiences as $experience)
                        <div class="flex gap-4">

                            {{-- Timeline dot --}}
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 rounded-full bg-indigo-400
                                            mt-1.5 flex-shrink-0"></div>
                                @if(! $loop->last)
                                    <div class="w-px flex-1 bg-gray-200 mt-1"></div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="pb-6">
                                <h3 class="font-semibold text-gray-900">
                                    {{ $experience->role }}
                                </h3>
                                <p class="text-indigo-600 text-sm font-medium">
                                    {{ $experience->company }}
                                </p>
                                <p class="text-gray-400 text-xs mt-0.5">
                                    {{ $experience->start_date->format('M Y') }}
                                    –
                                    {{ $experience->end_label }}
                                </p>
                                @if($experience->description)
                                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">
                                        {{ $experience->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ── TESTIMONIALS ─────────────────────────────────────── --}}
        @if($portfolio->testimonials->isNotEmpty())
            <section>
                <h2 class="text-lg font-semibold text-gray-900 mb-4
                           pb-2 border-b border-gray-200">
                    Testimonials
                </h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($portfolio->testimonials as $testimonial)
                        <div class="bg-white border border-gray-200
                                    rounded-xl p-5">

                            {{-- Rating stars --}}
                            @if($testimonial->rating)
                                <div class="flex gap-0.5 mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $testimonial->rating
                                                         ? 'text-yellow-400'
                                                         : 'text-gray-200' }}">
                                            ★
                                        </span>
                                    @endfor
                                </div>
                            @endif

                            <p class="text-gray-700 text-sm leading-relaxed italic">
                                "{{ $testimonial->message }}"
                            </p>

                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="font-medium text-sm text-gray-900">
                                    {{ $testimonial->submitter_name }}
                                </p>
                                @if($testimonial->submitter_role || $testimonial->company)
                                    <p class="text-xs text-gray-500">
                                        {{ $testimonial->submitter_role }}
                                        @if($testimonial->submitter_role && $testimonial->company)
                                            at
                                        @endif
                                        {{ $testimonial->company }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ── CONNECT BUTTON (for recruiters) ─────────────────── --}}
        @auth
            @if(auth()->user()->isRecruiter())
                @php
                    // Check if a request was already sent
                    $existingRequest = \App\Models\ConnectionRequest::where('recruiter_id', auth()->id())
                        ->where('developer_id', $user->id)
                        ->first();
                @endphp

                <section class="bg-white border border-gray-200 rounded-xl p-6
                                text-center" id="connect">

                    @if($existingRequest)
                        {{-- Already sent — show status --}}
                        <p class="text-gray-600 font-medium">
                            Connection Request Status:
                            <span class="font-semibold
                                {{ $existingRequest->isPending()  ? 'text-yellow-600' : '' }}
                                {{ $existingRequest->isAccepted() ? 'text-green-600'  : '' }}
                                {{ $existingRequest->isDeclined() ? 'text-red-600'    : '' }}">
                                {{ ucfirst($existingRequest->status) }}
                            </span>
                        </p>

                        @if($existingRequest->isPending())
                            <p class="text-sm text-gray-500 mt-1">
                                Waiting for {{ $user->name }} to respond.
                            </p>
                        @elseif($existingRequest->isAccepted())
                            <p class="text-sm text-green-600 mt-1">
                                📧 You can now contact them at:
                                <strong>{{ $user->email }}</strong>
                            </p>
                        @endif

                    @else
                        {{-- No request yet — show the form --}}
                        <h3 class="font-semibold text-gray-900 mb-1">
                            Interested in {{ $user->name }}?
                        </h3>
                        <p class="text-sm text-gray-500 mb-4">
                            Send a connection request to get in touch.
                        </p>

                        <form method="POST"
                            action="{{ route('connections.store', $user->username) }}">
                            @csrf

                            <textarea name="message"
                                    rows="3"
                                    maxlength="500"
                                    placeholder="Introduce yourself and explain the opportunity... (optional)"
                                    class="w-full border border-gray-200 rounded-lg p-3
                                            text-sm text-gray-700 resize-none
                                            focus:ring-indigo-500 focus:border-indigo-500
                                            mb-3">{{ old('message') }}</textarea>

                            @error('message')
                                <p class="text-red-600 text-xs mb-2">{{ $message }}</p>
                            @enderror

                            <button type="submit"
                                    class="w-full bg-indigo-600 text-white py-2.5
                                        rounded-lg font-medium hover:bg-indigo-700
                                        transition text-sm">
                                Send Connection Request
                            </button>
                        </form>
                    @endif

                </section>
            @endif
        @endauth

    </main>

    {{-- ── FOOTER ───────────────────────────────────────────────── --}}
    <footer class="border-t border-gray-200 mt-16 py-6 text-center
                   text-xs text-gray-400">
        Built with DevPortfolio Platform
    </footer>

    {{-- Analytics click tracking script --}}
    <script>
        // Track when visitors click demo or repo links
        // Uses fetch() to send a background request without page reload
        document.querySelectorAll('[data-analytics]').forEach(link => {
            link.addEventListener('click', function() {
                const type        = this.dataset.analytics;
                const portfolioId = this.dataset.portfolio;

                // Send the event to our analytics endpoint
                // We'll create this route next
                fetch('/analytics/track', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        event_type:   type,
                        portfolio_id: portfolioId,
                    }),
                }).catch(() => {}); // silently ignore errors
            });
        });
    </script>

</body>
</html>