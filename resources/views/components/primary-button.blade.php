@props([
    'href' => null,
])

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 p-3 px-5 rounded-lg transition text-white bg-gradient-to-r from-primary to-[#1145B5] shadow-lg shadow-primary/40 hover:-translate-y-1']) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 p-3 px-5 rounded-lg transition text-white bg-gradient-to-r from-primary to-[#1145B5] shadow-lg shadow-primary/40 hover:-translate-y-1']) }}>
        {{ $slot }}
    </button>
@endif
