@extends('layouts.master')

@section('title', 'Enquiry Management')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                <i class="bi bi-chat-left-text-fill text-primary me-2"></i>

                Enquiry Management

            </h2>

            <p class="text-muted">

                Manage all customer enquiries.

            </p>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card shadow border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>#</th>

                            <th>Sender</th>

                            <th>Receiver</th>

                            <th>Property</th>

                            <th>Message</th>

                            <th>Status</th>

                            <th>Date</th>

                            <th width="180">

                                Action

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($enquiries as $enquiry)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $enquiry->sender->name ?? 'N/A' }}

                            </td>

                            <td>

                                {{ $enquiry->receiver->name ?? 'N/A' }}

                            </td>

                            <td>

                                {{ $enquiry->property->title ?? 'N/A' }}

                            </td>

                            <td>

                                {{ \Illuminate\Support\Str::limit($enquiry->message,40) }}

                            </td>

                            <td>

                                @if($enquiry->status=='Pending')

                                    <span class="badge bg-warning text-dark">

                                        Pending

                                    </span>

                                @elseif($enquiry->status=='Replied')

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

                                <a href="{{ route('admin.enquiries.show',$enquiry) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <a href="{{ route('admin.enquiries.edit',$enquiry) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form action="{{ route('admin.enquiries.destroy',$enquiry) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete enquiry?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8"
                                class="text-center py-5">

                                No enquiries found.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $enquiries->links() }}

            </div>

        </div>

    </div>

</div>

@endsection