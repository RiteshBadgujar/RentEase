@extends('layouts.master')

@section('title', 'Booking Details')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            <i class="bi bi-calendar-check-fill text-primary me-2"></i>

            Booking Details

        </h2>

        <a href="{{ route('admin.bookings.index') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left me-2"></i>

            Back

        </a>

    </div>

    <div class="card border-0 shadow rounded-4">

        <div class="card-body p-4">

            <div class="row">

                <div class="col-md-6">

                    <h5 class="fw-bold mb-3">

                        Tenant Details

                    </h5>

                    <p><strong>Name :</strong> {{ $booking->tenant->name ?? 'N/A' }}</p>

                    <p><strong>Email :</strong> {{ $booking->tenant->email ?? 'N/A' }}</p>

                </div>

                <div class="col-md-6">

                    <h5 class="fw-bold mb-3">

                        Landlord Details

                    </h5>

                    <p><strong>Name :</strong> {{ $booking->landlord->name ?? 'N/A' }}</p>

                    <p><strong>Email :</strong> {{ $booking->landlord->email ?? 'N/A' }}</p>

                </div>

            </div>

            <hr>

            <div class="row">

                <div class="col-md-6">

                    <h5 class="fw-bold mb-3">

                        Property Details

                    </h5>

                    <p><strong>Title :</strong> {{ $booking->property->title ?? 'N/A' }}</p>

                    <p><strong>City :</strong> {{ $booking->property->city ?? 'N/A' }}</p>

                    <p><strong>Price :</strong>

                        ₹{{ number_format($booking->property->price ?? 0) }}

                    </p>

                </div>

                <div class="col-md-6">

                    <h5 class="fw-bold mb-3">

                        Booking Information

                    </h5>

                    <p>

                        <strong>Status :</strong>

                        @if($booking->status=='Pending')

                            <span class="badge bg-warning text-dark">

                                Pending

                            </span>

                        @elseif($booking->status=='Approved')

                            <span class="badge bg-success">

                                Approved

                            </span>

                        @elseif($booking->status=='Rejected')

                            <span class="badge bg-danger">

                                Rejected

                            </span>

                        @else

                            <span class="badge bg-info">

                                Completed

                            </span>

                        @endif

                    </p>

                    <p>

                        <strong>Created :</strong>

                        {{ $booking->created_at->format('d M Y h:i A') }}

                    </p>

                    <p>

                        <strong>Last Updated :</strong>

                        {{ $booking->updated_at->format('d M Y h:i A') }}

                    </p>

                </div>

            </div>

            <hr>

            <a href="{{ route('admin.bookings.edit',$booking) }}"
                class="btn btn-warning">

                <i class="bi bi-pencil-square me-2"></i>

                Edit Booking

            </a>

            <form action="{{ route('admin.bookings.destroy',$booking) }}"
                method="POST"
                class="d-inline">

                @csrf
                @method('DELETE')

                <button
                    class="btn btn-danger"
                    onclick="return confirm('Delete this booking?')">

                    <i class="bi bi-trash me-2"></i>

                    Delete

                </button>

            </form>

        </div>

    </div>

</div>

@endsection