<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Testimonials
            </h2>

            {{-- Copy link button --}}
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500 hidden sm:block">
                    Share your testimonial link:
                </span>
                <button onclick="copyTestimonialLink()"
                        class="flex items-center gap-2 text-sm bg-indigo-50
                               border border-indigo-200 text-indigo-700
                               px-4 py-2 rounded-lg hover:bg-indigo-100
                               transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012
                                 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2
                                 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span id="copy-btn-text">Copy Link</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200
                            text-green-700 rounded-lg p-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- How it works info box --}}
            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-5">
                <h3 class="font-semibold text-indigo-900 text-sm mb-1">
                    How testimonials work
                </h3>
                <p class="text-indigo-700 text-sm">
                    Share your unique link with colleagues and clients.
                    They can leave a testimonial without needing an account.
                    You review each submission and approve the ones
                    you want displayed on your public portfolio.
                </p>

                {{-- Preview the link --}}
                <div class="mt-3 flex items-center gap-2">
                    <code class="flex-1 bg-white border border-indigo-200
                                 rounded-lg px-3 py-1.5 text-xs text-indigo-600
                                 truncate">
                        {{ $testimonialLink }}
                    </code>
                    <button onclick="copyTestimonialLink()"
                            class="text-xs bg-indigo-600 text-white
                                   px-3 py-1.5 rounded-lg hover:bg-indigo-700
                                   transition whitespace-nowrap">
                        Copy
                    </button>
                </div>
            </div>

            {{-- ── PENDING TESTIMONIALS ────────────────────── --}}
            <div>
                <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                    Awaiting Review
                    @if($pending->isNotEmpty())
                        <span class="bg-yellow-100 text-yellow-800 text-xs
                                     font-bold px-2 py-0.5 rounded-full">
                            {{ $pending->count() }}
                        </span>
                    @endif
                </h3>

                @if($pending->isEmpty())
                    <div class="bg-white border border-gray-100 rounded-xl
                                p-6 text-center text-gray-400 text-sm">
                        No pending testimonials.
                        Share your link to start collecting feedback!
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($pending as $testimonial)
                            <div class="bg-white border-l-4 border-yellow-400
                                        rounded-xl shadow-sm p-5">

                                {{-- Submitter info --}}
                                <div class="flex justify-between items-start gap-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            {{ $testimonial->submitter_name }}
                                        </p>
                                        @if($testimonial->submitter_role || $testimonial->company)
                                            <p class="text-sm text-gray-500">
                                                {{ $testimonial->submitter_role }}
                                                @if($testimonial->submitter_role && $testimonial->company)
                                                    at
                                                @endif
                                                {{ $testimonial->company }}
                                            </p>
                                        @endif

                                        {{-- Stars --}}
                                        @if($testimonial->rating)
                                            <div class="flex gap-0.5 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="{{ $i <= $testimonial->rating
                                                                     ? 'text-yellow-400'
                                                                     : 'text-gray-200' }}
                                                                 text-sm">★</span>
                                                @endfor
                                            </div>
                                        @endif
                                    </div>

                                    <span class="text-xs text-gray-400 flex-shrink-0">
                                        {{ $testimonial->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                {{-- Message --}}
                                <p class="mt-3 text-gray-700 text-sm leading-relaxed
                                          italic border-l-2 border-gray-200 pl-3">
                                    "{{ $testimonial->message }}"
                                </p>

                                {{-- Actions --}}
                                <div class="mt-4 flex gap-3">

                                    {{-- Approve --}}
                                    <form method="POST"
                                          action="{{ route('developer.testimonials.approve', $testimonial) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="flex items-center gap-1.5 text-sm
                                                       bg-green-600 text-white px-4 py-2
                                                       rounded-lg hover:bg-green-700
                                                       transition font-medium">
                                            ✓ Approve & Publish
                                        </button>
                                    </form>

                                    {{-- Reject / Delete --}}
                                    <form method="POST"
                                          action="{{ route('developer.testimonials.destroy', $testimonial) }}"
                                          onsubmit="return confirm('Remove this testimonial?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="flex items-center gap-1.5 text-sm
                                                       bg-gray-100 text-gray-700 px-4 py-2
                                                       rounded-lg hover:bg-red-50
                                                       hover:text-red-700 transition">
                                            ✕ Reject
                                        </button>
                                    </form>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ── APPROVED TESTIMONIALS ───────────────────── --}}
            <div>
                <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                    Published on Portfolio
                    @if($approved->isNotEmpty())
                        <span class="bg-green-100 text-green-800 text-xs
                                     font-bold px-2 py-0.5 rounded-full">
                            {{ $approved->count() }}
                        </span>
                    @endif
                </h3>

                @if($approved->isEmpty())
                    <div class="bg-white border border-gray-100 rounded-xl
                                p-6 text-center text-gray-400 text-sm">
                        No approved testimonials yet.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($approved as $testimonial)
                            <div class="bg-white border-l-4 border-green-400
                                        rounded-xl shadow-sm p-5">

                                <div class="flex justify-between items-start gap-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            {{ $testimonial->submitter_name }}
                                        </p>
                                        @if($testimonial->submitter_role || $testimonial->company)
                                            <p class="text-sm text-gray-500">
                                                {{ $testimonial->submitter_role }}
                                                @if($testimonial->submitter_role && $testimonial->company)
                                                    at
                                                @endif
                                                {{ $testimonial->company }}
                                            </p>
                                        @endif

                                        @if($testimonial->rating)
                                            <div class="flex gap-0.5 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="{{ $i <= $testimonial->rating
                                                                     ? 'text-yellow-400'
                                                                     : 'text-gray-200' }}
                                                                 text-sm">★</span>
                                                @endfor
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-3 flex-shrink-0">
                                        <span class="text-xs text-gray-400">
                                            {{ $testimonial->created_at->diffForHumans() }}
                                        </span>

                                        {{-- Remove from portfolio --}}
                                        <form method="POST"
                                              action="{{ route('developer.testimonials.destroy', $testimonial) }}"
                                              onsubmit="return confirm('Remove this testimonial from your portfolio?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs text-red-500
                                                           hover:underline">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <p class="mt-3 text-gray-700 text-sm leading-relaxed
                                          italic border-l-2 border-gray-200 pl-3">
                                    "{{ $testimonial->message }}"
                                </p>

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        function copyTestimonialLink() {
            const link = '{{ $testimonialLink }}';

            navigator.clipboard.writeText(link).then(() => {
                const btn = document.getElementById('copy-btn-text');
                btn.textContent = 'Copied!';
                setTimeout(() => btn.textContent = 'Copy Link', 2000);
            });
        }
    </script>

</x-app-layout>