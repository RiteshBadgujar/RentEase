@extends('layouts.master')

@section('title', 'Landlord Dashboard')

@section('content')

<div class="container py-5">

    <!-- ==========================================================
         DASHBOARD HEADING
    =========================================================== -->

    <div class="row mb-4">

        <div class="col-md-12">

            <h2 class="fw-bold">

                <i class="bi bi-speedometer2 me-2 text-primary"></i>

                Landlord Dashboard

            </h2>

            <p class="text-muted">

                Welcome back,

                <strong>{{ Auth::user()->name }}</strong>

            </p>

        </div>

    </div>


    <!-- ==========================================================
         PROPERTY STATISTICS
    =========================================================== -->

    <div class="row g-4">

        <!-- Total Properties -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-buildings display-4 text-primary"></i>

                    <h5 class="mt-3">
                        Total Properties
                    </h5>

                    <h2 class="fw-bold">
                        {{ $totalProperties }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Available Properties -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-house-check display-4 text-success"></i>

                    <h5 class="mt-3">
                        Available
                    </h5>

                    <h2 class="fw-bold">
                        {{ $availableProperties }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Rented Properties -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-house-x display-4 text-danger"></i>

                    <h5 class="mt-3">
                        Rented
                    </h5>

                    <h2 class="fw-bold">
                        {{ $rentedProperties }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Total Property Value -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-currency-rupee display-4 text-info"></i>

                    <h5 class="mt-3">
                        Total Value
                    </h5>

                    <h4 class="fw-bold text-success">

                        ₹{{ number_format($totalValue) }}

                    </h4>

                </div>

            </div>

        </div>

    </div>


    <!-- ==========================================================
         NOTIFICATION STATISTICS
    =========================================================== -->

    <div class="row g-4 mt-1">

        <!-- Total Notifications -->

        <div class="col-lg-4 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-bell-fill display-4 text-primary"></i>

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

        <div class="col-lg-4 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-bell display-4 text-warning"></i>

                    <h5 class="mt-3">
                        Unread
                    </h5>

                    <h2 class="fw-bold">
                        {{ $unreadNotifications }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Read Notifications -->

        <div class="col-lg-4 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-check-circle-fill display-4 text-success"></i>

                    <h5 class="mt-3">
                        Read
                    </h5>

                    <h2 class="fw-bold">
                        {{ $readNotifications }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- ==========================================================
         BOOKING STATISTICS
    =========================================================== -->

    <div class="row g-4 mt-1">

        <!-- Total Bookings -->

        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-calendar-check-fill display-4 text-primary"></i>

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

                    <i class="bi bi-award-fill display-4 text-info"></i>

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


    <!-- ==========================================================
         ENQUIRY STATISTICS
    =========================================================== -->

    <div class="row g-4 mt-1">

        <!-- Total Enquiries -->

        <div class="col-lg-4 col-md-6">

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

        <div class="col-lg-4 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-hourglass-split display-4 text-warning"></i>

                    <h5 class="mt-3">
                        Pending
                    </h5>

                    <h2 class="fw-bold">
                        {{ $pendingEnquiries }}
                    </h2>

                </div>

            </div>

        </div>


        <!-- Replied Enquiries -->

        <div class="col-lg-4 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-check-circle-fill display-4 text-success"></i>

                    <h5 class="mt-3">
                        Replied
                    </h5>

                    <h2 class="fw-bold">
                        {{ $repliedEnquiries }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- ==========================================================
         QUICK ACTIONS
    =========================================================== -->

    <div class="row mt-4">

        <div class="col-md-12">

            <h5 class="fw-bold mb-3">
                Quick Actions
            </h5>


            <a
                href="{{ route('properties.create') }}"
                class="btn btn-primary me-2 mb-2">

                <i class="bi bi-plus-circle me-1"></i>

                Add Property

            </a>


            <a
                href="{{ route('properties.index') }}"
                class="btn btn-success me-2 mb-2">

                <i class="bi bi-buildings me-1"></i>

                Manage Properties

            </a>


            <a
                href="{{ route('bookings.index') }}"
                class="btn btn-info me-2 mb-2">

                <i class="bi bi-calendar-check me-1"></i>

                Booking Requests

            </a>


            <a
                href="{{ route('enquiries.index') }}"
                class="btn btn-info me-2 mb-2">

                <i class="bi bi-chat-dots me-1"></i>

                Enquiries

            </a>


            <a
                href="{{ route('notifications.index') }}"
                class="btn btn-secondary me-2 mb-2">

                <i class="bi bi-bell me-1"></i>

                Notifications

            </a>


            <a
                href="{{ route('profile.edit') }}"
                class="btn btn-warning mb-2">

                <i class="bi bi-person-circle me-1"></i>

                Profile

            </a>

        </div>

    </div>


    <!-- ==========================================================
         RECENT PROPERTIES
    =========================================================== -->

    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                <i class="bi bi-clock-history me-2"></i>

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

                            <th>Type</th>

                            <th>City</th>

                            <th>Status</th>

                            <th>Price</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($recentProperties as $property)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <strong>
                                        {{ $property->title }}
                                    </strong>

                                </td>


                                <td>
                                    {{ $property->property_type }}
                                </td>


                                <td>
                                    {{ $property->city }}
                                </td>


                                <td>

                                    @if($property->status === 'Available')

                                        <span class="badge bg-success">
                                            Available
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

                                    ₹{{ number_format((float) $property->price) }}

                                </td>


                                <td>

                                    <a
                                        href="{{ route('properties.show', $property->id) }}"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-eye me-1"></i>

                                        View

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-4">

                                    <i class="bi bi-house-x display-6 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        No Properties Available
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- ==========================================================
         RECENT BOOKINGS
    =========================================================== -->

    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-info text-white">

            <h5 class="mb-0">

                <i class="bi bi-calendar-check me-2"></i>

                Recent Booking Requests

            </h5>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Property</th>

                            <th>Tenant</th>

                            <th>Visit Date</th>

                            <th>Visit Time</th>

                            <th>Status</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($recentBookings as $booking)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    {{ $booking->property->title ?? 'N/A' }}

                                </td>


                                <td>

                                    {{ $booking->tenant->name ?? 'N/A' }}

                                </td>


                                <td>

                                    {{ $booking->visit_date
                                        ? $booking->visit_date->format('d M Y')
                                        : 'N/A'
                                    }}

                                </td>


                                <td>

                                    {{ $booking->visit_time ?? 'N/A' }}

                                </td>


                                <td>

                                    @if($booking->status === 'Pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($booking->status === 'Approved')

                                        <span class="badge bg-success">
                                            Approved
                                        </span>

                                    @elseif($booking->status === 'Rejected')

                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>

                                    @elseif($booking->status === 'Completed')

                                        <span class="badge bg-info">
                                            Completed
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $booking->status }}
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <a
                                        href="{{ route('bookings.show', $booking->id) }}"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-eye me-1"></i>

                                        View

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-4">

                                    <i class="bi bi-calendar-x display-6 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        No Booking Requests Available
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- ==========================================================
         RECENT ENQUIRIES
    =========================================================== -->

    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">

                <i class="bi bi-chat-dots me-2"></i>

                Recent Enquiries

            </h5>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Property</th>

                            <th>Tenant</th>

                            <th>Message</th>

                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($recentEnquiries as $enquiry)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    {{ $enquiry->property->title ?? 'N/A' }}

                                </td>


                                <td>

                                    {{ $enquiry->sender->name ?? 'N/A' }}

                                </td>


                                <td>

                                    {{ \Illuminate\Support\Str::limit(
                                        $enquiry->message,
                                        60
                                    ) }}

                                </td>


                                <td>

                                    @if($enquiry->status === 'Pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($enquiry->status === 'Replied')

                                        <span class="badge bg-success">
                                            Replied
                                        </span>

                                    @elseif($enquiry->status === 'Closed')

                                        <span class="badge bg-secondary">
                                            Closed
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $enquiry->status }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-4">

                                    <i class="bi bi-chat-square-x display-6 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        No Enquiries Available
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- ==========================================================
         RECENT NOTIFICATIONS
    =========================================================== -->

    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-warning">

            <h5 class="mb-0">

                <i class="bi bi-bell me-2"></i>

                Recent Notifications

            </h5>

        </div>


        <div class="card-body">

            @forelse($recentNotifications as $notification)

                <div class="d-flex align-items-start border-bottom py-3">

                    <div class="me-3">

                        @if(!$notification->is_read)

                            <i class="bi bi-bell-fill text-warning fs-4"></i>

                        @else

                            <i class="bi bi-check-circle text-success fs-4"></i>

                        @endif

                    </div>


                    <div class="flex-grow-1">

                        <h6 class="fw-bold mb-1">

                            {{ $notification->title }}

                        </h6>

                        <p class="text-muted mb-1">

                            {{ $notification->message }}

                        </p>

                        <small class="text-muted">

                            {{ $notification->created_at->format('d M Y, h:i A') }}

                        </small>

                    </div>


                    @if($notification->url)

                        <div>

                            <a
                                href="{{ $notification->url }}"
                                class="btn btn-sm btn-outline-primary">

                                View

                            </a>

                        </div>

                    @endif

                </div>

            @empty

                <div class="text-center py-4">

                    <i class="bi bi-bell-slash display-6 text-muted"></i>

                    <p class="text-muted mt-2 mb-0">

                        No Notifications Available

                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection