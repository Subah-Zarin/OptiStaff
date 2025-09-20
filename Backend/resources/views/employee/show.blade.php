<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Employee Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                
                {{-- Employee Card Header --}}
                <div class="flex items-center space-x-4 border-b pb-4 mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl font-bold">
                        {{ substr($employee->name, 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $employee->name }}</h1>
                        <p class="text-lg text-gray-500">{{ $employee->role ?? 'User' }}</p>
                    </div>
                </div>

                {{-- Details Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Personal Information --}}
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-700 border-b pb-2">Contact Information</h3>
                        <p class="text-gray-600"><strong>Email:</strong> {{ $employee->email }}</p>
                        {{-- Add other fields like phone, address here if available on the User model --}}
                        <p class="text-gray-600"><strong>Date Joined:</strong> {{ \Carbon\Carbon::parse($employee->created_at)->format('F d, Y') }}</p>
                        
                        {{-- Placeholder for Employee ID (assuming it is available) --}}
                        <p class="text-gray-600"><strong>Employee ID:</strong> #{{ $employee->id }}</p>
                    </div>

                    {{-- Role & Status Information (Expandable) --}}
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-700 border-b pb-2">Employment Details</h3>
                        <p class="text-gray-600">
                            <strong>Status:</strong> 
                            <span class="px-3 py-1 text-sm rounded-full font-semibold {{ $employee->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $employee->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                        
                        {{-- You can add more data here (e.g., Department, Position, Manager) --}}
                        <p class="text-gray-600"><strong>Department:</strong> HR (Placeholder)</p>
                        <p class="text-gray-600"><strong>Position:</strong> Software Engineer (Placeholder)</p>
                    </div>
                </div>
                
                {{-- Back Button --}}
                <div class="mt-8 pt-4 border-t">
                    <a href="{{ route('employees.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        &larr; Back to Directory
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>