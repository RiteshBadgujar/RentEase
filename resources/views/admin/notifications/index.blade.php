@extends('layouts.master')

@section('title', 'Notification Management')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                <i class="bi bi-bell-fill text-primary me-2"></i>

                Notification Management

            </h2>

            <p class="text-muted">

                Manage all system notifications.

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

                            <th>User</th>

                            <th>Title</th>

                            <th>Type</th>

                            <th>Status</th>

                            <th>Date</th>

                            <th width="180">

                                Action

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($notifications as $notification)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $notification->user->name ?? 'N/A' }}

                            </td>

                            <td>

                                {{ $notification->title }}

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

                                {{ $notification->created_at->format('d M Y') }}

                            </td>

                            <td>

                                <a href="{{ route('admin.notifications.show',$notification) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <a href="{{ route('admin.notifications.edit',$notification) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form action="{{ route('admin.notifications.destroy',$notification) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete notification?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                No notifications found.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $notifications->links() }}

            </div>

        </div>

    </div>

</div>

@endsection