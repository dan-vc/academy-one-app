@props([
    'type' => 'info',
    'duration' => 3000,
])

@php
    $colors = [
        'success' => 'bg-green-100 text-green-800 border-green-300',
        'error' => 'bg-red-100 text-red-800 border-red-300',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
        'info' => 'bg-blue-100 text-blue-800 border-blue-300',
    ];

    $icons = [
        'success' => '✅',
        'error' => '❌',
        'warning' => '⚠️',
        'info' => 'ℹ️',
    ];
@endphp

<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, {{ $duration }})" x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="fixed bottom-3 right-3 border-l-4 rounded p-4 mb-4 {{ $colors[$type] }}">
    <div class="flex items-center gap-2">
        <span class="text-xl">{{ $icons[$type] }}</span>
        <p>{{ $slot }}</p>
    </div>
</div>
