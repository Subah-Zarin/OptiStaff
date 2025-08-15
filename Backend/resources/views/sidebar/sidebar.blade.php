<aside x-data="{ open: true }"
       :class="open ? 'w-64' : 'w-20'"
       class="bg-white border-r border-gray-200 h-screen transition-all duration-300 flex flex-col shadow-sm fixed">


    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-gray-200">
        <span class="text-xl font-bold text-blue-600">Opti</span>
        <span x-show="open" class="ml-1 text-gray-800 font-semibold">Staff</span>
    </div>

    <!-- Nav Links -->
    <nav class="flex-1 mt-4 space-y-2">
        @php
            $menu = [
                ['label' => 'Dashboard', 'icon' => 'home', 'url' => route('dashboard')],
                ['label' => 'Employees', 'icon' => 'user-group', 'url' => route('employees.index')],
                ['label' => 'Attendence', 'icon' => 'clipboard-list', 'url' => '#'],
                ['label' => 'Leave Management', 'icon' => 'document-text', 'url' => '#', 'sub' => [
                    ['label' => 'My leave', 'url' => '#'],
                    ['label' => 'Holiday', 'url' => '#']
                ]],
                ['label' => 'Policies', 'icon' => 'document-text', 'url' => '#'],
                ['label' => 'Settings', 'icon' => 'cog', 'url' => '#'],
            ];
        @endphp

        @foreach($menu as $item)
            <div x-data="{ subOpen: false }">
                <a @click="subOpen = !subOpen"
                   href="{{ $item['url'] }}"
                   class="flex items-center px-4 py-3 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition rounded-md">

                    {{-- Inline SVG icons --}}
                    @switch($item['icon'] ?? '')
                        @case('home')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V12H9v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9z" />
                            </svg>
                        @break
                        @case('user-group')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 0 0-4-4h-1M9 20H4v-2a4 4 0 0 1 4-4h1m6-4a4 4 0 1 0-8 0 4 4 0 0 0 8 0zm6 0a4 4 0 1 0-8 0 4 4 0 0 0 8 0z" />
                            </svg>
                        @break
                        @case('clipboard-list')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 3h6a2 2 0 0 1 2 2v2H7V5a2 2 0 0 1 2-2z" />
                            </svg>
                        @break
                        @case('document-text')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5l2 2h5a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2z" />
                            </svg>
                        @break
                        @case('cog')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l.17.52a1.75 1.75 0 0 0 2.138 1.05l.518-.172c.921-.3 1.921.24 2.22 1.161l.19.585a1.75 1.75 0 0 0 1.052 1.137l.518.173c.921.3 1.221 1.299.5 2.04l-.435.392a1.75 1.75 0 0 0-.433 1.87l.174.518c.3.921-.24 1.921-1.16 2.22l-.585.19a1.75 1.75 0 0 0-1.137 1.052l-.173.518c-.3.921-1.299 1.221-2.04.5l-.392-.435a1.75 1.75 0 0 0-1.87-.433l-.518.174c-.921.3-1.921-.24-2.22-1.16l-.19-.585a1.75 1.75 0 0 0-1.052-1.137l-.518-.173c-.921-.3-1.221-1.299-.5-2.04l.435-.392a1.75 1.75 0 0 0 .433-1.87l-.174-.518c-.3-.921.24-1.921 1.16-2.22l.585-.19a1.75 1.75 0 0 0 1.137-1.052l.173-.518z" />
                            </svg>
                        @break
                    @endswitch

                    <span x-show="open" class="ml-3">{{ $item['label'] }}</span>
                    @if(isset($item['sub']))
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    @endif
                </a>

                {{-- Sub-menu --}}
                @if(isset($item['sub']))
                    <div x-show="subOpen" class="ml-8 mt-1 space-y-1">
                        @foreach($item['sub'] as $sub)
                            <a href="{{ $sub['url'] }}" class="block px-4 py-2 text-gray-500 hover:bg-blue-50 hover:text-blue-600 rounded-md text-sm">
                                {{ $sub['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </nav>

    <!-- Toggle Button -->
    <button @click="open = !open" class="p-3 text-gray-500 hover:text-blue-600 transition mt-auto">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path :d="open ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
        </svg>
    </button>

</aside>
