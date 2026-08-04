@extends('layouts.master')

@section('title', 'Enquiry Details')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            <i class="bi bi-chat-left-text-fill text-primary me-2"></i>

            Enquiry Details

        </h2>

        <a href="{{ route('admin.enquiries.index') }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left me-2"></i>

            Back

        </a>

    </div>

    <div class="card shadow border-0 rounded-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <h5 class="fw-bold mb-3">

                        Sender Details

                    </h5>

                    <p><strong>Name :</strong> {{ $enquiry->sender->name ?? 'N/A' }}</p>

                    <p><strong>Email :</strong> {{ $enquiry->sender->email ?? 'N/A' }}</p>

                </div>

                <div class="col-md-6">

                    <h5 class="fw-bold mb-3">

                        Receiver Details

                    </h5>

                    <p><strong>Name :</strong> {{ $enquiry->receiver->name ?? 'N/A' }}</p>

                    <p><strong>Email :</strong> {{ $enquiry->receiver->email ?? 'N/A' }}</p>

                </div>

            </div>

            <hr>

            <h5 class="fw-bold">

                Property Information

            </h5>

            <p>

                <strong>Property :</strong>

                {{ $enquiry->property->title ?? 'N/A' }}

            </p>

            <hr>

            <h5 class="fw-bold">

                Message

            </h5>

            <div class="border rounded p-3 bg-light">

                {{ $enquiry->message }}

            </div>

            <hr>

            <h5 class="fw-bold">

                Status

            </h5>

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

            <hr>

            <a href="{{ route('admin.enquiries.edit',$enquiry) }}"
               class="btn btn-warning">

                <i class="bi bi-pencil-square me-2"></i>

                Edit

            </a>

            <form action="{{ route('admin.enquiries.destroy',$enquiry) }}"
                  method="POST"
                  class="d-inline">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger"
                        onclick="return confirm('Delete enquiry?')">

                    <i class="bi bi-trash me-2"></i>

                    Delete

                </button>

            </form>

        </div>

    </div>

</div>

@endsection