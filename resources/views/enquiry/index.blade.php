@extends('layouts.master')

@section('title', 'My Enquiries')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            <i class="bi bi-chat-dots-fill text-primary me-2"></i>

            My Enquiries

        </h2>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Back

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    <div class="card shadow border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>#</th>

                            <th>Property</th>

                            <th>Tenant</th>

                            <th>Email</th>

                            <th>Message</th>

                            <th>Status</th>

                            <th>Date</th>

                            <th width="120">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($enquiries as $enquiry)

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                <td>

                                    {{ $enquiry->property->title }}

                                </td>

                                <td>

                                    {{ $enquiry->sender->name }}

                                </td>

                                <td>

                                    {{ $enquiry->sender->email }}

                                </td>

                                <td style="max-width:300px;">

                                    {{ $enquiry->message }}

                                </td>

                                <td>

                                    @if($enquiry->status == 'Pending')

                                        <span class="badge bg-warning text-dark">

                                            Pending

                                        </span>

                                    @elseif($enquiry->status == 'Replied')

                                        <span class="badge bg-success">

                                            Replied

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            Closed

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ $enquiry->created_at->format('d M Y') }}

                                </td>

                                <td>

                                    <form
                                        action="{{ route('enquiries.destroy', $enquiry->id) }}"
                                        method="POST">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this enquiry?')">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-5">

                                    <i class="bi bi-chat-left-text display-1 text-secondary"></i>

                                    <h4 class="mt-3">

                                        No Enquiries Found

                                    </h4>

                                    <p class="text-muted">

                                        You haven't received any enquiries yet.

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