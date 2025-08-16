@extends('layouts.app')

@section('title', 'Edit Attendance')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Edit Attendance</h1>

    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Employee</label>
            <select name="employee_id" class="border rounded w-full px-3 py-2">
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ $attendance->employee_id == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Date</label>
            <input type="date" name="date" value="{{ $attendance->date }}" class="border rounded w-full px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Status</label>
            <select name="status" class="border rounded w-full px-3 py-2">
                <option value="Present" {{ $attendance->status == 'Present' ? 'selected' : '' }}>Present</option>
                <option value="Absent" {{ $attendance->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                <option value="Leave" {{ $attendance->status == 'Leave' ? 'selected' : '' }}>Leave</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Notes</label>
            <textarea name="notes" class="border rounded w-full px-3 py-2">{{ $attendance->notes }}</textarea>
        </div>

        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Update Attendance</button>
    </form>
</div>
@endsection
