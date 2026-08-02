@extends('layouts.master')

@section('title', 'Booking Details')

@section('content')

<div class="container py-5">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">

                <i class="bi bi-calendar-check-fill me-2"></i>

                Booking Details

            </h4>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <p>

                        <strong>Property:</strong>

                        {{ $booking->property->title }}

                    </p>

                    <p>

                        <strong>Landlord:</strong>

                        {{ $booking->landlord->name }}

                    </p>

                    <p>

                        <strong>Visit Date:</strong>

                        {{ $booking->visit_date }}

                    </p>

                    <p>

                        <strong>Visit Time:</strong>

                        {{ $booking->visit_time }}

                    </p>

                </div>

                <div class="col-md-6">

                    <p>

                        <strong>Status:</strong>

                        @if($booking->status == 'Pending')

                            <span class="badge bg-warning text-dark">

                                Pending

                            </span>

                        @elseif($booking->status == 'Approved')

                            <span class="badge bg-success">

                                Approved

                            </span>

                        @elseif($booking->status == 'Rejected')

                            <span class="badge bg-danger">

                                Rejected

                            </span>

                        @else

                            <span class="badge bg-primary">

                                Completed

                            </span>

                        @endif

                    </p>

                    <p>

                        <strong>Message:</strong>

                    </p>

                    <div class="border rounded p-3 bg-light">

                        {{ $booking->message ?? 'No message provided.' }}

                    </div>

                </div>

            </div>

            <hr>

            <a href="{{ route('tenant.bookings.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

</div>

@endsection