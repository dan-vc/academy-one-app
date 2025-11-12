@props([

])

<div {{ $attributes->merge(['class' => "bg-white rounded-2xl overflow-hidden border-0 shadow-lg"]) }}>
    @isset($header)
        <div class="border-b bg-slate-100 p-6 pb-6">
            {{ $header }}
        </div>
    @endisset


    {{ $slot }}
</div>
