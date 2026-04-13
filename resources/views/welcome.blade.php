<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <title>DevPortfolio — Build Your Developer Identity</title>
    <meta name="description"
          content="Create a beautiful developer portfolio, showcase your projects,
                   and connect with recruiters. Free forever." />
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap"
          rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-900">

    {{-- ── NAVIGATION ───────────────────────────────────────── --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80
                backdrop-blur-md border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center
                    justify-between">

            <x-application-logo class="w-40 h-auto" />

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route(auth()->user()->dashboardRoute()) }}"
                       class="btn-primary text-sm py-2">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-600 hover:text-indigo-600
                              font-medium transition">
                        Sign in
                    </a>
                    <a href="{{ route('register') }}"
                       class="btn-primary text-sm py-2">
                        Get Started Free
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ── HERO ─────────────────────────────────────────────── --}}
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-4xl mx-auto text-center">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 bg-indigo-50
                        border border-indigo-200 rounded-full px-4 py-1.5
                        text-indigo-700 text-sm font-medium mb-6">
                <span class="w-2 h-2 bg-indigo-500 rounded-full
                             animate-pulse inline-block"></span>
                Free for developers, always
            </div>

            {{-- Headline --}}
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900
                       leading-tight tracking-tight mb-6">
                Your developer portfolio,
                <span class="text-indigo-600">
                    done right.
                </span>
            </h1>

            {{-- Subheadline --}}
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed mb-10">
                Create a stunning portfolio page, showcase your projects and skills,
                and get discovered by recruiters — all in one place.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="btn-primary text-base py-3 px-8">
                    Build My Portfolio
                </a>
                <a href="{{ route('developers.index') }}"
                   class="btn-secondary text-base py-3 px-8">
                    Browse Developers
                </a>
            </div>

            {{-- Social proof --}}
            <p class="text-sm text-gray-400 mt-6">
                Join developers already showcasing their work
            </p>

        </div>
    </section>

    {{-- ── FEATURES ─────────────────────────────────────────── --}}
    <section class="py-20 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">
                    Everything you need
                </h2>
                <p class="text-gray-500">
                    Built specifically for developers who want to stand out
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach([
                    [
                        'icon'  => '🚀',
                        'title' => 'Showcase Projects',
                        'desc'  => 'Display your best work with live demo links, GitHub repos, and tech stack tags. Let your code speak for itself.',
                    ],
                    [
                        'icon'  => '🎯',
                        'title' => 'Get Discovered',
                        'desc'  => 'Recruiters browse the developer directory and send connection requests. You stay in full control of who contacts you.',
                    ],
                    [
                        'icon'  => '📊',
                        'title' => 'Track Analytics',
                        'desc'  => 'See who views your portfolio, which projects get the most clicks, and how your profile grows over time.',
                    ],
                    [
                        'icon'  => '🛠️',
                        'title' => 'Skills & Experience',
                        'desc'  => 'Organize your skills by category, show your work history with a clean timeline, and let recruiters see your full profile.',
                    ],
                    [
                        'icon'  => '⭐',
                        'title' => 'Testimonials',
                        'desc'  => 'Collect and display recommendations from colleagues and clients. Build credibility with real social proof.',
                    ],
                    [
                        'icon'  => '🔗',
                        'title' => 'Your Own URL',
                        'desc'  => 'Get a clean shareable link at devportfolio.com/portfolio/yourname that you can put on your CV and LinkedIn.',
                    ],
                ] as $feature)
                    <div class="card hover:shadow-md transition-shadow">
                        <div class="text-3xl mb-3">{{ $feature['icon'] }}</div>
                        <h3 class="font-semibold text-gray-900 mb-2">
                            {{ $feature['title'] }}
                        </h3>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            {{ $feature['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── HOW IT WORKS ─────────────────────────────────────── --}}
    <section class="py-20 px-6">
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">
                    Up and running in minutes
                </h2>
            </div>

            <div class="space-y-6">
                @foreach([
                    [
                        'step'  => '01',
                        'title' => 'Create your account',
                        'desc'  => 'Sign up as a developer and choose your username. Your portfolio URL is instantly reserved.',
                    ],
                    [
                        'step'  => '02',
                        'title' => 'Fill in your profile',
                        'desc'  => 'Add your bio, location, social links, skills, and work experience. Takes about 10 minutes.',
                    ],
                    [
                        'step'  => '03',
                        'title' => 'Add your projects',
                        'desc'  => 'Upload thumbnails, add descriptions, link your GitHub repos and live demos.',
                    ],
                    [
                        'step'  => '04',
                        'title' => 'Publish and share',
                        'desc'  => 'Hit publish and share your URL. Recruiters can find you in the directory or you can link it from your CV.',
                    ],
                ] as $step)
                    <div class="flex gap-5 items-start">
                        <div class="flex-shrink-0 w-12 h-12 rounded-2xl
                                    bg-indigo-100 text-indigo-700 font-bold
                                    text-sm flex items-center justify-center">
                            {{ $step['step'] }}
                        </div>
                        <div class="pt-2">
                            <h3 class="font-semibold text-gray-900 mb-1">
                                {{ $step['title'] }}
                            </h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                {{ $step['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── FOR RECRUITERS ───────────────────────────────────── --}}
    <section class="py-20 px-6 bg-indigo-600">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                Are you a recruiter?
            </h2>
            <p class="text-indigo-200 text-lg mb-8">
                Browse a curated directory of developers with verified skills
                and real project portfolios. Send connection requests and
                let developers come to you.
            </p>
            <a href="{{ route('register') }}?role=recruiter"
               class="inline-block bg-white text-indigo-700 font-semibold
                      px-8 py-3 rounded-xl hover:bg-indigo-50 transition">
                Join as Recruiter →
            </a>
        </div>
    </section>

    {{-- ── FINAL CTA ────────────────────────────────────────── --}}
    <section class="py-24 px-6 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                Ready to stand out?
            </h2>
            <p class="text-gray-500 mb-8">
                Create your portfolio in minutes. It's completely free.
            </p>
            <a href="{{ route('register') }}"
               class="btn-primary text-lg py-4 px-10 inline-block">
                Get Started Free
            </a>
        </div>
    </section>

    {{-- ── FOOTER ───────────────────────────────────────────── --}}
    <footer class="border-t border-gray-100 py-8 px-6">
        <div class="max-w-6xl mx-auto flex flex-wrap items-center
                    justify-between gap-4">

            <x-application-logo class="w-32 h-auto" />

            <div class="flex gap-6 text-sm text-gray-400">
                <a href="{{ route('developers.index') }}"
                   class="hover:text-gray-600 transition">
                    Browse Developers
                </a>
                <a href="{{ route('register') }}"
                   class="hover:text-gray-600 transition">
                    Sign Up
                </a>
                <a href="{{ route('login') }}"
                   class="hover:text-gray-600 transition">
                    Sign In
                </a>
            </div>

            <p class="text-sm text-gray-400">
                © {{ date('Y') }} DevPortfolio
            </p>

        </div>
    </footer>

</body>
</html>