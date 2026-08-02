@extends('layouts.master')

@section('title', 'Booking Requests')

@section('content')

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">

                <i class="bi bi-calendar-check-fill text-primary me-2"></i>

                Booking Requests

            </h2>

        </div>

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif

        <div class="card shadow border-0">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>
                                <th>Property</th>
                                <th>Tenant</th>
                                <th>Visit Date</th>
                                <th>Visit Time</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($bookings as $booking)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $booking->property->title }}</td>

                                    <td>{{ $booking->tenant->name }}</td>

                                    <td>{{ $booking->visit_date }}</td>

                                    <td>{{ $booking->visit_time }}</td>

                                    <td>

                                        @if($booking->status == 'Pending')

                                            <span class="badge bg-warning text-dark">

                                                Pending

                                            </span>

                                        @elseif($booking->status == 'Approved')

                                            <span class="badge bg-success">

                                                Approved

                                            </span>

                                        @elseif($booking->status == 'Rejected')

                                            <span class="badge bg-danger">

                                                Rejected

                                            </span>

                                        @else

                                            <span class="badge bg-primary">

                                                Completed

                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if($booking->status == 'Pending')

                                            <!-- Approve -->

                                            <form action="{{ route('bookings.update', $booking->id) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden" name="status" value="Approved">

                                                <button type="submit" class="btn btn-success btn-sm">

                                                    <i class="bi bi-check-circle"></i>

                                                </button>

                                            </form>

                                            <!-- Reject -->

                                            <form action="{{ route('bookings.update', $booking->id) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden" name="status" value="Rejected">

                                                <button type="submit" class="btn btn-danger btn-sm">

                                                    <i class="bi bi-x-circle"></i>

                                                </button>

                                            </form>

                                        @elseif($booking->status == 'Approved')

                                            <!-- Complete -->

                                            <form action="{{ route('bookings.update', $booking->id) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden" name="status" value="Completed">

                                                <button type="submit" class="btn btn-primary btn-sm">

                                                    <i class="bi bi-check2-all"></i>

                                                </button>

                                            </form>

                                        @else

                                            <span class="text-muted">

                                                No Action

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-4">

                                        No Booking Requests Found.

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