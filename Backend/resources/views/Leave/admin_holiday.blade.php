@extends('layouts.app')
@section('title', 'Holiday Manager')
@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Manage Public Holidays</h1>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Add Holiday Form --}}
    <div class="bg-white p-6 rounded shadow mb-6">
        <form action="{{ route('holidays.store') }}" method="POST" class="flex space-x-4">
            @csrf
            <input type="text" name="name" placeholder="Holiday Name" required
                   class="border rounded px-3 py-2 w-1/2">
            <input type="date" name="date" required
                   class="border rounded px-3 py-2 w-1/4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Add</button>
        </form>
    </div>

    {{-- Holidays List --}}
    <div class="bg-white rounded-xl shadow p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Holiday</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($holidays as $holiday)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-700">{{ $holiday->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($holiday->date)->format('d M, Y') }}</td>
                        <td class="px-6 py-4 flex space-x-2">
                            {{-- Edit Form --}}
                            <form action="{{ route('holidays.update', $holiday->id) }}" method="POST" class="flex space-x-2">
                                @csrf 
                                @method('PUT')
                                <input type="text" name="name" value="{{ $holiday->name }}" class="border rounded px-2 py-1 w-40">
                                <input type="date" name="date" value="{{ $holiday->date }}" class="border rounded px-2 py-1">
                                <button type="submit" class="px-3 py-1 bg-yellow-500 text-white rounded">Update</button>
                            </form>

                            {{-- Delete Button --}}
                            <form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this holiday?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($holidays->isEmpty())
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No holidays found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection