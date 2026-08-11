@extends('layouts.admin')

@section('title', 'Booking Management')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-calendar-check-fill text-primary me-2"></i>

                    Booking Management

                </h2>

                <p class="text-muted mb-0">

                    Manage all property bookings.

                </p>

            </div>

            <span class="badge bg-primary fs-6">

                {{ $totalBookings }} Bookings

            </span>

        </div>

        <!-- Statistics -->

        <div class="row g-4 mb-4">

            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-calendar-event display-5 text-primary"></i>

                        <h2 class="mt-3">

                            {{ $totalBookings }}

                        </h2>

                        <p class="text-muted mb-0">

                            Total

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-hourglass-split display-5 text-warning"></i>

                        <h2 class="mt-3">

                            {{ $pendingBookings }}

                        </h2>

                        <p class="text-muted mb-0">

                            Pending

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-check-circle-fill display-5 text-success"></i>

                        <h2 class="mt-3">

                            {{ $approvedBookings }}

                        </h2>

                        <p class="text-muted mb-0">

                            Approved

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-x-circle-fill display-5 text-danger"></i>

                        <h2 class="mt-3">

                            {{ $rejectedBookings }}

                        </h2>

                        <p class="text-muted mb-0">

                            Rejected

                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- Search & Filter -->

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <form method="GET" action="{{ route('admin.bookings.index') }}">

                    <div class="row g-3">

                        <div class="col-md-5">

                            <input type="text" name="search" class="form-control" placeholder="Search Tenant or Property..."
                                value="{{ request('search') }}">

                        </div>

                        <div class="col-md-4">

                            <select name="status" class="form-select">

                                <option value="">All Status</option>

                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>

                                    Pending

                                </option>

                                <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>

                                    Approved

                                </option>

                                <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>

                                    Rejected

                                </option>

                                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>

                                    Completed

                                </option>

                            </select>

                        </div>

                        <div class="col-md-2 d-grid">

                            <button class="btn btn-primary">

                                <i class="bi bi-search me-2"></i>

                                Search

                            </button>

                        </div>

                        <div class="col-md-1 d-grid">

                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">

                                Reset

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <!-- Booking Table -->

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle datatable">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>

                                <th>Tenant</th>

                                <th>Landlord</th>

                                <th>Property</th>

                                <th>Status</th>

                                <th>Date</th>

                                <th width="170">

                                    Actions

                                </th>

                            </tr>

                        </thead>

                        <tbody>
                            @forelse($bookings as $booking)

                                @php

                                    $statusColor = [

                                        'Pending' => 'warning',

                                        'Approved' => 'success',

                                        'Rejected' => 'danger',

                                        'Completed' => 'primary'

                                    ];

                                @endphp

                                <tr>

                                    <td>

                                        {{ $booking->id }}

                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center me-2"
                                                style="width:40px;height:40px;">

                                                {{ strtoupper(substr($booking->tenant->name ?? 'N', 0, 1)) }}

                                            </div>

                                            <div>

                                                <div class="fw-bold">

                                                    {{ $booking->tenant->name ?? 'N/A' }}

                                                </div>

                                                <small class="text-muted">

                                                    Tenant

                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        {{ $booking->landlord->name ?? 'N/A' }}

                                    </td>

                                    <td>

                                        <div>

                                            <strong>

                                                {{ $booking->property->title ?? 'N/A' }}

                                            </strong>

                                            <br>

                                            <small class="text-muted">

                                                {{ $booking->property->city ?? '' }}

                                            </small>

                                        </div>

                                    </td>

                                    <td>

                                        <span class="badge bg-{{ $statusColor[$booking->status] ?? 'secondary' }}">

                                            {{ $booking->status }}

                                        </span>

                                    </td>

                                    <td>

                                        {{ $booking->created_at->format('d M Y') }}

                                    </td>

                                    <td>

                                        <div class="btn-group">

                                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-info btn-sm"
                                                title="View">

                                                <i class="bi bi-eye"></i>

                                            </a>

                                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning btn-sm"
                                                title="Edit">

                                                <i class="bi bi-pencil-square"></i>

                                            </a>

                                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
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

                                        <i class="bi bi-calendar-x display-1 text-secondary"></i>

                                        <h4 class="mt-3">

                                            No Bookings Found

                                        </h4>

                                        <p class="text-muted mb-0">

                                            There are currently no bookings available.

                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection