<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <style>
            .login-bg {
                background-image: url('/Img/LogInBg.png');
                background-size: cover; /* revert to original behavior */
                background-position: center;  /* keep subject centered */
            }
        </style>
        <div class="min-h-screen login-bg bg-fixed bg-cover bg-center relative">
            <div class="absolute inset-0" style="background-color: rgba(153, 0, 0, 0.35);"></div>
            <div class="relative z-10 min-h-screen w-full flex items-center justify-center px-4">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
