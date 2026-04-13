@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg text-indigo-600 bg-indigo-50 transition-colors'
    : 'inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>