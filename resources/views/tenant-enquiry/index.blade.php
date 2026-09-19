@extends('layouts.master')

@section('title', 'My Enquiries')

@section('content')

<div class="container py-5">

    <!-- ==========================================================
         PAGE HEADER
    =========================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-chat-left-text-fill text-primary me-2"></i>
                My Enquiries
            </h2>

            <p class="text-muted mb-0">
                View and track your property enquiries.
            </p>
        </div>

        <a
            href="{{ route('dashboard') }}"
            class="btn btn-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Dashboard
        </a>

    </div>


    <!-- ==========================================================
         SUCCESS MESSAGE
    =========================================================== -->

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>

    @endif


    <!-- ==========================================================
         ERROR MESSAGE
    =========================================================== -->

    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >
            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>

    @endif


    <!-- ==========================================================
         VALIDATION ERRORS
    =========================================================== -->

    @if($errors->any())

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >
            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>

    @endif


    <!-- ==========================================================
         ENQUIRY CARD
    =========================================================== -->

    <div class="card shadow-lg border-0 rounded-4">

        <!-- Card Header -->

        <div class="card-header bg-light">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>
                    Enquiry List
                </h5>

                <span class="badge bg-primary">

                    {{ $enquiries->count() }}

                    {{ $enquiries->count() === 1
                        ? 'Enquiry'
                        : 'Enquiries'
                    }}

                </span>

            </div>

        </div>


        <!-- Card Body -->

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <!-- ==================================================
                         TABLE HEADER
                    =================================================== -->

                    <thead class="table-primary">

                        <tr>

                            <th width="60">
                                #
                            </th>

                            <th>
                                Property
                            </th>

                            <th>
                                Landlord
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


                    <!-- ==================================================
                         TABLE BODY
                    =================================================== -->

                    <tbody>

                        @forelse($enquiries as $enquiry)

                            <tr>

                                <!-- ==================================================
                                     SERIAL NUMBER
                                =================================================== -->

                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                <!-- ==================================================
                                     PROPERTY
                                =================================================== -->

                                <td>

                                    @if($enquiry->property)

                                        <strong>
                                            {{ $enquiry->property->title }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            <i class="bi bi-geo-alt me-1"></i>

                                            {{ $enquiry->property->city ?? 'Location unavailable' }}

                                        </small>

                                    @else

                                        <span class="text-muted">
                                            Property unavailable
                                        </span>

                                    @endif

                                </td>


                                <!-- ==================================================
                                     LANDLORD
                                =================================================== -->

                                <td>

                                    @if($enquiry->receiver)

                                        <strong>
                                            {{ $enquiry->receiver->name }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $enquiry->receiver->email }}

                                        </small>

                                    @else

                                        <span class="text-muted">
                                            Landlord unavailable
                                        </span>

                                    @endif

                                </td>


                                <!-- ==================================================
                                     MESSAGE
                                =================================================== -->

                                <td style="min-width: 220px;">

                                    <div
                                        class="text-truncate"
                                        style="max-width: 280px;"
                                        title="{{ $enquiry->message }}"
                                    >
                                        {{ $enquiry->message }}
                                    </div>

                                </td>


                                <!-- ==================================================
                                     STATUS
                                =================================================== -->

                                <td>

                                    @if($enquiry->status === 'Pending')

                                        <span class="badge bg-warning text-dark">

                                            <i class="bi bi-clock me-1"></i>

                                            Pending

                                        </span>

                                    @elseif($enquiry->status === 'Replied')

                                        <span class="badge bg-success">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Replied

                                        </span>

                                    @elseif($enquiry->status === 'Closed')

                                        <span class="badge bg-secondary">

                                            <i class="bi bi-x-circle me-1"></i>

                                            Closed

                                        </span>

                                    @else

                                        <span class="badge bg-dark">

                                            {{ $enquiry->status }}

                                        </span>

                                    @endif

                                </td>


                                <!-- ==================================================
                                     DATE
                                =================================================== -->

                                <td>

                                    @if($enquiry->created_at)

                                        {{ $enquiry->created_at->format('d M Y') }}

                                        <br>

                                        <small class="text-muted">

                                            {{ $enquiry->created_at->format('h:i A') }}

                                        </small>

                                    @else

                                        <span class="text-muted">
                                            Not available
                                        </span>

                                    @endif

                                </td>


                                <!-- ==================================================
                                     ACTION
                                =================================================== -->

                                <td>

                                    @if($enquiry->property)

                                        <a
                                            href="{{ route('properties.show', $enquiry->property) }}"
                                            class="btn btn-info btn-sm"
                                            title="View Property"
                                        >

                                            <i class="bi bi-eye me-1"></i>

                                            View

                                        </a>

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <!-- ==================================================
                                 EMPTY STATE
                            =================================================== -->

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="bi bi-chat-square-text display-1 text-secondary"
                                    ></i>

                                    <h4 class="fw-bold mt-3">
                                        No Enquiries Found
                                    </h4>

                                    <p class="text-muted mb-3">
                                        You haven't sent any property enquiries yet.
                                    </p>

                                    <a
                                        href="{{ route('properties.index') }}"
                                        class="btn btn-primary"
                                    >

                                        <i class="bi bi-search me-2"></i>

                                        Browse Properties

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- ==========================================================
                 PAGINATION
            =========================================================== -->

            @if($enquiries->hasPages())

                <div class="mt-4">

                    {{ $enquiries->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection