@extends('layouts.master')

@section('title', 'My Booking Requests')

@section('content')

<div class="container py-5">

    <!-- ==========================
            Page Header
    =========================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-calendar-check-fill text-primary me-2"></i>

                My Booking Requests

            </h2>

            <p class="text-muted mb-0">

                View and manage your property visit requests.

            </p>

        </div>

        <a
            href="{{ route('dashboard') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Dashboard

        </a>

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
            Booking Card
    =========================== -->

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header bg-light">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="bi bi-list-ul me-2"></i>

                    Booking List

                </h5>

                <span class="badge bg-primary">

                    {{ $bookings->count() }}

                    {{ $bookings->count() == 1 ? 'Booking' : 'Bookings' }}

                </span>

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th width="60">#</th>

                            <th>Property</th>

                            <th>Landlord</th>

                            <th>Visit Date</th>

                            <th>Visit Time</th>

                            <th>Status</th>

                            <th width="150">Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($bookings as $booking)

                            <tr>

                                <!-- Serial Number -->

                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                <!-- Property -->

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


                                <!-- Landlord -->

                                <td>

                                    @if($booking->landlord)

                                        <strong>

                                            {{ $booking->landlord->name }}

                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $booking->landlord->email }}

                                        </small>

                                    @else

                                        <span class="text-muted">

                                            Landlord unavailable

                                        </span>

                                    @endif

                                </td>


                                <!-- Visit Date -->

                                <td>

                                    @if($booking->visit_date)

                                        {{ \Carbon\Carbon::parse($booking->visit_date)->format('d M Y') }}

                                    @else

                                        <span class="text-muted">

                                            Not specified

                                        </span>

                                    @endif

                                </td>


                                <!-- Visit Time -->

                                <td>

                                    @if($booking->visit_time)

                                        {{ \Carbon\Carbon::parse($booking->visit_time)->format('h:i A') }}

                                    @else

                                        <span class="text-muted">

                                            Not specified

                                        </span>

                                    @endif

                                </td>


                                <!-- Status -->

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


                                <!-- Actions -->

                                <td>

                                    <!-- View -->

                                    <a
                                        href="{{ route('tenant.bookings.show', $booking->id) }}"
                                        class="btn btn-info btn-sm"
                                        title="View Booking">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    <!-- Cancel -->

                                    @if($booking->status === 'Pending')

                                        <form
                                            action="{{ route('tenant.bookings.destroy', $booking->id) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Cancel Booking"
                                                onclick="return confirm('Are you sure you want to cancel this booking?')">

                                                <i class="bi bi-x-circle"></i>

                                            </button>

                                        </form>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <!-- Empty State -->

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5">

                                    <i
                                        class="bi bi-calendar-x display-1 text-secondary">
                                    </i>

                                    <h4 class="fw-bold mt-3">

                                        No Booking Requests Found

                                    </h4>

                                    <p class="text-muted mb-3">

                                        You haven't submitted any property visit requests yet.

                                    </p>

                                    <a
                                        href="{{ route('properties.index') }}"
                                        class="btn btn-primary">

                                        <i class="bi bi-search me-2"></i>

                                        Browse Properties

                                    </a>

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