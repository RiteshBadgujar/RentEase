@extends('layouts.master')

@section('title', 'Edit User')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-lg rounded-4">

                <div class="card-header bg-warning text-dark py-3">

                    <h3 class="mb-0">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit User

                    </h3>

                </div>

                <div class="card-body p-5">

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form action="{{ route('admin.users.update', $user) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Full Name

                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control form-control-lg"
                                value="{{ old('name', $user->name) }}"
                                required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Email Address

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control form-control-lg"
                                value="{{ old('email', $user->email) }}"
                                required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                User Role

                            </label>

                            <select
                                name="role"
                                class="form-select form-select-lg">

                                <option value="admin"
                                    {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>

                                    Admin

                                </option>

                                <option value="landlord"
                                    {{ old('role', $user->role) == 'landlord' ? 'selected' : '' }}>

                                    Landlord

                                </option>

                                <option value="tenant"
                                    {{ old('role', $user->role) == 'tenant' ? 'selected' : '' }}>

                                    Tenant

                                </option>

                            </select>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('admin.users.index') }}"
                               class="btn btn-secondary btn-lg">

                                <i class="bi bi-arrow-left me-2"></i>

                                Back

                            </a>

                            <button
                                type="submit"
                                class="btn btn-success btn-lg">

                                <i class="bi bi-check-circle me-2"></i>

                                Update User

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection