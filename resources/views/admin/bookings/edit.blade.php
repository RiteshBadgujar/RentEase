@extends('layouts.master')

@section('title', 'Edit Booking')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0 rounded-4">

                <div class="card-header bg-warning text-dark">

                    <h3 class="mb-0">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Booking

                    </h3>

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

                    <form action="{{ route('admin.bookings.update',$booking) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Tenant

                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $booking->tenant->name ?? 'N/A' }}"
                                   readonly>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Property

                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $booking->property->title ?? 'N/A' }}"
                                   readonly>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Booking Status

                            </label>

                            <select name="status"
                                    class="form-select">

                                <option value="Pending"
                                    {{ $booking->status=='Pending'?'selected':'' }}>

                                    Pending

                                </option>

                                <option value="Approved"
                                    {{ $booking->status=='Approved'?'selected':'' }}>

                                    Approved

                                </option>

                                <option value="Rejected"
                                    {{ $booking->status=='Rejected'?'selected':'' }}>

                                    Rejected

                                </option>

                                <option value="Completed"
                                    {{ $booking->status=='Completed'?'selected':'' }}>

                                    Completed

                                </option>

                            </select>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('admin.bookings.index') }}"
                               class="btn btn-secondary">

                                <i class="bi bi-arrow-left me-2"></i>

                                Back

                            </a>

                            <button class="btn btn-success">

                                <i class="bi bi-check-circle me-2"></i>

                                Update Booking

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection