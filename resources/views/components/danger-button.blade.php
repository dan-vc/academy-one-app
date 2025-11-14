<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 p-3 px-5 rounded-lg transition bg-red-600 text-white hover:-translate-y-1']) }}>
    {{ $slot }}
</button>
