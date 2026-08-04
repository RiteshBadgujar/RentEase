@extends('layouts.master')

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

    </div>

    <!-- Statistics -->

    <div class="row g-4 mb-4">

        <div class="col-lg-3">

            <div class="card border-0 shadow rounded-4">

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

            <div class="card border-0 shadow rounded-4">

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

            <div class="card border-0 shadow rounded-4">

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

            <div class="card border-0 shadow rounded-4">

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

    <div class="card border-0 shadow rounded-4 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search property..."
                            value="{{ request('search') }}">

                    </div>

                    <div class="col-md-3">

                        <select
                            name="status"
                            class="form-select">

                            <option value="">

                                All Status

                            </option>

                            <option value="Available">

                                Available

                            </option>

                            <option value="Rented">

                                Rented

                            </option>

                            <option value="Pending">

                                Pending

                            </option>

                        </select>

                    </div>

                    <div class="col-md-3">

                        <button
                            class="btn btn-primary w-100">

                            <i class="bi bi-search me-2"></i>

                            Search

                        </button>

                    </div>

                    <div class="col-md-2">

                        <a
                            href="{{ route('admin.properties.index') }}"
                            class="btn btn-secondary w-100">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Property Table -->

    <div class="card border-0 shadow rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>#</th>

                            <th>Image</th>

                            <th>Title</th>

                            <th>Owner</th>

                            <th>City</th>

                            <th>Price</th>

                            <th>Status</th>

                            <th width="170">

                                Action

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($properties as $property)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                @if($property->image)

                                    <img
                                        src="{{ asset('storage/'.$property->image) }}"
                                        width="70"
                                        class="rounded">

                                @else

                                    <span class="text-muted">

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

                                {{ $property->user->name ?? 'N/A' }}

                            </td>

                            <td>

                                {{ $property->city }}

                            </td>

                            <td>

                                ₹{{ number_format($property->price) }}

                            </td>

                            <td>

                                @if($property->status=='Available')

                                    <span class="badge bg-success">

                                        Available

                                    </span>

                                @elseif($property->status=='Rented')

                                    <span class="badge bg-danger">

                                        Rented

                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark">

                                        Pending

                                    </span>

                                @endif

                            </td>

                            <td>

                                <a
                                    href="{{ route('admin.properties.show',$property) }}"
                                    class="btn btn-info btn-sm">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <a
                                    href="{{ route('admin.properties.edit',$property) }}"
                                    class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form
                                    action="{{ route('admin.properties.destroy',$property) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this property?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8" class="text-center py-5">

                                <i class="bi bi-house display-3 text-muted"></i>

                                <p class="mt-3">

                                    No properties found.

                                </p>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $properties->links() }}

            </div>

        </div>

    </div>

</div>

@endsection