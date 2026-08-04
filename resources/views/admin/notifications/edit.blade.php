@extends('layouts.master')

@section('title', 'Edit Notification')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header bg-warning text-dark">

                    <h3 class="mb-0">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Notification

                    </h3>

                </div>

                <div class="card-body">

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form action="{{ route('admin.notifications.update',$notification) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                User

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $notification->user->name ?? 'N/A' }}"
                                readonly>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Title

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $notification->title }}"
                                readonly>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Type

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $notification->type }}"
                                readonly>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Message

                            </label>

                            <textarea
                                class="form-control"
                                rows="5"
                                readonly>{{ $notification->message }}</textarea>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Status

                            </label>

                            <select
                                name="is_read"
                                class="form-select">

                                <option value="0"
                                    {{ !$notification->is_read ? 'selected' : '' }}>

                                    Unread

                                </option>

                                <option value="1"
                                    {{ $notification->is_read ? 'selected' : '' }}>

                                    Read

                                </option>

                            </select>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('admin.notifications.index') }}"
                               class="btn btn-secondary">

                                <i class="bi bi-arrow-left me-2"></i>

                                Back

                            </a>

                            <button
                                class="btn btn-success">

                                <i class="bi bi-check-circle me-2"></i>

                                Update Notification

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection