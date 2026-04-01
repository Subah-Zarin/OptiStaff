@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    {{-- Notification Bell + Pending Admin Requests --}}
@php
    $pendingAdminRequests = \App\Models\User::where('role', 'admin')
        ->where('status', 'pending')
        ->get();
    $unreadCount = auth()->user()->unreadNotifications->count();
@endphp

@if($pendingAdminRequests->count() > 0)
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-3">
            {{-- Bell Icon --}}
            <div class="relative">
                <div class="p-2 bg-yellow-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ $unreadCount }}
                    </span>
                @endif
            </div>
            <div>
                <h3 class="text-base font-semibold text-yellow-800">Pending Admin Registration Requests</h3>
                <p class="text-sm text-yellow-600">{{ $pendingAdminRequests->count() }} request(s) waiting for your approval</p>
            </div>
        </div>
        <a href="{{ route('admin.approvals') }}"
           class="text-sm text-blue-600 hover:underline font-medium">
            View All →
        </a>
    </div>

    {{-- Requests Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="text-yellow-700 border-b border-yellow-200">
                    <th class="pb-2 font-semibold">Name</th>
                    <th class="pb-2 font-semibold">Email</th>
                    <th class="pb-2 font-semibold">Requested At</th>
                    <th class="pb-2 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingAdminRequests as $applicant)
                <tr class="border-b border-yellow-100 hover:bg-yellow-100 transition">
                    <td class="py-2 text-gray-700 font-medium">{{ $applicant->name }}</td>
                    <td class="py-2 text-gray-500">{{ $applicant->email }}</td>
                    <td class="py-2 text-gray-400">{{ $applicant->created_at->format('d M Y, h:i A') }}</td>
                    <td class="py-2 flex gap-2">
                        <form method="POST" action="{{ route('admin.approvals.approve', $applicant) }}">
                            @csrf
                            <button class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs rounded-lg transition">
                                ✓ Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.approvals.reject', $applicant) }}">
                            @csrf
                            <button class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded-lg transition">
                                ✗ Reject
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

    {{-- KPI Summary Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        {{-- Total Leaves --}}
        <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center space-x-4">
            <div class="p-3 bg-blue-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 font-medium text-sm">Total Leaves This Month</p>
                <h2 class="text-2xl font-bold">{{ $totalLeavesThisMonth }}</h2>
            </div>
        </div>

        {{-- Pending Approvals --}}
        <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center space-x-4">
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 font-medium text-sm">Pending Approvals</p>
                <h2 class="text-2xl font-bold">{{ $pendingApprovals }}</h2>
            </div>
        </div>

        {{-- Payroll Ready --}}
        <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center space-x-4">
            <div class="p-3 bg-green-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.86 0-7 1.79-7 4v4h14v-4c0-2.21-3.14-4-7-4z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v4" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 font-medium text-sm">Payroll Ready</p>
                <h2 class="text-2xl font-bold">{{ $payrollReady }}</h2>
            </div>
        </div>

        {{-- Holidays Left --}}
        <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center space-x-4">
            <div class="p-3 bg-red-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-7 8h4m-2-8v8" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 font-medium text-sm">Holidays Left</p>
                <h2 class="text-2xl font-bold">{{ $holidaysLeft }}</h2>
            </div>
        </div>
    </div>

    {{-- Main Grid: Cards + Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Attendance Card --}}
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Today's Attendance</h3>
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="text-center p-3 bg-blue-50 rounded-lg shadow">
                    <p class="text-gray-500 text-sm">Present</p>
                    <h2 class="text-2xl font-bold">{{ $presentCount }}</h2>
                </div>
                <div class="text-center p-3 bg-red-50 rounded-lg shadow">
                    <p class="text-gray-500 text-sm">Absent</p>
                    <h2 class="text-2xl font-bold">{{ $absentCount }}</h2>
                </div>
                <div class="text-center p-3 bg-yellow-50 rounded-lg shadow">
                    <p class="text-gray-500 text-sm">On Leave</p>
                    <h2 class="text-2xl font-bold">{{ $leaveCountToday }}</h2>
                </div>
            </div>

            {{-- Attendance Chart --}}
            <canvas id="attendanceChart" class="w-full h-64"></canvas>
        </div>

        {{-- Leave & Payroll Trends --}}
        <div class="space-y-6">

            {{-- Leave Trends Chart --}}
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Leave Trends (Last 6 Months)</h3>
                <canvas id="leaveChart" class="w-full h-64"></canvas>
            </div>

            {{-- Payroll Overview Chart --}}
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Payroll Overview (Last 6 Months)</h3>
                <canvas id="payrollChart" class="w-full h-64"></canvas>
            </div>

        </div>

    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Attendance Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'line',
        data: {
            labels: @json($attendanceLabels),
            datasets: [
                {
                    label: 'Present',
                    data: @json($attendancePresent),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.3,
                },
                {
                    label: 'Absent',
                    data: @json($attendanceAbsent),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    tension: 0.3,
                },
                {
                    label: 'On Leave',
                    data: @json($attendanceLeave),
                    borderColor: '#facc15',
                    backgroundColor: 'rgba(250, 204, 21, 0.2)',
                    tension: 0.3,
                },
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { tooltip: { enabled: true }, legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true, precision:0 },
            }
        }
    });

    // Leave Chart
    const leaveCtx = document.getElementById('leaveChart').getContext('2d');
    new Chart(leaveCtx, {
        type: 'bar',
        data: {
            labels: @json($leaveLabels),
            datasets: [{
                label: 'Leaves',
                data: @json($leaveCounts),
                backgroundColor: '#3b82f6',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { tooltip: { enabled: true }, legend: { display: false } },
            scales: { y: { beginAtZero: true, precision:0 } }
        }
    });

    // Payroll Chart
    const payrollCtx = document.getElementById('payrollChart').getContext('2d');
    new Chart(payrollCtx, {
        type: 'bar',
        data: {
            labels: @json($payrollLabels),
            datasets: [{
                label: 'Payroll',
                data: @json($payrollCounts),
                backgroundColor: '#10b981',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { tooltip: { enabled: true }, legend: { display: false } },
            scales: { y: { beginAtZero: true, precision:0 } }
        }
    });
</script>
@endsection
