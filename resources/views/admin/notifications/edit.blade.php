@extends('layouts.admin')

@section('title', 'Edit Notification')

@section('content')

    <div class="container-fluid py-4">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-warning">

                        <h4 class="mb-0">

                            <i class="bi bi-pencil-square me-2"></i>

                            Edit Notification

                        </h4>

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

                        <form action="{{ route('admin.notifications.update', $notification) }}" method="POST">

                            @csrf

                            @method('PUT')

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">

                                        Notification ID

                                    </label>

                                    <input type="text" class="form-control" value="#{{ $notification->id }}" readonly>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">

                                        Created Date

                                    </label>

                                    <input type="text" class="form-control"
                                        value="{{ $notification->created_at->format('d M Y') }}" readonly>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">

                                        User

                                    </label>

                                    <input type="text" class="form-control" value="{{ $notification->user->name ?? 'N/A' }}"
                                        readonly>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">

                                        Type

                                    </label>

                                    <input type="text" class="form-control" value="{{ ucfirst($notification->type) }}"
                                        readonly>

                                </div>

                                <div class="col-12 mb-3">

                                    <label class="form-label fw-bold">

                                        Title

                                    </label>

                                    <input type="text" class="form-control" value="{{ $notification->title }}" readonly>

                                </div>

                                <div class="col-12 mb-4">

                                    <label class="form-label fw-bold">

                                        Message

                                    </label>

                                    <textarea class="form-control" rows="5" readonly>{{ $notification->message }}</textarea>

                                </div>
                                <div class="col-md-12 mb-4">

                                    <label class="form-label fw-bold">

                                        Status

                                    </label>

                                    <select name="is_read" class="form-select @error('is_read') is-invalid @enderror"
                                        required>

                                        <option value="0" {{ old('is_read', $notification->is_read) == 0 ? 'selected' : '' }}>

                                            Unread

                                        </option>

                                        <option value="1" {{ old('is_read', $notification->is_read) == 1 ? 'selected' : '' }}>

                                            Read

                                        </option>

                                    </select>

                                    @error('is_read')

                                        <div class="invalid-feedback">

                                            {{ $message }}

                                        </div>

                                    @enderror

                                </div>

                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">

                                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">

                                    <i class="bi bi-arrow-left me-2"></i>

                                    Back

                                </a>

                                <div>

                                    <button type="reset" class="btn btn-outline-dark me-2">

                                        <i class="bi bi-arrow-clockwise me-2"></i>

                                        Reset

                                    </button>

                                    <button type="submit" class="btn btn-success">

                                        <i class="bi bi-check-circle-fill me-2"></i>

                                        Update Notification

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection