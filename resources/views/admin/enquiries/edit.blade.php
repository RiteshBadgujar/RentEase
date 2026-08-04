@extends('layouts.master')

@section('title', 'Edit Enquiry')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header bg-warning text-dark">

                    <h3 class="mb-0">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Enquiry

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

                    <form action="{{ route('admin.enquiries.update',$enquiry) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Sender

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $enquiry->sender->name ?? 'N/A' }}"
                                readonly>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Receiver

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $enquiry->receiver->name ?? 'N/A' }}"
                                readonly>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Property

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $enquiry->property->title ?? 'N/A' }}"
                                readonly>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Message

                            </label>

                            <textarea
                                class="form-control"
                                rows="5"
                                readonly>{{ $enquiry->message }}</textarea>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Status

                            </label>

                            <select
                                name="status"
                                class="form-select">

                                <option value="Pending"
                                    {{ $enquiry->status=='Pending' ? 'selected' : '' }}>

                                    Pending

                                </option>

                                <option value="Replied"
                                    {{ $enquiry->status=='Replied' ? 'selected' : '' }}>

                                    Replied

                                </option>

                                <option value="Closed"
                                    {{ $enquiry->status=='Closed' ? 'selected' : '' }}>

                                    Closed

                                </option>

                            </select>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('admin.enquiries.index') }}"
                               class="btn btn-secondary">

                                <i class="bi bi-arrow-left me-2"></i>

                                Back

                            </a>

                            <button
                                class="btn btn-success">

                                <i class="bi bi-check-circle me-2"></i>

                                Update Enquiry

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection