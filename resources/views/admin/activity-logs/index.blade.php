@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-clock-history text-primary me-2"></i>

                    Activity Logs

                </h2>

                <p class="text-muted mb-0">

                    Monitor all system activities performed by users.

                </p>

            </div>

        </div>

        <!-- Statistics -->

        <div class="row g-4 mb-4">

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-list-check display-5 text-primary"></i>

                        <h3 class="fw-bold mt-2">

                            {{ $totalLogs }}

                        </h3>

                        <p class="mb-0">

                            Total Activities

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-calendar-day display-5 text-success"></i>

                        <h3 class="fw-bold mt-2">

                            {{ $todayLogs }}

                        </h3>

                        <p class="mb-0">

                            Today's Activities

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-people-fill display-5 text-warning"></i>

                        <h3 class="fw-bold mt-2">

                            {{ $activeUsers }}

                        </h3>

                        <p class="mb-0">

                            Active Users

                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- Search -->

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <form action="{{ route('admin.activity-logs.index') }}" method="GET">

                    <div class="row">

                        <div class="col-md-10">

                            <input type="text" name="search" class="form-control"
                                placeholder="Search by module, action, description or user..."
                                value="{{ request('search') }}">

                        </div>

                        <div class="col-md-2 d-grid">

                            <button class="btn btn-primary">

                                <i class="bi bi-search me-2"></i>

                                Search

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle datatable">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>

                                <th>User</th>

                                <th>Module</th>

                                <th>Action</th>

                                <th>Description</th>

                                <th>Date</th>

                                <th width="170">

                                    Actions

                                </th>

                            </tr>

                        </thead>

                        <tbody>
                            @forelse($activityLogs as $log)

                                @php

                                    $badge = [

                                        'Create' => 'success',

                                        'Update' => 'warning',

                                        'Delete' => 'danger',

                                        'Login' => 'primary',

                                        'Logout' => 'secondary',

                                        'View' => 'info',

                                    ];

                                @endphp

                                <tr>

                                    <td>

                                        {{ $log->id }}

                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center me-3"
                                                style="width:40px;height:40px;">

                                                {{ strtoupper(substr($log->user->name ?? 'U', 0, 1)) }}

                                            </div>

                                            <div>

                                                <strong>

                                                    {{ $log->user->name ?? 'Unknown User' }}

                                                </strong>

                                                <br>

                                                <small class="text-muted">

                                                    ID #{{ $log->user_id }}

                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <span class="badge bg-info">

                                            {{ ucfirst($log->module) }}

                                        </span>

                                    </td>

                                    <td>

                                        <span class="badge bg-{{ $badge[$log->action] ?? 'dark' }}">

                                            {{ ucfirst($log->action) }}

                                        </span>

                                    </td>

                                    <td>

                                        {{ \Illuminate\Support\Str::limit($log->description, 60) }}

                                    </td>

                                    <td>

                                        {{ $log->created_at->format('d M Y') }}

                                        <br>

                                        <small class="text-muted">

                                            {{ $log->created_at->format('h:i A') }}

                                        </small>

                                    </td>

                                    <td>

                                        <div class="btn-group">

                                            <a href="{{ route('admin.activity-logs.show', $log) }}" class="btn btn-info btn-sm"
                                                title="View">

                                                <i class="bi bi-eye"></i>

                                            </a>

                                            <form action="{{ route('admin.activity-logs.destroy', $log) }}" method="POST"
                                                class="delete-form d-inline">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>
                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-5">

                                        <i class="bi bi-clock-history display-1 text-secondary"></i>

                                        <h4 class="mt-3">

                                            No Activity Logs Found

                                        </h4>

                                        <p class="text-muted mb-0">

                                            There are currently no activity logs available.

                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-4">

                    {{ $activityLogs->withQueryString()->links() }}

                </div>

            </div>

        </div>

    </div>

@endsection