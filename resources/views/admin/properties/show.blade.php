@extends('layouts.admin')

@section('title', 'Property Details')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-house-door-fill text-primary me-2"></i>

                    Property Details

                </h2>

                <p class="text-muted mb-0">

                    Complete information about the selected property.

                </p>

            </div>

            <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left me-2"></i>

                Back

            </a>

        </div>

        <div class="row">

            <!-- Property Image -->

            <div class="col-lg-8 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    @if($property->image)

                        <img src="{{ asset('storage/' . $property->image) }}" class="card-img-top rounded-top-4"
                            style="height:450px;object-fit:cover;">

                    @else

                        <div class="d-flex justify-content-center align-items-center bg-light rounded-top-4"
                            style="height:450px;">

                            <div class="text-center">

                                <i class="bi bi-image display-1 text-secondary"></i>

                                <p class="text-muted mt-3">

                                    No Image Available

                                </p>

                            </div>

                        </div>

                    @endif

                    <div class="card-body">

                        <h2 class="fw-bold">

                            {{ $property->title }}

                        </h2>

                        <p class="text-muted mb-3">

                            <i class="bi bi-geo-alt-fill me-2"></i>

                            {{ $property->address }},

                            {{ $property->city }}

                        </p>

                        <hr>

                        <h5 class="fw-bold">

                            Description

                        </h5>

                        <p class="text-muted">

                            {{ $property->description }}

                        </p>

                    </div>

                </div>

            </div>

            <!-- Property Information -->

            <div class="col-lg-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-info-circle me-2"></i>

                            Property Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless align-middle">

                            <tr>

                                <th width="40%">

                                    Owner

                                </th>

                                <td>

                                    {{ $property->user->name ?? 'N/A' }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Email

                                </th>

                                <td>

                                    {{ $property->user->email ?? 'N/A' }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Property Type

                                </th>

                                <td>

                                    <span class="badge bg-info">

                                        {{ $property->property_type }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Monthly Rent

                                </th>

                                <td>

                                    <strong class="text-success">

                                        ₹{{ number_format($property->price) }}

                                    </strong>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Status

                                </th>

                                <td>

                                    @if($property->status == 'Available')

                                        <span class="badge bg-success">

                                            Available

                                        </span>

                                    @elseif($property->status == 'Rented')

                                        <span class="badge bg-danger">

                                            Rented

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            Pending

                                        </span>

                                    @endif

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Created On

                                </th>

                                <td>

                                    {{ $property->created_at->format('d M Y') }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

                <!-- Statistics -->

                <div class="row mt-4">

                    <div class="col-md-4 mb-3">

                        <div class="card border-0 shadow-sm text-center">

                            <div class="card-body">

                                <i class="bi bi-calendar-check-fill display-5 text-primary"></i>

                                <h3 class="mt-3">

                                    {{ $property->bookings->count() }}

                                </h3>

                                <p class="mb-0 text-muted">

                                    Bookings

                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <div class="card border-0 shadow-sm text-center">

                            <div class="card-body">

                                <i class="bi bi-heart-fill display-5 text-danger"></i>

                                <h3 class="mt-3">

                                    {{ $property->wishlists->count() }}

                                </h3>

                                <p class="mb-0 text-muted">

                                    Wishlist

                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <div class="card border-0 shadow-sm text-center">

                            <div class="card-body">

                                <i class="bi bi-chat-dots-fill display-5 text-success"></i>

                                <h3 class="mt-3">

                                    {{ $property->enquiries->count() }}

                                </h3>

                                <p class="mb-0 text-muted">

                                    Enquiries

                                </p>

                            </div>

                        </div>

                    </div>

                </div>
                <!-- Action Buttons -->

                <div class="card shadow-sm border-0 mt-4">

                    <div class="card-body text-center">

                        <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-warning me-2">

                            <i class="bi bi-pencil-square me-2"></i>

                            Edit Property

                        </a>

                        <form action="{{ route('admin.properties.destroy', $property) }}" method="POST"
                            class="delete-form d-inline">

                            @csrf

                            @method('DELETE')

                            <button type="submit" class="btn btn-danger me-2">

                                <i class="bi bi-trash me-2"></i>

                                Delete Property

                            </button>

                        </form>

                        <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary">

                            <i class="bi bi-arrow-left me-2"></i>

                            Back to List

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection