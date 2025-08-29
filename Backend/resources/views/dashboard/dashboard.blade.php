<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Employee Dashboard') }}
        </h2>

    {{-- Main Dashboard Content --}}
    <main x-data="{ open: true }" 
          :class="open ? 'ml-100' : 'ml-20'" 
          class="transition-all duration-300 p-6 bg-blue-50 min-h-screen">

        @if(auth()->user()->role === 'user')
            <div class="transition-all duration-300 flex-1 space-y-6">

                <div class="bg-white p-6 rounded-xl shadow-md flex justify-between items-center border-l-4 border-blue-500">
                    <div>
                        <h1 class="text-3xl font-semibold text-gray-800">Welcome, {{ $user->name }}!</h1>
                        <p class="text-gray-500 mt-1">Here’s your HR overview at a glance.</p>
                    </div>
                    <a href="#" class="px-5 py-3 bg-blue-500 text-white font-medium rounded-lg shadow hover:bg-blue-600 transition">
                        View Profile
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border-l-4 border-green-500">
                        <p class="text-sm text-gray-500 font-medium">Present</p>
                        <h2 class="text-2xl font-bold text-gray-800 mt-2">{{ $presentDays }}</h2>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border-l-4 border-yellow-500">
                        <p class="text-sm text-gray-500 font-medium">Late</p>
                        <h2 class="text-2xl font-bold text-gray-800 mt-2">{{ $lateDays }}</h2>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border-l-4 border-red-500">
                        <p class="text-sm text-gray-500 font-medium">Absent</p>
                        <h2 class="text-2xl font-bold text-gray-800 mt-2">{{ $absentDays }}</h2>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border-l-4 border-indigo-500">
                        <p class="text-sm text-gray-500 font-medium">Pending Leaves</p>
                        <h2 class="text-2xl font-bold text-gray-800 mt-2">{{ $pendingLeaves }}</h2>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border-l-4 border-teal-500">
                        <p class="text-sm text-gray-500 font-medium">Approved Leaves</p>
                        <h2 class="text-2xl font-bold text-gray-800 mt-2">{{ $approvedLeaves }}</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Weekly Attendance</h3>
                        <canvas id="attendanceChart" class="w-full h-64"></canvas>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Leave Distribution</h3>
                        <canvas id="leaveChart" class="w-full h-64"></canvas>
                    </div>

                </div>

                <div class="bg-white p-6 rounded-xl shadow-md mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Leave Summary</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-gray-700">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium uppercase">Leave Type</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium uppercase">Total</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium uppercase">Taken</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium uppercase">Remaining</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($leaveSummary as $type => $data)
                                    <tr>
                                        <td class="px-4 py-2">{{ $type }}</td>
                                        <td class="px-4 py-2">{{ $data['total'] }}</td>
                                        <td class="px-4 py-2">{{ $data['taken'] }}</td>
                                        <td class="px-4 py-2">{{ $data['remaining'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Employee Type Distribution</h3>
        <canvas id="employeePieChart" class="w-full h-64"></canvas>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Today Events</h3>
        <ul class="space-y-3 text-gray-700">
            <li>Mim's Birthday 🎂</li>
            <li>Prionty - On Leave</li>
            <li>Tathai - On Leave</li>
            <li>Team Meeting - 3:00 PM</li>
        </ul>
    </div>

</div>


            </div>
        @else
            <div class="p-6">
                <h1 class="text-red-600 font-bold text-lg">
                    You are not authorized to view this page.
                </h1>
            </div>
        @endif
    </main>

    <script>
        // Attendance Line Chart
        const attendanceChart = new Chart(document.getElementById('attendanceChart'), {
            type: 'line',
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri'],
                datasets: [{
                    label: 'Attendance',
                    data: [
                        {{ $attendanceData['Mon'] ?? 0 }},
                        {{ $attendanceData['Tue'] ?? 0 }},
                        {{ $attendanceData['Wed'] ?? 0 }},
                        {{ $attendanceData['Thu'] ?? 0 }},
                        {{ $attendanceData['Fri'] ?? 0 }}
                    ],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.2)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 5,
                    pointBackgroundColor: '#3b82f6'
                }]
            },
            options: { responsive:true, plugins:{ legend:{ display:false } } }
        });

        // Leave Doughnut Chart
        const leaveChart = new Chart(document.getElementById('leaveChart'), {
            type: 'doughnut',
            data: {
                labels: ['Casual Leave', 'Sick Leave', 'Other'],
                datasets: [{
                    data: [
                        {{ $casualLeave ?? 0 }},
                        {{ $sickLeave ?? 0 }},
                        {{ $otherLeave ?? 0 }}
                    ],
                    backgroundColor: ['#3b82f6','#10b981','#f97316'],
                }]
            },
            options: { responsive:true, plugins:{ legend:{ position:'bottom' } } }
        });

        // Employee Type Pie Chart
        new Chart(document.getElementById('employeePieChart'), {
            type:'doughnut',
            data:{
                labels:['Full Time','Part Time','Internship'],
                datasets:[{
                    data:[
                        {{ $fullTime ?? 0 }},
                        {{ $partTime ?? 0 }},
                        {{ $internship ?? 0 }}
                    ],
                    backgroundColor:['#6366F1','#10B981','#F59E0B']
                }]
            },
            options:{ responsive:true, plugins:{ legend:{ position:'bottom' } } }
        });
    </script>
    </x-slot>
</x-app-layout>