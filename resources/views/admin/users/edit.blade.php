@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')

@php

$badge = [
    'admin' => 'danger',
    'landlord' => 'success',
    'tenant' => 'primary'
];

@endphp

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-warning">

                    <h4 class="mb-0">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit User

                    </h4>

                </div>

                <div class="card-body">

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <div class="text-center mb-4">

                        <div class="rounded-circle bg-primary text-white fw-bold d-inline-flex align-items-center justify-content-center"
                             style="width:90px;height:90px;font-size:34px;">

                            {{ strtoupper(substr($user->name,0,1)) }}

                        </div>

                        <h4 class="mt-3">

                            {{ $user->name }}

                        </h4>

                        <span class="badge bg-{{ $badge[$user->role] ?? 'secondary' }}">

                            {{ ucfirst($user->role) }}

                        </span>

                    </div>

                    <form
                        action="{{ route('admin.users.update',$user) }}"
                        method="POST">

                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    User ID

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $user->id }}"
                                    readonly>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Full Name

                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name',$user->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    required>

                                @error('name')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Email Address

                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    autocomplete="email"
                                    value="{{ old('email',$user->email) }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    required>

                                @error('email')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Role

                                </label>

                                <select
                                    name="role"
                                    class="form-select">

                                    <option value="admin"
                                        {{ old('role',$user->role)=='admin'?'selected':'' }}>

                                        Admin

                                    </option>

                                    <option value="landlord"
                                        {{ old('role',$user->role)=='landlord'?'selected':'' }}>

                                        Landlord

                                    </option>

                                    <option value="tenant"
                                        {{ old('role',$user->role)=='tenant'?'selected':'' }}>

                                        Tenant

                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="mt-4 d-flex justify-content-between">

                            <a
                                href="{{ route('admin.users.index') }}"
                                class="btn btn-secondary">

                                <i class="bi bi-arrow-left me-2"></i>

                                Back

                            </a>

                            <div>

                                <button
                                    type="reset"
                                    class="btn btn-outline-secondary">

                                    <i class="bi bi-arrow-counterclockwise me-2"></i>

                                    Reset

                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-success">

                                    <i class="bi bi-check-circle me-2"></i>

                                    Update User

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection