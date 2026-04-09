<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Connection Requests
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200
                            text-green-700 rounded-lg p-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mb-4 bg-blue-50 border border-blue-200
                            text-blue-700 rounded-lg p-4 text-sm">
                    {{ session('info') }}
                </div>
            @endif

            @if($connections->isEmpty())
                <div class="bg-white shadow sm:rounded-lg p-8
                            text-center text-gray-500 text-sm">
                    You haven't sent any connection requests yet.
                    <a href="{{ route('developers.index') }}"
                       class="text-indigo-600 hover:underline block mt-2">
                        Browse developers →
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($connections as $connection)
                        <div class="bg-white shadow sm:rounded-lg p-5">
                            <div class="flex justify-between items-start gap-4">

                                <div class="flex-1">
                                    {{-- Developer info --}}
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('portfolio.show', $connection->developer->username) }}"
                                           class="font-semibold text-gray-900
                                                  hover:text-indigo-600">
                                            {{ $connection->developer->name }}
                                        </a>

                                        {{-- Status badge --}}
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                            {{ $connection->isPending()
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : ($connection->isAccepted()
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-700') }}">
                                            {{ ucfirst($connection->status) }}
                                        </span>
                                    </div>

                                    {{-- Show email if accepted --}}
                                    @if($connection->isAccepted())
                                        <p class="text-sm text-green-600 mt-1">
                                            📧 {{ $connection->developer->email }}
                                        </p>
                                    @endif

                                    {{-- Your message --}}
                                    @if($connection->message)
                                        <div class="mt-2 bg-gray-50 rounded-lg p-3
                                                    text-sm text-gray-600 italic">
                                            "{{ $connection->message }}"
                                        </div>
                                    @endif

                                    <p class="text-xs text-gray-400 mt-2">
                                        Sent {{ $connection->created_at->diffForHumans() }}
                                        @if($connection->responded_at)
                                            · Responded {{ $connection->responded_at->diffForHumans() }}
                                        @endif
                                    </p>
                                </div>

                                {{-- Cancel button (only for pending) --}}
                                @if($connection->isPending())
                                    <form method="POST"
                                          action="{{ route('recruiter.connections.destroy', $connection) }}"
                                          onsubmit="return confirm('Cancel this request?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-sm text-red-600
                                                       hover:underline">
                                            Cancel
                                        </button>
                                    </form>
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