@props([

])

<div {{ $attributes->merge(['class' => "bg-white rounded-2xl overflow-hidden border-0 shadow-md dark:bg-gray-800"]) }}>
    @isset($header)
        <div class="border-b bg-gray-50 p-4 sm:p-6 pb-6 dark:bg-gray-800 dark:border-slate-700">
            {{ $header }}
        </div>
    @endisset


    {{ $slot }}
</div>
