<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Experience
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST"
                      action="{{ route('developer.experience.store') }}">
                    @csrf

                    @include('developer.experience._form', ['experience' => null])

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('developer.experience.index') }}"
                           class="text-sm text-gray-600 hover:underline">
                            ← Back
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2
                                       rounded-md text-sm font-medium
                                       hover:bg-indigo-700 transition">
                            Add Experience
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>