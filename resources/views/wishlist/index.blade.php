@extends('layouts.master')

@section('title', 'My Wishlist')

@section('content')

<div class="container py-5">

    <!-- ==========================
            Page Header
    =========================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-heart-fill text-danger me-2"></i>

                My Wishlist

            </h2>

            <p class="text-muted mb-0">

                Properties you have saved for later.

            </p>

        </div>

        <a
            href="{{ route('properties.index') }}"
            class="btn btn-primary">

            <i class="bi bi-search me-1"></i>

            Browse Properties

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
            Wishlist Card
    =========================== -->

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header bg-light py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="bi bi-heart me-2 text-danger"></i>

                    Saved Properties

                </h5>

                <span class="badge bg-danger">

                    {{ $wishlists->total() }}

                    {{ $wishlists->total() == 1 ? 'Property' : 'Properties' }}

                </span>

            </div>

        </div>


        <div class="card-body">

            <!-- ==========================
                    Property Grid
            =========================== -->

            @forelse($wishlists as $wishlist)

                @php

                    $property = $wishlist->property;

                @endphp

                @if($property)

                    <div class="card mb-4 border shadow-sm">

                        <div class="row g-0">

                            <!-- Property Image -->

                            <div class="col-md-4">

                                @if($property->image)

                                    <img
                                        src="{{ asset('storage/' . $property->image) }}"
                                        class="img-fluid rounded-start w-100"
                                        style="height: 240px; object-fit: cover;"
                                        alt="{{ $property->title }}">

                                @else

                                    <div
                                        class="bg-light d-flex align-items-center justify-content-center rounded-start"
                                        style="height: 240px;">

                                        <i class="bi bi-house-door display-3 text-secondary"></i>

                                    </div>

                                @endif

                            </div>


                            <!-- Property Details -->

                            <div class="col-md-8">

                                <div class="card-body h-100 d-flex flex-column">

                                    <div class="d-flex justify-content-between align-items-start">

                                        <div>

                                            <h4 class="card-title fw-bold mb-2">

                                                {{ $property->title }}

                                            </h4>

                                            <p class="text-muted mb-2">

                                                <i class="bi bi-geo-alt-fill me-1"></i>

                                                {{ $property->city }},
                                                {{ $property->state }}

                                            </p>

                                        </div>

                                        @if($property->status == 'Available')

                                            <span class="badge bg-success">

                                                Available

                                            </span>

                                        @else

                                            <span class="badge bg-secondary">

                                                {{ $property->status }}

                                            </span>

                                        @endif

                                    </div>


                                    <!-- Property Information -->

                                    <div class="row mt-2">

                                        <div class="col-sm-6 mb-2">

                                            <i class="bi bi-house me-1 text-primary"></i>

                                            <strong>Type:</strong>

                                            {{ $property->property_type }}

                                        </div>

                                        <div class="col-sm-6 mb-2">

                                            <i class="bi bi-tag me-1 text-primary"></i>

                                            <strong>Purpose:</strong>

                                            {{ $property->purpose }}

                                        </div>

                                        <div class="col-sm-6 mb-2">

                                            <i class="bi bi-door-open me-1 text-primary"></i>

                                            <strong>Bedrooms:</strong>

                                            {{ $property->bedrooms ?? 'N/A' }}

                                        </div>

                                        <div class="col-sm-6 mb-2">

                                            <i class="bi bi-bounding-box me-1 text-primary"></i>

                                            <strong>Area:</strong>

                                            {{ $property->area ?? 'N/A' }}

                                        </div>

                                    </div>


                                    <!-- Price -->

                                    <div class="mt-2">

                                        <h4 class="fw-bold text-primary mb-1">

                                            ₹{{ number_format((float) $property->price) }}

                                        </h4>

                                        @if($property->purpose === 'Rent')

                                            <small class="text-muted">

                                                per month

                                            </small>

                                        @endif

                                    </div>


                                    <!-- Owner -->

                                    @if($property->user)

                                        <p class="text-muted mt-2 mb-3">

                                            <i class="bi bi-person-fill me-1"></i>

                                            Owner:

                                            <strong>

                                                {{ $property->user->name }}

                                            </strong>

                                        </p>

                                    @endif


                                    <!-- Actions -->

                                    <div class="mt-auto pt-3">

                                        <a
                                            href="{{ route('properties.show', $property->id) }}"
                                            class="btn btn-primary btn-sm">

                                            <i class="bi bi-eye me-1"></i>

                                            View Property

                                        </a>


                                        <form
                                            action="{{ route('wishlist.destroy', $property->id) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Remove this property from your wishlist?')">

                                                <i class="bi bi-heartbreak me-1"></i>

                                                Remove

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endif

            @empty

                <!-- ==========================
                        Empty State
                =========================== -->

                <div class="text-center py-5">

                    <i class="bi bi-heart display-1 text-secondary"></i>

                    <h4 class="fw-bold mt-3">

                        Your Wishlist is Empty

                    </h4>

                    <p class="text-muted mb-4">

                        You haven't saved any properties yet.

                    </p>

                    <a
                        href="{{ route('properties.index') }}"
                        class="btn btn-primary">

                        <i class="bi bi-search me-2"></i>

                        Browse Properties

                    </a>

                </div>

            @endforelse


            <!-- ==========================
                    Pagination
            =========================== -->

            @if($wishlists->hasPages())

                <div class="d-flex justify-content-center mt-4">

                    {{ $wishlists->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection