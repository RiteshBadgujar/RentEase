@extends('layouts.admin')

@section('title', 'Property Management')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-buildings-fill text-primary me-2"></i>

                    Property Management

                </h2>

                <p class="text-muted mb-0">

                    Manage all rental properties.

                </p>

            </div>

            <span class="badge bg-primary fs-6">

                {{ $totalProperties }} Properties

            </span>

        </div>

        <!-- Statistics -->

        <div class="row g-4 mb-4">

            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-house-fill display-5 text-primary"></i>

                        <h2 class="mt-3">

                            {{ $totalProperties }}

                        </h2>

                        <p class="text-muted mb-0">

                            Total Properties

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-check-circle-fill display-5 text-success"></i>

                        <h2 class="mt-3">

                            {{ $availableProperties }}

                        </h2>

                        <p class="text-muted mb-0">

                            Available

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-key-fill display-5 text-danger"></i>

                        <h2 class="mt-3">

                            {{ $rentedProperties }}

                        </h2>

                        <p class="text-muted mb-0">

                            Rented

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-clock-fill display-5 text-warning"></i>

                        <h2 class="mt-3">

                            {{ $pendingProperties }}

                        </h2>

                        <p class="text-muted mb-0">

                            Pending

                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- Search -->

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <form method="GET" action="{{ route('admin.properties.index') }}">

                    <div class="row g-3">

                        <div class="col-md-4">

                            <input type="text" name="search" class="form-control" placeholder="Search Property..."
                                value="{{ request('search') }}">

                        </div>

                        <div class="col-md-3">

                            <select name="property_type" class="form-select">

                                <option value="">

                                    All Types

                                </option>

                                <option value="Apartment" {{ request('property_type') == 'Apartment' ? 'selected' : '' }}>

                                    Apartment

                                </option>

                                <option value="House" {{ request('property_type') == 'House' ? 'selected' : '' }}>

                                    House

                                </option>

                                <option value="Villa" {{ request('property_type') == 'Villa' ? 'selected' : '' }}>

                                    Villa

                                </option>

                                <option value="PG" {{ request('property_type') == 'PG' ? 'selected' : '' }}>

                                    PG

                                </option>

                            </select>

                        </div>

                        <div class="col-md-3">

                            <select name="status" class="form-select">

                                <option value="">

                                    All Status

                                </option>

                                <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>

                                    Available

                                </option>

                                <option value="Rented" {{ request('status') == 'Rented' ? 'selected' : '' }}>

                                    Rented

                                </option>

                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>

                                    Pending

                                </option>

                            </select>

                        </div>

                        <div class="col-md-1 d-grid">

                            <button class="btn btn-primary">

                                <i class="bi bi-search"></i>

                            </button>

                        </div>

                        <div class="col-md-1 d-grid">

                            <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary">

                                Reset

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <!-- Property Table -->

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    <i class="bi bi-table me-2"></i>

                    Property List

                </h5>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle datatable">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>

                                <th>Image</th>

                                <th>Property</th>

                                <th>Owner</th>

                                <th>City</th>

                                <th>Price</th>

                                <th>Type</th>

                                <th>Status</th>

                                <th width="170">

                                    Actions

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($properties as $property)

                                @php

                                    $statusColor = [

                                        'Available' => 'success',

                                        'Rented' => 'danger',

                                        'Pending' => 'warning'

                                    ];

                                @endphp

                                <tr>

                                    <td>

                                        {{ $property->id }}

                                    </td>

                                    <td>

                                        @if($property->image)

                                            <img src="{{ asset('storage/' . $property->image) }}" class="rounded shadow-sm"
                                                style="width:70px;height:70px;object-fit:cover;">

                                        @else

                                            <div class="bg-light rounded d-flex justify-content-center align-items-center"
                                                style="width:70px;height:70px;">

                                                <i class="bi bi-image text-secondary fs-3"></i>

                                            </div>

                                        @endif

                                    </td>

                                    <td>

                                        <strong>

                                            {{ $property->title }}

                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ \Illuminate\Support\Str::limit($property->address, 40) }}

                                        </small>

                                    </td>

                                    <td>

                                        {{ $property->user->name ?? 'N/A' }}

                                    </td>

                                    <td>

                                        {{ $property->city }}

                                    </td>

                                    <td>

                                        ₹{{ number_format($property->price) }}

                                    </td>

                                    <td>

                                        <span class="badge bg-info">

                                            {{ $property->property_type }}

                                        </span>

                                    </td>

                                    <td>

                                        <span class="badge bg-{{ $statusColor[$property->status] ?? 'secondary' }}">

                                            {{ $property->status }}

                                        </span>

                                    </td>

                                    <td>

                                        <div class="btn-group">

                                            <a href="{{ route('admin.properties.show', $property) }}"
                                                class="btn btn-info btn-sm" title="View">

                                                <i class="bi bi-eye"></i>

                                            </a>

                                            <a href="{{ route('admin.properties.edit', $property) }}"
                                                class="btn btn-warning btn-sm" title="Edit">

                                                <i class="bi bi-pencil-square"></i>

                                            </a>

                                            <form action="{{ route('admin.properties.destroy', $property) }}" method="POST"
                                                class="delete-form d-inline">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>
                            @empty

                                <tr>

                                    <td colspan="9" class="text-center py-5">

                                        <i class="bi bi-buildings display-1 text-secondary"></i>

                                        <h4 class="mt-3">

                                            No Properties Available

                                        </h4>

                                        <p class="text-muted mb-0">

                                            There are currently no registered properties.

                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection