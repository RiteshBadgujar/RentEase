@extends('layouts.master')

@section('title', 'Booking Details')

@section('content')

<div class="container py-5">

    <!-- ==========================================================
         PAGE HEADER
    =========================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-calendar-check-fill text-primary me-2"></i>

                Booking Details

            </h2>

            <p class="text-muted mb-0">

                View details and status of your property visit request.

            </p>

        </div>

    </div>


    <!-- ==========================================================
         SUCCESS MESSAGE
    =========================================================== -->

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <!-- ==========================================================
         ERROR MESSAGE
    =========================================================== -->

    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <!-- ==========================================================
         BOOKING CARD
    =========================================================== -->

    <div class="card shadow-lg border-0 rounded-4">

        <!-- ======================================================
             CARD HEADER
        ======================================================= -->

        <div class="card-header bg-primary text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">

                    <i class="bi bi-calendar-check-fill me-2"></i>

                    Booking Details

                </h4>


                <!-- Booking ID -->

                <span class="badge bg-light text-dark">

                    #{{ $booking->id }}

                </span>

            </div>

        </div>


        <!-- ======================================================
             CARD BODY
        ======================================================= -->

        <div class="card-body p-4">

            <div class="row g-4">


                <!-- ==================================================
                     PROPERTY INFORMATION
                =================================================== -->

                <div class="col-md-6">

                    <div class="border rounded-4 p-4 h-100">

                        <h5 class="fw-bold mb-4">

                            <i class="bi bi-house-door-fill text-primary me-2"></i>

                            Property Information

                        </h5>


                        @if($booking->property)

                            <!-- Property -->

                            <div class="mb-3">

                                <span class="text-muted d-block">
                                    Property
                                </span>

                                <strong>
                                    {{ $booking->property->title }}
                                </strong>

                            </div>


                            <!-- Location -->

                            <div class="mb-3">

                                <span class="text-muted d-block">
                                    Location
                                </span>

                                <strong>

                                    {{ $booking->property->city ?? 'N/A' }}

                                    @if($booking->property->state)

                                        , {{ $booking->property->state }}

                                    @endif

                                </strong>

                            </div>


                            <!-- Property Status -->

                            <div class="mb-0">

                                <span class="text-muted d-block">
                                    Property Status
                                </span>


                                @if($booking->property->status === 'Available')

                                    <span class="badge bg-success">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Available

                                    </span>

                                @elseif($booking->property->status === 'Rented')

                                    <span class="badge bg-danger">

                                        <i class="bi bi-house-x me-1"></i>

                                        Rented

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        {{ $booking->property->status }}

                                    </span>

                                @endif

                            </div>

                        @else

                            <p class="text-muted mb-0">

                                Property information is unavailable.

                            </p>

                        @endif

                    </div>

                </div>


                <!-- ==================================================
                     LANDLORD INFORMATION
                =================================================== -->

                <div class="col-md-6">

                    <div class="border rounded-4 p-4 h-100">

                        <h5 class="fw-bold mb-4">

                            <i class="bi bi-person-circle text-primary me-2"></i>

                            Landlord Information

                        </h5>


                        @if($booking->landlord)

                            <!-- Name -->

                            <div class="mb-3">

                                <span class="text-muted d-block">
                                    Name
                                </span>

                                <strong>
                                    {{ $booking->landlord->name }}
                                </strong>

                            </div>


                            <!-- Email -->

                            <div class="mb-0">

                                <span class="text-muted d-block">
                                    Email
                                </span>

                                <strong>
                                    {{ $booking->landlord->email }}
                                </strong>

                            </div>

                        @else

                            <p class="text-muted mb-0">

                                Landlord information is unavailable.

                            </p>

                        @endif

                    </div>

                </div>


                <!-- ==================================================
                     VISIT INFORMATION
                =================================================== -->

                <div class="col-md-6">

                    <div class="border rounded-4 p-4 h-100">

                        <h5 class="fw-bold mb-4">

                            <i class="bi bi-calendar-event text-primary me-2"></i>

                            Visit Information

                        </h5>


                        <!-- Visit Date -->

                        <div class="mb-3">

                            <span class="text-muted d-block">
                                Visit Date
                            </span>

                            <strong>

                                @if($booking->visit_date)

                                    {{ $booking->visit_date->format('d M Y') }}

                                @else

                                    Not specified

                                @endif

                            </strong>

                        </div>


                        <!-- Visit Time -->

                        <div class="mb-0">

                            <span class="text-muted d-block">
                                Visit Time
                            </span>

                            <strong>

                                @if($booking->visit_time)

                                    {{ \Carbon\Carbon::parse($booking->visit_time)->format('h:i A') }}

                                @else

                                    Not specified

                                @endif

                            </strong>

                        </div>

                    </div>

                </div>


                <!-- ==================================================
                     BOOKING STATUS
                =================================================== -->

                <div class="col-md-6">

                    <div class="border rounded-4 p-4 h-100">

                        <h5 class="fw-bold mb-4">

                            <i class="bi bi-info-circle text-primary me-2"></i>

                            Booking Status

                        </h5>


                        <div class="mb-0">

                            @if($booking->status === 'Pending')

                                <span class="badge bg-warning text-dark fs-6">

                                    <i class="bi bi-clock me-1"></i>

                                    Pending

                                </span>

                                <p class="text-muted mt-3 mb-0">

                                    Your booking request is waiting for
                                    the landlord's response.

                                </p>


                            @elseif($booking->status === 'Approved')

                                <span class="badge bg-success fs-6">

                                    <i class="bi bi-check-circle me-1"></i>

                                    Approved

                                </span>

                                <p class="text-muted mt-3 mb-0">

                                    Your visit request has been approved
                                    by the landlord.

                                </p>


                            @elseif($booking->status === 'Rejected')

                                <span class="badge bg-danger fs-6">

                                    <i class="bi bi-x-circle me-1"></i>

                                    Rejected

                                </span>

                                <p class="text-muted mt-3 mb-0">

                                    Your visit request was rejected
                                    by the landlord.

                                </p>


                            @elseif($booking->status === 'Completed')

                                <span class="badge bg-primary fs-6">

                                    <i class="bi bi-check2-all me-1"></i>

                                    Completed

                                </span>

                                <p class="text-muted mt-3 mb-0">

                                    The property visit has been marked
                                    as completed.

                                </p>


                            @else

                                <span class="badge bg-secondary fs-6">

                                    {{ $booking->status }}

                                </span>

                            @endif

                        </div>

                    </div>

                </div>


                <!-- ==================================================
                     MESSAGE
                =================================================== -->

                <div class="col-12">

                    <div class="border rounded-4 p-4">

                        <h5 class="fw-bold mb-3">

                            <i class="bi bi-chat-left-text text-primary me-2"></i>

                            Your Message

                        </h5>


                        <div class="bg-light border rounded p-3">

                            @if($booking->message)

                                {{ $booking->message }}

                            @else

                                <span class="text-muted">

                                    No message provided.

                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            <hr class="my-4">


            <!-- ======================================================
                 ACTION BUTTONS
            ======================================================= -->

            <div class="d-flex flex-wrap gap-2">


                <!-- Back to My Bookings -->

                <a
                    href="{{ route('tenant.bookings.index') }}"
                    class="btn btn-secondary">

                    <i class="bi bi-arrow-left me-1"></i>

                    Back to My Bookings

                </a>


                <!-- ==================================================
                     CANCEL PENDING BOOKING
                =================================================== -->

                @if($booking->status === 'Pending')

                    <form
                        action="{{ route('tenant.bookings.destroy', $booking) }}"
                        method="POST"
                        class="d-inline">

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to cancel this booking?')">

                            <i class="bi bi-x-circle me-1"></i>

                            Cancel Booking

                        </button>

                    </form>

                @endif


                <!-- ==================================================
                     VIEW PROPERTY
                =================================================== -->

                @if($booking->property)

                    <a
                        href="{{ route('properties.show', $booking->property) }}"
                        class="btn btn-outline-primary">

                        <i class="bi bi-house-door me-1"></i>

                        View Property

                    </a>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection