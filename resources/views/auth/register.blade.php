<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Username --}}
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username"
                class="block mt-1 w-full"
                type="text"
                name="username"
                :value="old('username')"
                required />
            {{-- Shows the public URL they will get --}}
            <p class="text-xs text-gray-500 mt-1">
                Your portfolio will be at:
                <span class="font-mono">
                    {{ url('/portfolio') }}/{{ old('username') ?? 'username' }}
                </span>
            </p>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Role Selection --}}
        <div class="mt-4">
            <x-input-label :value="__('I am a...')" />
            <div class="mt-2 flex gap-4">

                {{-- Developer option --}}
                <label class="flex-1 cursor-pointer">
                    <input type="radio"
                        name="role"
                        value="developer"
                        class="sr-only peer"
                        {{ old('role', 'developer') === 'developer' ? 'checked' : '' }} />
                    <div class="border-2 rounded-lg p-3 text-center text-sm font-medium
                                peer-checked:border-indigo-500 peer-checked:bg-indigo-50
                                peer-checked:text-indigo-700 border-gray-200 text-gray-600
                                transition-all">
                        Developer
                        <p class="text-xs font-normal mt-1">I want a portfolio</p>
                    </div>
                </label>

                {{-- Recruiter option --}}
                <label class="flex-1 cursor-pointer">
                    <input type="radio"
                        name="role"
                        value="recruiter"
                        class="sr-only peer"
                        {{ old('role') === 'recruiter' ? 'checked' : '' }} />
                    <div class="border-2 rounded-lg p-3 text-center text-sm font-medium
                                peer-checked:border-indigo-500 peer-checked:bg-indigo-50
                                peer-checked:text-indigo-700 border-gray-200 text-gray-600
                                transition-all">
                        Recruiter
                        <p class="text-xs font-normal mt-1">I want to hire</p>
                    </div>
                </label>

            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>

    </form>
</x-guest-layout>