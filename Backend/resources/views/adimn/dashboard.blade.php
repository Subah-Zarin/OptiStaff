{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app') {{-- keep your login/register layout unchanged --}}

@section('content')
<div class="flex min-h-screen bg-gray-100">

    {{-- Sidebar --}}
    <aside class="w-56 bg-white border-r">
        <div class="p-4 text-xl font-bold text-blue-600">
            Opti <span class="text-gray-700">Staff</span>
        </div>
        <nav class="mt-4 space-y-2">
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-home w-5 text-gray-500"></i>
                <span class="ml-3">Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-users w-5 text-gray-500"></i>
                <span class="ml-3">Employees</span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-user-tie w-5 text-gray-500"></i>
                <span class="ml-3">Clients</span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-tasks w-5 text-gray-500"></i>
                <span class="ml-3">Projects</span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-file-alt w-5 text-gray-500"></i>
                <span class="ml-3">Policies</span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-wallet w-5 text-gray-500"></i>
                <span class="ml-3">Accounts</span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-credit-card w-5 text-gray-500"></i>
                <span class="ml-3">Payrolls</span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-chart-line w-5 text-gray-500"></i>
                <span class="ml-3">Reports</span>
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-cog w-5 text-gray-500"></i>
                <span class="ml-3">Settings</span>
            </a>
        </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1">
        {{-- Top Navbar --}}
        <header class="flex justify-between items-center bg-white shadow px-6 py-4">
            <h2 class="text-lg font-semibold">Dashboard</h2>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">tat</span>
                <i class="fas fa-user-circle text-2xl text-gray-500"></i>
            </div>
        </header>

        {{-- Dashboard Body --}}
        <main class="p-6">
            <h3 class="text-xl font-bold mb-4">Welcome, John Doe!</h3>
            <p class="text-gray-600 mb-6">Here’s your HR dashboard overview.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
