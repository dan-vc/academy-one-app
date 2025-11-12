@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block items-center gap-3 p-3 mx-2 rounded-md transition text-white bg-gradient-to-r from-primary to-[#1145B5]'
            : 'block items-center gap-3 p-3 mx-2 rounded-md transition text-gray-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
