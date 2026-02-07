<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') | {{ config('app.name', 'SIKAP') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#F3F4F6]">
        <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4">
            <div class="mb-8">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SIKAP" class="h-20 w-auto object-contain">
                </a>
            </div>

            @yield('content')

            <div class="mt-12 text-gray-500 text-sm flex items-center gap-2">
                <span class="text-lg">©</span> 2025, Sistem Informasi Karier dan Portofolio
            </div>
        </div>
    </body>
</html>