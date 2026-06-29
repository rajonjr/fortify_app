<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Authentification' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="bg-gray-100 font-sans antialiased">
       <div class="min-h-screen flex flex-col justify-center items-center">
          {{ $slot }}
       </div>

        @livewireScripts
    </body>
</html>
