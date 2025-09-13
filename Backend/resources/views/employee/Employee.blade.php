@extends('layouts.app')

@section('title', 'Employee List')

@section('content')
<div class="container mx-auto px-4 py-10">

    <!-- Header & Search -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-4 sm:mb-0">Employee Directory</h1>

        <form method="GET" class="w-full sm:w-auto flex items-center">
            <input 
                type="text" 
                name="search" 
                value="{{ $search ?? '' }}" 
                placeholder="Search employees..."
                class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500"
            >
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Search
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @php
                        $columns = [
                            'id' => 'ID',
                            'name' => 'Name',
                            'email' => 'Email',
                            'role' => 'Role',
                            'created_at' => 'Joined',
                            'updated_at' => 'Updated'
                        ];
                    @endphp
                    @foreach ($columns as $field => $label)
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <a href="?sortField={{ $field }}&sortDirection={{ $sortField === $field && $sortDirection === 'asc' ? 'desc' : 'asc' }}&search={{ $search ?? '' }}">
                            {{ $label }}
                            @if($sortField === $field)
                                @if($sortDirection === 'asc')
                                    ▲
                                @else
                                    ▼
                                @endif
                            @endif
                        </a>
                    </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($employees as $employee)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $employee->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->role ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $employee->updated_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No employees found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
@endsection
