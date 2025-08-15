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

    <!-- Scripts & Alpine.js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="font-sans antialiased bg-gray-100">
<div x-data="{ open: true }" class="flex h-screen">

    <!-- Sidebar -->
    @include('sidebar.sidebar')

    <!-- Main content -->
    <div :class="open ? 'ml-64' : 'ml-20'" 
         class="flex-1 transition-all duration-300 overflow-y-auto">

        <!-- Optional Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
