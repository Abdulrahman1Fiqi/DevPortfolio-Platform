<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <meta name="theme-color" content="#6366f1" />
    <title>{{ config('app.name', 'DevPortfolio') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap"
          rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50
             flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <x-application-logo class="w-48 h-auto mx-auto" />
            </a>
            <p class="text-gray-500 text-sm mt-2">
                Build your developer identity
            </p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            {{ $slot }}
        </div>

        {{-- Footer link --}}
        <p class="text-center text-xs text-gray-400 mt-6">
            © {{ date('Y') }} DevPortfolio. All rights reserved.
        </p>

    </div>

</body>
</html>