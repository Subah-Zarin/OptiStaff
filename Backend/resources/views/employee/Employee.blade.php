@extends('layouts.app')
@section('title', 'Employee Directory')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Employee Directory</h1>

    <!-- Search -->
    <form method="GET" action="{{ route('employees.index') }}" class="mb-4 flex space-x-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search employees..."
               class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
            Search
        </button>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach(['id' => 'ID', 'name' => 'Name', 'email' => 'Email', 'role' => 'Role', 'created_at' => 'Joined', 'updated_at' => 'Updated'] as $field => $label)
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('employees.index', array_merge(request()->all(), ['sort' => $field, 'direction' => (request('sort') === $field && request('direction') === 'asc') ? 'desc' : 'asc'])) }}">
                                {{ $label }}
                                @if(request('sort') === $field)
                                    <span class="ml-1 text-xs">
                                        {{ request('direction') === 'asc' ? '↑' : '↓' }}
                                    </span>
                                @endif
                            </a>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($employees as $emp)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-700">{{ $emp->id }}</td>

                        <!-- Name is now a clickable link -->
                        <td class="px-6 py-4 text-blue-600 hover:underline cursor-pointer">
                            <a href="{{ route('employees.show', $emp->id) }}">
                                {{ $emp->name }}
                            </a>
                        </td>

                        <td class="px-6 py-4 text-gray-700">{{ $emp->email }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $emp->role === 'manager' ? 'bg-green-100 text-green-800' :
                                   ($emp->role === 'staff' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $emp->role ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $emp->created_at->format('d M, Y') }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $emp->updated_at->format('d M, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No employees found.</td>
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
