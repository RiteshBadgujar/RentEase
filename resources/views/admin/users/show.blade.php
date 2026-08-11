@extends('layouts.admin')

@section('title', 'User Details')

@section('content')

@php

$badge = [
    'admin' => 'danger',
    'landlord' => 'success',
    'tenant' => 'primary'
];

@endphp

<div class="container-fluid">

    <div class="row">

        <!-- Profile -->

        <div class="col-lg-4 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center fw-bold mb-3"
                         style="width:120px;height:120px;font-size:48px;">

                        {{ strtoupper(substr($user->name,0,1)) }}

                    </div>

                    <h3 class="fw-bold">

                        {{ $user->name }}

                    </h3>

                    <p class="text-muted">

                        {{ $user->email }}

                    </p>

                    <span class="badge bg-{{ $badge[$user->role] ?? 'secondary' }} fs-6">

                        {{ ucfirst($user->role) }}

                    </span>

                </div>

            </div>

        </div>

        <!-- Information -->

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-primary text-white">

                    <h4 class="mb-0">

                        <i class="bi bi-person-vcard me-2"></i>

                        User Information

                    </h4>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <strong>User ID</strong>

                            <p class="mb-0">

                                #{{ $user->id }}

                            </p>

                        </div>

                        <div class="col-md-6 mb-3">

                            <strong>Name</strong>

                            <p class="mb-0">

                                {{ $user->name }}

                            </p>

                        </div>

                        <div class="col-md-6 mb-3">

                            <strong>Email</strong>

                            <p class="mb-0">

                                {{ $user->email }}

                            </p>

                        </div>

                        <div class="col-md-6 mb-3">

                            <strong>Role</strong>

                            <p class="mb-0">

                                <span class="badge bg-{{ $badge[$user->role] ?? 'secondary' }}">

                                    {{ ucfirst($user->role) }}

                                </span>

                            </p>

                        </div>

                        <div class="col-md-6 mb-3">

                            <strong>Joined On</strong>

                            <p class="mb-0">

                                {{ $user->created_at->format('d M Y') }}

                            </p>

                        </div>

                        <div class="col-md-6 mb-3">

                            <strong>Created Time</strong>

                            <p class="mb-0">

                                {{ $user->created_at->format('h:i A') }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Statistics -->

            <div class="row mt-4">

                <div class="col-md-4 mb-3">

                    <div class="card border-0 shadow-sm text-center h-100">

                        <div class="card-body">

                            <i class="bi bi-buildings-fill display-5 text-primary"></i>

                            <h2 class="mt-3">

                                {{ number_format($user->properties()->count()) }}

                            </h2>

                            <p class="mb-0">

                                Properties

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="card border-0 shadow-sm text-center h-100">

                        <div class="card-body">

                            <i class="bi bi-calendar-check-fill display-5 text-success"></i>

                            <h2 class="mt-3">

                                {{ number_format($user->tenantBookings()->count()) }}

                            </h2>

                            <p class="mb-0">

                                Bookings

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="card border-0 shadow-sm text-center h-100">

                        <div class="card-body">

                            <i class="bi bi-heart-fill display-5 text-danger"></i>

                            <h2 class="mt-3">

                                {{ number_format($user->wishlists()->count()) }}

                            </h2>

                            <p class="mb-0">

                                Wishlist

                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Actions -->

            <div class="mt-4">

                <a href="{{ route('admin.users.edit', $user) }}"
                   class="btn btn-warning">

                    <i class="bi bi-pencil-square me-2"></i>

                    Edit User

                </a>

                @if(auth()->id() != $user->id)

                <form action="{{ route('admin.users.destroy',$user) }}"
                      method="POST"
                      class="delete-form d-inline">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger">

                        <i class="bi bi-trash me-2"></i>

                        Delete

                    </button>

                </form>

                @endif

                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-secondary">

                    <i class="bi bi-arrow-left me-2"></i>

                    Back

                </a>

            </div>

        </div>

    </div>

</div>

@endsection