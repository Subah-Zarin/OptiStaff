@extends('layouts.app')

@section('title', 'Employee Performance Report')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Employee Performance Report</h1>
        <a href="{{ route('attendance.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Back to Attendance</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto mx-auto">
        <table class="min-w-full border border-gray-200 text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 border-b">Rank</th>
                    <th class="py-3 px-4 border-b">Employee</th>
                    <th class="py-3 px-4 border-b">Email</th>
                    <th class="py-3 px-4 border-b">Present</th>
                    <th class="py-3 px-4 border-b">Absent</th>
                    <th class="py-3 px-4 border-b">Leave</th>
                    <th class="py-3 px-4 border-b">Performance Score</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $index => $employee)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                        <td class="py-2 px-4 border-b">{{ $employee->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $employee->email }}</td>
                        <td class="py-2 px-4 border-b">{{ $employee->present_days }}</td>
                        <td class="py-2 px-4 border-b">{{ $employee->absent_days }}</td>
                        <td class="py-2 px-4 border-b">{{ $employee->leave_days }}</td>
                        <td class="py-2 px-4 border-b">{{ $employee->performance_score }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">No employee data found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection