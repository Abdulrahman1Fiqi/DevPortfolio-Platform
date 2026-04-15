<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <title>Leave a Testimonial for {{ $user->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap"
          rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white
             to-purple-50 flex items-center justify-center p-4">

    <div class="w-full max-w-lg">

        {{-- Header --}}
        <div class="text-center mb-8">
            {{-- Developer avatar --}}
            @if($portfolio->avatar_path)
                <img src="{{ Storage::url($portfolio->avatar_path) }}"
                     alt="{{ $user->name }}"
                     class="w-16 h-16 rounded-full object-cover mx-auto
                            mb-3 ring-4 ring-white shadow" />
            @else
                <div class="w-16 h-16 rounded-full bg-indigo-100 mx-auto mb-3
                            flex items-center justify-center
                            text-indigo-600 font-bold text-2xl shadow">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif

            <h1 class="text-xl font-bold text-gray-900">
                Leave a testimonial for {{ $user->name }}
            </h1>

            @if($portfolio->headline)
                <p class="text-indigo-600 text-sm mt-1">
                    {{ $portfolio->headline }}
                </p>
            @endif

            <p class="text-gray-500 text-sm mt-2">
                Your feedback helps {{ $user->name }} showcase
                their work to potential clients and employers.
            </p>
        </div>

        {{-- Success message --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800
                        rounded-2xl p-5 mb-6 text-center">
                <div class="text-3xl mb-2">🎉</div>
                <p class="font-medium">{{ session('success') }}</p>
                <a href="{{ route('portfolio.show', $user->username) }}"
                   class="inline-block mt-3 text-sm text-indigo-600 hover:underline">
                    View {{ $user->name }}'s portfolio →
                </a>
            </div>
        @else
            {{-- Submission form --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">

                <form method="POST"
                      action="{{ route('testimonial.store', $portfolio->testimonial_token) }}"
                      class="space-y-5">
                    @csrf

                    {{-- Your name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Your Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="submitter_name"
                               value="{{ old('submitter_name') }}"
                               required
                               placeholder="John Smith"
                               class="input-field" />
                        @error('submitter_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role & Company side by side --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Your Role
                            </label>
                            <input type="text"
                                   name="submitter_role"
                                   value="{{ old('submitter_role') }}"
                                   placeholder="e.g. CTO"
                                   class="input-field" />
                            @error('submitter_role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Company
                            </label>
                            <input type="text"
                                   name="company"
                                   value="{{ old('company') }}"
                                   placeholder="e.g. Google"
                                   class="input-field" />
                            @error('company')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Star Rating --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Rating
                        </label>

                        {{-- Interactive star rating --}}
                        <div class="flex gap-1" id="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button"
                                        data-star="{{ $i }}"
                                        class="star-btn text-3xl text-gray-300
                                               hover:text-yellow-400 transition-colors
                                               focus:outline-none">
                                    ★
                                </button>
                            @endfor
                        </div>

                        {{-- Hidden input that stores the selected rating --}}
                        <input type="hidden"
                               name="rating"
                               id="rating-value"
                               value="{{ old('rating') }}" />

                        @error('rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Your Testimonial <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message"
                                  rows="5"
                                  required
                                  minlength="20"
                                  maxlength="1000"
                                  placeholder="Share your experience working with {{ $user->name }}. What did they do well? What made them stand out?"
                                  class="input-field resize-none">{{ old('message') }}</textarea>
                        <div class="flex justify-between mt-1">
                            @error('message')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 text-xs">Minimum 20 characters</p>
                            @enderror
                            <p class="text-gray-400 text-xs" id="char-count">
                                0 / 1000
                            </p>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-primary w-full">
                        Submit Testimonial
                    </button>

                </form>
            </div>
        @endif

        {{-- Footer --}}
        <p class="text-center text-xs text-gray-400 mt-6">
            Powered by
            <a href="{{ route('home') }}"
               class="text-indigo-500 hover:underline">
                DevPortfolio
            </a>
        </p>

    </div>

    <script>
        // ── Star rating interaction ────────────────────────────
        const stars      = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-value');

        // Restore selected rating on page load (e.g. after validation error)
        const savedRating = parseInt(ratingInput.value);
        if (savedRating) highlightStars(savedRating);

        stars.forEach(star => {

            // Hover effect — highlight stars up to hovered one
            star.addEventListener('mouseenter', () => {
                const hovered = parseInt(star.dataset.star);
                highlightStars(hovered);
            });

            // When mouse leaves the rating area, restore selected state
            star.addEventListener('mouseleave', () => {
                const selected = parseInt(ratingInput.value) || 0;
                highlightStars(selected);
            });

            // Click — set the rating value
            star.addEventListener('click', () => {
                const clicked = parseInt(star.dataset.star);
                ratingInput.value = clicked;
                highlightStars(clicked);
            });
        });

        function highlightStars(count) {
            stars.forEach((s, index) => {
                s.classList.toggle('text-yellow-400', index < count);
                s.classList.toggle('text-gray-300',   index >= count);
            });
        }

        // ── Character counter ─────────────────────────────────
        const textarea  = document.querySelector('textarea[name="message"]');
        const charCount = document.getElementById('char-count');

        textarea.addEventListener('input', () => {
            const len = textarea.value.length;
            charCount.textContent = `${len} / 1000`;
            charCount.classList.toggle('text-red-500', len > 950);
        });

        // Init counter
        charCount.textContent = `${textarea.value.length} / 1000`;
    </script>

</body>
</html>