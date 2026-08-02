@extends('layouts.master')

@section('title', 'My Booking Requests')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            <i class="bi bi-calendar-check-fill text-primary me-2"></i>

            My Booking Requests

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

                            <th>Landlord</th>

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

                                <td>{{ $booking->landlord->name }}</td>

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

                                    <a href="{{ route('tenant.bookings.show', $booking->id) }}"
                                       class="btn btn-info btn-sm">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    @if($booking->status == 'Pending')

                                        <form action="{{ route('tenant.bookings.destroy', $booking->id) }}"
                                              method="POST"
                                              class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Cancel this booking?')">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

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