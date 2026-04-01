<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Work Experience
            </h2>
            <a href="{{ route('developer.experience.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md
                      text-sm font-medium hover:bg-indigo-700 transition">
                + Add Experience
            </a>
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

            @if($experiences->isEmpty())
                <div class="bg-white shadow sm:rounded-lg p-8
                            text-center text-gray-500 text-sm">
                    No experience added yet.
                    <a href="{{ route('developer.experience.create') }}"
                       class="text-indigo-600 hover:underline">
                        Add your first entry.
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($experiences as $experience)
                        <div class="bg-white shadow sm:rounded-lg p-5">
                            <div class="flex justify-between items-start">

                                <div class="flex-1">
                                    {{-- Role & Company --}}
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $experience->role }}
                                    </h3>
                                    <p class="text-indigo-600 text-sm font-medium">
                                        {{ $experience->company }}
                                    </p>

                                    {{-- Dates --}}
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $experience->start_date->format('M Y') }}
                                        —
                                        {{-- Uses our accessor from the Experience model --}}
                                        {{ $experience->end_label }}
                                    </p>

                                    {{-- Description --}}
                                    @if($experience->description)
                                        <p class="mt-2 text-sm text-gray-600">
                                            {{ $experience->description }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex gap-3 ml-4 flex-shrink-0">
                                    <a href="{{ route('developer.experience.edit', $experience) }}"
                                       class="text-sm text-indigo-600 hover:underline">
                                        Edit
                                    </a>
                                    <form method="POST"
                                          action="{{ route('developer.experience.destroy', $experience) }}"
                                          onsubmit="return confirm('Remove this experience?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-sm text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>