<x-app-layout>
    @if(auth()->user()->role === 'user')
        
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Dashboard') }}
        </h2>
   

    <div class="grid grid-cols-12 gap-6">

        <!-- Welcome Section -->
        <div class="col-span-12 bg-white p-6 rounded-lg shadow flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                        Welcome, {{ auth()->user()->name }}!
                    </h1>
                <p class="text-gray-500">Here's your HR dashboard overview.</p>
            </div>
            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                View Profile
            </button>
        </div>

<!-- Charts Row -->
<div class="col-span-12 grid grid-cols-12 gap-6">

    <!-- Employees Chart -->
    <div class="col-span-12 md:col-span-6 bg-white p-4 rounded-lg shadow flex flex-col items-center">
        <h3 class="text-lg font-semibold mb-2">Total Employees</h3>
        <canvas id="employeesChart" width="250" height="400"></canvas>
        <div class="mt-2 text-gray-500 text-sm flex justify-between w-full px-4">
            <span>Full time: 267</span>
            <span>Part time: 18</span>
        </div>
    </div>

    <!-- Projects Chart -->
    <div class="col-span-12 md:col-span-6 bg-white p-4 rounded-lg shadow flex flex-col items-center">
        <h3 class="text-lg font-semibold mb-2">Total Projects</h3>
        <canvas id="projectsChart" width="400" height="250"></canvas>
        <div class="mt-2 text-gray-500 text-sm flex justify-between w-full px-4">
            <span>In Progress: 5</span>
            <span>Completed: 8</span>
        </div>
    </div>

</div>

<script>
    const employeesChart = new Chart(document.getElementById('employeesChart'), {
        type: 'doughnut',
        data: {
            labels: ['Full time', 'Part time'],
            datasets: [{ data: [267, 18], backgroundColor: ['#3b82f6', '#ef4444'] }]
        },
        options: { 
            responsive: false,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    const projectsChart = new Chart(document.getElementById('projectsChart'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{ label: 'Projects', data: [2,4,6,5,7,3,8,6,5,4,3,2], backgroundColor: '#f59e0b' }]
        },
        options: { 
            responsive: false,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { drawBorder: false } }
            }
        }
    });
</script>



        <!-- Attendance Cards -->
        <div class="col-span-12 grid grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow text-center flex flex-col justify-center">
                <p class="text-gray-500 text-sm">Attendance</p>
                <h2 class="text-xl font-bold">359</h2>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center flex flex-col justify-center">
                <p class="text-gray-500 text-sm">Late</p>
                <h2 class="text-xl font-bold">12</h2>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center flex flex-col justify-center">
                <p class="text-gray-500 text-sm">Absent</p>
                <h2 class="text-xl font-bold">4</h2>
            </div>
        </div>

        <!-- Project Summary Table -->
        <div class="col-span-12 bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Project Summary</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Project Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Team</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cost</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-2">A012</td>
                            <td class="px-4 py-2">Paytm bank app</td>
                            <td class="px-4 py-2 flex">
                                <img src="https://i.pravatar.cc/30?img=1" class="w-6 h-6 rounded-full -ml-2 border-2 border-white">
                                <img src="https://i.pravatar.cc/30?img=2" class="w-6 h-6 rounded-full -ml-2 border-2 border-white">
                            </td>
                            <td class="px-4 py-2">$34,220</td>
                            <td class="px-4 py-2 text-green-600 font-semibold">Completed</td>
                            <td class="px-4 py-2 text-green-600 font-semibold">Done</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">D372</td>
                            <td class="px-4 py-2">Cynrut Dashboard</td>
                            <td class="px-4 py-2 flex">
                                <img src="https://i.pravatar.cc/30?img=3" class="w-6 h-6 rounded-full -ml-2 border-2 border-white">
                                <img src="https://i.pravatar.cc/30?img=4" class="w-6 h-6 rounded-full -ml-2 border-2 border-white">
                            </td>
                            <td class="px-4 py-2">$58,000</td>
                            <td class="px-4 py-2 text-yellow-600 font-semibold">In Progress</td>
                            <td class="px-4 py-2 text-red-600 font-semibold">Pending</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Chart Scripts -->
    <script>
        const employeesChart = new Chart(document.getElementById('employeesChart'), {
            type: 'doughnut',
            data: {
                labels: ['Full time', 'Part time'],
                datasets: [{
                    data: [267, 18],
                    backgroundColor: ['#3b82f6', '#ef4444']
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        const projectsChart = new Chart(document.getElementById('projectsChart'), {
            type: 'bar',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets: [{
                    label: 'Projects',
                    data: [2, 4, 6, 5, 7, 3, 8, 6, 5, 4, 3, 2],
                    backgroundColor: '#f59e0b'
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { drawBorder: false } }
                }
            }
        });
    </script>
     @else
        <div class="p-6">
            <h1 class="text-red-600 font-bold text-lg">
                You are not authorized to view this page.
            </h1>
        </div>
    @endif
     </x-slot>
</x-app-layout>