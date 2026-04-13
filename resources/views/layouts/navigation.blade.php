<nav x-data="{ open: false }"
     class="bg-white border-b border-gray-100 sticky top-0 z-40">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14">

            {{-- Left: Logo + links --}}
            <div class="flex items-center gap-6">

                {{-- Logo --}}
                <a href="{{ route(auth()->user()->dashboardRoute()) }}">
                    <x-application-logo class="w-36 h-auto" />
                </a>

                {{-- Desktop nav links --}}
                <div class="hidden sm:flex items-center gap-1">

                    @if(auth()->user()->isDeveloper())

                        <x-nav-link
                            :href="route('developer.dashboard')"
                            :active="request()->routeIs('developer.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link
                            :href="route('developer.profile.edit')"
                            :active="request()->routeIs('developer.profile.*')">
                            Profile
                        </x-nav-link>

                        <x-nav-link
                            :href="route('developer.projects.index')"
                            :active="request()->routeIs('developer.projects.*')">
                            Projects
                        </x-nav-link>

                        <x-nav-link
                            :href="route('developer.skills.index')"
                            :active="request()->routeIs('developer.skills.*')">
                            Skills
                        </x-nav-link>

                        <x-nav-link
                            :href="route('developer.experience.index')"
                            :active="request()->routeIs('developer.experience.*')">
                            Experience
                        </x-nav-link>

                        <x-nav-link
                            :href="route('developer.analytics.index')"
                            :active="request()->routeIs('developer.analytics.*')">
                            Analytics
                        </x-nav-link>

                        {{-- Connections with badge --}}
                        <a href="{{ route('developer.connections.index') }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm
                                  font-medium rounded-lg transition-colors
                                  {{ request()->routeIs('developer.connections.*')
                                     ? 'text-indigo-600 bg-indigo-50'
                                     : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            Connections
                            @php
                                $pending = auth()->user()
                                    ->receivedConnectionRequests()
                                    ->where('status', 'pending')
                                    ->count();
                            @endphp
                            @if($pending > 0)
                                <span class="bg-red-500 text-white text-xs
                                             font-bold w-4 h-4 rounded-full
                                             flex items-center justify-center
                                             leading-none">
                                    {{ $pending > 9 ? '9+' : $pending }}
                                </span>
                            @endif
                        </a>

                    @elseif(auth()->user()->isRecruiter())

                        <x-nav-link
                            :href="route('recruiter.dashboard')"
                            :active="request()->routeIs('recruiter.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link
                            :href="route('recruiter.connections.index')"
                            :active="request()->routeIs('recruiter.connections.*')">
                            My Requests
                        </x-nav-link>

                        <x-nav-link
                            :href="route('developers.index')"
                            :active="request()->routeIs('developers.*')">
                            Find Developers
                        </x-nav-link>

                    @endif

                </div>
            </div>

            {{-- Right: User dropdown --}}
            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 text-sm
                                       text-gray-700 hover:text-gray-900
                                       focus:outline-none transition">
                            {{-- Avatar or initials --}}
                            @php
                                $av = auth()->user()->portfolio?->avatar_path;
                            @endphp
                            @if($av)
                                <img src="{{ Storage::url($av) }}"
                                     class="w-7 h-7 rounded-full object-cover"
                                     alt="" />
                            @else
                                <div class="w-7 h-7 rounded-full bg-indigo-100
                                            text-indigo-600 text-xs font-bold
                                            flex items-center justify-center">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="font-medium">
                                {{ auth()->user()->name }}
                            </span>
                            <svg class="w-4 h-4 text-gray-400" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        {{-- View portfolio link --}}
                        @if(auth()->user()->isDeveloper())
                            <a href="{{ route('portfolio.show', auth()->user()->username) }}"
                               target="_blank"
                               class="block px-4 py-2 text-sm text-gray-700
                                      hover:bg-gray-100">
                                View My Portfolio ↗
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                        @endif

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left block px-4 py-2
                                           text-sm text-red-600 hover:bg-red-50">
                                Sign Out
                            </button>
                        </form>

                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile hamburger --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="text-gray-500 hover:text-gray-700 p-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path :class="{'hidden': open}"
                              stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open}"
                              class="hidden"
                              stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': !open}"
         class="hidden sm:hidden border-t border-gray-100 bg-white px-4 py-2">

        @if(auth()->user()->isDeveloper())
            <x-responsive-nav-link :href="route('developer.dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('developer.profile.edit')">Profile</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('developer.projects.index')">Projects</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('developer.skills.index')">Skills</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('developer.experience.index')">Experience</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('developer.analytics.index')">Analytics</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('developer.connections.index')">Connections</x-responsive-nav-link>
        @elseif(auth()->user()->isRecruiter())
            <x-responsive-nav-link :href="route('recruiter.dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('recruiter.connections.index')">My Requests</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('developers.index')">Find Developers</x-responsive-nav-link>
        @endif

        <div class="border-t border-gray-100 mt-2 pt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-3 py-2 text-sm
                               text-red-600 hover:bg-red-50 rounded-lg">
                    Sign Out
                </button>
            </form>
        </div>
    </div>

</nav>