@extends('layouts.master')

@section('title', 'Booking Management')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                <i class="bi bi-calendar-check-fill text-primary me-2"></i>
                Booking Management
            </h2>

            <p class="text-muted">
                Manage all property bookings.
            </p>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card shadow border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>#</th>

                            <th>Tenant</th>

                            <th>Landlord</th>

                            <th>Property</th>

                            <th>Status</th>

                            <th>Booked On</th>

                            <th width="180">

                                Action

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($bookings as $booking)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $booking->tenant->name ?? 'N/A' }}

                            </td>

                            <td>

                                {{ $booking->landlord->name ?? 'N/A' }}

                            </td>

                            <td>

                                {{ $booking->property->title ?? 'N/A' }}

                            </td>

                            <td>

                                @if($booking->status=='Pending')

                                    <span class="badge bg-warning text-dark">

                                        Pending

                                    </span>

                                @elseif($booking->status=='Approved')

                                    <span class="badge bg-success">

                                        Approved

                                    </span>

                                @elseif($booking->status=='Rejected')

                                    <span class="badge bg-danger">

                                        Rejected

                                    </span>

                                @else

                                    <span class="badge bg-info">

                                        Completed

                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $booking->created_at->format('d M Y') }}

                            </td>

                            <td>

                                <a href="{{ route('admin.bookings.show',$booking) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <a href="{{ route('admin.bookings.edit',$booking) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form action="{{ route('admin.bookings.destroy',$booking) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete booking?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-5">

                                No bookings found.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $bookings->links() }}

            </div>

        </div>

    </div>

</div>

@endsection