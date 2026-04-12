<x-admin-layout>

    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}"
           class="text-sm text-indigo-600 hover:underline">
            ← Back to users
        </a>
    </div>

    <div class="grid grid-cols-3 gap-6">

        {{-- ── User info card ─────────────────────────────── --}}
        <div class="col-span-1 space-y-4">

            <div class="bg-white shadow rounded-lg p-5">
                <h2 class="font-semibold text-gray-900 text-lg">
                    {{ $user->name }}
                </h2>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <p class="text-sm text-gray-500 font-mono">
                    {{ $user->username }}
                </p>

                <div class="mt-3 flex gap-2">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $user->role === 'developer'
                            ? 'bg-blue-100 text-blue-700'
                            : 'bg-purple-100 text-purple-700' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $user->is_active
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">
                        {{ $user->is_active ? 'Active' : 'Suspended' }}
                    </span>
                </div>

                <p class="text-xs text-gray-400 mt-3">
                    Joined {{ $user->created_at->format('M d, Y') }}
                </p>
            </div>

            {{-- Actions --}}
            @if(! $user->isAdmin())
                <div class="bg-white shadow rounded-lg p-5 space-y-3">
                    <h3 class="font-medium text-gray-800 text-sm">
                        Admin Actions
                    </h3>

                    @if($user->is_active)
                        <form method="POST"
                              action="{{ route('admin.users.suspend', $user) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full text-sm bg-yellow-50 border
                                           border-yellow-200 text-yellow-800
                                           py-2 rounded-lg hover:bg-yellow-100
                                           transition">
                                Suspend Account
                            </button>
                        </form>
                    @else
                        <form method="POST"
                              action="{{ route('admin.users.activate', $user) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full text-sm bg-green-50 border
                                           border-green-200 text-green-800
                                           py-2 rounded-lg hover:bg-green-100
                                           transition">
                                Activate Account
                            </button>
                        </form>
                    @endif

                    <form method="POST"
                          action="{{ route('admin.users.destroy', $user) }}"
                          onsubmit="return confirm('Permanently delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full text-sm bg-red-50 border
                                       border-red-200 text-red-700
                                       py-2 rounded-lg hover:bg-red-100
                                       transition">
                            Delete Account Permanently
                        </button>
                    </form>

                    {{-- View public portfolio --}}
                    @if($user->isDeveloper() && $user->portfolio?->is_published)
                        <a href="{{ route('portfolio.show', $user->username) }}"
                           target="_blank"
                           class="block w-full text-center text-sm
                                  bg-indigo-50 border border-indigo-200
                                  text-indigo-700 py-2 rounded-lg
                                  hover:bg-indigo-100 transition">
                            View Portfolio ↗
                        </a>
                    @endif
                </div>
            @endif
        </div>

        {{-- ── Portfolio summary ──────────────────────────── --}}
        <div class="col-span-2 space-y-4">

            @if($user->isDeveloper() && $user->portfolio)
                <div class="bg-white shadow rounded-lg p-5">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-gray-800">
                            Portfolio
                        </h3>
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $user->portfolio->is_published
                                ? 'bg-green-100 text-green-700'
                                : 'bg-gray-100 text-gray-500' }}">
                            {{ $user->portfolio->is_published
                                ? 'Published' : 'Unpublished' }}
                        </span>
                    </div>

                    @if($user->portfolio->headline)
                        <p class="text-sm text-indigo-600 font-medium">
                            {{ $user->portfolio->headline }}
                        </p>
                    @endif

                    <div class="mt-3 grid grid-cols-2 gap-3 text-center">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-xl font-bold text-gray-900">
                                {{ $user->portfolio->projects->count() }}
                            </p>
                            <p class="text-xs text-gray-500">Projects</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-xl font-bold text-gray-900">
                                {{ $user->portfolio->skills->count() }}
                            </p>
                            <p class="text-xs text-gray-500">Skills</p>
                        </div>
                    </div>
                </div>

                {{-- Projects list --}}
                @if($user->portfolio->projects->isNotEmpty())
                    <div class="bg-white shadow rounded-lg p-5">
                        <h3 class="font-semibold text-gray-800 mb-3">
                            Projects
                        </h3>
                        <div class="space-y-2">
                            @foreach($user->portfolio->projects as $project)
                                <div class="flex items-center justify-between
                                            text-sm py-1">
                                    <span class="text-gray-800">
                                        {{ $project->title }}
                                    </span>
                                    <div class="flex gap-2 text-xs text-gray-400">
                                        @if($project->demo_url)
                                            <a href="{{ $project->demo_url }}"
                                               target="_blank"
                                               class="hover:text-indigo-600">
                                                Demo ↗
                                            </a>
                                        @endif
                                        @if($project->repo_url)
                                            <a href="{{ $project->repo_url }}"
                                               target="_blank"
                                               class="hover:text-indigo-600">
                                                GitHub ↗
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            @else
                <div class="bg-white shadow rounded-lg p-8
                            text-center text-gray-400 text-sm">
                    @if($user->isRecruiter())
                        This user is a recruiter — no portfolio.
                    @else
                        No portfolio created yet.
                    @endif
                </div>
            @endif
        </div>
    </div>

</x-admin-layout>