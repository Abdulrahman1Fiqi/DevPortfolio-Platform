<x-guest-layout>

    <h2 class="text-xl font-bold text-gray-900 mb-1">Create your account</h2>
    <p class="text-sm text-gray-500 mb-6">Start building your developer portfolio</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Full Name
            </label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required autofocus autocomplete="name"
                   placeholder="John Doe"
                   class="input-field" />
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Username --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Username
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center
                             text-gray-400 text-sm pointer-events-none">
                    /portfolio/
                </span>
                <input type="text"
                       name="username"
                       id="username"
                       value="{{ old('username') }}"
                       required
                       placeholder="johndoe"
                       class="input-field pl-[5.5rem]" />
            </div>
            @error('username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Email address
            </label>
            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required autocomplete="username"
                   placeholder="john@example.com"
                   class="input-field" />
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role selector --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                I am joining as a...
            </label>
            <div class="grid grid-cols-2 gap-3">

                <label class="cursor-pointer">
                    <input type="radio" name="role" value="developer"
                           class="sr-only peer"
                           {{ old('role', 'developer') === 'developer' ? 'checked' : '' }} />
                    <div class="border-2 border-gray-200 rounded-xl p-3
                                peer-checked:border-indigo-500
                                peer-checked:bg-indigo-50
                                transition-all text-center">
                        <div class="text-2xl mb-1">👨‍💻</div>
                        <p class="text-sm font-semibold text-gray-800">
                            Developer
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            I want a portfolio
                        </p>
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="role" value="recruiter"
                           class="sr-only peer"
                           {{ old('role') === 'recruiter' ? 'checked' : '' }} />
                    <div class="border-2 border-gray-200 rounded-xl p-3
                                peer-checked:border-indigo-500
                                peer-checked:bg-indigo-50
                                transition-all text-center">
                        <div class="text-2xl mb-1">🔍</div>
                        <p class="text-sm font-semibold text-gray-800">
                            Recruiter
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            I want to hire
                        </p>
                    </div>
                </label>

            </div>
            @error('role')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Password
            </label>
            <input type="password"
                   name="password"
                   required autocomplete="new-password"
                   class="input-field" />
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Confirm Password
            </label>
            <input type="password"
                   name="password_confirmation"
                   required autocomplete="new-password"
                   class="input-field" />
            @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full mt-2">
            Create Account
        </button>

    </form>

    {{-- Login link --}}
    <p class="text-center text-sm text-gray-500 mt-6">
        Already have an account?
        <a href="{{ route('login') }}"
           class="text-indigo-600 font-medium hover:underline">
            Sign in
        </a>
    </p>

</x-guest-layout>