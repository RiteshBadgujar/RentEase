@extends('layouts.admin')

@section('title', 'Edit Property')

@section('content')

<div class="container-fluid py-4">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-header bg-warning">

                    <h4 class="mb-0">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Property

                    </h4>

                </div>

                <div class="card-body">

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form
                        action="{{ route('admin.properties.update',$property) }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        @method('PUT')

                        <div class="row">

                            <div class="col-md-4 text-center mb-4">

                                @if($property->image)

                                    <img
                                        src="{{ asset('storage/'.$property->image) }}"
                                        class="img-fluid rounded shadow"
                                        style="height:220px;width:100%;object-fit:cover;">

                                @else

                                    <div
                                        class="bg-light rounded d-flex justify-content-center align-items-center"
                                        style="height:220px;">

                                        <div>

                                            <i class="bi bi-image display-3 text-secondary"></i>

                                            <p class="text-muted mt-2">

                                                No Image

                                            </p>

                                        </div>

                                    </div>

                                @endif

                            </div>

                            <div class="col-md-8">

                                <div class="row">

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label fw-bold">

                                            Property ID

                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            value="{{ $property->id }}"
                                            readonly>

                                    </div>

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label fw-bold">

                                            Property Title

                                        </label>

                                        <input
                                            type="text"
                                            name="title"
                                            value="{{ old('title',$property->title) }}"
                                            class="form-control @error('title') is-invalid @enderror"
                                            required>

                                        @error('title')

                                            <div class="invalid-feedback">

                                                {{ $message }}

                                            </div>

                                        @enderror

                                    </div>

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label fw-bold">

                                            Property Type

                                        </label>

                                        <select
                                            name="property_type"
                                            class="form-select">

                                            <option value="Apartment"
                                                {{ old('property_type',$property->property_type)=='Apartment'?'selected':'' }}>

                                                Apartment

                                            </option>

                                            <option value="House"
                                                {{ old('property_type',$property->property_type)=='House'?'selected':'' }}>

                                                House

                                            </option>

                                            <option value="Villa"
                                                {{ old('property_type',$property->property_type)=='Villa'?'selected':'' }}>

                                                Villa

                                            </option>

                                            <option value="PG"
                                                {{ old('property_type',$property->property_type)=='PG'?'selected':'' }}>

                                                PG

                                            </option>

                                        </select>

                                    </div>

                                                    <div class="col-md-6 mb-3">

                                        <label class="form-label fw-bold">

                                            Price (₹)

                                        </label>

                                        <input
                                            type="number"
                                            name="price"
                                            value="{{ old('price',$property->price) }}"
                                            class="form-control @error('price') is-invalid @enderror"
                                            required>

                                        @error('price')

                                            <div class="invalid-feedback">

                                                {{ $message }}

                                            </div>

                                        @enderror

                                    </div>

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label fw-bold">

                                            Status

                                        </label>

                                        <select
                                            name="status"
                                            class="form-select">

                                            <option value="Available"
                                                {{ old('status',$property->status)=='Available' ? 'selected' : '' }}>

                                                Available

                                            </option>

                                            <option value="Rented"
                                                {{ old('status',$property->status)=='Rented' ? 'selected' : '' }}>

                                                Rented

                                            </option>

                                            <option value="Pending"
                                                {{ old('status',$property->status)=='Pending' ? 'selected' : '' }}>

                                                Pending

                                            </option>

                                        </select>

                                    </div>

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label fw-bold">

                                            City

                                        </label>

                                        <input
                                            type="text"
                                            name="city"
                                            value="{{ old('city',$property->city) }}"
                                            class="form-control @error('city') is-invalid @enderror"
                                            required>

                                        @error('city')

                                            <div class="invalid-feedback">

                                                {{ $message }}

                                            </div>

                                        @enderror

                                    </div>

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label fw-bold">

                                            Address

                                        </label>

                                        <input
                                            type="text"
                                            name="address"
                                            value="{{ old('address',$property->address) }}"
                                            class="form-control @error('address') is-invalid @enderror"
                                            required>

                                        @error('address')

                                            <div class="invalid-feedback">

                                                {{ $message }}

                                            </div>

                                        @enderror

                                    </div>

                                </div>

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label fw-bold">

                                    Description

                                </label>

                                <textarea
                                    name="description"
                                    rows="5"
                                    class="form-control @error('description') is-invalid @enderror"
                                    required>{{ old('description',$property->description) }}</textarea>

                                @error('description')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Change Property Image

                                </label>

                                <input
                                    type="file"
                                    name="image"
                                    class="form-control"
                                    accept="image/*">

                                <small class="text-muted">

                                    Leave empty to keep the current image.

                                </small>

                            </div>

                            <div class="col-md-6 mb-4 d-flex align-items-end">

                                @if($property->image)

                                    <img
                                        src="{{ asset('storage/'.$property->image) }}"
                                        class="img-thumbnail shadow"
                                        style="height:120px;object-fit:cover;">

                                @endif

                            </div>     
                                                    <hr class="my-4">

                        <div class="d-flex justify-content-between">

                            <a
                                href="{{ route('admin.properties.index') }}"
                                class="btn btn-secondary">

                                <i class="bi bi-arrow-left me-2"></i>

                                Back

                            </a>

                            <div>

                                <button
                                    type="reset"
                                    class="btn btn-outline-dark me-2">

                                    <i class="bi bi-arrow-clockwise me-2"></i>

                                    Reset

                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-success">

                                    <i class="bi bi-check-circle-fill me-2"></i>

                                    Update Property

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
