<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon (School Logo) -->
        <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpeg') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.jpeg') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.jpeg') }}">

        <!-- Fonts -->
        <link href="{{ asset('vendor/fonts/figtree.css') }}" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-center bg-no-repeat relative" style="background-image: url('{{ asset('loginimage.png') }}');">
            <!-- Overlay to ensure text readability -->
            <div class="absolute inset-0 bg-slate-900/40"></div>
            
            <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl shadow-slate-900/20 overflow-hidden sm:rounded-2xl border border-slate-100">
                <div class="flex flex-col items-center">
                    <a href="{{ url('/') }}">
                        <x-application-logo class="h-24 w-auto rounded-xl shadow-lg drop-shadow-2xl" />
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
