@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Employee List</h1>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="py-3 px-4 border-b">ID</th>
                    <th class="py-3 px-4 border-b">Name</th>
                    <th class="py-3 px-4 border-b">Email</th>
                    <th class="py-3 px-4 border-b">Role</th>
                    <th class="py-3 px-4 border-b">join At</th>
                    <th class="py-3 px-4 border-b">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $employee->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $employee->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $employee->email }}</td>
                    <td class="py-2 px-4 border-b">{{ $employee->role ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $employee->created_at->format('d M Y') }}</td>
                    <td class="py-2 px-4 border-b">{{ $employee->updated_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
