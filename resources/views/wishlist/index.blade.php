@extends('layouts.master')

@section('title', 'My Wishlist')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            <i class="bi bi-heart-fill text-danger me-2"></i>

            My Wishlist

        </h2>

        <a
            href="{{ route('properties.index') }}"
            class="btn btn-primary">

            <i class="bi bi-arrow-left me-1"></i>

            Back to Properties

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

                            <th>Image</th>

                            <th>Title</th>

                            <th>Type</th>

                            <th>City</th>

                            <th>Price</th>

                            <th>Status</th>

                            <th width="180">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($wishlists as $wishlist)

                            @if(!$wishlist->property)

                                @continue

                            @endif

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                <td>

                                    @if($wishlist->property && $wishlist->property->image)

                                        <img
                                            src="{{ asset('uploads/properties/'.$wishlist->property->image) }}"
                                            width="80"
                                            class="rounded shadow"
                                            alt="{{ $wishlist->property->title }}">

                                    @else

                                        <span class="badge bg-secondary">

                                            No Image

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ $wishlist->property->title }}

                                </td>

                                <td>

                                    {{ $wishlist->property->property_type }}

                                </td>

                                <td>

                                    {{ $wishlist->property->city }}

                                </td>

                                <td>

                                    ₹{{ number_format($wishlist->property->price) }}

                                </td>

                                <td>

                                    @if($wishlist->property->status == 'Available')

                                        <span class="badge bg-success">

                                            Available

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Rented

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a
                                        href="{{ route('properties.show', $wishlist->property->id) }}"
                                        class="btn btn-info btn-sm">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    <form
                                        action="{{ route('wishlist.destroy', $wishlist->property->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Remove from wishlist?')">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-5">

                                    <i class="bi bi-heart display-1 text-secondary"></i>

                                    <h4 class="mt-3">

                                        Your Wishlist is Empty

                                    </h4>

                                    <p class="text-muted">

                                        Browse properties and add your favorite properties.

                                    </p>

                                    <a
                                        href="{{ route('properties.index') }}"
                                        class="btn btn-primary">

                                        Browse Properties

                                    </a>

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