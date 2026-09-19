@extends('layouts.master')

@section('title', 'My Properties')

@section('content')

<div class="container py-5">

    {{-- ==========================
         Header
    =========================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-buildings-fill text-primary me-2"></i>
                My Properties
            </h2>

            <p class="text-muted mb-0">
                Manage your rental properties.
            </p>
        </div>

        <a
            href="{{ route('properties.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-circle me-1"></i>
            Add Property

        </a>

    </div>


    {{-- ==========================
         Session Messages
    =========================== --}}

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


    @if($errors->any())

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ==========================
         Search / Filter
    =========================== --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('properties.my') }}">

                <div class="row g-3">

                    {{-- Title --}}

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Property
                        </label>

                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            placeholder="Search property..."
                            value="{{ request('title') }}">

                    </div>


                    {{-- City --}}

                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            City
                        </label>

                        <input
                            type="text"
                            name="city"
                            class="form-control"
                            placeholder="Search city..."
                            value="{{ request('city') }}">

                    </div>


                    {{-- Status --}}

                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="Available"
                                {{ request('status') === 'Available' ? 'selected' : '' }}>

                                Available

                            </option>

                            <option
                                value="Rented"
                                {{ request('status') === 'Rented' ? 'selected' : '' }}>

                                Rented

                            </option>

                            <option
                                value="Pending"
                                {{ request('status') === 'Pending' ? 'selected' : '' }}>

                                Pending

                            </option>

                        </select>

                    </div>


                    {{-- Search --}}

                    <div class="col-md-1 d-grid">

                        <label class="form-label">
                            &nbsp;
                        </label>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-search"></i>

                        </button>

                    </div>


                    {{-- Reset --}}

                    <div class="col-md-1 d-grid">

                        <label class="form-label">
                            &nbsp;
                        </label>

                        <a
                            href="{{ route('properties.my') }}"
                            class="btn btn-secondary">

                            <i class="bi bi-arrow-clockwise"></i>

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ==========================
         Property List
    =========================== --}}

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="fw-bold mb-0">

                    <i class="bi bi-table me-2"></i>

                    Property List

                </h5>

                <span class="badge bg-primary">

                    {{ $properties->total() }}

                    {{ $properties->total() === 1 ? 'Property' : 'Properties' }}

                </span>

            </div>

        </div>


        <div class="card-body">

            @forelse($properties as $property)

                <div class="card border mb-3 shadow-sm">

                    <div class="card-body">

                        <div class="row align-items-center g-3">

                            {{-- Image --}}

                            <div class="col-md-2">

                                @if($property->image)

                                    <img
                                        src="{{ $property->image_url }}"
                                        alt="{{ $property->title }}"
                                        class="img-fluid rounded"
                                        style="width:100%; height:130px; object-fit:cover;">

                                @else

                                    <div
                                        class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="width:100%; height:130px;">

                                        <i class="bi bi-house-door display-5 text-secondary"></i>

                                    </div>

                                @endif

                            </div>


                            {{-- Property Information --}}

                            <div class="col-md-4">

                                <h5 class="fw-bold mb-2">

                                    {{ $property->title }}

                                </h5>

                                <p class="text-muted mb-2">

                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>

                                    {{ $property->city }},
                                    {{ $property->state }}

                                </p>

                                <p class="mb-2">

                                    <i class="bi bi-house-door me-1"></i>

                                    {{ $property->property_type }}

                                </p>

                                <p class="mb-0 text-primary fw-bold">

                                    ₹{{ number_format((float) $property->price, 2) }}

                                    @if($property->purpose === 'Rent')

                                        <small class="text-muted">
                                            / month
                                        </small>

                                    @endif

                                </p>

                            </div>


                            {{-- Status --}}

                            <div class="col-md-2 text-center">

                                @if($property->status === 'Available')

                                    <span class="badge bg-success fs-6">
                                        Available
                                    </span>

                                @elseif($property->status === 'Rented')

                                    <span class="badge bg-danger fs-6">
                                        Rented
                                    </span>

                                @elseif($property->status === 'Pending')

                                    <span class="badge bg-warning text-dark fs-6">
                                        Pending
                                    </span>

                                @else

                                    <span class="badge bg-secondary fs-6">
                                        {{ $property->status }}
                                    </span>

                                @endif

                            </div>


                            {{-- Actions --}}

                            <div class="col-md-4">

                                <div class="d-flex flex-wrap justify-content-md-end gap-2">

                                    {{-- View --}}

                                    <a
                                        href="{{ route('properties.show', $property->id) }}"
                                        class="btn btn-info btn-sm">

                                        <i class="bi bi-eye me-1"></i>
                                        View

                                    </a>


                                    {{-- Edit --}}

                                    <a
                                        href="{{ route('properties.edit', $property->id) }}"
                                        class="btn btn-warning btn-sm">

                                        <i class="bi bi-pencil-square me-1"></i>
                                        Edit

                                    </a>


                                    {{-- Delete --}}

                                    <form
                                        action="{{ route('properties.destroy', $property->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
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

            @empty

                <div class="text-center py-5">

                    <i class="bi bi-buildings display-1 text-secondary"></i>

                    <h4 class="mt-3">
                        No Properties Found
                    </h4>

                    <p class="text-muted">
                        You have not added any properties yet.
                    </p>

                    <a
                        href="{{ route('properties.create') }}"
                        class="btn btn-primary">

                        <i class="bi bi-plus-circle me-1"></i>
                        Add Your First Property

                    </a>

                </div>

            @endforelse


            {{-- Pagination --}}

            @if($properties->hasPages())

                <div class="mt-4">

                    {{ $properties->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection