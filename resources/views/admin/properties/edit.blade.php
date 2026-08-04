@extends('layouts.master')

@section('title', 'Edit Property')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card border-0 shadow-lg rounded-4">

                <div class="card-header bg-warning text-dark py-3">

                    <h3 class="mb-0">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Property

                    </h3>

                </div>

                <div class="card-body p-5">

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form action="{{ route('admin.properties.update',$property) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Property Title

                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    value="{{ old('title',$property->title) }}"
                                    required>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Property Type

                                </label>

                                <input
                                    type="text"
                                    name="property_type"
                                    class="form-control"
                                    value="{{ old('property_type',$property->property_type) }}"
                                    required>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Price

                                </label>

                                <input
                                    type="number"
                                    name="price"
                                    class="form-control"
                                    value="{{ old('price',$property->price) }}"
                                    required>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Status

                                </label>

                                <select
                                    name="status"
                                    class="form-select">

                                    <option value="Available"
                                        {{ $property->status=='Available' ? 'selected':'' }}>

                                        Available

                                    </option>

                                    <option value="Rented"
                                        {{ $property->status=='Rented' ? 'selected':'' }}>

                                        Rented

                                    </option>

                                    <option value="Pending"
                                        {{ $property->status=='Pending' ? 'selected':'' }}>

                                        Pending

                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    City

                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    class="form-control"
                                    value="{{ old('city',$property->city) }}"
                                    required>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Address

                                </label>

                                <input
                                    type="text"
                                    name="address"
                                    class="form-control"
                                    value="{{ old('address',$property->address) }}"
                                    required>

                            </div>

                            <div class="col-12 mb-4">

                                <label class="form-label fw-bold">

                                    Description

                                </label>

                                <textarea
                                    name="description"
                                    rows="5"
                                    class="form-control"
                                    required>{{ old('description',$property->description) }}</textarea>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Property Image

                                </label>

                                <input
                                    type="file"
                                    name="image"
                                    class="form-control">

                            </div>

                            <div class="col-md-6 mb-4">

                                @if($property->image)

                                    <img
                                        src="{{ asset('storage/'.$property->image) }}"
                                        class="img-fluid rounded shadow"
                                        style="max-height:180px;">

                                @endif

                            </div>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('admin.properties.index') }}"
                               class="btn btn-secondary">

                                <i class="bi bi-arrow-left me-2"></i>

                                Back

                            </a>

                            <button
                                class="btn btn-success">

                                <i class="bi bi-check-circle me-2"></i>

                                Update Property

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection