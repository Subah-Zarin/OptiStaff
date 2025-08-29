@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar is assumed fixed, main content gets offset -->
        <div class="col-lg-10 offset-lg-2 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Leave Requests</h2>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>Duration</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $leave)
                                <tr>
                                    <td>{{ $leave->user->name }}</td>
                                    <td>{{ ucfirst($leave->leave_type) }}</td>
                                    <td>{{ ucfirst($leave->duration) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d M, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d M, Y') }}</td>
                                    <td>{{ $leave->number_of_days }}</td>
                                    <td>
                                        <span class="badge 
                                            @if(strtolower($leave->status) == 'pending') bg-warning
                                            @elseif(strtolower($leave->status) == 'approved') bg-success
                                            @else bg-danger
                                            @endif">
                                            {{ ucfirst($leave->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(strtolower($leave->status) == 'pending')
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('leave.approve', $leave->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="bi bi-check-circle"></i> Approve
                                                    </button>
                                                </form>

                                                <form action="{{ route('leave.reject', $leave->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-x-circle"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted">No action needed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No leave requests found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Bootstrap Icons CDN if not included already -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection
