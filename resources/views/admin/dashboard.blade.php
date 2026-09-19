@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container py-5">

    <!-- ============================================================
         Dashboard Header
    ============================================================ -->

    <div class="row mb-4">

        <div class="col-md-12">

            <h2 class="fw-bold">

                <i class="bi bi-speedometer2 text-primary me-2"></i>

                Admin Dashboard

            </h2>

            <p class="text-muted">

                Welcome,
                <strong>{{ Auth::user()->name }}</strong>

            </p>

        </div>

    </div>


    <!-- ============================================================
         User Statistics
    ============================================================ -->

    <div class="row g-4">

        <!-- Total Users -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-people-fill display-4 text-primary"></i>

                    <h5 class="mt-3">
                        Total Users
                    </h5>

                    <h2 class="fw-bold">
                        {{ $totalUsers }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Admins -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-shield-lock-fill display-4 text-danger"></i>

                    <h5 class="mt-3">
                        Admins
                    </h5>

                    <h2 class="fw-bold">
                        {{ $totalAdmins }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Landlords -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-building-fill display-4 text-success"></i>

                    <h5 class="mt-3">
                        Landlords
                    </h5>

                    <h2 class="fw-bold">
                        {{ $totalLandlords }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Tenants -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-person-fill display-4 text-warning"></i>

                    <h5 class="mt-3">
                        Tenants
                    </h5>

                    <h2 class="fw-bold">
                        {{ $totalTenants }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- ============================================================
         Property Statistics
    ============================================================ -->

    <div class="row g-4 mt-2">

        <!-- Total Properties -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-buildings-fill display-4 text-primary"></i>

                    <h5 class="mt-3">
                        Properties
                    </h5>

                    <h2 class="fw-bold">
                        {{ $totalProperties }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Available -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-house-check-fill display-4 text-success"></i>

                    <h5 class="mt-3">
                        Available
                    </h5>

                    <h2 class="fw-bold">
                        {{ $availableProperties }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Pending -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-hourglass-split display-4 text-warning"></i>

                    <h5 class="mt-3">
                        Pending
                    </h5>

                    <h2 class="fw-bold">
                        {{ $pendingProperties }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Rented -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-house-x-fill display-4 text-danger"></i>

                    <h5 class="mt-3">
                        Rented
                    </h5>

                    <h2 class="fw-bold">
                        {{ $rentedProperties }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- ============================================================
         Booking Statistics
    ============================================================ -->

    <div class="row g-4 mt-2">

        <!-- Total Bookings -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-calendar-check-fill display-4 text-info"></i>

                    <h5 class="mt-3">
                        Total Bookings
                    </h5>

                    <h2 class="fw-bold">
                        {{ $totalBookings }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Pending Bookings -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-hourglass-split display-4 text-warning"></i>

                    <h5 class="mt-3">
                        Pending
                    </h5>

                    <h2 class="fw-bold">
                        {{ $pendingBookings }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Approved Bookings -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-check-circle-fill display-4 text-success"></i>

                    <h5 class="mt-3">
                        Approved
                    </h5>

                    <h2 class="fw-bold">
                        {{ $approvedBookings }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Completed Bookings -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-patch-check-fill display-4 text-primary"></i>

                    <h5 class="mt-3">
                        Completed
                    </h5>

                    <h2 class="fw-bold">
                        {{ $completedBookings }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- ============================================================
         Enquiry Statistics
    ============================================================ -->

    <div class="row g-4 mt-2">

        <!-- Total Enquiries -->

        <div class="col-lg-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-chat-dots-fill display-4 text-primary"></i>

                    <h5 class="mt-3">
                        Total Enquiries
                    </h5>

                    <h2 class="fw-bold">
                        {{ $totalEnquiries }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Pending Enquiries -->

        <div class="col-lg-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-hourglass-split display-4 text-warning"></i>

                    <h5 class="mt-3">
                        Pending Enquiries
                    </h5>

                    <h2 class="fw-bold">
                        {{ $pendingEnquiries }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Replied Enquiries -->

        <div class="col-lg-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-check-circle-fill display-4 text-success"></i>

                    <h5 class="mt-3">
                        Replied Enquiries
                    </h5>

                    <h2 class="fw-bold">
                        {{ $repliedEnquiries }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- ============================================================
         Notification Statistics
    ============================================================ -->

    <div class="row g-4 mt-2">

        <!-- Total Notifications -->

        <div class="col-lg-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-bell-fill display-4 text-danger"></i>

                    <h5 class="mt-3">
                        Total Notifications
                    </h5>

                    <h2 class="fw-bold">
                        {{ $totalNotifications }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Unread Notifications -->

        <div class="col-lg-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-bell display-4 text-warning"></i>

                    <h5 class="mt-3">
                        Unread Notifications
                    </h5>

                    <h2 class="fw-bold">
                        {{ $unreadNotifications }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- ============================================================
         Charts
    ============================================================ -->

    <div class="row mt-5">

        <!-- Monthly Booking Chart -->

        <div class="col-lg-8">

            <div class="card shadow border-0">

                <div class="card-header">

                    <h5 class="mb-0">
                        Monthly Bookings
                    </h5>

                </div>

                <div class="card-body">

                    <canvas
                        id="bookingChart"
                        height="120"
                    ></canvas>

                </div>

            </div>

        </div>


        <!-- Property Status Chart -->

        <div class="col-lg-4">

            <div class="card shadow border-0">

                <div class="card-header">

                    <h5 class="mb-0">
                        Property Status
                    </h5>

                </div>

                <div class="card-body">

                    <canvas
                        id="propertyChart"
                        height="250"
                    ></canvas>

                </div>

            </div>

        </div>

    </div>


    <!-- ============================================================
         Recent Users
    ============================================================ -->

    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                <i class="bi bi-people-fill me-2"></i>

                Recent Users

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

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
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $user->name }}
                                </td>

                                <td>
                                    {{ $user->email }}
                                </td>

                                <td>

                                    @if($user->role === 'admin')

                                        <span class="badge bg-danger">
                                            Admin
                                        </span>

                                    @elseif($user->role === 'landlord')

                                        <span class="badge bg-success">
                                            Landlord
                                        </span>

                                    @else

                                        <span class="badge bg-primary">
                                            Tenant
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $user->created_at->format('d M Y') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-4"
                                >
                                    No Users Found
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- ============================================================
         Recent Properties
    ============================================================ -->

    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">

                <i class="bi bi-buildings-fill me-2"></i>

                Recent Properties

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Title</th>

                            <th>Owner</th>

                            <th>City</th>

                            <th>Status</th>

                            <th>Price</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($recentProperties as $property)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $property->title }}
                                </td>

                                <td>
                                    {{ optional($property->user)->name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $property->city }}
                                </td>

                                <td>

                                    @if($property->status === 'Available')

                                        <span class="badge bg-success">
                                            Available
                                        </span>

                                    @elseif($property->status === 'Pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($property->status === 'Rented')

                                        <span class="badge bg-danger">
                                            Rented
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $property->status }}
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    ₹{{ number_format($property->price) }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-4"
                                >
                                    No Properties Found
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- ============================================================
         Recent Bookings
    ============================================================ -->

    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-info text-white">

            <h5 class="mb-0">

                <i class="bi bi-calendar-check-fill me-2"></i>

                Recent Bookings

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Tenant</th>

                            <th>Property</th>

                            <th>Visit Date</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($recentBookings as $booking)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ optional($booking->tenant)->name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ optional($booking->property)->title ?? 'N/A' }}
                                </td>

                                <td>

                                    @if($booking->visit_date)

                                        {{ \Carbon\Carbon::parse($booking->visit_date)->format('d M Y') }}

                                    @else

                                        N/A

                                    @endif

                                </td>

                                <td>

                                    @switch($booking->status)

                                        @case('Pending')

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                            @break

                                        @case('Approved')

                                            <span class="badge bg-success">
                                                Approved
                                            </span>

                                            @break

                                        @case('Rejected')

                                            <span class="badge bg-danger">
                                                Rejected
                                            </span>

                                            @break

                                        @case('Completed')

                                            <span class="badge bg-primary">
                                                Completed
                                            </span>

                                            @break

                                        @default

                                            <span class="badge bg-secondary">
                                                {{ $booking->status }}
                                            </span>

                                    @endswitch

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-4"
                                >
                                    No Bookings Found
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- ============================================================
         Recent Activities
    ============================================================ -->

    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-dark text-white">

            <h5 class="mb-0">

                <i class="bi bi-clock-history me-2"></i>

                Recent Activities

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>User</th>

                            <th>Module</th>

                            <th>Action</th>

                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($recentActivities as $activity)

                            <tr>

                                <td>
                                    {{ optional($activity->user)->name ?? 'System' }}
                                </td>

                                <td>
                                    {{ $activity->module }}
                                </td>

                                <td>
                                    {{ $activity->action }}
                                </td>

                                <td>
                                    {{ $activity->created_at->diffForHumans() }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center py-4"
                                >
                                    No Activity Found
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<!-- ================================================================
     Chart.js
================================================================ -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

    /*
    |--------------------------------------------------------------------------
    | Monthly Booking Chart
    |--------------------------------------------------------------------------
    */

    const bookingCtx =
        document.getElementById('bookingChart');

    if (bookingCtx) {

        new Chart(
            bookingCtx,
            {
                type: 'bar',

                data: {

                    labels: [

                        @foreach($monthlyBookings as $booking)

                            '{{ DateTime::createFromFormat('!m', $booking->month)->format('M') }}',

                        @endforeach

                    ],

                    datasets: [{

                        label: 'Bookings',

                        data: [

                            @foreach($monthlyBookings as $booking)

                                {{ $booking->total }},

                            @endforeach

                        ],

                        backgroundColor: '#0d6efd'

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: true,

                    scales: {

                        y: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0

                            }

                        }

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Property Status Chart
    |--------------------------------------------------------------------------
    */

    const propertyCtx =
        document.getElementById('propertyChart');

    if (propertyCtx) {

        new Chart(
            propertyCtx,
            {
                type: 'doughnut',

                data: {

                    labels: [
                        'Available',
                        'Pending',
                        'Rented'
                    ],

                    datasets: [{

                        data: [

                            {{ $availableProperties }},

                            {{ $pendingProperties }},

                            {{ $rentedProperties }}

                        ],

                        backgroundColor: [

                            '#198754',

                            '#ffc107',

                            '#dc3545'

                        ]

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: true,

                    plugins: {

                        legend: {

                            position: 'bottom'

                        }

                    }

                }

            }
        );

    }

</script>

@endsection