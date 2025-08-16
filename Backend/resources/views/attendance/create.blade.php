@extends('layouts.app')

@section('title', 'Add Attendance')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">

    <!-- Page Header -->
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Add Attendance</h1>
        <a href="{{ route('attendance.index') }}" class="bg-gray-300 text-gray-800 px-3 py-2 rounded hover:bg-gray-400">
            Back
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('attendance.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Employee</label>
            <select name="employee_id" class="border rounded w-full px-3 py-2">
                <option value="">Select Employee</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>
            @error('employee_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Date</label>
            <input type="date" name="date" class="border rounded w-full px-3 py-2">
            @error('date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Status</label>
            <select name="status" class="border rounded w-full px-3 py-2">
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
                <option value="Leave">Leave</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Notes</label>
            <textarea name="notes" class="border rounded w-full px-3 py-2" rows="3"></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Add Attendance
        </button>
    </form>

</div>
@endsection
