@extends('layouts.admin')

@section('title', 'Edit Enquiry')

@section('content')

<div class="container-fluid py-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-header bg-warning">

                    <h4 class="mb-0">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Enquiry

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

                    <form
                        action="{{ route('admin.enquiries.update',$enquiry) }}"
                        method="POST">

                        @csrf

                        @method('PUT')

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Enquiry ID

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="#{{ $enquiry->id }}"
                                    readonly>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Created Date

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $enquiry->created_at->format('d M Y') }}"
                                    readonly>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Sender

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $enquiry->sender->name ?? 'N/A' }}"
                                    readonly>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Receiver

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $enquiry->receiver->name ?? 'N/A' }}"
                                    readonly>

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label fw-bold">

                                    Property

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $enquiry->property->title ?? 'N/A' }}"
                                    readonly>

                            </div>

                            <div class="col-12 mb-4">

                                <label class="form-label fw-bold">

                                    Message

                                </label>

                                <textarea
                                    class="form-control"
                                    rows="5"
                                    readonly>{{ $enquiry->message }}</textarea>

                            </div>
                                                        <div class="col-md-12 mb-4">

                                <label class="form-label fw-bold">

                                    Status

                                </label>

                                <select
                                    name="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    required>

                                    <option
                                        value="Pending"
                                        {{ old('status', $enquiry->status) == 'Pending' ? 'selected' : '' }}>

                                        Pending

                                    </option>

                                    <option
                                        value="Replied"
                                        {{ old('status', $enquiry->status) == 'Replied' ? 'selected' : '' }}>

                                        Replied

                                    </option>

                                    <option
                                        value="Closed"
                                        {{ old('status', $enquiry->status) == 'Closed' ? 'selected' : '' }}>

                                        Closed

                                    </option>

                                </select>

                                @error('status')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">

                            <a
                                href="{{ route('admin.enquiries.index') }}"
                                class="btn btn-secondary">

                                <i class="bi bi-arrow-left me-2"></i>

                                Back

                            </a>

                            <div>

                                <button
                                    type="reset"
                                    class="btn btn-outline-dark me-2">

                                    <i class="bi bi-arrow-clockwise me-2"></i>

                                    Reset

                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-success">

                                    <i class="bi bi-check-circle-fill me-2"></i>

                                    Update Enquiry

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