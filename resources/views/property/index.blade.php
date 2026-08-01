@extends('layouts.master')

@section('title', 'Property Management')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold mb-0">

            <i class="bi bi-buildings text-primary me-2"></i>

            Property Management

            <span class="badge bg-primary ms-2">

                {{ $properties->total() }}

            </span>

        </h2>

        <a href="{{ route('properties.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle me-1"></i>

            Add Property

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button"
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

                        <th>Image</th>

                        <th>Title</th>

                        <th>Type</th>

                        <th>Purpose</th>

                        <th>Price</th>

                        <th>City</th>

                        <th>Status</th>

                        <th width="190" class="text-center">

                            Actions

                        </th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($properties as $property)

                    <tr>

                        <td>

                            {{ $properties->firstItem() + $loop->index }}

                        </td>

                        <td>

                            @if($property->image)

                                <img
                                    src="{{ asset('uploads/properties/'.$property->image) }}"
                                    alt="{{ $property->title }}"
                                    width="90"
                                    height="70"
                                    class="rounded shadow-sm object-fit-cover">

                            @else

                                <span class="badge bg-secondary">

                                    No Image

                                </span>

                            @endif

                        </td>

                        <td>

                            <strong>

                                {{ $property->title }}

                            </strong>

                        </td>

                        <td>

                            {{ $property->property_type }}

                        </td>

                        <td>

                            {{ $property->purpose }}

                        </td>

                        <td>

                            <strong class="text-success">

                                ₹{{ number_format($property->price,2) }}

                            </strong>

                        </td>

                        <td>

                            {{ $property->city }}

                        </td>

                        <td>

                            @if($property->status=='Available')

                                <span class="badge bg-success">

                                    Available

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Rented

                                </span>

                            @endif

                        </td>

                        <td class="text-center">

                            <a href="{{ route('properties.show',$property->id) }}"
                               class="btn btn-info btn-sm"
                               title="View">

                                <i class="bi bi-eye"></i>

                            </a>

                            <a href="{{ route('properties.edit',$property->id) }}"
                               class="btn btn-warning btn-sm"
                               title="Edit">

                                <i class="bi bi-pencil-square"></i>

                            </a>

                            <form action="{{ route('properties.destroy',$property->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this property?')">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9">

                            <div class="text-center py-5">

                                <i class="bi bi-house display-1 text-secondary"></i>

                                <h4 class="mt-3">

                                    No Properties Found

                                </h4>

                                <p class="text-muted">

                                    Click the <strong>Add Property</strong> button to create your first property.

                                </p>

                                <a href="{{ route('properties.create') }}"
                                   class="btn btn-primary">

                                    <i class="bi bi-plus-circle me-1"></i>

                                    Add Property

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-center mt-4">

                {{ $properties->links() }}

            </div>

        </div>

    </div>

</div>

@endsection