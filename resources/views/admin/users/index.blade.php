<x-admin-layout>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Users</h1>
        <span class="text-sm text-gray-500">
            {{ $users->total() }} total users
        </span>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="bg-white shadow rounded-lg p-4 mb-6
                 flex flex-wrap gap-3 items-end">

        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">
                Search
            </label>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Name, email or username..."
                   class="w-full border-gray-300 rounded-md shadow-sm text-sm
                          focus:ring-indigo-500 focus:border-indigo-500" />
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">
                Role
            </label>
            <select name="role"
                    class="border-gray-300 rounded-md shadow-sm text-sm
                           focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All roles</option>
                <option value="developer"
                    {{ request('role') === 'developer' ? 'selected' : '' }}>
                    Developer
                </option>
                <option value="recruiter"
                    {{ request('role') === 'recruiter' ? 'selected' : '' }}>
                    Recruiter
                </option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">
                Status
            </label>
            <select name="status"
                    class="border-gray-300 rounded-md shadow-sm text-sm
                           focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All statuses</option>
                <option value="active"
                    {{ request('status') === 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="suspended"
                    {{ request('status') === 'suspended' ? 'selected' : '' }}>
                    Suspended
                </option>
            </select>
        </div>

        <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md
                       text-sm hover:bg-indigo-700 transition">
            Filter
        </button>

        @if(request('search') || request('role') || request('status'))
            <a href="{{ route('admin.users.index') }}"
               class="text-sm text-gray-500 hover:underline">
                Clear
            </a>
        @endif
    </form>

    {{-- Users table --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-5 py-3">User</th>
                    <th class="text-left px-5 py-3">Role</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Portfolio</th>
                    <th class="text-left px-5 py-3">Joined</th>
                    <th class="text-left px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">

                        {{-- User info --}}
                        <td class="px-5 py-3">
                            <a href="{{ route('admin.users.show', $user) }}"
                               class="font-medium text-gray-900
                                      hover:text-indigo-600">
                                {{ $user->name }}
                            </a>
                            <p class="text-xs text-gray-400">
                                {{ $user->email }}
                            </p>
                        </td>

                        {{-- Role badge --}}
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $user->role === 'developer'
                                    ? 'bg-blue-100 text-blue-700'
                                    : ($user->role === 'admin'
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-purple-100 text-purple-700') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $user->is_active
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700' }}">
                                {{ $user->is_active ? 'Active' : 'Suspended' }}
                            </span>
                        </td>

                        {{-- Portfolio status --}}
                        <td class="px-5 py-3 text-gray-500">
                            @if($user->role === 'developer')
                                {{ $user->portfolio_count > 0 ? 'Has portfolio' : '—' }}
                            @else
                                —
                            @endif
                        </td>

                        {{-- Joined --}}
                        <td class="px-5 py-3 text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">

                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="text-indigo-600 hover:underline text-xs">
                                    View
                                </a>

                                @if(! $user->isAdmin())
                                    {{-- Suspend / Activate --}}
                                    @if($user->is_active)
                                        <form method="POST"
                                              action="{{ route('admin.users.suspend', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="text-yellow-600 hover:underline
                                                           text-xs">
                                                Suspend
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST"
                                              action="{{ route('admin.users.activate', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="text-green-600 hover:underline
                                                           text-xs">
                                                Activate
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete --}}
                                    <form method="POST"
                                          action="{{ route('admin.users.destroy', $user) }}"
                                          onsubmit="return confirm('Permanently delete {{ addslashes($user->name) }}? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:underline
                                                       text-xs">
                                            Delete
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"
                            class="px-5 py-8 text-center text-gray-400 text-sm">
                            No users found matching your filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>

</x-admin-layout>