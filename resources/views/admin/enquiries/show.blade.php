@extends('layouts.admin')

@section('title', 'Enquiry Details')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-chat-left-text-fill text-primary me-2"></i>

                    Enquiry Details

                </h2>

                <p class="text-muted mb-0">

                    View complete enquiry information.

                </p>

            </div>

            <a href="{{ route('admin.enquiries.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left me-2"></i>

                Back

            </a>

        </div>

        <div class="row">

            <!-- Sender -->

            <div class="col-lg-4 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-person-fill me-2"></i>

                            Sender

                        </h5>

                    </div>

                    <div class="card-body text-center">

                        <div class="rounded-circle bg-primary text-white d-inline-flex justify-content-center align-items-center mb-3"
                            style="width:80px;height:80px;font-size:32px;">

                            {{ strtoupper(substr($enquiry->sender->name ?? 'N', 0, 1)) }}

                        </div>

                        <h5>

                            {{ $enquiry->sender->name ?? 'N/A' }}

                        </h5>

                        <p class="text-muted">

                            {{ $enquiry->sender->email ?? 'N/A' }}

                        </p>

                    </div>

                </div>

            </div>

            <!-- Receiver -->

            <div class="col-lg-4 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-success text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-person-workspace me-2"></i>

                            Receiver

                        </h5>

                    </div>

                    <div class="card-body text-center">

                        <div class="rounded-circle bg-success text-white d-inline-flex justify-content-center align-items-center mb-3"
                            style="width:80px;height:80px;font-size:32px;">

                            {{ strtoupper(substr($enquiry->receiver->name ?? 'N', 0, 1)) }}

                        </div>

                        <h5>

                            {{ $enquiry->receiver->name ?? 'N/A' }}

                        </h5>

                        <p class="text-muted">

                            {{ $enquiry->receiver->email ?? 'N/A' }}

                        </p>

                    </div>

                </div>

            </div>

            <!-- Property -->

            <div class="col-lg-4 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-info text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-house-door-fill me-2"></i>

                            Property

                        </h5>

                    </div>

                    <div class="card-body">

                        <h5>

                            {{ $enquiry->property->title ?? 'N/A' }}

                        </h5>

                        <p class="text-muted">

                            {{ $enquiry->property->city ?? 'N/A' }}

                        </p>

                        <h4 class="text-success">

                            ₹{{ number_format($enquiry->property->price ?? 0) }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-dark text-white">

                <h5 class="mb-0">

                    <i class="bi bi-info-circle me-2"></i>

                    Enquiry Information

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <table class="table table-borderless">

                            <tr>

                                <th width="40%">

                                    Enquiry ID

                                </th>

                                <td>

                                    #{{ $enquiry->id }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Status

                                </th>

                                <td>
                                    @php

                                        $badge = [

                                            'Pending' => 'warning',

                                            'Replied' => 'success',

                                            'Closed' => 'secondary'

                                        ];

                                    @endphp

                                    <span class="badge bg-{{ $badge[$enquiry->status] ?? 'dark' }}">

                                        {{ $enquiry->status }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Created

                                </th>

                                <td>

                                    {{ $enquiry->created_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Last Updated

                                </th>

                                <td>

                                    {{ $enquiry->updated_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                        </table>

                    </div>

                    <div class="col-md-6">

                        <h5 class="fw-bold mb-3">

                            <i class="bi bi-chat-left-text me-2"></i>

                            Message

                        </h5>

                        <div class="border rounded-3 bg-light p-4">

                            {!! nl2br(e($enquiry->message)) !!}

                        </div>

                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between">

                    <a href="{{ route('admin.enquiries.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left me-2"></i>

                        Back

                    </a>

                    <div>

                        <a href="{{ route('admin.enquiries.edit', $enquiry) }}" class="btn btn-warning me-2">

                            <i class="bi bi-pencil-square me-2"></i>

                            Edit Enquiry

                        </a>

                        <form action="{{ route('admin.enquiries.destroy', $enquiry) }}" method="POST"
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