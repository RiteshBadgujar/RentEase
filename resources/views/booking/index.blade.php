@extends('layouts.master')

@section('title', 'Booking Requests')

@section('content')

<div class="container py-5">

    <!-- ==========================
            Page Header
    =========================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-calendar-check-fill text-primary me-2"></i>

                Booking Requests

            </h2>

            <p class="text-muted mb-0">

                Manage property visit requests received from tenants.

            </p>

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
            Booking List
    =========================== -->

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header bg-light">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="bi bi-list-ul me-2"></i>

                    Booking List

                </h5>

                <span class="badge bg-primary">

                    {{ $bookings->total() }}

                    {{ $bookings->total() == 1 ? 'Booking' : 'Bookings' }}

                </span>

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th width="60">

                                #

                            </th>

                            <th>

                                Property

                            </th>

                            <th>

                                Tenant

                            </th>

                            <th>

                                Visit Date

                            </th>

                            <th>

                                Visit Time

                            </th>

                            <th>

                                Status

                            </th>

                            <th width="220">

                                Actions

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($bookings as $booking)

                            <tr>

                                <!-- ==========================
                                        Serial Number
                                =========================== -->

                                <td>

                                    {{ $bookings->firstItem() + $loop->index }}

                                </td>


                                <!-- ==========================
                                        Property
                                =========================== -->

                                <td>

                                    @if($booking->property)

                                        <strong>

                                            {{ $booking->property->title }}

                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            <i class="bi bi-geo-alt me-1"></i>

                                            {{ $booking->property->city ?? 'Location unavailable' }}

                                        </small>

                                    @else

                                        <span class="text-muted">

                                            Property unavailable

                                        </span>

                                    @endif

                                </td>


                                <!-- ==========================
                                        Tenant
                                =========================== -->

                                <td>

                                    @if($booking->tenant)

                                        <strong>

                                            {{ $booking->tenant->name }}

                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $booking->tenant->email }}

                                        </small>

                                    @else

                                        <span class="text-muted">

                                            Tenant unavailable

                                        </span>

                                    @endif

                                </td>


                                <!-- ==========================
                                        Visit Date
                                =========================== -->

                                <td>

                                    @if($booking->visit_date)

                                        {{ \Carbon\Carbon::parse($booking->visit_date)->format('d M Y') }}

                                    @else

                                        <span class="text-muted">

                                            Not specified

                                        </span>

                                    @endif

                                </td>


                                <!-- ==========================
                                        Visit Time
                                =========================== -->

                                <td>

                                    @if($booking->visit_time)

                                        {{ \Carbon\Carbon::parse($booking->visit_time)->format('h:i A') }}

                                    @else

                                        <span class="text-muted">

                                            Not specified

                                        </span>

                                    @endif

                                </td>


                                <!-- ==========================
                                        Status
                                =========================== -->

                                <td>

                                    @if($booking->status === 'Pending')

                                        <span class="badge bg-warning text-dark">

                                            <i class="bi bi-clock me-1"></i>

                                            Pending

                                        </span>

                                    @elseif($booking->status === 'Approved')

                                        <span class="badge bg-success">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Approved

                                        </span>

                                    @elseif($booking->status === 'Rejected')

                                        <span class="badge bg-danger">

                                            <i class="bi bi-x-circle me-1"></i>

                                            Rejected

                                        </span>

                                    @elseif($booking->status === 'Completed')

                                        <span class="badge bg-primary">

                                            <i class="bi bi-check2-all me-1"></i>

                                            Completed

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            {{ $booking->status }}

                                        </span>

                                    @endif

                                </td>


                                <!-- ==========================
                                        Actions
                                =========================== -->

                                <td>

                                    <!-- View -->

                                    <a
                                        href="{{ route('bookings.show', $booking->id) }}"
                                        class="btn btn-info btn-sm"
                                        title="View Booking">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    <!-- ==========================
                                            Pending Actions
                                    =========================== -->

                                    @if($booking->status === 'Pending')

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
                                                class="btn btn-success btn-sm"
                                                title="Approve Booking"
                                                onclick="return confirm('Approve this booking request?')">

                                                <i class="bi bi-check-circle"></i>

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
                                                class="btn btn-danger btn-sm"
                                                title="Reject Booking"
                                                onclick="return confirm('Reject this booking request?')">

                                                <i class="bi bi-x-circle"></i>

                                            </button>

                                        </form>

                                    @elseif($booking->status === 'Approved')

                                        <!-- ==========================
                                                Complete Booking
                                        =========================== -->

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
                                                class="btn btn-primary btn-sm"
                                                title="Mark as Completed"
                                                onclick="return confirm('Mark this booking as completed?')">

                                                <i class="bi bi-check2-all"></i>

                                            </button>

                                        </form>

                                    @elseif($booking->status === 'Rejected')

                                        <!-- Rejected bookings have no status action -->

                                    @elseif($booking->status === 'Completed')

                                        <!-- Completed bookings have no status action -->

                                    @endif


                                    <!-- ==========================
                                            Delete Booking
                                    =========================== -->

                                    @if(
                                        $booking->status === 'Rejected' ||
                                        $booking->status === 'Completed'
                                    )

                                        <form
                                            action="{{ route('bookings.destroy', $booking->id) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Delete Booking"
                                                onclick="return confirm('Are you sure you want to delete this booking?')">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <!-- ==========================
                                    Empty State
                            =========================== -->

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5">

                                    <i
                                        class="bi bi-calendar-x display-1 text-muted">
                                    </i>

                                    <h4 class="fw-bold mt-3">

                                        No Booking Requests Found

                                    </h4>

                                    <p class="text-muted">

                                        There are currently no booking requests for your properties.

                                    </p>

                                    <a
                                        href="{{ route('properties.index') }}"
                                        class="btn btn-primary mt-2">

                                        <i class="bi bi-house-door me-2"></i>

                                        View Properties

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- ==========================
                    Pagination
            =========================== -->

            @if($bookings->hasPages())

                <div class="d-flex justify-content-center mt-4">

                    {{ $bookings->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection