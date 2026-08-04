@extends('layouts.master')

@section('title', 'Property Details')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            <i class="bi bi-house-door-fill text-primary me-2"></i>

            Property Details

        </h2>

        <a href="{{ route('admin.properties.index') }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left me-2"></i>

            Back

        </a>

    </div>

    <div class="card shadow border-0 rounded-4">

        @if($property->image)

            <img src="{{ asset('storage/'.$property->image) }}"
                 class="card-img-top"
                 style="height:420px;object-fit:cover;">

        @endif

        <div class="card-body p-4">

            <div class="row">

                <div class="col-lg-8">

                    <h2 class="fw-bold">

                        {{ $property->title }}

                    </h2>

                    <p class="text-muted">

                        <i class="bi bi-geo-alt-fill me-2"></i>

                        {{ $property->address }}, {{ $property->city }}

                    </p>

                    <hr>

                    <h5>

                        Description

                    </h5>

                    <p>

                        {{ $property->description }}

                    </p>

                </div>

                <div class="col-lg-4">

                    <div class="card bg-light border-0">

                        <div class="card-body">

                            <h5 class="mb-4">

                                Property Information

                            </h5>

                            <table class="table table-borderless">

                                <tr>

                                    <th>Owner</th>

                                    <td>{{ $property->user->name }}</td>

                                </tr>

                                <tr>

                                    <th>Type</th>

                                    <td>{{ $property->property_type }}</td>

                                </tr>

                                <tr>

                                    <th>Price</th>

                                    <td>

                                        ₹{{ number_format($property->price) }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Status</th>

                                    <td>

                                        @if($property->status=='Available')

                                            <span class="badge bg-success">

                                                Available

                                            </span>

                                        @elseif($property->status=='Rented')

                                            <span class="badge bg-danger">

                                                Rented

                                            </span>

                                        @else

                                            <span class="badge bg-warning text-dark">

                                                Pending

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                                <tr>

                                    <th>Bookings</th>

                                    <td>

                                        {{ $property->bookings->count() }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Wishlist</th>

                                    <td>

                                        {{ $property->wishlists->count() }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Enquiries</th>

                                    <td>

                                        {{ $property->enquiries->count() }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Created</th>

                                    <td>

                                        {{ $property->created_at->format('d M Y') }}

                                    </td>

                                </tr>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            <hr>

            <a href="{{ route('admin.properties.edit',$property) }}"
               class="btn btn-warning">

                <i class="bi bi-pencil-square me-2"></i>

                Edit Property

            </a>

            <form action="{{ route('admin.properties.destroy',$property) }}"
                  method="POST"
                  class="d-inline">

                @csrf
                @method('DELETE')

                <button
                    class="btn btn-danger"
                    onclick="return confirm('Delete this property?')">

                    <i class="bi bi-trash me-2"></i>

                    Delete

                </button>

            </form>

        </div>

    </div>

</div>

@endsection