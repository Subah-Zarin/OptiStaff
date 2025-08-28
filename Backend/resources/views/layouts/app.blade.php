<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">



    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts & Alpine.js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="font-sans antialiased bg-gray-100">
<div x-data="{ open: true }" class="flex h-screen">

    <!-- Sidebar -->
    <!-- Sidebar -->
<aside class="h-screen w-20 bg-white border-r border-gray-200 fixed top-0 left-0 flex flex-col items-center py-4">
    <div class="flex-1 flex flex-col gap-6 mt-10">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
            <i class="fas fa-home text-lg"></i>
            <span class="text-xs mt-1">Dashboard</span>
        </a>

        <a href="#" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
            <i class="fas fa-users text-lg"></i>
            <span class="text-xs mt-1">Employees</span>
        </a>

        <a href="#" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
            <i class="fas fa-briefcase text-lg"></i>
            <span class="text-xs mt-1">Clients</span>
        </a>

        <a href="#" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
            <i class="fas fa-tasks text-lg"></i>
            <span class="text-xs mt-1">Projects</span>
        </a>

        <a href="#" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
            <i class="fas fa-file-alt text-lg"></i>
            <span class="text-xs mt-1">Reports</span>
        </a>
    </div>
</aside>


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
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
