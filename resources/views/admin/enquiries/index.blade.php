@extends('layouts.admin')

@section('title', 'Enquiry Management')

@section('content')

    <div class="container-fluid py-4">

        <!-- Page Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-chat-left-text-fill text-primary me-2"></i>

                    Enquiry Management

                </h2>

                <p class="text-muted mb-0">

                    Manage all customer enquiries from one place.

                </p>

            </div>

        </div>

        <!-- Statistics -->

        <div class="row mb-4">

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Total Enquiries

                        </h6>

                        <h2 class="fw-bold text-primary">

                            {{ $totalEnquiries }}

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Pending

                        </h6>

                        <h2 class="fw-bold text-warning">

                            {{ $pendingEnquiries }}

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Replied

                        </h6>

                        <h2 class="fw-bold text-success">

                            {{ $repliedEnquiries }}

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6 mb-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Closed

                        </h6>

                        <h2 class="fw-bold text-secondary">

                            {{ $closedEnquiries }}

                        </h2>

                    </div>

                </div>

            </div>

        </div>

        <!-- Search & Filter -->

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <form action="{{ route('admin.enquiries.index') }}" method="GET">

                    <div class="row">

                        <div class="col-md-5">

                            <input type="text" name="search" class="form-control"
                                placeholder="Search sender, receiver or property..." value="{{ request('search') }}">

                        </div>

                        <div class="col-md-3">

                            <select name="status" class="form-select">

                                <option value="">

                                    All Status

                                </option>

                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>

                                    Pending

                                </option>

                                <option value="Replied" {{ request('status') == 'Replied' ? 'selected' : '' }}>

                                    Replied

                                </option>

                                <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>

                                    Closed

                                </option>

                            </select>

                        </div>

                        <div class="col-md-2 d-grid">

                            <button class="btn btn-primary">

                                <i class="bi bi-search me-2"></i>

                                Search

                            </button>

                        </div>

                        <div class="col-md-2 d-grid">

                            <a href="{{ route('admin.enquiries.index') }}" class="btn btn-secondary">

                                Reset

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <!-- Data Table -->

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle datatable">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>

                                <th>Sender</th>

                                <th>Receiver</th>

                                <th>Property</th>

                                <th>Message</th>

                                <th>Status</th>

                                <th>Date</th>

                                <th width="170">

                                    Actions

                                </th>

                            </tr>

                        </thead>

                        <tbody>
                            @forelse($enquiries as $enquiry)

                                @php

                                    $statusColor = [

                                        'Pending' => 'warning',

                                        'Replied' => 'success',

                                        'Closed' => 'secondary'

                                    ];

                                @endphp

                                <tr>

                                    <td>

                                        {{ $enquiry->id }}

                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center me-2"
                                                style="width:40px;height:40px;">

                                                {{ strtoupper(substr($enquiry->sender->name ?? 'N', 0, 1)) }}

                                            </div>

                                            <div>

                                                <strong>

                                                    {{ $enquiry->sender->name ?? 'N/A' }}

                                                </strong>

                                                <br>

                                                <small class="text-muted">

                                                    {{ $enquiry->sender->email ?? '' }}

                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="rounded-circle bg-success text-white fw-bold d-flex justify-content-center align-items-center me-2"
                                                style="width:40px;height:40px;">

                                                {{ strtoupper(substr($enquiry->receiver->name ?? 'N', 0, 1)) }}

                                            </div>

                                            <div>

                                                <strong>

                                                    {{ $enquiry->receiver->name ?? 'N/A' }}

                                                </strong>

                                                <br>

                                                <small class="text-muted">

                                                    {{ $enquiry->receiver->email ?? '' }}

                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <strong>

                                            {{ $enquiry->property->title ?? 'N/A' }}

                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $enquiry->property->city ?? '' }}

                                        </small>

                                    </td>

                                    <td>

                                        {{ \Illuminate\Support\Str::limit($enquiry->message, 45) }}

                                    </td>

                                    <td>

                                        <span class="badge bg-{{ $statusColor[$enquiry->status] ?? 'dark' }}">

                                            {{ $enquiry->status }}

                                        </span>

                                    </td>

                                    <td>

                                        {{ $enquiry->created_at->format('d M Y') }}

                                    </td>

                                    <td>

                                        <div class="btn-group">

                                            <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="btn btn-info btn-sm"
                                                title="View">

                                                <i class="bi bi-eye"></i>

                                            </a>

                                            <a href="{{ route('admin.enquiries.edit', $enquiry) }}"
                                                class="btn btn-warning btn-sm" title="Edit">

                                                <i class="bi bi-pencil-square"></i>

                                            </a>

                                            <form action="{{ route('admin.enquiries.destroy', $enquiry) }}" method="POST"
                                                class="delete-form d-inline">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>
                            @empty

                                <tr>

                                    <td colspan="8" class="text-center py-5">

                                        <i class="bi bi-chat-left-text display-1 text-secondary"></i>

                                        <h4 class="mt-3">

                                            No Enquiries Found

                                        </h4>

                                        <p class="text-muted mb-0">

                                            There are currently no enquiries available.

                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection