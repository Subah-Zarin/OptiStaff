@extends('layouts.app')

@section('title', 'Employee Attendance')

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Employee Attendance</h1>
        <a href="{{ route('attendance.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Attendance
        </a>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('attendance.index') }}" class="flex flex-wrap gap-4 mb-6">
        <input type="date" name="date" value="{{ request('date') }}" class="border rounded px-3 py-2">
        <select name="employee" class="border rounded px-3 py-2">
            <option value="">All Employees</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ request('employee') == $employee->id ? 'selected' : '' }}>
                    {{ $employee->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
        <a href="{{ route('attendance.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Reset</a>
    </form>

    <!-- Attendance Table -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 border-b text-left">#</th>
                    <th class="py-3 px-4 border-b text-left">Employee</th>
                    <th class="py-3 px-4 border-b text-left">Date</th>
                    <th class="py-3 px-4 border-b text-left">Status</th>
                    <th class="py-3 px-4 border-b text-left">Notes</th>
                    <th class="py-3 px-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $index => $attendance)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $index + 1 + ($attendances->currentPage() - 1) * $attendances->perPage() }}</td>
                        <td class="py-2 px-4 border-b">{{ $attendance->employee->name }}</td>
                        <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                        <td class="py-2 px-4 border-b">
                            @php
                                $colors = ['Present'=>'green','Absent'=>'red','Leave'=>'yellow'];
                            @endphp
                            <span class="px-2 py-1 rounded text-white bg-{{ $colors[$attendance->status] ?? 'gray' }}-500">
                                {{ $attendance->status }}
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b">{{ $attendance->notes ?? '—' }}</td>
                        <td class="py-2 px-4 border-b text-center flex justify-center gap-2">
                            <a href="{{ route('attendance.edit', $attendance->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No attendance records found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $attendances->links() }}
    </div>

</div>
@endsection
