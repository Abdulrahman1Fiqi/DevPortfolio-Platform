<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Skills
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200
                            text-green-700 rounded-lg p-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Add skill form --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">
                    Add a Skill
                </h3>

                <form method="POST"
                      action="{{ route('developer.skills.store') }}"
                      class="flex flex-wrap gap-3 items-end">
                    @csrf

                    {{-- Skill name --}}
                    <div class="flex-1 min-w-[160px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Skill Name
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="e.g. Laravel"
                               required
                               class="w-full border-gray-300 rounded-md shadow-sm
                                      focus:ring-indigo-500 focus:border-indigo-500
                                      text-sm" />
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category dropdown --}}
                    <div class="flex-1 min-w-[140px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Category
                        </label>
                        <select name="category"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       focus:ring-indigo-500 focus:border-indigo-500
                                       text-sm">
                            @foreach(['Languages','Frameworks','Databases','Tools','Other'] as $cat)
                                <option value="{{ $cat }}"
                                    {{ old('category') === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Proficiency dropdown --}}
                    <div class="flex-1 min-w-[140px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Proficiency
                        </label>
                        <select name="proficiency"
                                class="w-full border-gray-300 rounded-md shadow-sm
                                       focus:ring-indigo-500 focus:border-indigo-500
                                       text-sm">
                            <option value="">— optional —</option>
                            @foreach(['Beginner','Intermediate','Advanced','Expert'] as $level)
                                <option value="{{ $level }}"
                                    {{ old('proficiency') === $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md
                                   text-sm font-medium hover:bg-indigo-700 transition
                                   whitespace-nowrap">
                        + Add Skill
                    </button>
                </form>
            </div>

            {{-- Skills grouped by category --}}
            @if($groupedSkills->isEmpty())
                <div class="bg-white shadow sm:rounded-lg p-8 text-center
                            text-gray-500 text-sm">
                    No skills added yet. Add your first skill above!
                </div>
            @else
                @foreach($groupedSkills as $category => $skills)
                    <div class="bg-white shadow sm:rounded-lg p-6">

                        {{-- Category heading --}}
                        <h3 class="text-sm font-semibold text-gray-500
                                   uppercase tracking-wider mb-3">
                            {{ $category }}
                        </h3>

                        {{-- Skill tags --}}
                        <div class="flex flex-wrap gap-2">
                            @foreach($skills as $skill)
                                <div class="flex items-center gap-1 bg-indigo-50
                                            border border-indigo-200 rounded-full
                                            px-3 py-1">

                                    <span class="text-sm text-indigo-800 font-medium">
                                        {{ $skill->name }}
                                    </span>

                                    @if($skill->proficiency)
                                        <span class="text-xs text-indigo-500">
                                            · {{ $skill->proficiency }}
                                        </span>
                                    @endif

                                    {{-- Delete button --}}
                                    <form method="POST"
                                          action="{{ route('developer.skills.destroy', $skill) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="ml-1 text-indigo-400
                                                       hover:text-red-500 transition
                                                       text-xs leading-none"
                                                title="Remove skill">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</x-app-layout>