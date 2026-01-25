<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-data="{
    dark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggle() {
        this.dark = !this.dark;
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
    }
}" x-init="document.documentElement.classList.toggle('dark', dark);
$watch('dark', value => document.documentElement.classList.toggle('dark', value))">

    @if (session('success'))
        <x-alert type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    @if (session('error'))
        <x-alert type="error">
            {{ session('error') }}
        </x-alert>
    @endif

    <div class="layout-wrapper min-h-screen bg-gray-100 dark:bg-gray-900 transition">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="flex-1 flex flex-col p-4 sm:p-8 gap-6 max-w-screen-2xl">
            {{ $slot }}
        </main>
    </div>

    {{-- Theme Toggle --}}
    <div class="hidden sm:flex fixed right-4 top-4">

        <button @click="toggle()" class="text-2xl">
            <span x-show="!dark">🌙</span>
            <span x-show="dark">☀️</span>
        </button>
    </div>
</body>

</html>
