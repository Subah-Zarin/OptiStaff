@extends('layouts.app')

@section('content')
<div class="p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold">Admin Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }} ({{ auth()->user()->role }})</p>
</div>
@endsection

