@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

<div class="container py-5">

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

    <div class="row g-4">

        <!-- Total Properties -->
        <div class="col-md-3">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="bi bi-buildings display-4 text-primary"></i>

                    <h5 class="mt-3">

                        Total Properties

                    </h5>

                    <h2>

                        {{ \App\Models\Property::count() }}

                    </h2>

                </div>

            </div>

        </div>

        <!-- Available -->
        <div class="col-md-3">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="bi bi-house-check display-4 text-success"></i>

                    <h5 class="mt-3">

                        Available

                    </h5>

                    <h2>

                        {{ \App\Models\Property::where('status','Available')->count() }}

                    </h2>

                </div>

            </div>

        </div>

        <!-- Rented -->
        <div class="col-md-3">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="bi bi-house-x display-4 text-danger"></i>

                    <h5 class="mt-3">

                        Rented

                    </h5>

                    <h2>

                        {{ \App\Models\Property::where('status','Rented')->count() }}

                    </h2>

                </div>

            </div>

        </div>

        <!-- User -->
        <div class="col-md-3">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="bi bi-person-circle display-4 text-warning"></i>

                    <h5 class="mt-3">

                        Logged User

                    </h5>

                    <h6>

                        {{ Auth::user()->name }}

                    </h6>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                Recent Properties

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                    <tr>

                        <th>Title</th>

                        <th>Type</th>

                        <th>City</th>

                        <th>Status</th>

                        <th>Price</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach(\App\Models\Property::latest()->take(5)->get() as $property)

                        <tr>

                            <td>{{ $property->title }}</td>

                            <td>{{ $property->property_type }}</td>

                            <td>{{ $property->city }}</td>

                            <td>

                                @if($property->status=='Available')

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

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection