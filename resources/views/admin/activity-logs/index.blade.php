@extends('layouts.master')

@section('title', 'Activity Logs')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            Activity Logs
        </h2>

        <form method="GET"
              action="{{ route('admin.activity-logs.index') }}"
              class="d-flex">

            <input
                type="text"
                name="search"
                class="form-control me-2"
                placeholder="Search..."
                value="{{ request('search') }}">

            <button
                class="btn btn-primary">
                Search
            </button>

        </form>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>User</th>

                        <th>Module</th>

                        <th>Action</th>

                        <th>Description</th>

                        <th>Date</th>

                        <th width="150">Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($activityLogs as $log)

                    <tr>

                        <td>{{ $log->id }}</td>

                        <td>{{ $log->user->name ?? 'Unknown' }}</td>

                        <td>

                            <span class="badge bg-info">

                                {{ $log->module }}

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-success">

                                {{ $log->action }}

                            </span>

                        </td>

                        <td>

                            {{ $log->description }}

                        </td>

                        <td>

                            {{ $log->created_at->format('d M Y h:i A') }}

                        </td>

                        <td>

                            <a
                                href="{{ route('admin.activity-logs.show',$log) }}"
                                class="btn btn-sm btn-primary">

                                View

                            </a>

                            <form
                                action="{{ route('admin.activity-logs.destroy',$log) }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                @method('DELETE')

                                <button
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this log?')">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="text-center">

                            No activity found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

            {{ $activityLogs->links() }}

        </div>

    </div>

</div>

@endsection