<div class="space-y-5">

    {{-- Company --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Company <span class="text-red-500">*</span>
        </label>
        <input type="text"
               name="company"
               value="{{ old('company', $experience?->company) }}"
               required
               placeholder="e.g. Google"
               class="w-full border-gray-300 rounded-md shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500" />
        @error('company')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Role --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Job Title <span class="text-red-500">*</span>
        </label>
        <input type="text"
               name="role"
               value="{{ old('role', $experience?->role) }}"
               required
               placeholder="e.g. Senior Backend Developer"
               class="w-full border-gray-300 rounded-md shadow-sm
                      focus:ring-indigo-500 focus:border-indigo-500" />
        @error('role')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Dates --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Start Date <span class="text-red-500">*</span>
            </label>
            <input type="date"
                   name="start_date"
                   value="{{ old('start_date', $experience?->start_date?->format('Y-m-d')) }}"
                   required
                   class="w-full border-gray-300 rounded-md shadow-sm
                          focus:ring-indigo-500 focus:border-indigo-500" />
            @error('start_date')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                End Date
                <span class="text-gray-400 font-normal">(leave blank if current)</span>
            </label>
            <input type="date"
                   name="end_date"
                   value="{{ old('end_date', $experience?->end_date?->format('Y-m-d')) }}"
                   class="w-full border-gray-300 rounded-md shadow-sm
                          focus:ring-indigo-500 focus:border-indigo-500" />
            @error('end_date')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Description --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Description
        </label>
        <textarea name="description"
                  rows="4"
                  placeholder="Describe your responsibilities and achievements..."
                  class="w-full border-gray-300 rounded-md shadow-sm
                         focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $experience?->description) }}</textarea>
        @error('description')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>