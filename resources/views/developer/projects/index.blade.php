<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Projects
            </h2>
            <a href="{{ route('developer.projects.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md
                      text-sm font-medium hover:bg-indigo-700 transition">
                + Add Project
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Success message --}}
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200
                            text-green-700 rounded-lg p-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Empty state --}}
            @if($projects->isEmpty())
                <div class="bg-white shadow sm:rounded-lg p-12 text-center">
                    <p class="text-gray-500 text-sm">
                        No projects yet. Add your first one!
                    </p>
                    <a href="{{ route('developer.projects.create') }}"
                       class="mt-4 inline-block bg-indigo-600 text-white
                              px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        + Add Project
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($projects as $project)
                        <div class="bg-white shadow sm:rounded-lg p-5
                                    flex items-start gap-4">

                            {{-- Thumbnail --}}
                            @if($project->thumbnail_path)
                                <img src="{{ Storage::url($project->thumbnail_path) }}"
                                     alt="{{ $project->title }}"
                                     class="w-20 h-20 object-cover rounded-md flex-shrink-0" />
                            @else
                                <div class="w-20 h-20 bg-gray-100 rounded-md
                                            flex-shrink-0 flex items-center
                                            justify-center text-gray-400 text-xs">
                                    No image
                                </div>
                            @endif

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-medium text-gray-900">
                                        {{ $project->title }}
                                    </h3>
                                    @if($project->is_featured)
                                        <span class="text-xs bg-yellow-100
                                                     text-yellow-800 px-2 py-0.5
                                                     rounded-full">
                                            Featured
                                        </span>
                                    @endif
                                </div>

                                {{-- Tech stack tags --}}
                                @if($project->tech_stack)
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @foreach($project->tech_stack as $tag)
                                            <span class="text-xs bg-indigo-50
                                                         text-indigo-700 px-2 py-0.5
                                                         rounded-full">
                                                {{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Links --}}
                                <div class="mt-2 flex gap-3 text-xs text-gray-500">
                                    @if($project->demo_url)
                                        <a href="{{ $project->demo_url }}"
                                           target="_blank"
                                           class="hover:text-indigo-600">
                                            Live Demo ↗
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

                            {{-- Actions --}}
                            <div class="flex gap-2 flex-shrink-0">
                                <a href="{{ route('developer.projects.edit', $project) }}"
                                   class="text-sm text-indigo-600 hover:underline">
                                    Edit
                                </a>

                                {{-- Delete button --}}
                                <form method="POST"
                                      action="{{ route('developer.projects.destroy', $project) }}"
                                      onsubmit="return confirm('Delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-sm text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination links --}}
                <div class="mt-4">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>