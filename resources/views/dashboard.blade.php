@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

<div class="container py-5">

    <!-- Dashboard Heading -->
    <div class="row mb-4">

        <div class="col-md-12">

            <h2 class="fw-bold">

                <i class="bi bi-speedometer2 me-2 text-primary"></i>

                Dashboard

            </h2>

            <p class="text-muted">

                Welcome back,
                <strong>{{ Auth::user()->name }}</strong>

            </p>

        </div>

    </div>

    <!-- Statistics Cards -->
    <div class="row g-4">

        <!-- Total Properties -->
        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-buildings display-4 text-primary"></i>

                    <h5 class="mt-3">
                        Total Properties
                    </h5>

                    <h2 class="fw-bold">
                        {{ $totalProperties }}
                    </h2>

                </div>

            </div>

        </div>

        <!-- Available Properties -->
        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-house-check display-4 text-success"></i>

                    <h5 class="mt-3">
                        Available
                    </h5>

                    <h2 class="fw-bold">
                        {{ $availableProperties }}
                    </h2>

                </div>

            </div>

        </div>

        <!-- Rented Properties -->
        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-house-x display-4 text-danger"></i>

                    <h5 class="mt-3">
                        Rented
                    </h5>

                    <h2 class="fw-bold">
                        {{ $rentedProperties }}
                    </h2>

                </div>

            </div>

        </div>

        <!-- Total Property Value -->
        <div class="col-lg-3 col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-currency-rupee display-4 text-info"></i>

                    <h5 class="mt-3">
                        Total Value
                    </h5>

                    <h5 class="fw-bold">
                        ₹{{ number_format($totalValue) }}
                    </h5>

                </div>

            </div>

        </div>

    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">

        <div class="col-md-12">

            <a href="{{ route('properties.create') }}"
               class="btn btn-primary me-2">

                <i class="bi bi-plus-circle me-1"></i>

                Add Property

            </a>

            <a href="{{ route('properties.index') }}"
               class="btn btn-success me-2">

                <i class="bi bi-buildings me-1"></i>

                Manage Properties

            </a>

            <a href="{{ route('profile.edit') }}"
               class="btn btn-warning">

                <i class="bi bi-person-circle me-1"></i>

                Profile

            </a>

        </div>

    </div>

    <!-- Recent Properties -->
    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                <i class="bi bi-clock-history me-2"></i>

                Recent Properties

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Title</th>

                            <th>Type</th>

                            <th>City</th>

                            <th>Status</th>

                            <th>Price</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($recentProperties as $property)

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                <td>

                                    {{ $property->title }}

                                </td>

                                <td>

                                    {{ $property->property_type }}

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

                                    ₹{{ number_format($property->price) }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-4">

                                    No Properties Available

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