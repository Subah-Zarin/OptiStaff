@extends('layouts.app')
@section('title', 'My Leave')
@section('content')
<div class="container mx-auto p-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">My Leave</h1>
        <a href="{{ route('leave.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg shadow-md transition">
            Request Leave
        </a>
    </div>

    <!-- Leave Balance Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="p-5 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm">Casual Leave</h3>
            <p class="text-xl font-semibold text-gray-800 mt-1">{{ $remainingLeaves['Casual'] }} days left</p>
        </div>
        <div class="p-5 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm">Sick Leave</h3>
            <p class="text-xl font-semibold text-gray-800 mt-1">{{ $remainingLeaves['Sick'] }} days left</p>
        </div>
        <div class="p-5 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm">Earned Leave</h3>
            <p class="text-xl font-semibold text-gray-800 mt-1">{{ $remainingLeaves['Earned'] }} days left</p>
        </div>
    </div>

    <!-- Pending Leave Requests Table -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Pending Leave Requests</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">From – To</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Days</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Applied On</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($leaves->where('status', 'Pending') as $leave)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-700">{{ $leave->leave_type }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $leave->from_date }} - {{ $leave->to_date ?? $leave->from_date }}</td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $leave->duration ?? 'Full Day' }}
                                @if($leave->duration == 'Half')
                                    ({{ $leave->half_day_type ?? 'AM/PM' }})
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                @if($leave->duration === 'Half')
                                    0.5
                                @else
                                    {{ intval($leave->number_of_days) }}
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $leave->status == 'Approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $leave->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $leave->status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $leave->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $leave->created_at->format('d-m-Y') }}</td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('leave.cancel', $leave->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 font-medium transition">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($leaves->where('status', 'Pending')->isEmpty())
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-400">No pending leave requests.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Leave History Section -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Leave History</h2>
        @php
            $historyLeaves = $leaves->whereIn('status', ['Approved', 'Rejected']);
        @endphp

        @if($historyLeaves->isEmpty())
            <p class="text-gray-500 text-center">No leave history available.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">From – To</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Days</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Applied On</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($historyLeaves as $leave)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-700">{{ $leave->leave_type }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $leave->from_date }} - {{ $leave->to_date ?? $leave->from_date }}</td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $leave->duration ?? 'Full Day' }}
                                @if($leave->duration == 'Half')
                                    ({{ $leave->half_day_type ?? 'AM/PM' }})
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                @if($leave->duration === 'Half')
                                    0.5
                                @else
                                    {{ intval($leave->number_of_days) }}
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $leave->status == 'Approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $leave->status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $leave->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $leave->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
