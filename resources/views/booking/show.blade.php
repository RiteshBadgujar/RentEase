@extends('layouts.master')

@section('title', 'Booking Details')

@section('content')

<div class="container py-5">

    <!-- ==========================
            Page Header
    =========================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-calendar-check-fill text-primary me-2"></i>

                Booking Details

            </h2>

            <p class="text-muted mb-0">

                View complete booking request information.

            </p>

        </div>


        <!-- Status -->

        <div>

            @if($booking->status === 'Pending')

                <span class="badge bg-warning text-dark fs-6">

                    <i class="bi bi-clock me-1"></i>

                    Pending

                </span>

            @elseif($booking->status === 'Approved')

                <span class="badge bg-success fs-6">

                    <i class="bi bi-check-circle me-1"></i>

                    Approved

                </span>

            @elseif($booking->status === 'Rejected')

                <span class="badge bg-danger fs-6">

                    <i class="bi bi-x-circle me-1"></i>

                    Rejected

                </span>

            @elseif($booking->status === 'Completed')

                <span class="badge bg-primary fs-6">

                    <i class="bi bi-check2-all me-1"></i>

                    Completed

                </span>

            @else

                <span class="badge bg-secondary fs-6">

                    {{ $booking->status }}

                </span>

            @endif

        </div>

    </div>


    <!-- ==========================
            Success Message
    =========================== -->

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


    <!-- ==========================
            Error Message
    =========================== -->

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


    <!-- ==========================
            Property + Tenant
    =========================== -->

    <div class="row g-4">

        <!-- ==========================
                Property Information
        =========================== -->

        <div class="col-lg-6">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">

                        <i class="bi bi-house-door-fill me-2"></i>

                        Property Information

                    </h5>

                </div>


                <div class="card-body">

                    @if($booking->property)

                        @if($booking->property->image)

                            <img
                                src="{{ $booking->property->image_url }}"
                                class="img-fluid rounded-3 mb-3"
                                alt="{{ $booking->property->title }}"
                                style="width: 100%; max-height: 300px; object-fit: cover;">

                        @endif


                        <table class="table table-borderless align-middle">

                            <tr>

                                <th width="35%">

                                    Property

                                </th>

                                <td>

                                    <strong>

                                        {{ $booking->property->title }}

                                    </strong>

                                </td>

                            </tr>


                            <tr>

                                <th>

                                    Type

                                </th>

                                <td>

                                    {{ $booking->property->property_type ?? 'Not specified' }}

                                </td>

                            </tr>


                            <tr>

                                <th>

                                    Purpose

                                </th>

                                <td>

                                    {{ $booking->property->purpose ?? 'Not specified' }}

                                </td>

                            </tr>


                            <tr>

                                <th>

                                    Price

                                </th>

                                <td>

                                    ₹{{ number_format((float) $booking->property->price, 2) }}

                                </td>

                            </tr>


                            <tr>

                                <th>

                                    Location

                                </th>

                                <td>

                                    {{ $booking->property->city ?? 'N/A' }}

                                    @if($booking->property->state)

                                        , {{ $booking->property->state }}

                                    @endif

                                </td>

                            </tr>


                            <tr>

                                <th>

                                    Property Status

                                </th>

                                <td>

                                    @if($booking->property->status === 'Available')

                                        <span class="badge bg-success">

                                            Available

                                        </span>

                                    @elseif($booking->property->status === 'Rented')

                                        <span class="badge bg-danger">

                                            Rented

                                        </span>

                                    @elseif($booking->property->status === 'Pending')

                                        <span class="badge bg-warning text-dark">

                                            Pending

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            {{ $booking->property->status }}

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        </table>

                    @else

                        <div class="text-center py-5">

                            <i class="bi bi-house-x display-4 text-muted"></i>

                            <p class="text-muted mt-3 mb-0">

                                Property information is unavailable.

                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>


        <!-- ==========================
                Tenant Information
        =========================== -->

        <div class="col-lg-6">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-header bg-success text-white">

                    <h5 class="mb-0">

                        <i class="bi bi-person-fill me-2"></i>

                        Tenant Information

                    </h5>

                </div>


                <div class="card-body">

                    @if($booking->tenant)

                        <table class="table table-borderless align-middle">

                            <tr>

                                <th width="35%">

                                    Name

                                </th>

                                <td>

                                    <strong>

                                        {{ $booking->tenant->name }}

                                    </strong>

                                </td>

                            </tr>


                            <tr>

                                <th>

                                    Email

                                </th>

                                <td>

                                    {{ $booking->tenant->email }}

                                </td>

                            </tr>


                            <tr>

                                <th>

                                    Phone

                                </th>

                                <td>

                                    {{ $booking->tenant->phone ?? 'Not Available' }}

                                </td>

                            </tr>


                            <tr>

                                <th>

                                    Booking Status

                                </th>

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

                                        <span class="badge bg-primary">

                                            Completed

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            {{ $booking->status }}

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        </table>

                    @else

                        <div class="text-center py-5">

                            <i class="bi bi-person-x display-4 text-muted"></i>

                            <p class="text-muted mt-3 mb-0">

                                Tenant information is unavailable.

                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    <!-- ==========================
            Booking Information
    =========================== -->

    <div class="card shadow border-0 rounded-4 mt-4">

        <div class="card-header bg-info text-white">

            <h5 class="mb-0">

                <i class="bi bi-calendar-event-fill me-2"></i>

                Booking Information

            </h5>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered align-middle mb-0">

                    <tr>

                        <th width="25%">

                            Booking ID

                        </th>

                        <td>

                            #{{ $booking->id }}

                        </td>

                    </tr>


                    <tr>

                        <th>

                            Visit Date

                        </th>

                        <td>

                            @if($booking->visit_date)

                                {{ \Carbon\Carbon::parse($booking->visit_date)->format('d F Y') }}

                            @else

                                Not specified

                            @endif

                        </td>

                    </tr>


                    <tr>

                        <th>

                            Visit Time

                        </th>

                        <td>

                            @if($booking->visit_time)

                                {{ \Carbon\Carbon::parse($booking->visit_time)->format('h:i A') }}

                            @else

                                Not specified

                            @endif

                        </td>

                    </tr>


                    <tr>

                        <th>

                            Message

                        </th>

                        <td>

                            @if($booking->message)

                                {{ $booking->message }}

                            @else

                                <span class="text-muted">

                                    No message provided.

                                </span>

                            @endif

                        </td>

                    </tr>


                    <tr>

                        <th>

                            Current Status

                        </th>

                        <td>

                            @if($booking->status === 'Pending')

                                <span class="badge bg-warning text-dark fs-6">

                                    Pending

                                </span>

                            @elseif($booking->status === 'Approved')

                                <span class="badge bg-success fs-6">

                                    Approved

                                </span>

                            @elseif($booking->status === 'Rejected')

                                <span class="badge bg-danger fs-6">

                                    Rejected

                                </span>

                            @elseif($booking->status === 'Completed')

                                <span class="badge bg-primary fs-6">

                                    Completed

                                </span>

                            @else

                                <span class="badge bg-secondary fs-6">

                                    {{ $booking->status }}

                                </span>

                            @endif

                        </td>

                    </tr>


                    <tr>

                        <th>

                            Created At

                        </th>

                        <td>

                            {{ $booking->created_at->format('d M Y, h:i A') }}

                            <br>

                            <small class="text-muted">

                                {{ $booking->created_at->diffForHumans() }}

                            </small>

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>


    <!-- ==========================
            Actions
    =========================== -->

    <div class="card shadow border-0 rounded-4 mt-4">

        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-center gap-2">


                <!-- Pending -->

                @if(auth()->id() === $booking->landlord_id && $booking->status === 'Pending')

                    <!-- Approve -->

                    <form
                        action="{{ route('bookings.update', $booking->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf

                        @method('PATCH')

                        <input
                            type="hidden"
                            name="status"
                            value="Approved">

                        <button
                            type="submit"
                            class="btn btn-success"
                            onclick="return confirm('Approve this booking request?')">

                            <i class="bi bi-check-circle-fill me-2"></i>

                            Approve

                        </button>

                    </form>


                    <!-- Reject -->

                    <form
                        action="{{ route('bookings.update', $booking->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf

                        @method('PATCH')

                        <input
                            type="hidden"
                            name="status"
                            value="Rejected">

                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('Reject this booking request?')">

                            <i class="bi bi-x-circle-fill me-2"></i>

                            Reject

                        </button>

                    </form>

                @endif


                <!-- Approved -->

                @if(auth()->id() === $booking->landlord_id && $booking->status === 'Approved')

                    <form
                        action="{{ route('bookings.update', $booking->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf

                        @method('PATCH')

                        <input
                            type="hidden"
                            name="status"
                            value="Completed">

                        <button
                            type="submit"
                            class="btn btn-primary"
                            onclick="return confirm('Mark this booking as completed?')">

                            <i class="bi bi-check2-all me-2"></i>

                            Mark as Completed

                        </button>

                    </form>

                @endif


                <!-- Delete -->

                @if(
                    auth()->id() === $booking->landlord_id &&
                    (
                        $booking->status === 'Rejected' ||
                        $booking->status === 'Completed'
                    )
                )

                    <form
                        action="{{ route('bookings.destroy', $booking->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this booking?')">

                            <i class="bi bi-trash me-2"></i>

                            Delete

                        </button>

                    </form>

                @endif


                <!-- Back -->

                <a
                    href="{{ route('bookings.index') }}"
                    class="btn btn-secondary">

                    <i class="bi bi-arrow-left-circle me-2"></i>

                    Back to Booking List

                </a>

            </div>

        </div>

    </div>

</div>

@endsection