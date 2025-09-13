@extends('layouts.app')

@section('title', 'Employee Directory')

@section('content')
<div class="flex flex-col min-h-screen bg-gray-50 p-6 lg:p-10 relative">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 space-y-4 sm:space-y-0">
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-indigo-600">Employee Directory</h1>
        <div class="relative w-full max-w-sm">
            <input
                type="text"
                id="searchInput"
                placeholder="Search employees..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500"
            >
            <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
            </svg>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 table-auto">
            <thead class="bg-gray-100 sticky top-0 shadow-sm">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" data-field="id">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" data-field="name">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" data-field="email">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" data-field="role">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" data-field="created_at">Joined</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" data-field="updated_at">Updated</th>
                </tr>
            </thead>
            <tbody id="employeeTableBody" class="bg-white divide-y divide-gray-200">
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div id="pagination" class="mt-4 flex justify-center space-x-2"></div>


<!-- Axios & Script -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let employees = [];
    let currentPage = 1;
    let perPage = 10;
    let sortField = 'id';
    let sortDirection = 'asc';

    const tableBody = document.getElementById('employeeTableBody');
    const searchInput = document.getElementById('searchInput');

    function fetchEmployees() {
        axios.get('/api/employees', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(response => {
            employees = response.data.data;
            renderTable();
        })
        .catch(error => {
            console.error(error);
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-red-500">Failed to load employees.</td></tr>`;
        });
    }

    function renderTable() {
        let search = searchInput.value.toLowerCase();
        let filtered = employees.filter(emp =>
            emp.name.toLowerCase().includes(search) ||
            emp.email.toLowerCase().includes(search) ||
            (emp.role && emp.role.toLowerCase().includes(search))
        );

        filtered.sort((a, b) => {
            if(a[sortField] < b[sortField]) return sortDirection === 'asc' ? -1 : 1;
            if(a[sortField] > b[sortField]) return sortDirection === 'asc' ? 1 : -1;
            return 0;
        });

        let totalPages = Math.ceil(filtered.length / perPage);
        let start = (currentPage - 1) * perPage;
        let end = start + perPage;
        let paginated = filtered.slice(start, end);

        if(paginated.length === 0){
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-gray-500">No employees found.</td></tr>`;
        } else {
            tableBody.innerHTML = paginated.map(emp => `
                <tr class="hover:bg-blue-50 transition-colors duration-200 cursor-pointer">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${emp.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${emp.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${emp.email}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold ${
                            emp.role === 'admin' ? 'bg-red-100 text-red-800' :
                            emp.role === 'manager' ? 'bg-green-100 text-green-800' :
                            'bg-blue-100 text-blue-800'
                        }">${emp.role ?? 'N/A'}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${new Date(emp.created_at).toLocaleDateString()}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${new Date(emp.updated_at).toLocaleDateString()}</td>
                </tr>
            `).join('');
        }

        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';
        for(let i=1; i<=totalPages; i++){
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = `px-3 py-1 rounded-md font-semibold ${i === currentPage ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-700 hover:bg-blue-100'}`;
            btn.addEventListener('click', () => { currentPage = i; renderTable(); });
            pagination.appendChild(btn);
        }
    }

    searchInput.addEventListener('input', () => { currentPage = 1; renderTable(); });

    document.querySelectorAll('th[data-field]').forEach(th => {
        th.addEventListener('click', () => {
            const field = th.getAttribute('data-field');
            if(sortField === field){
                sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                sortField = field;
                sortDirection = 'asc';
            }
            renderTable();
        });
    });

    fetchEmployees();
});
</script>
@endsection
