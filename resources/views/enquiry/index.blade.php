@extends('layouts.master')

@section('title', 'My Enquiries')

@section('content')

<div class="container py-5">

    <!-- ==========================
            Page Header
    =========================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-chat-dots-fill text-primary me-2"></i>

                My Enquiries

            </h2>

            <p class="text-muted mb-0">

                Manage enquiries received from tenants.

            </p>

        </div>

        <a
            href="{{ route('dashboard') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Back

        </a>

    </div>


    <!-- ==========================
            Success Message
    =========================== -->

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <!-- ==========================
            Error Message
    =========================== -->

    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <!-- ==========================
            Enquiry List
    =========================== -->

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header bg-light py-3">

            <h5 class="mb-0">

                <i class="bi bi-list-ul me-2"></i>

                Enquiry List

            </h5>

        </div>


        <div class="card-body">


            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <!-- ==========================
                            Table Header
                    =========================== -->

                    <thead class="table-primary">

                        <tr>

                            <th width="60">
                                #
                            </th>

                            <th>
                                Property
                            </th>

                            <th>
                                Tenant
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Message
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Date
                            </th>

                            <th width="120">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <!-- ==========================
                            Table Body
                    =========================== -->

                    <tbody>

                        @forelse($enquiries as $enquiry)

                            <tr>

                                <!-- Serial Number -->

                                <td>

                                    {{ $enquiries->firstItem() + $loop->index }}

                                </td>


                                <!-- Property -->

                                <td>

                                    <strong>

                                        {{ $enquiry->property->title }}

                                    </strong>

                                </td>


                                <!-- Tenant -->

                                <td>

                                    <div class="d-flex align-items-center">

                                        <i class="bi bi-person-circle text-primary me-2"></i>

                                        <strong>

                                            {{ $enquiry->sender->name }}

                                        </strong>

                                    </div>

                                </td>


                                <!-- Email -->

                                <td>

                                    <a
                                        href="mailto:{{ $enquiry->sender->email }}"
                                        class="text-decoration-none">

                                        {{ $enquiry->sender->email }}

                                    </a>

                                </td>


                                <!-- Message -->

                                <td style="max-width: 300px;">

                                    <div
                                        class="text-truncate"
                                        style="max-width: 280px;"
                                        title="{{ $enquiry->message }}">

                                        {{ $enquiry->message }}

                                    </div>

                                </td>


                                <!-- Status -->

                                <td>

                                    @if($enquiry->status == 'Pending')

                                        <span class="badge bg-warning text-dark">

                                            <i class="bi bi-clock me-1"></i>

                                            Pending

                                        </span>

                                    @elseif($enquiry->status == 'Replied')

                                        <span class="badge bg-success">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Replied

                                        </span>

                                    @elseif($enquiry->status == 'Closed')

                                        <span class="badge bg-secondary">

                                            <i class="bi bi-x-circle me-1"></i>

                                            Closed

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            {{ $enquiry->status }}

                                        </span>

                                    @endif

                                </td>


                                <!-- Date -->

                                <td>

                                    <span class="text-nowrap">

                                        {{ $enquiry->created_at->format('d M Y') }}

                                    </span>

                                    <small class="d-block text-muted">

                                        {{ $enquiry->created_at->format('h:i A') }}

                                    </small>

                                </td>


                                <!-- Action -->

                                <td>

                                    <form
                                        action="{{ route('enquiries.destroy', $enquiry->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            title="Delete Enquiry"
                                            onclick="return confirm('Are you sure you want to delete this enquiry?')">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <!-- ==========================
                                    Empty State
                            =========================== -->

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-5">

                                    <i class="bi bi-chat-left-text display-1 text-secondary"></i>

                                    <h4 class="fw-bold mt-3">

                                        No Enquiries Found

                                    </h4>

                                    <p class="text-muted mb-3">

                                        You haven't received any enquiries yet.

                                    </p>

                                    <a
                                        href="{{ route('properties.index') }}"
                                        class="btn btn-primary">

                                        <i class="bi bi-house-door me-2"></i>

                                        View Properties

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- ==========================
                    Pagination
            =========================== -->

            @if($enquiries->hasPages())

                <div class="d-flex justify-content-center mt-4">

                    {{ $enquiries->links() }}

                </div>

            @endif


        </div>

    </div>

</div>

@endsection