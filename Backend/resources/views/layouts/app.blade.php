<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head> 

{{-- AI Assistant Popup --}}
<div id="aiChatPopup" 
     class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-end justify-end z-50">
    <div class="bg-white w-full max-w-md h-[80vh] rounded-t-xl shadow-xl flex flex-col animate-slide-up">
        
        {{-- Header --}}
        <div class="flex justify-between items-center bg-purple-600 text-white px-4 py-2 rounded-t-xl">
            <h2 class="font-bold">AI HR Assistant</h2>
            <button onclick="toggleAiChat()" class="text-white hover:text-gray-200 text-xl">&times;</button>
        </div>

        {{-- Body (iframe loads hr.chat page) --}}
        <iframe src="{{ route('hr.chat') }}" class="flex-1 w-full border-0"></iframe>
    </div>
</div>

<script>
    function toggleAiChat() {
        const popup = document.getElementById("aiChatPopup");
        popup.classList.toggle("hidden");
    }
</script>

<style>
    @keyframes slide-up {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-up {
        animation: slide-up 0.3s ease-out;
    }
</style>



<body class="font-sans antialiased bg-gray-100">
<div x-data="{ open: true }" class="flex h-screen">

    @if(Auth::check() && Auth::user()->role === 'user')
        @include('sidebar.sidebar')
    @elseif(Auth::check() && Auth::user()->role === 'admin')
        @include('admin.admin_sidebar')
    @endif

    <div @if(Auth::check()) :class="open ? 'ml-64' : 'ml-20'" @endif 
         class="flex-1 transition-all duration-300 overflow-y-auto">

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>