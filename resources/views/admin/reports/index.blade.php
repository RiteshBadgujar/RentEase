@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-bar-chart-fill text-primary me-2"></i>

                    Reports & Analytics Dashboard

                </h2>

                <p class="text-muted mb-0">

                    View complete system statistics and analytics.

                </p>

            </div>

        </div>

        <!-- Main Statistics -->

        <div class="row g-4 mb-5">

            <div class="col-xl-2 col-md-4">

                <div class="card shadow-sm border-0 text-center">

                    <div class="card-body">

                        <i class="bi bi-people-fill display-5 text-primary"></i>

                        <h3 class="fw-bold mt-2">

                            {{ $totalUsers }}

                        </h3>

                        <p class="mb-0">

                            Users

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-xl-2 col-md-4">

                <div class="card shadow-sm border-0 text-center">

                    <div class="card-body">

                        <i class="bi bi-house-door-fill display-5 text-success"></i>

                        <h3 class="fw-bold mt-2">

                            {{ $totalProperties }}

                        </h3>

                        <p class="mb-0">

                            Properties

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-xl-2 col-md-4">

                <div class="card shadow-sm border-0 text-center">

                    <div class="card-body">

                        <i class="bi bi-calendar-check-fill display-5 text-warning"></i>

                        <h3 class="fw-bold mt-2">

                            {{ $totalBookings }}

                        </h3>

                        <p class="mb-0">

                            Bookings

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-xl-2 col-md-4">

                <div class="card shadow-sm border-0 text-center">

                    <div class="card-body">

                        <i class="bi bi-chat-left-text-fill display-5 text-danger"></i>

                        <h3 class="fw-bold mt-2">

                            {{ $totalEnquiries }}

                        </h3>

                        <p class="mb-0">

                            Enquiries

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-xl-2 col-md-4">

                <div class="card shadow-sm border-0 text-center">

                    <div class="card-body">

                        <i class="bi bi-bell-fill display-5 text-info"></i>

                        <h3 class="fw-bold mt-2">

                            {{ $totalNotifications }}

                        </h3>

                        <p class="mb-0">

                            Notifications

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-xl-2 col-md-4">

                <div class="card shadow-sm border-0 text-center">

                    <div class="card-body">

                        <i class="bi bi-heart-fill display-5 text-secondary"></i>

                        <h3 class="fw-bold mt-2">

                            {{ $totalWishlist }}

                        </h3>

                        <p class="mb-0">

                            Wishlist

                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- User Role Statistics -->

        <div class="row mb-5">

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">

                            Admins

                        </h6>

                        <h3 class="text-danger">

                            {{ $totalAdmins }}

                        </h3>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">

                            Landlords

                        </h6>

                        <h3 class="text-success">

                            {{ $totalLandlords }}

                        </h3>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">

                            Tenants

                        </h6>

                        <h3 class="text-primary">

                            {{ $totalTenants }}

                        </h3>

                    </div>

                </div>

            </div>

        </div>

        <!-- Charts -->

        <div class="row">
            <div class="col-lg-6 mb-4">

                <div class="card shadow-sm border-0">

                    <div class="card-header fw-bold">

                        Booking Status

                    </div>

                    <div class="card-body">

                        <canvas id="bookingChart"></canvas>

                    </div>

                </div>

            </div>

            <div class="col-lg-6 mb-4">

                <div class="card shadow-sm border-0">

                    <div class="card-header fw-bold">

                        Property Status

                    </div>

                    <div class="card-body">

                        <canvas id="propertyChart"></canvas>

                    </div>

                </div>

            </div>

            <div class="col-lg-6 mb-4">

                <div class="card shadow-sm border-0">

                    <div class="card-header fw-bold">

                        Enquiry Status

                    </div>

                    <div class="card-body">

                        <canvas id="enquiryChart"></canvas>

                    </div>

                </div>

            </div>

            <div class="col-lg-6 mb-4">

                <div class="card shadow-sm border-0">

                    <div class="card-header fw-bold">

                        Notification Status

                    </div>

                    <div class="card-body">

                        <canvas id="notificationChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

        <!-- Recent Users -->

        <div class="card shadow-sm border-0 mt-4">

            <div class="card-header fw-bold">

                Recent Users

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>Name</th>

                                <th>Email</th>

                                <th>Role</th>

                                <th>Joined</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($recentUsers as $user)

                                <tr>

                                    <td>

                                        {{ $user->name }}

                                    </td>

                                    <td>

                                        {{ $user->email }}

                                    </td>

                                    <td>

                                        <span class="badge bg-primary">

                                            {{ ucfirst($user->role) }}

                                        </span>

                                    </td>

                                    <td>

                                        {{ $user->created_at->format('d M Y') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="text-center">

                                        No users found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- Recent Properties -->

        <div class="card shadow-sm border-0 mt-4">

            <div class="card-header fw-bold">

                Recent Properties

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>Title</th>

                                <th>City</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($recentProperties as $property)

                                <tr>

                                    <td>

                                        {{ $property->title }}

                                    </td>

                                    <td>

                                        {{ $property->city }}

                                    </td>

                                    <td>

                                        <span class="badge bg-success">

                                            {{ $property->status }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="text-center">

                                        No properties found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
        <!-- Recent Bookings -->

        <div class="card shadow-sm border-0 mt-4">

            <div class="card-header fw-bold">

                Recent Bookings

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>Tenant</th>

                                <th>Property</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($recentBookings as $booking)

                                <tr>

                                    <td>

                                        {{ $booking->tenant->name ?? 'N/A' }}

                                    </td>

                                    <td>

                                        {{ $booking->property->title ?? 'N/A' }}

                                    </td>

                                    <td>

                                        <span class="badge bg-warning">

                                            {{ $booking->status }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="text-center">

                                        No bookings found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- Recent Enquiries -->

        <div class="card shadow-sm border-0 mt-4">

            <div class="card-header fw-bold">

                Recent Enquiries

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>Sender</th>

                                <th>Property</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($recentEnquiries as $enquiry)

                                <tr>

                                    <td>

                                        {{ $enquiry->sender->name ?? 'N/A' }}

                                    </td>

                                    <td>

                                        {{ $enquiry->property->title ?? 'N/A' }}

                                    </td>

                                    <td>

                                        <span class="badge bg-info">

                                            {{ $enquiry->status }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="text-center">

                                        No enquiries found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        new Chart(document.getElementById('bookingChart'), {

            type: 'doughnut',

            data: {

                labels: ['Pending', 'Approved', 'Completed', 'Rejected'],

                datasets: [{

                    data: [
                    {{ $pendingBookings }},
                    {{ $approvedBookings }},
                    {{ $completedBookings }},
                        {{ $rejectedBookings }}
                    ]

                }]

            }

        });

        new Chart(document.getElementById('propertyChart'), {

            type: 'pie',

            data: {

                labels: ['Available', 'Rented', 'Pending'],

                datasets: [{

                    data: [
                    {{ $availableProperties }},
                    {{ $rentedProperties }},
                        {{ $pendingProperties }}
                    ]

                }]

            }

        });

        new Chart(document.getElementById('enquiryChart'), {

            type: 'bar',

            data: {

                labels: ['Pending', 'Replied', 'Closed'],

                datasets: [{

                    data: [
                    {{ $pendingEnquiries }},
                    {{ $repliedEnquiries }},
                        {{ $closedEnquiries }}
                    ]

                }]

            }

        });

        new Chart(document.getElementById('notificationChart'), {

            type: 'polarArea',

            data: {

                labels: ['Read', 'Unread'],

                datasets: [{

                    data: [
                    {{ $readNotifications }},
                        {{ $unreadNotifications }}
                    ]

                }]

            }

        });

    </script>

@endsection