@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-calendar-check-fill text-primary me-2"></i>

                    Booking Details

                </h2>

                <p class="text-muted mb-0">

                    Complete booking information.

                </p>

            </div>

            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left me-2"></i>

                Back

            </a>

        </div>

        <div class="row">

            <!-- Tenant Card -->

            <div class="col-lg-4 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-person-fill me-2"></i>

                            Tenant

                        </h5>

                    </div>

                    <div class="card-body text-center">

                        <div class="rounded-circle bg-primary text-white d-inline-flex justify-content-center align-items-center mb-3"
                            style="width:80px;height:80px;font-size:32px;">

                            {{ strtoupper(substr($booking->tenant->name ?? 'N', 0, 1)) }}

                        </div>

                        <h5>

                            {{ $booking->tenant->name ?? 'N/A' }}

                        </h5>

                        <p class="text-muted">

                            {{ $booking->tenant->email ?? 'N/A' }}

                        </p>

                    </div>

                </div>

            </div>

            <!-- Landlord Card -->

            <div class="col-lg-4 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-success text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-person-workspace me-2"></i>

                            Landlord

                        </h5>

                    </div>

                    <div class="card-body text-center">

                        <div class="rounded-circle bg-success text-white d-inline-flex justify-content-center align-items-center mb-3"
                            style="width:80px;height:80px;font-size:32px;">

                            {{ strtoupper(substr($booking->landlord->name ?? 'N', 0, 1)) }}

                        </div>

                        <h5>

                            {{ $booking->landlord->name ?? 'N/A' }}

                        </h5>

                        <p class="text-muted">

                            {{ $booking->landlord->email ?? 'N/A' }}

                        </p>

                    </div>

                </div>

            </div>

            <!-- Property Card -->

            <div class="col-lg-4 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-info text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-house-door-fill me-2"></i>

                            Property

                        </h5>

                    </div>

                    <div class="card-body">

                        <h5>

                            {{ $booking->property->title ?? 'N/A' }}

                        </h5>

                        <p class="text-muted">

                            {{ $booking->property->city ?? 'N/A' }}

                        </p>

                        <h4 class="text-success">

                            ₹{{ number_format($booking->property->price ?? 0) }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>

        <!-- Booking Information -->

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-dark text-white">

                <h5 class="mb-0">

                    <i class="bi bi-info-circle me-2"></i>

                    Booking Information

                </h5>

            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">

                        <table class="table table-borderless">

                            <tr>

                                <th width="40%">

                                    Booking ID

                                </th>

                                <td>

                                    #{{ $booking->id }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Status

                                </th>

                                <td>

                                    @php

                                        $badge = [

                                            'Pending' => 'warning',

                                            'Approved' => 'success',

                                            'Rejected' => 'danger',

                                            'Completed' => 'primary'

                                        ];

                                    @endphp

                                    <span class="badge bg-{{ $badge[$booking->status] ?? 'secondary' }}">

                                        {{ $booking->status }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Created

                                </th>

                                <td>

                                    {{ $booking->created_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Last Updated

                                </th>

                                <td>

                                    {{ $booking->updated_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                        </table>

                    </div>

                    <div class="col-md-6">

                        <table class="table table-borderless">

                            <tr>

                                <th width="40%">

                                    Property

                                </th>

                                <td>

                                    {{ $booking->property->title ?? 'N/A' }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    City

                                </th>

                                <td>

                                    {{ $booking->property->city ?? 'N/A' }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Price

                                </th>

                                <td>

                                    ₹{{ number_format($booking->property->price ?? 0) }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Tenant

                                </th>

                                <td>

                                    {{ $booking->tenant->name ?? 'N/A' }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-between">

                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left me-2"></i>

                        Back

                    </a>

                    <div>

                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning me-2">

                            <i class="bi bi-pencil-square me-2"></i>

                            Edit Booking

                        </a>

                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
                            class="delete-form d-inline">

                            @csrf

                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">

                                <i class="bi bi-trash me-2"></i>

                                Delete

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection