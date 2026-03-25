<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome card --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">
                    Welcome back, {{ $user->name }}! 👋
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    Your portfolio is currently
                    @if($portfolio?->is_published)
                        <span class="text-green-600 font-medium">published</span>
                    @else
                        <span class="text-yellow-600 font-medium">unpublished</span>
                    @endif
                </p>
                @if($portfolio?->is_published)
                    <a href="{{ route('portfolio.show', $user->username) }}"
                       target="_blank"
                       class="mt-3 inline-flex items-center text-sm text-indigo-600 hover:underline">
                        View your portfolio →
                    </a>
                @endif

                <form method="POST"
                    action="{{ route('developer.portfolio.toggle-publish') }}"
                    class="mt-3">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="text-sm px-4 py-2 rounded-md font-medium transition
                                {{ $portfolio?->is_published
                                    ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200'
                                    : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                        {{ $portfolio?->is_published ? 'Unpublish Portfolio' : 'Publish Portfolio' }}
                    </button>
                </form>

            </div>

            {{-- Quick links --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    ['label' => 'Edit Profile',  'route' => 'developer.profile.edit'],
                ] as $link)
                    <a href="{{ route($link['route']) }}"
                       class="bg-white shadow sm:rounded-lg p-4 text-center
                              hover:shadow-md transition text-sm font-medium text-gray-700">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>