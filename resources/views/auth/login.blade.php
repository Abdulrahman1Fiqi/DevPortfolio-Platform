<x-guest-layout>

    <h2 class="text-xl font-bold text-gray-900 mb-1">Welcome back</h2>
    <p class="text-sm text-gray-500 mb-6">Sign in to your account</p>

    {{-- Session status (e.g. password reset success) --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Email address
            </label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="input-field
                          {{ $errors->has('email') ? 'border-red-400 bg-red-50' : '' }}" />
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs text-indigo-600 hover:underline">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password"
                   type="password"
                   name="password"
                   required autocomplete="current-password"
                   class="input-field
                          {{ $errors->has('password') ? 'border-red-400 bg-red-50' : '' }}" />
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2">
            <input id="remember_me"
                   type="checkbox"
                   name="remember"
                   class="rounded border-gray-300 text-indigo-600
                          focus:ring-indigo-500 w-4 h-4" />
            <label for="remember_me" class="text-sm text-gray-600">
                Remember me
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full mt-2">
            Sign in
        </button>

    </form>

    {{-- Register link --}}
    <p class="text-center text-sm text-gray-500 mt-6">
        Don't have an account?
        <a href="{{ route('register') }}"
           class="text-indigo-600 font-medium hover:underline">
            Create one free
        </a>
    </p>

</x-guest-layout>