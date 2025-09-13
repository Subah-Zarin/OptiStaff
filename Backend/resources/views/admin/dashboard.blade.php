@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="flex min-h-screen bg-gray-100">
    {{-- This div is for layout consistency, assuming sidebar is handled in app.blade.php --}}

    {{-- Main Content --}}
    <div class="flex-1">
        {{-- Top Navbar is handled by layouts.navigation --}}

        {{-- Dashboard Body --}}
        <main class="p-6">
            <h3 class="text-xl font-bold mb-4">Welcome, Admin!</h3>
            <p class="text-gray-600 mb-6">Here's a summary of today's attendance.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 font-medium">Present Today</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $presentCount }}</h2>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-red-500">
                    <p class="text-sm text-gray-500 font-medium">Absent Today</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $absentCount }}</h2>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500 font-medium">On Leave Today</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $leaveCount }}</h2>
                </div>
            </div>

            {{-- AI Assistant Card --}}
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-purple-500 mt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">AI HR Assistant</p>
                        <h2 class="text-xl font-bold text-gray-800 mt-2">Get Instant Insights</h2>
                        <p class="text-sm text-gray-600 mt-1">Ask questions about attendance, leaves, and policies</p>
                    </div>
                    <a href="{{ route('hr.chat') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                        Open AI Assistant
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="bg-white p-4 rounded shadow">
                    <h4 class="text-center font-semibold mb-2">Total Employees</h4>
                    <canvas id="employeesChart"></canvas>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h4 class="text-center font-semibold mb-2">Total Projects</h4>
                    <canvas id="projectsChart"></canvas>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('employeesChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [90, 10],
                backgroundColor: ['#3b82f6', '#ef4444']
            }]
        }
    });

    new Chart(document.getElementById('projectsChart'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Projects',
                data: [2,4,6,5,7,3,8,6,5,4,3,2],
                backgroundColor: '#f59e0b'
            }]
        }
    });
</script>
@endsection