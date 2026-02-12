@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Total Payroll Summary --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Employees</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $summary['total_employees'] ?? 0 }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Paid ({{ \Carbon\Carbon::now()->format('F Y') }})</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $summary['total_paid'] ?? 0 }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total Pending</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $summary['total_pending'] ?? 0 }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.payments.index') }}" class="mb-4 d-flex gap-2">
        <select name="status" class="form-control">
            <option value="">All Status</option>
            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        </select>

        <select name="month" class="form-control">
            <option value="">All Months</option>
            @foreach($months as $month)
                <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($month.'-01')->format('F Y') }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    {{-- Payments Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Month</th>
                    <th>Basic Salary</th>
                    <th>Absent Days</th>
                    <th>Deduction</th>
                    <th>Final Salary</th>
                    <th>Status</th>
                    <th>Paid At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $loop->iteration + ($payments->currentPage()-1)*$payments->perPage() }}</td>
                    <td>{{ $payment->user->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->month.'-01')->format('F Y') }}</td>
                    <td>{{ number_format($payment->basic_salary) }}</td>
                    <td>{{ $payment->absent_days }}</td>
                    <td>{{ number_format($payment->deduction) }}</td>
                    <td>{{ number_format($payment->final_salary) }}</td>
                    <td>
                        @if($payment->status == 'paid')
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') : '-' }}</td>
                    <td>
                        <a href="{{ route('admin.payments.download', $payment->id) }}" class="btn btn-sm btn-info mb-1">Download PDF</a>

                        @if($payment->status == 'pending')
                        <form action="{{ route('admin.payments.markPaid', $payment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success mb-1">Mark Paid</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $payments->withQueryString()->links() }}
    </div>

</div>
@endsection
