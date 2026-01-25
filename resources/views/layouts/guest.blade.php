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

<body class="font-sans text-gray-900 antialiased">
    <div
        class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-secondary transition">

        <div
            class="flex flex-col items-center gap-6 w-full sm:max-w-md p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <a href="/">
                <x-application-logo class="w-48 h-24 hidden dark:block"/>
                <x-application-logo-dark class="w-48 h-24 dark:hidden"/>
            </a>

            {{ $slot }}
        </div>
    </div>




    {{-- Theme Toggle --}}
    <div class="fixed right-4 top-4" x-data="{
        dark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
        toggle() {
            this.dark = !this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        }
    }" x-init="document.documentElement.classList.toggle('dark', dark);
    $watch('dark', value => document.documentElement.classList.toggle('dark', value))">

        <button @click="toggle()" class="text-2xl">
            <span x-show="!dark">🌙</span>
            <span x-show="dark">☀️</span>
        </button>
    </div>
</body>

</html>
