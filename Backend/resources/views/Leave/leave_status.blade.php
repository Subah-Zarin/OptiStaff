@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h2 class="my-4">Leave Status Dashboard</h2>

    <!-- Metrics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5>Total Employees</h5>
                    <h3>{{ $metrics['totalEmployees'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center bg-primary text-white">
                <div class="card-body">
                    <h5>On Leave Today</h5>
                    <h3>{{ $metrics['onLeaveToday'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center bg-success text-white">
                <div class="card-body">
                    <h5>Recently Returned</h5>
                    <h3>{{ $metrics['recentlyReturned'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center bg-dark text-white">
                <div class="card-body">
                    <h5>Total Leave Days Used</h5>
                    <h3>{{ $metrics['totalDaysUsedOrg'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- On Leave Today -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            Employees On Leave Today
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Employee</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Days</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($onLeaveToday as $leave)
                        <tr>
                            <td>{{ $leave->user->name }}</td>
                            <td>{{ $leave->from_date }}</td>
                            <td>{{ $leave->to_date }}</td>
                            <td>{{ $leave->number_of_days }}</td>
                            <td>{{ $leave->leave_type }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No employees on leave today</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recently Returned -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            Employees Recently Returned (Last 30 Days)
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Employee</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Days</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentlyReturned as $leave)
                        <tr>
                            <td>{{ $leave->user->name }}</td>
                            <td>{{ $leave->from_date }}</td>
                            <td>{{ $leave->to_date }}</td>
                            <td>{{ $leave->number_of_days }}</td>
                            <td>{{ $leave->leave_type }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No employees have returned recently</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Leave Summary -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Leave Summary Per Employee
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Employee</th>
                        <th>Entitlement</th>
                        <th>Used</th>
                        <th>Remaining</th>
                        <th>Usage %</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($summary as $row)
                        <tr>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->entitlement }}</td>
                            <td>{{ $row->used }}</td>
                            <td>{{ $row->remaining }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar 
                                        @if($row->used_percent < 50) bg-success
                                        @elseif($row->used_percent < 80) bg-warning
                                        @else bg-danger
                                        @endif"
                                        role="progressbar"
                                        style="width: {{ $row->used_percent }}%">
                                        {{ $row->used_percent }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No summary available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
