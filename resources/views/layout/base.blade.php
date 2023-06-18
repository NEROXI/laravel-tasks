<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @vite(['resources/js/app.js'])
    </head>
    <body class="antialiased">
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Header -->
        @include('layout.header')
        <!-- Sidebar -->
        @include('layout.sidebar')
        @yield('content')
    </div>
    </body>

</html>
