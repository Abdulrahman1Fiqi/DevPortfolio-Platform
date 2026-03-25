<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Success message --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700
                            rounded-lg p-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">

                {{-- enctype is REQUIRED for file uploads --}}
                <form method="POST"
                      action="{{ route('developer.profile.update') }}"
                      enctype="multipart/form-data">
                    @csrf

                    {{-- ── Personal Info ── --}}
                    <h3 class="text-base font-semibold text-gray-900 mb-4">
                        Personal Information
                    </h3>

                    {{-- Name --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Full Name
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm
                                      focus:ring-indigo-500 focus:border-indigo-500" />
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Headline --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Headline
                            <span class="text-gray-400 font-normal">(e.g. Full Stack Developer)</span>
                        </label>
                        <input type="text"
                               name="headline"
                               value="{{ old('headline', $portfolio?->headline) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm
                                      focus:ring-indigo-500 focus:border-indigo-500" />
                        @error('headline')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bio --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Bio
                        </label>
                        <textarea name="bio"
                                  rows="4"
                                  class="w-full border-gray-300 rounded-md shadow-sm
                                         focus:ring-indigo-500 focus:border-indigo-500">{{ old('bio', $portfolio?->bio) }}</textarea>
                        @error('bio')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Location
                        </label>
                        <input type="text"
                               name="location"
                               value="{{ old('location', $portfolio?->location) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm
                                      focus:ring-indigo-500 focus:border-indigo-500" />
                        @error('location')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="my-6" />

                    {{-- ── Avatar ── --}}
                    <h3 class="text-base font-semibold text-gray-900 mb-4">
                        Profile Photo
                    </h3>

                    <div class="mb-6 flex items-center gap-4">
                        {{-- Show current avatar or placeholder --}}
                        @if($portfolio?->avatar_path)
                            <img src="{{ Storage::url($portfolio->avatar_path) }}"
                                 alt="Avatar"
                                 class="w-16 h-16 rounded-full object-cover" />
                        @else
                            <div class="w-16 h-16 rounded-full bg-indigo-100
                                        flex items-center justify-center
                                        text-indigo-600 font-bold text-xl">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif

                        <div>
                            <input type="file"
                                   name="avatar"
                                   accept="image/*"
                                   class="text-sm text-gray-600" />
                            <p class="text-xs text-gray-400 mt-1">
                                JPG, PNG or GIF. Max 2MB.
                            </p>
                            @error('avatar')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-6" />

                    {{-- ── Social Links ── --}}
                    <h3 class="text-base font-semibold text-gray-900 mb-4">
                        Social Links
                    </h3>

                    @foreach(['github' => 'GitHub', 'linkedin' => 'LinkedIn', 'website' => 'Website', 'twitter' => 'Twitter'] as $key => $label)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $label }}
                            </label>
                            <input type="url"
                                   name="social_links[{{ $key }}]"
                                   value="{{ old('social_links.'.$key, $portfolio?->social_links[$key] ?? '') }}"
                                   placeholder="https://"
                                   class="w-full border-gray-300 rounded-md shadow-sm
                                          focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('social_links.'.$key)
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach

                    <hr class="my-6" />

                    {{-- Submit --}}
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2 rounded-md
                                       hover:bg-indigo-700 transition text-sm font-medium">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>