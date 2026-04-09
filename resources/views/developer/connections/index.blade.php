<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Connection Requests
            </h2>
            @if($pendingCount > 0)
                <span class="bg-red-500 text-white text-xs font-bold
                             px-2 py-0.5 rounded-full">
                    {{ $pendingCount }} pending
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200
                            text-green-700 rounded-lg p-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($connections->isEmpty())
                <div class="bg-white shadow sm:rounded-lg p-8
                            text-center text-gray-500 text-sm">
                    No connection requests yet.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($connections as $connection)
                        <div class="bg-white shadow sm:rounded-lg p-5">
                            <div class="flex justify-between items-start gap-4">

                                <div class="flex-1">
                                    {{-- Recruiter info --}}
                                    <div class="flex items-center gap-2">
                                        <p class="font-semibold text-gray-900">
                                            {{ $connection->recruiter->name }}
                                        </p>

                                        {{-- Status badge --}}
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                            {{ $connection->isPending()
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : ($connection->isAccepted()
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-gray-100 text-gray-600') }}">
                                            {{ ucfirst($connection->status) }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-500">
                                        {{ $connection->recruiter->email }}
                                    </p>

                                    {{-- Message --}}
                                    @if($connection->message)
                                        <div class="mt-2 bg-gray-50 rounded-lg p-3
                                                    text-sm text-gray-700 italic">
                                            "{{ $connection->message }}"
                                        </div>
                                    @endif

                                    <p class="text-xs text-gray-400 mt-2">
                                        Received {{ $connection->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                {{-- Action buttons (only for pending) --}}
                                @if($connection->isPending())
                                    <div class="flex gap-2 flex-shrink-0">

                                        {{-- Accept --}}
                                        <form method="POST"
                                              action="{{ route('developer.connections.accept', $connection) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="bg-green-600 text-white px-4 py-2
                                                           rounded-lg text-sm font-medium
                                                           hover:bg-green-700 transition">
                                                Accept
                                            </button>
                                        </form>

                                        {{-- Decline --}}
                                        <form method="POST"
                                              action="{{ route('developer.connections.decline', $connection) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="bg-gray-100 text-gray-700 px-4 py-2
                                                           rounded-lg text-sm font-medium
                                                           hover:bg-gray-200 transition">
                                                Decline
                                            </button>
                                        </form>

                                    </div>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $connections->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>