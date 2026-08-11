@extends('layouts.admin')

@section('title', 'Notification Management')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-bell-fill text-primary me-2"></i>

                    Notification Management

                </h2>

                <p class="text-muted mb-0">

                    Manage all system notifications.

                </p>

            </div>

        </div>

        <!-- Statistics -->

        <div class="row mb-4">

            <div class="col-lg-4 col-md-6 mb-3">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Total Notifications

                        </h6>

                        <h2 class="fw-bold text-primary">

                            {{ $totalNotifications }}

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-lg-4 col-md-6 mb-3">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Read

                        </h6>

                        <h2 class="fw-bold text-success">

                            {{ $readNotifications }}

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-lg-4 col-md-6 mb-3">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Unread

                        </h6>

                        <h2 class="fw-bold text-warning">

                            {{ $unreadNotifications }}

                        </h2>

                    </div>

                </div>

            </div>

        </div>

        <!-- Search -->

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <form action="{{ route('admin.notifications.index') }}" method="GET">

                    <div class="row">

                        <div class="col-md-5">

                            <input type="text" name="search" class="form-control"
                                placeholder="Search user, title or message..." value="{{ request('search') }}">

                        </div>

                        <div class="col-md-3">

                            <select name="is_read" class="form-select">

                                <option value="">

                                    All Status

                                </option>

                                <option value="1" {{ request('is_read') === '1' ? 'selected' : '' }}>

                                    Read

                                </option>

                                <option value="0" {{ request('is_read') === '0' ? 'selected' : '' }}>

                                    Unread

                                </option>

                            </select>

                        </div>

                        <div class="col-md-2 d-grid">

                            <button class="btn btn-primary">

                                <i class="bi bi-search me-2"></i>

                                Search

                            </button>

                        </div>

                        <div class="col-md-2 d-grid">

                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">

                                Reset

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <!-- DataTable -->

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle datatable">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>

                                <th>User</th>

                                <th>Title</th>

                                <th>Type</th>

                                <th>Status</th>

                                <th>Date</th>

                                <th width="170">

                                    Actions

                                </th>

                            </tr>

                        </thead>

                        <tbody>
                            @forelse($notifications as $notification)

                                <tr>

                                    <td>

                                        {{ $notification->id }}

                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center me-2"
                                                style="width:40px;height:40px;">

                                                {{ strtoupper(substr($notification->user->name ?? 'N', 0, 1)) }}

                                            </div>

                                            <div>

                                                <strong>

                                                    {{ $notification->user->name ?? 'N/A' }}

                                                </strong>

                                                <br>

                                                <small class="text-muted">

                                                    {{ $notification->user->email ?? '' }}

                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <strong>

                                            {{ $notification->title }}

                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ \Illuminate\Support\Str::limit($notification->message, 40) }}

                                        </small>

                                    </td>

                                    <td>

                                        <span class="badge bg-info">

                                            {{ ucfirst($notification->type) }}

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

                                        <div class="btn-group">

                                            <a href="{{ route('admin.notifications.show', $notification) }}"
                                                class="btn btn-info btn-sm" title="View">

                                                <i class="bi bi-eye"></i>

                                            </a>

                                            <a href="{{ route('admin.notifications.edit', $notification) }}"
                                                class="btn btn-warning btn-sm" title="Edit">

                                                <i class="bi bi-pencil-square"></i>

                                            </a>

                                            <form action="{{ route('admin.notifications.destroy', $notification) }}"
                                                method="POST" class="delete-form d-inline">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>
                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-5">

                                        <i class="bi bi-bell-slash display-1 text-secondary"></i>

                                        <h4 class="mt-3">

                                            No Notifications Found

                                        </h4>

                                        <p class="text-muted mb-0">

                                            There are currently no notifications available.

                                        </p>

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