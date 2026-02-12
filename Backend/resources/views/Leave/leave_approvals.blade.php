
@extends('layouts.app')
@section('title', 'Leave Requests')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 offset-lg-0">
            <h2 class="fw-bold mb-4">Employee Leave Requests</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- 🔎 Search & Filter -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <input type="text" id="searchInput" class="form-control w-50 shadow-sm" placeholder="Search by employee name...">
                <select id="statusFilter" class="form-select w-auto shadow-sm">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            @if($leaves->count() > 0)
                <div class="table-responsive shadow-sm rounded-3">
                    <table id="leaveTable" class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Type</th>
                                <th>Duration</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaves as $index => $leave)
                                <tr data-status="{{ strtolower($leave->status) }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="employee-name">{{ $leave->user->name }}</td>
                                    <td>{{ ucfirst($leave->leave_type) }}</td>
                                    <td>{{ ucfirst($leave->duration) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d M, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d M, Y') }}</td>
                                    <td>{{ $leave->number_of_days }}</td>
                                    <td>
                                        <span class="badge 
                                            @if(strtolower($leave->status) == 'pending') bg-warning text-dark
                                            @elseif(strtolower($leave->status) == 'approved') bg-success
                                            @else bg-danger
                                            @endif p-2">
                                            @if(strtolower($leave->status) == 'pending')
                                                <i class="bi bi-hourglass-split me-1"></i>
                                            @elseif(strtolower($leave->status) == 'approved')
                                                <i class="bi bi-check-circle me-1"></i>
                                            @else
                                                <i class="bi bi-x-circle me-1"></i>
                                            @endif
                                            {{ ucfirst($leave->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(strtolower($leave->status) == 'pending')
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('leave.approve', $leave->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success shadow-sm">
                                                        <i class="bi bi-check-circle"></i> Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('leave.reject', $leave->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                                        <i class="bi bi-x-circle"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted">No action</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    No leave requests found.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- 🔎 Search & Filter Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const statusFilter = document.getElementById("statusFilter");
        const rows = document.querySelectorAll("#leaveTable tbody tr");

        function filterTable() {
            const search = searchInput.value.toLowerCase();
            const filter = statusFilter.value;

            rows.forEach(row => {
                const name = row.querySelector(".employee-name").textContent.toLowerCase();
                const status = row.getAttribute("data-status");

                const matchSearch = name.includes(search);
                const matchFilter = (filter === "all" || status === filter);

                row.style.display = matchSearch && matchFilter ? "" : "none";
            });
        }

        searchInput.addEventListener("keyup", filterTable);
        statusFilter.addEventListener("change", filterTable);
    });
</script>

<style>
    .table {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    thead {
        font-size: 0.95rem;
        letter-spacing: 0.5px;
    }
    .badge {
        font-size: 0.85rem;
    }
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.35rem 0.75rem;
    }
</style>
@endsection

