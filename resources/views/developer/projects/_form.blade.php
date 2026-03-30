{{-- This partial is included by both create.blade.php and edit.blade.php --}}
{{-- $project is null when creating, filled when editing --}}

<div class="space-y-5">

    {{-- Title --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Project Title <span class="text-red-500">*</span>
        </label>
        <input type="text"
               name="title"
               value="{{ old('title', $project?->title) }}"
               required
               class="w-full border-gray-300 rounded-md shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500" />
        @error('title')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Description
        </label>
        <textarea name="description"
                  rows="4"
                  class="w-full border-gray-300 rounded-md shadow-sm
                         focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $project?->description) }}</textarea>
        @error('description')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tech Stack --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Tech Stack
            <span class="text-gray-400 font-normal">(comma separated)</span>
        </label>

        {{-- We store as array but display as comma-separated string --}}
        <input type="text"
               id="tech-stack-input"
               placeholder="Laravel, MySQL, Tailwind CSS, Vue.js"
               value="{{ old('tech_stack_raw',
                   $project?->tech_stack
                       ? implode(', ', $project->tech_stack)
                       : '') }}"
               class="w-full border-gray-300 rounded-md shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500" />

        {{-- Hidden inputs — populated by JavaScript below --}}
        <div id="tech-stack-hidden"></div>

        <p class="text-xs text-gray-400 mt-1">
            Type tags separated by commas
        </p>
        @error('tech_stack')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Thumbnail --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Thumbnail Image
        </label>
        @if($project?->thumbnail_path)
            <img src="{{ Storage::url($project->thumbnail_path) }}"
                 alt="Current thumbnail"
                 class="w-32 h-20 object-cover rounded-md mb-2" />
            <p class="text-xs text-gray-400 mb-2">
                Upload a new image to replace the current one.
            </p>
        @endif
        <input type="file"
               name="thumbnail"
               accept="image/*"
               class="text-sm text-gray-600" />
        @error('thumbnail')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Demo URL --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Live Demo URL
        </label>
        <input type="url"
               name="demo_url"
               value="{{ old('demo_url', $project?->demo_url) }}"
               placeholder="https://myproject.com"
               class="w-full border-gray-300 rounded-md shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500" />
        @error('demo_url')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- GitHub Repo URL --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            GitHub Repository URL
        </label>
        <input type="url"
               name="repo_url"
               value="{{ old('repo_url', $project?->repo_url) }}"
               placeholder="https://github.com/username/repo"
               class="w-full border-gray-300 rounded-md shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500" />
        <p class="text-xs text-gray-400 mt-1">
            Must be a GitHub URL (https://github.com/...)
        </p>
        @error('repo_url')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Featured --}}
    <div class="flex items-center gap-2">
        <input type="checkbox"
               name="is_featured"
               id="is_featured"
               value="1"
               {{ old('is_featured', $project?->is_featured) ? 'checked' : '' }}
               class="rounded border-gray-300 text-indigo-600
                      focus:ring-indigo-500" />
        <label for="is_featured" class="text-sm text-gray-700">
            Feature this project (pinned to top of portfolio)
        </label>
    </div>

</div>

{{-- JavaScript: convert comma-separated input to array inputs --}}
<script>
    // When form submits, split the comma-separated tech stack
    // into individual hidden inputs named tech_stack[]
    // so Laravel receives them as an array
    document.querySelector('form').addEventListener('submit', function() {
        const input = document.getElementById('tech-stack-input').value;
        const container = document.getElementById('tech-stack-hidden');

        // Clear previous hidden inputs
        container.innerHTML = '';

        const tags = input.split(',')
            .map(tag => tag.trim())
            .filter(tag => tag.length > 0);

        tags.forEach(tag => {
            const hidden = document.createElement('input');
            hidden.type  = 'hidden';
            hidden.name  = 'tech_stack[]';
            hidden.value = tag;
            container.appendChild(hidden);
        });
    });
</script>