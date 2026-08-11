@extends('layouts.admin')

@section('title', 'Notification Details')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-bell-fill text-primary me-2"></i>

                    Notification Details

                </h2>

                <p class="text-muted mb-0">

                    View complete notification information.

                </p>

            </div>

            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left me-2"></i>

                Back

            </a>

        </div>

        <div class="row">

            <!-- User Card -->

            <div class="col-lg-4 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-person-fill me-2"></i>

                            User Information

                        </h5>

                    </div>

                    <div class="card-body text-center">

                        <div class="rounded-circle bg-primary text-white d-inline-flex justify-content-center align-items-center mb-3"
                            style="width:80px;height:80px;font-size:32px;">

                            {{ strtoupper(substr($notification->user->name ?? 'N', 0, 1)) }}

                        </div>

                        <h5>

                            {{ $notification->user->name ?? 'N/A' }}

                        </h5>

                        <p class="text-muted">

                            {{ $notification->user->email ?? 'N/A' }}

                        </p>

                    </div>

                </div>

            </div>

            <!-- Notification Info -->

            <div class="col-lg-8 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-dark text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-info-circle me-2"></i>

                            Notification Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless">

                            <tr>

                                <th width="30%">

                                    Notification ID

                                </th>

                                <td>

                                    #{{ $notification->id }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Type

                                </th>

                                <td>

                                    <span class="badge bg-info">

                                        {{ ucfirst($notification->type) }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Status

                                </th>

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

                            </tr>

                            <tr>

                                <th>

                                    Created

                                </th>

                                <td>

                                    {{ $notification->created_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Last Updated

                                </th>

                                <td>

                                    {{ $notification->updated_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">

                    <i class="bi bi-card-heading me-2"></i>

                    Notification Title

                </h5>

                <div class="alert alert-primary">

                    {{ $notification->title }}

                </div>

                <hr>

                <h5 class="fw-bold mb-3">

                    <i class="bi bi-chat-left-text me-2"></i>

                    Message

                </h5>

                <div class="border rounded-3 bg-light p-4">

                    {!! nl2br(e($notification->message)) !!}

                </div>
                @if(!empty($notification->url))

                    <hr>

                    <h5 class="fw-bold mb-3">

                        <i class="bi bi-link-45deg me-2"></i>

                        Related Link

                    </h5>

                    <a href="{{ $notification->url }}" target="_blank" class="btn btn-primary">

                        <i class="bi bi-box-arrow-up-right me-2"></i>

                        Open Link

                    </a>

                @endif

                <hr class="my-4">

                <div class="d-flex justify-content-between">

                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left me-2"></i>

                        Back

                    </a>

                    <div>

                        <a href="{{ route('admin.notifications.edit', $notification) }}" class="btn btn-warning me-2">

                            <i class="bi bi-pencil-square me-2"></i>

                            Edit Notification

                        </a>

                        <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST"
                            class="delete-form d-inline">

                            @csrf

                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">

                                <i class="bi bi-trash me-2"></i>

                                Delete

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection