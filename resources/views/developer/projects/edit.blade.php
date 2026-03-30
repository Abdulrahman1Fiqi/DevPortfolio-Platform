<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Project
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                {{-- PUT method for update --}}
                <form method="POST"
                      action="{{ route('developer.projects.update', $project) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Pass $project so the form pre-fills existing values --}}
                    @include('developer.projects._form', ['project' => $project])

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('developer.projects.index') }}"
                           class="text-sm text-gray-600 hover:underline">
                            ← Back to projects
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2
                                       rounded-md text-sm font-medium
                                       hover:bg-indigo-700 transition">
                            Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>