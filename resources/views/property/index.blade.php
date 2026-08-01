@extends('layouts.master')

@section('title', 'Property Management')

@section('content')

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                Property Management
            </h2>

            <a href="{{ route('properties.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>

                Add Property

            </a>

        </div>

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        @endif
        <!-- Search & Filter -->
        <div class="card shadow border-0 mb-4">

            <div class="card-header bg-light">

                <h5 class="mb-0">

                    <i class="bi bi-search me-2"></i>

                    Search Properties

                </h5>

            </div>

            <div class="card-body">

                <form action="{{ route('properties.index') }}" method="GET">

                    <div class="row">

                        <!-- Title -->
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Property Title
                            </label>

                            <input type="text" name="title" value="{{ request('title') }}" class="form-control"
                                placeholder="Property Title">

                        </div>

                        <!-- City -->
                        <div class="col-md-2 mb-3">

                            <label class="form-label">
                                City
                            </label>

                            <input type="text" name="city" value="{{ request('city') }}" class="form-control"
                                placeholder="City">

                        </div>

                        <!-- Property Type -->
                        <div class="col-md-2 mb-3">

                            <label class="form-label">
                                Type
                            </label>

                            <select name="property_type" class="form-select">

                                <option value="">All</option>

                                <option value="Apartment" {{ request('property_type') == 'Apartment' ? 'selected' : '' }}>
                                    Apartment
                                </option>

                                <option value="Villa" {{ request('property_type') == 'Villa' ? 'selected' : '' }}>
                                    Villa
                                </option>

                                <option value="House" {{ request('property_type') == 'House' ? 'selected' : '' }}>
                                    House
                                </option>

                                <option value="Office" {{ request('property_type') == 'Office' ? 'selected' : '' }}>
                                    Office
                                </option>

                                <option value="Shop" {{ request('property_type') == 'Shop' ? 'selected' : '' }}>
                                    Shop
                                </option>

                                <option value="Land" {{ request('property_type') == 'Land' ? 'selected' : '' }}>
                                    Land
                                </option>

                            </select>

                        </div>

                        <!-- Purpose -->
                        <div class="col-md-2 mb-3">

                            <label class="form-label">
                                Purpose
                            </label>

                            <select name="purpose" class="form-select">

                                <option value="">All</option>

                                <option value="Rent" {{ request('purpose') == 'Rent' ? 'selected' : '' }}>
                                    Rent
                                </option>

                                <option value="Sale" {{ request('purpose') == 'Sale' ? 'selected' : '' }}>
                                    Sale
                                </option>

                            </select>

                        </div>

                        <!-- Status -->
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="status" class="form-select">

                                <option value="">All</option>

                                <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>
                                    Available
                                </option>

                                <option value="Rented" {{ request('status') == 'Rented' ? 'selected' : '' }}>
                                    Rented
                                </option>

                            </select>

                        </div>

                        <!-- Minimum Price -->
                        <div class="col-md-2 mb-3">

                            <label class="form-label">
                                Min Price
                            </label>

                            <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control"
                                placeholder="10000">

                        </div>

                        <!-- Maximum Price -->
                        <div class="col-md-2 mb-3">

                            <label class="form-label">
                                Max Price
                            </label>

                            <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control"
                                placeholder="50000">

                        </div>

                        <!-- Bedrooms -->
                        <div class="col-md-2 mb-3">

                            <label class="form-label">
                                Bedrooms
                            </label>

                            <select name="bedrooms" class="form-select">

                                <option value="">All</option>

                                @for($i = 1; $i <= 10; $i++)

                                    <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>

                                        {{ $i }}

                                    </option>

                                @endfor

                            </select>

                        </div>

                        <!-- Bathrooms -->
                        <div class="col-md-2 mb-3">

                            <label class="form-label">
                                Bathrooms
                            </label>

                            <select name="bathrooms" class="form-select">

                                <option value="">All</option>

                                @for($i = 1; $i <= 10; $i++)

                                    <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>

                                        {{ $i }}

                                    </option>

                                @endfor

                            </select>

                        </div>

                        <!-- Sort -->
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Sort By
                            </label>

                            <select name="sort" class="form-select">

                                <option value="">Latest</option>

                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                    Price: Low to High
                                </option>

                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                    Price: High to Low
                                </option>

                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    Oldest
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="text-end">

                        <a href="{{ route('properties.index') }}" class="btn btn-secondary">

                            Reset

                        </a>

                        <button type="submit" class="btn btn-primary">

                            Search

                        </button>

                    </div>
                </form>

            </div>

        </div> 


        <div class="card shadow border-0">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>#</th>

                                <th>Image</th>

                                <th>Title</th>

                                <th>Type</th>

                                <th>Purpose</th>

                                <th>Price</th>

                                <th>City</th>

                                <th>Status</th>

                                <th width="180">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($properties as $property)

                                <tr>

                                    <td>{{ $properties->firstItem() + $loop->index }}</td>

                                    <td>

                                        @if($property->image)

                                            <img src="{{ asset('uploads/properties/' . $property->image) }}" width="80"
                                                class="rounded shadow">

                                        @else

                                            <span class="badge bg-secondary">
                                                No Image
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <strong>

                                            {{ $property->title }}

                                        </strong>

                                    </td>

                                    <td>

                                        {{ $property->property_type }}

                                    </td>

                                    <td>

                                        {{ $property->purpose }}

                                    </td>

                                    <td>

                                        ₹{{ number_format($property->price) }}

                                    </td>

                                    <td>

                                        {{ $property->city }}

                                    </td>

                                    <td>

                                        @if($property->status == 'Available')

                                            <span class="badge bg-success">

                                                Available

                                            </span>

                                        @else

                                            <span class="badge bg-danger">

                                                Rented

                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <a href="{{ route('properties.show', $property->id) }}" class="btn btn-info btn-sm">

                                            View

                                        </a>

                                        <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-warning btn-sm">

                                            Edit

                                        </a>

                                        <form action="{{ route('properties.destroy', $property->id) }}" method="POST"
                                            class="d-inline">

                                            @csrf

                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this property?')">

                                                Delete

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="9" class="text-center py-5">

                                        <h5>

                                            No Properties Found

                                        </h5>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">

                    {{ $properties->links() }}

                </div>

            </div>

        </div>

    </div>

@endsection