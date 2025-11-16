@props([
    'disabled' => false,
    'isSearch' => null
])

<div class="relative">
    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
        {{ $slot }}
    </div>

    <input @disabled($disabled)
        {{ $attributes->merge(['class' => 'h-12 pl-11 border-gray-300 placeholder:text-gray-400 focus:outline-none focus:border-primary focus:ring-primary rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-primary']) }} />

    @isset($isSearch)
        <button type="button" x-on:click="$root.submit()"
            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-500 hover:text-red-500 transition-colors {{ request('search') ? '' : 'hidden' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    @endisset
</div>
