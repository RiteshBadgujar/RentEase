@extends('layouts.admin')

@section('title', 'Edit Booking')

@section('content')

    <div class="container-fluid py-4">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-warning">

                        <h4 class="mb-0">

                            <i class="bi bi-pencil-square me-2"></i>

                            Edit Booking

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

                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">

                            @csrf

                            @method('PUT')

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">

                                        Booking ID

                                    </label>

                                    <input type="text" class="form-control" value="#{{ $booking->id }}" readonly>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">

                                        Booking Date

                                    </label>

                                    <input type="text" class="form-control"
                                        value="{{ $booking->created_at->format('d M Y') }}" readonly>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">

                                        Tenant

                                    </label>

                                    <input type="text" class="form-control" value="{{ $booking->tenant->name ?? 'N/A' }}"
                                        readonly>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">

                                        Landlord

                                    </label>

                                    <input type="text" class="form-control" value="{{ $booking->landlord->name ?? 'N/A' }}"
                                        readonly>

                                </div>

                                <div class="col-12 mb-3">

                                    <label class="form-label fw-bold">

                                        Property

                                    </label>

                                    <input type="text" class="form-control" value="{{ $booking->property->title ?? 'N/A' }}"
                                        readonly>

                                </div>
                                <div class="col-md-12 mb-4">

                                    <label class="form-label fw-bold">

                                        Booking Status

                                    </label>

                                    <select name="status" class="form-select @error('status') is-invalid @enderror"
                                        required>

                                        <option value="Pending" {{ old('status', $booking->status) == 'Pending' ? 'selected' : '' }}>

                                            Pending

                                        </option>

                                        <option value="Approved" {{ old('status', $booking->status) == 'Approved' ? 'selected' : '' }}>

                                            Approved

                                        </option>

                                        <option value="Rejected" {{ old('status', $booking->status) == 'Rejected' ? 'selected' : '' }}>

                                            Rejected

                                        </option>

                                        <option value="Completed" {{ old('status', $booking->status) == 'Completed' ? 'selected' : '' }}>

                                            Completed

                                        </option>

                                    </select>

                                    @error('status')

                                        <div class="invalid-feedback">

                                            {{ $message }}

                                        </div>

                                    @enderror

                                </div>

                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">

                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">

                                    <i class="bi bi-arrow-left me-2"></i>

                                    Back

                                </a>

                                <div>

                                    <button type="reset" class="btn btn-outline-dark me-2">

                                        <i class="bi bi-arrow-clockwise me-2"></i>

                                        Reset

                                    </button>

                                    <button type="submit" class="btn btn-success">

                                        <i class="bi bi-check-circle-fill me-2"></i>

                                        Update Booking

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