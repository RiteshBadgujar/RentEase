@extends('layouts.master')

@section('title', 'Notification Details')

@section('content')

<div class="container py-5">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">

                <i class="bi bi-bell-fill me-2"></i>

                Notification Details

            </h4>

        </div>

        <div class="card-body">

            <!-- Title -->

            <div class="mb-4">

                <h3 class="fw-bold">

                    {{ $notification->title }}

                </h3>

                <span class="badge bg-info">

                    {{ $notification->type }}

                </span>

            </div>

            <hr>

            <!-- Message -->

            <div class="mb-4">

                <h5>

                    Message

                </h5>

                <div class="border rounded p-3 bg-light">

                    {{ $notification->message }}

                </div>

            </div>

            <!-- Information -->

            <div class="row gy-4">

                <div class="col-md-4">

                    <strong>Notification ID</strong>

                    <br>

                    #{{ $notification->id }}

                </div>

                <div class="col-md-4">

                    <strong>Status</strong>

                    <br>

                    @if($notification->is_read)

                        <span class="badge bg-success">

                            <i class="bi bi-check-circle-fill me-1"></i>

                            Read

                        </span>

                    @else

                        <span class="badge bg-warning text-dark">

                            <i class="bi bi-bell-fill me-1"></i>

                            Unread

                        </span>

                    @endif

                </div>

                <div class="col-md-4">

                    <strong>Created</strong>

                    <br>

                    <small>

                        {{ $notification->created_at->format('d M Y h:i A') }}

                    </small>

                    <br>

                    <small class="text-muted">

                        {{ $notification->created_at->diffForHumans() }}

                    </small>

                </div>

            </div>

            <hr>

            <!-- Action Buttons -->

            <div class="d-flex flex-wrap gap-2">

                @if($notification->url)

                    <a
                        href="{{ $notification->url }}"
                        class="btn btn-primary"
                        title="Open Related Page">

                        <i class="bi bi-box-arrow-up-right me-1"></i>

                        Open Related Page

                    </a>

                @else

                    <button
                        class="btn btn-outline-secondary"
                        disabled>

                        <i class="bi bi-link-45deg me-1"></i>

                        No Related Page

                    </button>

                @endif

                <a
                    href="{{ route('notifications.index') }}"
                    class="btn btn-secondary"
                    title="Back to Notifications">

                    <i class="bi bi-arrow-left me-1"></i>

                    Back

                </a>

                <form
                    action="{{ route('notifications.destroy', $notification->id) }}"
                    method="POST"
                    class="d-inline">

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger"
                        title="Delete Notification"
                        onclick="return confirm('Delete this notification?')">

                        <i class="bi bi-trash me-1"></i>

                        Delete

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection