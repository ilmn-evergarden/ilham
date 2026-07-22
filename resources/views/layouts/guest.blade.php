<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <x-seo context="admin" title="Login" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="{{ asset('css/portfolio.css') }}" rel="stylesheet">
    </head>
    <body class="font-sans text-[#555] dark:text-[#a4a4a4] antialiased bg-white dark:bg-[#111]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f2f2f2] dark:bg-[#111]">
            <div>
                <a href="/">
                    <img src="{{ asset('sidebar.png') }}" alt="Logo" class="block h-16 w-auto mx-auto">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-white dark:bg-[#111] border border-[#e1e1e1] dark:border-[#383848] rounded shadow-sm overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
