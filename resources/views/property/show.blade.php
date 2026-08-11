@extends('layouts.master')

@section('title', 'Property Details')

@section('content')

<div class="container py-5">

    <!-- ==========================
            Session Messages
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


    <div class="row g-4">

        <!-- ==========================
                Main Property Details
        =========================== -->

        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Property Image -->

                @if($property->image)

                    <img
                        src="{{ $property->image_url }}"
                        loading="lazy"
                        class="card-img-top"
                        style="height:450px; object-fit:cover;"
                        alt="{{ $property->title }}">

                @else

                    <div
                        class="bg-light d-flex align-items-center justify-content-center"
                        style="height:450px;">

                        <div class="text-center">

                            <i class="bi bi-house-door display-1 text-secondary"></i>

                            <p class="text-muted mt-2 mb-0">

                                No Image Available

                            </p>

                        </div>

                    </div>

                @endif


                <div class="card-body p-4">

                    <!-- ==========================
                            Title & Status
                    =========================== -->

                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">

                        <div>

                            <h2 class="fw-bold mb-1">

                                {{ $property->title }}

                            </h2>

                            <p class="text-muted mb-0">

                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>

                                {{ $property->city }},
                                {{ $property->state }}

                            </p>

                        </div>


                        <!-- Status -->

                        @if($property->status == 'Available')

                            <span class="badge bg-success fs-6">

                                Available

                            </span>

                        @elseif($property->status == 'Pending')

                            <span class="badge bg-warning text-dark fs-6">

                                Pending

                            </span>

                        @elseif($property->status == 'Rented')

                            <span class="badge bg-danger fs-6">

                                Rented

                            </span>

                        @else

                            <span class="badge bg-secondary fs-6">

                                {{ $property->status }}

                            </span>

                        @endif

                    </div>


                    <!-- Price -->

                    <h3 class="text-primary fw-bold mb-4">

                        ₹{{ number_format((float) $property->price, 2) }}

                        @if($property->purpose == 'Rent')

                            <small class="fs-6 text-muted">

                                / month

                            </small>

                        @endif

                    </h3>


                    <!-- ==========================
                            Property Information
                    =========================== -->

                    <div class="row g-3">

                        <!-- Basic Information -->

                        <div class="col-md-6">

                            <div class="border rounded p-3 h-100">

                                <h5 class="fw-bold mb-3">

                                    <i class="bi bi-info-circle me-2 text-primary"></i>

                                    Property Information

                                </h5>

                                <p>

                                    <strong>

                                        <i class="bi bi-house-door me-2"></i>

                                        Type:

                                    </strong>

                                    {{ $property->property_type }}

                                </p>

                                <p>

                                    <strong>

                                        <i class="bi bi-tag me-2"></i>

                                        Purpose:

                                    </strong>

                                    {{ $property->purpose }}

                                </p>

                                <p>

                                    <strong>

                                        <i class="bi bi-wallet2 me-2"></i>

                                        Deposit:

                                    </strong>

                                    ₹{{ number_format((float) ($property->deposit ?? 0), 2) }}

                                </p>

                                <p class="mb-0">

                                    <strong>

                                        <i class="bi bi-rulers me-2"></i>

                                        Area:

                                    </strong>

                                    {{ $property->area }} Sq. Ft.

                                </p>

                            </div>

                        </div>


                        <!-- Features -->

                        <div class="col-md-6">

                            <div class="border rounded p-3 h-100">

                                <h5 class="fw-bold mb-3">

                                    <i class="bi bi-house-gear me-2 text-primary"></i>

                                    Features

                                </h5>

                                <p>

                                    <strong>

                                        <i class="bi bi-door-open me-2"></i>

                                        Bedrooms:

                                    </strong>

                                    {{ $property->bedrooms }}

                                </p>

                                <p>

                                    <strong>

                                        <i class="bi bi-droplet me-2"></i>

                                        Bathrooms:

                                    </strong>

                                    {{ $property->bathrooms }}

                                </p>

                                <p>

                                    <strong>

                                        <i class="bi bi-building me-2"></i>

                                        Balconies:

                                    </strong>

                                    {{ $property->balconies ?? 0 }}

                                </p>

                                <p class="mb-0">

                                    <strong>

                                        <i class="bi bi-car-front me-2"></i>

                                        Parking:

                                    </strong>

                                    {{ $property->parking ? 'Available' : 'Not Available' }}

                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- ==========================
                            Furnishing
                    =========================== -->

                    <div class="mt-4">

                        <h4 class="fw-bold">

                            <i class="bi bi-lamp me-2 text-primary"></i>

                            Furnishing

                        </h4>

                        <p class="mb-0">

                            {{ $property->furnishing }}

                        </p>

                    </div>


                    <hr>


                    <!-- ==========================
                            Description
                    =========================== -->

                    <div>

                        <h4 class="fw-bold">

                            <i class="bi bi-file-text me-2 text-primary"></i>

                            Description

                        </h4>

                        <p class="text-muted mb-0">

                            {{ $property->description }}

                        </p>

                    </div>


                    <hr>


                    <!-- ==========================
                            Location
                    =========================== -->

                    <div>

                        <h4 class="fw-bold">

                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>

                            Location

                        </h4>

                        <p class="mb-2">

                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>

                            {{ $property->address }}

                        </p>

                        <p class="mb-0">

                            <strong>

                                {{ $property->city }}

                            </strong>,

                            {{ $property->state }}

                            -

                            {{ $property->pincode }}

                        </p>

                    </div>


                    <hr>


                    <!-- ==========================
                            Property Owner
                    =========================== -->

                    <div class="alert alert-light border">

                        <h5 class="fw-bold">

                            <i class="bi bi-person-circle me-2"></i>

                            Property Owner

                        </h5>

                        <p class="mb-0">

                            {{ $property->user->name ?? 'Unknown' }}

                        </p>

                    </div>


                    <!-- ==========================
                            Enquiry
                    =========================== -->

                    @auth

                        @if(
                            auth()->id() != $property->user_id &&
                            $property->status == 'Available'
                        )

                            <div class="card border-0 shadow-sm mb-4">

                                <div class="card-body">

                                    <h4 class="fw-bold mb-3">

                                        <i class="bi bi-chat-dots-fill text-success me-2"></i>

                                        Contact Landlord

                                    </h4>


                                    @if($errors->any())

                                        <div class="alert alert-danger">

                                            <ul class="mb-0">

                                                @foreach($errors->all() as $error)

                                                    <li>{{ $error }}</li>

                                                @endforeach

                                            </ul>

                                        </div>

                                    @endif


                                    <form
                                        action="{{ route('enquiries.store', $property->id) }}"
                                        method="POST">

                                        @csrf

                                        <div class="mb-3">

                                            <label
                                                class="form-label fw-semibold"
                                                for="enquiry_message">

                                                Message

                                            </label>

                                            <textarea
                                                id="enquiry_message"
                                                name="message"
                                                class="form-control"
                                                rows="5"
                                                minlength="10"
                                                maxlength="1000"
                                                placeholder="Write your enquiry..."
                                                required>{{ old('message') }}</textarea>

                                            <div class="form-text">

                                                Minimum 10 characters and maximum 1000 characters.

                                            </div>

                                        </div>

                                        <button
                                            type="submit"
                                            class="btn btn-success">

                                            <i class="bi bi-send-fill me-2"></i>

                                            Send Enquiry

                                        </button>

                                    </form>

                                </div>

                            </div>

                        @endif

                    @endauth


                    <!-- ==========================
                            Booking
                    =========================== -->

                    @auth

                        @if(
                            auth()->id() != $property->user_id &&
                            $property->status == 'Available'
                        )

                            <div class="card border-0 shadow-sm mb-4">

                                <div class="card-body">

                                    <h4 class="fw-bold mb-3">

                                        <i class="bi bi-calendar-check-fill text-primary me-2"></i>

                                        Request Property Visit

                                    </h4>


                                    <form
                                        action="{{ route('bookings.store', $property->id) }}"
                                        method="POST">

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="property_id"
                                            value="{{ $property->id }}">


                                        <div class="row">

                                            <!-- Visit Date -->

                                            <div class="col-md-6 mb-3">

                                                <label
                                                    class="form-label fw-semibold"
                                                    for="visit_date">

                                                    Visit Date

                                                </label>

                                                <input
                                                    type="date"
                                                    id="visit_date"
                                                    name="visit_date"
                                                    class="form-control"
                                                    value="{{ old('visit_date') }}"
                                                    min="{{ now()->toDateString() }}"
                                                    required>

                                            </div>


                                            <!-- Visit Time -->

                                            <div class="col-md-6 mb-3">

                                                <label
                                                    class="form-label fw-semibold"
                                                    for="visit_time">

                                                    Visit Time

                                                </label>

                                                <input
                                                    type="time"
                                                    id="visit_time"
                                                    name="visit_time"
                                                    class="form-control"
                                                    value="{{ old('visit_time') }}"
                                                    required>

                                            </div>

                                        </div>


                                        <!-- Booking Message -->

                                        <div class="mb-3">

                                            <label
                                                class="form-label fw-semibold"
                                                for="booking_message">

                                                Additional Message

                                            </label>

                                            <textarea
                                                id="booking_message"
                                                name="message"
                                                rows="4"
                                                maxlength="500"
                                                class="form-control"
                                                placeholder="Any special request...">{{ old('message') }}</textarea>

                                        </div>


                                        <button
                                            type="submit"
                                            class="btn btn-primary">

                                            <i class="bi bi-calendar-plus me-2"></i>

                                            Request Visit

                                        </button>

                                    </form>

                                </div>

                            </div>

                        @endif

                    @endauth


                    <!-- ==========================
                            Action Buttons
                    =========================== -->

                    <hr>

                    <div class="d-flex flex-wrap gap-2">

                        <!-- Back -->

                        <a
                            href="{{ route('properties.index') }}"
                            class="btn btn-secondary">

                            <i class="bi bi-arrow-left me-1"></i>

                            Back

                        </a>


                        @auth

                            <!-- Owner Actions -->

                            @if(auth()->id() == $property->user_id)

                                <a
                                    href="{{ route('properties.edit', $property->id) }}"
                                    class="btn btn-warning">

                                    <i class="bi bi-pencil-square me-1"></i>

                                    Edit

                                </a>


                                <form
                                    action="{{ route('properties.destroy', $property->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this property?')">

                                        <i class="bi bi-trash me-1"></i>

                                        Delete

                                    </button>

                                </form>

                            @endif


                            <!-- Wishlist -->

                            @if(auth()->id() != $property->user_id)

                                @if($isWishlisted)

                                    <form
                                        action="{{ route('wishlist.destroy', $property->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-outline-danger">

                                            <i class="bi bi-heartbreak-fill me-1"></i>

                                            Remove Wishlist

                                        </button>

                                    </form>

                                @else

                                    <form
                                        action="{{ route('wishlist.store', $property->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary">

                                            <i class="bi bi-heart-fill me-1"></i>

                                            Add Wishlist

                                        </button>

                                    </form>

                                @endif

                            @endif

                        @endauth

                    </div>

                </div>

            </div>

        </div>


        <!-- ==========================
                Right Sidebar
        =========================== -->

        <div class="col-lg-4">

            <!-- Quick Information -->

            <div class="card shadow border-0 rounded-4 mb-4">

                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">

                        <i class="bi bi-info-circle me-2"></i>

                        Quick Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Property Type

                        </span>

                        <strong>

                            {{ $property->property_type }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Purpose

                        </span>

                        <strong>

                            {{ $property->purpose }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Area

                        </span>

                        <strong>

                            {{ $property->area }} Sq. Ft.

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Bedrooms

                        </span>

                        <strong>

                            {{ $property->bedrooms }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">

                            Status

                        </span>

                        <strong>

                            {{ $property->status }}

                        </strong>

                    </div>

                </div>

            </div>


            <!-- Related Properties -->

            @if(isset($relatedProperties) && $relatedProperties->count())

                <div class="card shadow border-0 rounded-4">

                    <div class="card-header bg-light">

                        <h5 class="mb-0">

                            <i class="bi bi-houses me-2"></i>

                            Related Properties

                        </h5>

                    </div>

                    <div class="card-body">

                        @foreach($relatedProperties as $related)

                            <div class="border-bottom pb-3 mb-3">

                                @if($related->image)

                                    <img
                                        src="{{ $related->image_url }}"
                                        class="img-fluid rounded mb-2"
                                        style="height:140px; width:100%; object-fit:cover;"
                                        alt="{{ $related->title }}">

                                @endif

                                <h6 class="fw-bold mb-1">

                                    {{ $related->title }}

                                </h6>

                                <p class="text-muted small mb-1">

                                    <i class="bi bi-geo-alt me-1"></i>

                                    {{ $related->city }}

                                </p>

                                <p class="text-primary fw-bold mb-2">

                                    ₹{{ number_format((float) $related->price, 2) }}

                                </p>

                                <a
                                    href="{{ route('properties.show', $related->id) }}"
                                    class="btn btn-outline-primary btn-sm">

                                    View Property

                                </a>

                            </div>

                        @endforeach

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection