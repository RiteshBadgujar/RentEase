@extends('layouts.master')

@section('title', 'Notification Details')

@section('content')

<div class="container py-5">

    <!-- ==========================
            Page Header
    =========================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-bell-fill text-warning me-2"></i>

                Notification Details

            </h2>

            <p class="text-muted mb-0">

                View notification information and related activity.

            </p>

        </div>

    </div>


    <!-- ==========================
            Notification Card
    =========================== -->

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header bg-primary text-white py-3">

            <h4 class="mb-0">

                <i class="bi bi-bell-fill me-2"></i>

                Notification Details

            </h4>

        </div>


        <div class="card-body p-4">

            <!-- ==========================
                    Title & Type
            =========================== -->

            <div class="mb-4">

                <h3 class="fw-bold mb-2">

                    {{ $notification->title }}

                </h3>

                @if($notification->type)

                    <span class="badge bg-info">

                        <i class="bi bi-tag me-1"></i>

                        {{ $notification->type }}

                    </span>

                @endif

            </div>


            <hr>


            <!-- ==========================
                    Message
            =========================== -->

            <div class="mb-4">

                <h5 class="fw-bold mb-3">

                    <i class="bi bi-chat-left-text me-2"></i>

                    Message

                </h5>

                <div class="border rounded-3 p-4 bg-light">

                    <p class="mb-0">

                        {{ $notification->message }}

                    </p>

                </div>

            </div>


            <!-- ==========================
                    Notification Information
            =========================== -->

            <div class="row gy-4 mb-4">

                <!-- Notification ID -->

                <div class="col-md-4">

                    <div class="border rounded-3 p-3 h-100">

                        <small class="text-muted d-block mb-1">

                            Notification ID

                        </small>

                        <strong>

                            #{{ $notification->id }}

                        </strong>

                    </div>

                </div>


                <!-- Status -->

                <div class="col-md-4">

                    <div class="border rounded-3 p-3 h-100">

                        <small class="text-muted d-block mb-1">

                            Status

                        </small>

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

                </div>


                <!-- Created -->

                <div class="col-md-4">

                    <div class="border rounded-3 p-3 h-100">

                        <small class="text-muted d-block mb-1">

                            Created

                        </small>

                        <strong>

                            {{ $notification->created_at->format('d M Y') }}

                        </strong>

                        <small class="d-block text-muted">

                            {{ $notification->created_at->format('h:i A') }}

                        </small>

                        <small class="d-block text-muted mt-1">

                            {{ $notification->created_at->diffForHumans() }}

                        </small>

                    </div>

                </div>

            </div>


            <hr>


            <!-- ==========================
                    Action Buttons
            =========================== -->

            <div class="d-flex flex-wrap gap-2">

                <!-- Open Related Page -->

                @if($notification->url)

                    <a
                        href="{{ $notification->url }}"
                        class="btn btn-primary"
                        title="Open Related Page">

                        <i class="bi bi-box-arrow-up-right me-1"></i>

                        Open Related Page

                    </a>

                @endif


                <!-- Back -->

                <a
                    href="{{ route('notifications.index') }}"
                    class="btn btn-secondary"
                    title="Back to Notifications">

                    <i class="bi bi-arrow-left me-1"></i>

                    Back

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
                        class="btn btn-danger"
                        title="Delete Notification"
                        onclick="return confirm('Are you sure you want to delete this notification?')">

                        <i class="bi bi-trash me-1"></i>

                        Delete

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection