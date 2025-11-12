@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center gap-3 w-full p-3 px-4 hover:bg-[#165EFB] rounded-md transition text-white bg-gradient-to-r from-[#165EFB] to-[#1145B5]'
            : 'inline-flex items-center gap-3 w-full p-3 px-4 hover:bg-gray-700 rounded-md transition text-gray-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
