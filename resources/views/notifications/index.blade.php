@extends('layouts.master')

@section('title', 'Notifications')

@section('content')

<div class="container py-5">

    <!-- ==========================
            Page Header
    =========================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-bell-fill text-warning me-2"></i>

                Notifications

            </h2>

            <p class="text-muted mb-0">

                View and manage your notifications.

            </p>

        </div>

    </div>


    <!-- ==========================
            Success Message
    =========================== -->

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <!-- ==========================
            Error Message
    =========================== -->

    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <!-- ==========================
            Notification Card
    =========================== -->

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header bg-light py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="bi bi-list-ul me-2"></i>

                    Notification List

                </h5>

                <span class="badge bg-primary">

                    {{ $notifications->total() }}

                    {{ $notifications->total() == 1 ? 'Notification' : 'Notifications' }}

                </span>

            </div>

        </div>


        <div class="card-body">

            <!-- ==========================
                    Notification Table
            =========================== -->

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="60">
                                #
                            </th>

                            <th>
                                Title
                            </th>

                            <th>
                                Message
                            </th>

                            <th>
                                Type
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Date
                            </th>

                            <th width="140">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($notifications as $notification)

                            <tr
                                class="{{ !$notification->is_read ? 'table-warning' : '' }}">

                                <!-- Serial Number -->

                                <td>

                                    {{ $notifications->firstItem() + $loop->index }}

                                </td>


                                <!-- Title -->

                                <td>

                                    <strong>

                                        {{ $notification->title }}

                                    </strong>

                                </td>


                                <!-- Message -->

                                <td style="max-width: 300px;">

                                    <div
                                        class="text-truncate"
                                        style="max-width: 280px;"
                                        title="{{ $notification->message }}">

                                        {{ \Illuminate\Support\Str::limit(
                                            $notification->message,
                                            70
                                        ) }}

                                    </div>

                                </td>


                                <!-- Type -->

                                <td>

                                    <span class="badge bg-info">

                                        <i class="bi bi-tag me-1"></i>

                                        {{ $notification->type }}

                                    </span>

                                </td>


                                <!-- Status -->

                                <td>

                                    @if($notification->is_read)

                                        <span class="badge bg-success">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Read

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            <i class="bi bi-circle-fill me-1"></i>

                                            Unread

                                        </span>

                                    @endif

                                </td>


                                <!-- Date -->

                                <td>

                                    <span class="text-nowrap">

                                        {{ $notification->created_at->format('d M Y') }}

                                    </span>

                                    <small class="d-block text-muted">

                                        {{ $notification->created_at->format('h:i A') }}

                                    </small>

                                    <small class="d-block text-muted">

                                        {{ $notification->created_at->diffForHumans() }}

                                    </small>

                                </td>


                                <!-- Actions -->

                                <td>

                                    <!-- View -->

                                    <a
                                        href="{{ route('notifications.show', $notification->id) }}"
                                        class="btn btn-primary btn-sm"
                                        title="View Notification">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    <!-- Delete -->

                                    <form
                                        action="{{ route('notifications.destroy', $notification->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            title="Delete Notification"
                                            onclick="return confirm('Are you sure you want to delete this notification?')">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <!-- ==========================
                                    Empty State
                            =========================== -->

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5">

                                    <i class="bi bi-bell-slash display-1 text-secondary"></i>

                                    <h5 class="fw-bold mt-3">

                                        No Notifications Found

                                    </h5>

                                    <p class="text-muted mb-3">

                                        You're all caught up.

                                    </p>

                                    <a
                                        href="{{ route('dashboard') }}"
                                        class="btn btn-primary">

                                        <i class="bi bi-speedometer2 me-2"></i>

                                        Back to Dashboard

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- ==========================
                    Pagination
            =========================== -->

            @if($notifications->hasPages())

                <div class="d-flex justify-content-center mt-4">

                    {{ $notifications->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection