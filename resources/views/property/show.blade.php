@extends('layouts.master')

@section('title', 'Property Details')

@section('content')

<div class="container py-5">

    <div class="row">

        <div class="col-lg-8">

            <div class="card shadow-lg border-0">

                @if($property->image)

                    <img
                        src="{{ asset('uploads/properties/'.$property->image) }}"
                        class="card-img-top"
                        style="height:450px;object-fit:cover;"
                        alt="{{ $property->title }}">

                @else

                    <img
                        src="https://placehold.co/1200x450?text=No+Image"
                        class="card-img-top"
                        style="height:450px;object-fit:cover;"
                        alt="No Image">

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

                        ₹{{ number_format($property->price,2) }}

                    </h3>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="border rounded p-3 h-100">

                                <p><strong><i class="bi bi-house-door me-2"></i>Type:</strong> {{ $property->property_type }}</p>

                                <p><strong><i class="bi bi-tag me-2"></i>Purpose:</strong> {{ $property->purpose }}</p>

                                <p><strong><i class="bi bi-wallet2 me-2"></i>Deposit:</strong> ₹{{ number_format($property->deposit ?? 0,2) }}</p>

                                <p><strong><i class="bi bi-rulers me-2"></i>Area:</strong> {{ $property->area }} Sq. Ft.</p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="border rounded p-3 h-100">

                                <p><strong><i class="bi bi-door-open me-2"></i>Bedrooms:</strong> {{ $property->bedrooms }}</p>

                                <p><strong><i class="bi bi-droplet me-2"></i>Bathrooms:</strong> {{ $property->bathrooms }}</p>

                                <p><strong><i class="bi bi-building me-2"></i>Balconies:</strong> {{ $property->balconies }}</p>

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

                    <div class="d-flex gap-2">

                        <a href="{{ route('properties.index') }}"
                           class="btn btn-secondary">

                            <i class="bi bi-arrow-left me-1"></i>

                            Back

                        </a>

                        <a href="{{ route('properties.edit', $property->id) }}"
                           class="btn btn-warning">

                            <i class="bi bi-pencil-square me-1"></i>

                            Edit

                        </a>

                        <form action="{{ route('properties.destroy', $property->id) }}"
                              method="POST">

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

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection