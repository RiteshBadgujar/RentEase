@extends('layouts.master')

@section('title', 'Property Details')

@section('content')

    <div class="container py-5">

        <div class="row">

            <div class="col-lg-8">

                <div class="card shadow-lg border-0">

                    @if($property->image)

                        <img src="{{ asset('uploads/properties/' . $property->image) }}" class="card-img-top"
                            style="height:450px;object-fit:cover;" alt="{{ $property->title }}">

                    @else

                        <img src="https://placehold.co/1200x450?text=No+Image" class="card-img-top"
                            style="height:450px;object-fit:cover;" alt="No Image">

                    @endif

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <h2 class="fw-bold mb-0">

                                {{ $property->title }}

                            </h2>

                            @if($property->status == 'Available')

                                <span class="badge bg-success fs-6">

                                    Available

                                </span>

                            @else

                                <span class="badge bg-danger fs-6">

                                    Rented

                                </span>

                            @endif

                        </div>

                        <h3 class="text-primary fw-bold mb-4">

                            ₹{{ number_format($property->price, 2) }}

                        </h3>

                        <div class="row g-3">

                            <div class="col-md-6">

                                <div class="border rounded p-3 h-100">

                                    <p><strong><i class="bi bi-house-door me-2"></i>Type:</strong>
                                        {{ $property->property_type }}</p>

                                    <p><strong><i class="bi bi-tag me-2"></i>Purpose:</strong> {{ $property->purpose }}</p>

                                    <p><strong><i class="bi bi-wallet2 me-2"></i>Deposit:</strong>
                                        ₹{{ number_format($property->deposit ?? 0, 2) }}</p>

                                    <p><strong><i class="bi bi-rulers me-2"></i>Area:</strong> {{ $property->area }} Sq. Ft.
                                    </p>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="border rounded p-3 h-100">

                                    <p><strong><i class="bi bi-door-open me-2"></i>Bedrooms:</strong>
                                        {{ $property->bedrooms }}</p>

                                    <p><strong><i class="bi bi-droplet me-2"></i>Bathrooms:</strong>
                                        {{ $property->bathrooms }}</p>

                                    <p><strong><i class="bi bi-building me-2"></i>Balconies:</strong>
                                        {{ $property->balconies }}</p>

                                    <p><strong><i class="bi bi-car-front me-2"></i>Parking:</strong>

                                        {{ $property->parking ? 'Available' : 'Not Available' }}

                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="mt-4">

                            <h4 class="fw-bold">

                                Furnishing

                            </h4>

                            <p>

                                {{ $property->furnishing }}

                            </p>

                        </div>

                        <hr>

                        <div>

                            <h4 class="fw-bold">

                                Description

                            </h4>

                            <p class="text-muted">

                                {{ $property->description }}

                            </p>

                        </div>

                        <hr>

                        <div>

                            <h4 class="fw-bold">

                                Location

                            </h4>

                            <p>

                                <i class="bi bi-geo-alt-fill text-danger me-2"></i>

                                {{ $property->address }}

                            </p>

                            <p>

                                {{ $property->city }},
                                {{ $property->state }}
                                - {{ $property->pincode }}

                            </p>
                        </div>

                        <hr>

                        @auth

                            @if(auth()->id() != $property->user_id)

                                <div class="card border-0 shadow-sm mb-4">

                                    <div class="card-body">

                                        <h4 class="fw-bold mb-3">

                                            <i class="bi bi-chat-dots-fill text-success me-2"></i>

                                            Contact Landlord

                                        </h4>

                                        @if(session('success'))

                                            <div class="alert alert-success">

                                                {{ session('success') }}

                                            </div>

                                        @endif

                                        @if(session('error'))

                                            <div class="alert alert-danger">

                                                {{ session('error') }}

                                            </div>

                                        @endif

                                        @if($errors->any())

                                            <div class="alert alert-danger">

                                                <ul class="mb-0">

                                                    @foreach($errors->all() as $error)

                                                        <li>{{ $error }}</li>

                                                    @endforeach

                                                </ul>

                                            </div>

                                        @endif

                                        <form action="{{ route('enquiries.store', $property->id) }}" method="POST">

                                            @csrf

                                            <div class="mb-3">

                                                <label class="form-label">

                                                    Message

                                                </label>

                                                <textarea name="message" class="form-control" rows="5"
                                                    placeholder="Write your enquiry..." required>{{ old('message') }}</textarea>

                                            </div>

                                            <button type="submit" class="btn btn-success">

                                                <i class="bi bi-send-fill me-2"></i>

                                                Send Enquiry

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            @endif

                        @endauth

                        @auth

                            @if(auth()->id() != $property->user_id)

                                <div class="card border-0 shadow-sm mb-4">

                                    <div class="card-body">

                                        <h4 class="fw-bold mb-3">

                                            <i class="bi bi-calendar-check-fill text-primary me-2"></i>

                                            Request Property Visit

                                        </h4>

                                        <form action="{{ route('bookings.store', $property->id) }}" method="POST">

                                            @csrf

                                            <input type="hidden" name="property_id" value="{{ $property->id }}">

                                            <div class="row">

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">

                                                        Visit Date

                                                    </label>

                                                    <input type="date" name="visit_date" class="form-control"
                                                        min="{{ now()->toDateString() }}" required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">

                                                        Visit Time

                                                    </label>

                                                    <input type="time" name="visit_time" class="form-control" required>

                                                </div>

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">

                                                    Additional Message

                                                </label>

                                                <textarea name="message" rows="4" class="form-control"
                                                    placeholder="Any special request..."></textarea>

                                            </div>

                                            <button type="submit" class="btn btn-primary">

                                                <i class="bi bi-calendar-plus me-2"></i>

                                                Request Visit

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            @endif

                        @endauth

                        <hr>

                        <div class="d-flex flex-wrap gap-2">

                            <!-- Back Button -->
                            <a href="{{ route('properties.index') }}" class="btn btn-secondary">

                                <i class="bi bi-arrow-left me-1"></i>

                                Back

                            </a>

                            @if(auth()->id() == $property->user_id)

                                <!-- Edit -->
                                <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-warning">

                                    <i class="bi bi-pencil-square me-1"></i>

                                    Edit

                                </a>

                                <!-- Delete -->
                                <form action="{{ route('properties.destroy', $property->id) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this property?')">

                                        <i class="bi bi-trash me-1"></i>

                                        Delete

                                    </button>

                                </form>

                            @endif

                            <!-- Wishlist -->

                            @auth

                                @if($isWishlisted)

                                    <form action="{{ route('wishlist.destroy', $property->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger">

                                            <i class="bi bi-heartbreak-fill me-1"></i>

                                            Remove Wishlist

                                        </button>

                                    </form>

                                @else

                                    <form action="{{ route('wishlist.store', $property->id) }}" method="POST">

                                        @csrf

                                        <button type="submit" class="btn btn-outline-primary">

                                            <i class="bi bi-heart-fill me-1"></i>

                                            Add Wishlist

                                        </button>


                                    </form>

                                @endif

                            @endauth

                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection