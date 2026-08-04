@extends('layouts.master')

@section('title', 'User Details')

@section('content')

<div class="container py-5">

    <div class="row">

        <div class="col-lg-4">

            <div class="card shadow border-0 rounded-4">

                <div class="card-body text-center">

                    <div class="mb-3">

                        <div class="rounded-circle bg-primary text-white d-inline-flex justify-content-center align-items-center"
                            style="width:120px;height:120px;font-size:45px;">

                            {{ strtoupper(substr($user->name,0,1)) }}

                        </div>

                    </div>

                    <h3 class="fw-bold">

                        {{ $user->name }}

                    </h3>

                    <p class="text-muted">

                        {{ $user->email }}

                    </p>

                    @if($user->role=='admin')

                        <span class="badge bg-danger px-3 py-2">

                            Admin

                        </span>

                    @elseif($user->role=='landlord')

                        <span class="badge bg-success px-3 py-2">

                            Landlord

                        </span>

                    @else

                        <span class="badge bg-primary px-3 py-2">

                            Tenant

                        </span>

                    @endif

                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="card shadow border-0 rounded-4">

                <div class="card-header bg-primary text-white">

                    <h4 class="mb-0">

                        User Information

                    </h4>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <strong>Name</strong>

                            <p>{{ $user->name }}</p>

                        </div>

                        <div class="col-md-6">

                            <strong>Email</strong>

                            <p>{{ $user->email }}</p>

                        </div>

                        <div class="col-md-6">

                            <strong>Role</strong>

                            <p>{{ ucfirst($user->role) }}</p>

                        </div>

                        <div class="col-md-6">

                            <strong>Joined</strong>

                            <p>

                                {{ $user->created_at->format('d M Y h:i A') }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <div class="row mt-4">

                <div class="col-md-4">

                    <div class="card text-center shadow border-0">

                        <div class="card-body">

                            <i class="bi bi-buildings-fill display-5 text-primary"></i>

                            <h2 class="mt-2">

                                {{ $user->properties()->count() }}

                            </h2>

                            <p class="mb-0">

                                Properties

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card text-center shadow border-0">

                        <div class="card-body">

                            <i class="bi bi-calendar-check-fill display-5 text-success"></i>

                            <h2 class="mt-2">

                                {{ $user->tenantBookings()->count() }}

                            </h2>

                            <p class="mb-0">

                                Bookings

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card text-center shadow border-0">

                        <div class="card-body">

                            <i class="bi bi-heart-fill display-5 text-danger"></i>

                            <h2 class="mt-2">

                                {{ $user->wishlists()->count() }}

                            </h2>

                            <p class="mb-0">

                                Wishlist

                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <div class="mt-4">

                <a href="{{ route('admin.users.edit',$user) }}"
                    class="btn btn-warning">

                    <i class="bi bi-pencil-square me-2"></i>

                    Edit User

                </a>

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