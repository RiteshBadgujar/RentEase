@extends('layouts.master')

@section('title', 'Notifications')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            <i class="bi bi-bell-fill text-warning me-2"></i>

            Notifications

        </h2>

    </div>

    <div class="card shadow border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Title</th>

                            <th>Message</th>

                            <th>Type</th>

                            <th>Status</th>

                            <th>Date</th>

                            <th width="140">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($notifications as $notification)

                            <tr class="{{ !$notification->is_read ? 'table-warning' : '' }}">

                                <td>

                                    @if(method_exists($notifications, 'firstItem'))

                                        {{ $notifications->firstItem() + $loop->index }}

                                    @else

                                        {{ $loop->iteration }}

                                    @endif

                                </td>

                                <td>

                                    <strong>{{ $notification->title }}</strong>

                                </td>

                                <td>

                                    {{ \Illuminate\Support\Str::limit($notification->message, 50) }}

                                </td>

                                <td>

                                    <span class="badge bg-info">

                                        {{ $notification->type }}

                                    </span>

                                </td>

                                <td>

                                    @if($notification->is_read)

                                        <span class="badge bg-success">

                                            Read

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            Unread

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <small>

                                        {{ $notification->created_at->format('d M Y h:i A') }}

                                    </small>

                                    <br>

                                    <small class="text-muted">

                                        {{ $notification->created_at->diffForHumans() }}

                                    </small>

                                </td>

                                <td>

                                    <a
                                        href="{{ route('notifications.show', $notification->id) }}"
                                        class="btn btn-primary btn-sm"
                                        title="View Notification">

                                        <i class="bi bi-eye"></i>

                                    </a>

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
                                            onclick="return confirm('Delete this notification?')">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7">

                                    <div class="text-center py-5">

                                        <i class="bi bi-bell-slash display-1 text-secondary"></i>

                                        <h5 class="mt-3">

                                            No Notifications Found

                                        </h5>

                                        <p class="text-muted mb-0">

                                            You're all caught up.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if(method_exists($notifications, 'links'))

                <div class="mt-4">

                    {{ $notifications->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection