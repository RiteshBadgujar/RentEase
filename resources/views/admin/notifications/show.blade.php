@extends('layouts.master')

@section('title', 'Notification Details')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            <i class="bi bi-bell-fill text-primary me-2"></i>

            Notification Details

        </h2>

        <a href="{{ route('admin.notifications.index') }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left me-2"></i>

            Back

        </a>

    </div>

    <div class="card shadow border-0 rounded-4">

        <div class="card-body p-4">

            <div class="row">

                <div class="col-md-6">

                    <h5 class="fw-bold">

                        User Information

                    </h5>

                    <hr>

                    <p>

                        <strong>Name :</strong>

                        {{ $notification->user->name ?? 'N/A' }}

                    </p>

                    <p>

                        <strong>Email :</strong>

                        {{ $notification->user->email ?? 'N/A' }}

                    </p>

                </div>

                <div class="col-md-6">

                    <h5 class="fw-bold">

                        Notification Info

                    </h5>

                    <hr>

                    <p>

                        <strong>Type :</strong>

                        {{ $notification->type }}

                    </p>

                    <p>

                        <strong>Status :</strong>

                        @if($notification->is_read)

                            <span class="badge bg-success">

                                Read

                            </span>

                        @else

                            <span class="badge bg-warning text-dark">

                                Unread

                            </span>

                        @endif

                    </p>

                    <p>

                        <strong>Date :</strong>

                        {{ $notification->created_at->format('d M Y h:i A') }}

                    </p>

                </div>

            </div>

            <hr>

            <h5 class="fw-bold">

                Notification Title

            </h5>

            <p>

                {{ $notification->title }}

            </p>

            <hr>

            <h5 class="fw-bold">

                Message

            </h5>

            <div class="border rounded p-3 bg-light">

                {{ $notification->message }}

            </div>

            @if(!empty($notification->url))

                <hr>

                <h5 class="fw-bold">

                    Related Link

                </h5>

                <a href="{{ $notification->url }}"
                   target="_blank"
                   class="btn btn-primary">

                    Open Link

                </a>

            @endif

            <hr>

            <a href="{{ route('admin.notifications.edit',$notification) }}"
               class="btn btn-warning">

                <i class="bi bi-pencil-square me-2"></i>

                Edit

            </a>

            <form action="{{ route('admin.notifications.destroy',$notification) }}"
                  method="POST"
                  class="d-inline">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger"
                        onclick="return confirm('Delete notification?')">

                    <i class="bi bi-trash me-2"></i>

                    Delete

                </button>

            </form>

        </div>

    </div>

</div>

@endsection