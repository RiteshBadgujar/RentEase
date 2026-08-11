@extends('layouts.master')

@section('title', 'Property Management')

@section('content')

<div class="container py-5">

    {{-- =========================================================
        Page Header
    ========================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-house-door-fill text-primary me-2"></i>
                Property Management
            </h2>

            <p class="text-muted mb-0">
                Browse, search and manage properties.
            </p>
        </div>

        @auth
            @if(auth()->user()->isLandlord())
                <a
                    href="{{ route('properties.create') }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-plus-circle me-2"></i>
                    Add Property
                </a>
            @endif
        @endauth

    </div>


    {{-- =========================================================
        Success Message
    ========================================================== --}}

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>

    @endif


    {{-- =========================================================
        Error Message
    ========================================================== --}}

    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >
            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>

    @endif


    {{-- =========================================================
        Search & Filters
    ========================================================== --}}

    <div class="card shadow border-0 rounded-4 mb-4">

        <div class="card-header bg-light py-3">

            <h5 class="mb-0">
                <i class="bi bi-search me-2"></i>
                Search Properties
            </h5>

        </div>


        <div class="card-body">

            <form
                action="{{ route('properties.index') }}"
                method="GET"
            >

                <div class="row g-3">

                    {{-- Property Title --}}

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label">
                            Property Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            value="{{ request('title') }}"
                            class="form-control"
                            placeholder="Search by title"
                        >

                    </div>


                    {{-- City --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            City
                        </label>

                        <input
                            type="text"
                            name="city"
                            value="{{ request('city') }}"
                            class="form-control"
                            placeholder="City"
                        >

                    </div>


                    {{-- Property Type --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            Property Type
                        </label>

                        <select
                            name="property_type"
                            class="form-select"
                        >

                            <option value="">
                                All
                            </option>

                            <option
                                value="Apartment"
                                {{ request('property_type') == 'Apartment' ? 'selected' : '' }}
                            >
                                Apartment
                            </option>

                            <option
                                value="House"
                                {{ request('property_type') == 'House' ? 'selected' : '' }}
                            >
                                House
                            </option>

                            <option
                                value="Villa"
                                {{ request('property_type') == 'Villa' ? 'selected' : '' }}
                            >
                                Villa
                            </option>

                            <option
                                value="PG"
                                {{ request('property_type') == 'PG' ? 'selected' : '' }}
                            >
                                PG
                            </option>

                            <option
                                value="Office"
                                {{ request('property_type') == 'Office' ? 'selected' : '' }}
                            >
                                Office
                            </option>

                            <option
                                value="Commercial"
                                {{ request('property_type') == 'Commercial' ? 'selected' : '' }}
                            >
                                Commercial
                            </option>

                        </select>

                    </div>


                    {{-- Purpose --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            Purpose
                        </label>

                        <select
                            name="purpose"
                            class="form-select"
                        >

                            <option value="">
                                All
                            </option>

                            <option
                                value="Rent"
                                {{ request('purpose') == 'Rent' ? 'selected' : '' }}
                            >
                                Rent
                            </option>

                            <option
                                value="Sale"
                                {{ request('purpose') == 'Sale' ? 'selected' : '' }}
                            >
                                Sale
                            </option>

                        </select>

                    </div>


                    {{-- Status --}}

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="">
                                All
                            </option>

                            <option
                                value="Available"
                                {{ request('status') == 'Available' ? 'selected' : '' }}
                            >
                                Available
                            </option>

                            <option
                                value="Pending"
                                {{ request('status') == 'Pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                            <option
                                value="Rented"
                                {{ request('status') == 'Rented' ? 'selected' : '' }}
                            >
                                Rented
                            </option>

                        </select>

                    </div>


                    {{-- Minimum Price --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            Min Price
                        </label>

                        <input
                            type="number"
                            name="min_price"
                            value="{{ request('min_price') }}"
                            class="form-control"
                            min="0"
                            placeholder="Minimum"
                        >

                    </div>


                    {{-- Maximum Price --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            Max Price
                        </label>

                        <input
                            type="number"
                            name="max_price"
                            value="{{ request('max_price') }}"
                            class="form-control"
                            min="0"
                            placeholder="Maximum"
                        >

                    </div>


                    {{-- Bedrooms --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            Bedrooms
                        </label>

                        <select
                            name="bedrooms"
                            class="form-select"
                        >

                            <option value="">
                                All
                            </option>

                            @for($i = 1; $i <= 10; $i++)

                                <option
                                    value="{{ $i }}"
                                    {{ request('bedrooms') == $i ? 'selected' : '' }}
                                >
                                    {{ $i }}
                                </option>

                            @endfor

                        </select>

                    </div>


                    {{-- Bathrooms --}}

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            Bathrooms
                        </label>

                        <select
                            name="bathrooms"
                            class="form-select"
                        >

                            <option value="">
                                All
                            </option>

                            @for($i = 1; $i <= 10; $i++)

                                <option
                                    value="{{ $i }}"
                                    {{ request('bathrooms') == $i ? 'selected' : '' }}
                                >
                                    {{ $i }}
                                </option>

                            @endfor

                        </select>

                    </div>


                    {{-- Sort --}}

                    <div class="col-lg-4 col-md-6">

                        <label class="form-label">
                            Sort By
                        </label>

                        <select
                            name="sort"
                            class="form-select"
                        >

                            <option
                                value=""
                                {{ !request('sort') ? 'selected' : '' }}
                            >
                                Latest
                            </option>

                            <option
                                value="price_low"
                                {{ request('sort') == 'price_low' ? 'selected' : '' }}
                            >
                                Price: Low to High
                            </option>

                            <option
                                value="price_high"
                                {{ request('sort') == 'price_high' ? 'selected' : '' }}
                            >
                                Price: High to Low
                            </option>

                            <option
                                value="oldest"
                                {{ request('sort') == 'oldest' ? 'selected' : '' }}
                            >
                                Oldest
                            </option>

                        </select>

                    </div>

                </div>


                {{-- Filter Buttons --}}

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a
                        href="{{ route('properties.index') }}"
                        class="btn btn-secondary"
                    >
                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Reset
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-search me-2"></i>
                        Search
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
        Property List
    ========================================================== --}}

    <div class="card shadow border-0 rounded-4">

        <div class="card-header bg-light py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>
                    Property List
                </h5>

                <span class="badge bg-primary">

                    {{ $properties->total() }}

                    {{ $properties->total() == 1 ? 'Property' : 'Properties' }}

                </span>

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th width="80">
                                Image
                            </th>

                            <th>
                                Title
                            </th>

                            <th>
                                Owner
                            </th>

                            <th>
                                City
                            </th>

                            <th>
                                Type
                            </th>

                            <th>
                                Purpose
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="190">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($properties as $property)

                            <tr>

                                {{-- Image --}}

                                <td>

                                    @if($property->image)

                                        <img
                                            src="{{ $property->image_url }}"
                                            class="rounded"
                                            width="70"
                                            height="70"
                                            style="object-fit: cover;"
                                            alt="{{ $property->title }}"
                                        >

                                    @else

                                        <div
                                            class="bg-light rounded d-flex align-items-center justify-content-center"
                                            style="width: 70px; height: 70px;"
                                        >
                                            <i class="bi bi-house-door text-secondary fs-3"></i>
                                        </div>

                                    @endif

                                </td>


                                {{-- Title --}}

                                <td>

                                    <strong>
                                        {{ $property->title }}
                                    </strong>

                                </td>


                                {{-- Owner --}}

                                <td>

                                    @if($property->user)

                                        {{ $property->user->name }}

                                    @else

                                        <span class="text-muted">
                                            Unknown
                                        </span>

                                    @endif

                                </td>


                                {{-- City --}}

                                <td>
                                    {{ $property->city }}
                                </td>


                                {{-- Type --}}

                                <td>

                                    <span class="badge bg-info">
                                        {{ $property->property_type }}
                                    </span>

                                </td>


                                {{-- Purpose --}}

                                <td>

                                    <span class="badge bg-secondary">
                                        {{ $property->purpose }}
                                    </span>

                                </td>


                                {{-- Price --}}

                                <td>

                                    <strong class="text-success">
                                        ₹{{ number_format((float) $property->price, 2) }}
                                    </strong>

                                </td>


                                {{-- Status --}}

                                <td>

                                    @if($property->status == 'Available')

                                        <span class="badge bg-success">
                                            Available
                                        </span>

                                    @elseif($property->status == 'Pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($property->status == 'Rented')

                                        <span class="badge bg-danger">
                                            Rented
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $property->status }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}

                                <td>

                                    {{-- View --}}

                                    <a
                                        href="{{ route('properties.show', $property) }}"
                                        class="btn btn-info btn-sm"
                                        title="View Property"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>


                                    @auth

                                        @if(auth()->id() === $property->user_id)

                                            {{-- Edit --}}

                                            <a
                                                href="{{ route('properties.edit', $property) }}"
                                                class="btn btn-warning btn-sm"
                                                title="Edit Property"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>


                                            {{-- Delete --}}

                                            <form
                                                action="{{ route('properties.destroy', $property) }}"
                                                method="POST"
                                                class="d-inline"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    title="Delete Property"
                                                    onclick="return confirm('Are you sure you want to delete this property?')"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        @endif

                                    @endauth

                                </td>

                            </tr>

                        @empty

                            {{-- Empty State --}}

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center py-5"
                                >

                                    <i class="bi bi-house-x display-1 text-secondary"></i>

                                    <h4 class="fw-bold mt-3">
                                        No Properties Found
                                    </h4>

                                    <p class="text-muted">
                                        No properties match your current search criteria.
                                    </p>

                                    <a
                                        href="{{ route('properties.index') }}"
                                        class="btn btn-primary mt-2"
                                    >
                                        <i class="bi bi-arrow-clockwise me-2"></i>
                                        Reset Filters
                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                Pagination
            ================================================== --}}

            @if($properties->hasPages())

                <div class="d-flex justify-content-center mt-4">

                    {{ $properties->links() }}

                </div>

            @endif

        </div>

    </div>


    {{-- =========================================================
        Quick Actions
    ========================================================== --}}

    @auth

        @if(auth()->user()->isLandlord())

            <div class="row mt-5">

                {{-- Add Property --}}

                <div class="col-md-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body text-center">

                            <i class="bi bi-plus-circle-fill display-4 text-primary"></i>

                            <h5 class="mt-3">
                                Add New Property
                            </h5>

                            <p class="text-muted">
                                Publish a new property for rent or sale.
                            </p>

                            <a
                                href="{{ route('properties.create') }}"
                                class="btn btn-primary"
                            >
                                Add Property
                            </a>

                        </div>

                    </div>

                </div>


                {{-- Browse Properties --}}

                <div class="col-md-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body text-center">

                            <i class="bi bi-search display-4 text-success"></i>

                            <h5 class="mt-3">
                                Browse Properties
                            </h5>

                            <p class="text-muted">
                                Search and view available properties.
                            </p>

                            <a
                                href="{{ route('properties.index') }}"
                                class="btn btn-success"
                            >
                                View List
                            </a>

                        </div>

                    </div>

                </div>


                {{-- Refresh --}}

                <div class="col-md-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body text-center">

                            <i class="bi bi-arrow-repeat display-4 text-warning"></i>

                            <h5 class="mt-3">
                                Refresh
                            </h5>

                            <p class="text-muted">
                                Reload the latest property information.
                            </p>

                            <a
                                href="{{ route('properties.index') }}"
                                class="btn btn-warning"
                            >
                                Refresh
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @endif

    @endauth

</div>

@endsection