@extends('layouts.master')

@section('title', 'Add Property')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow-lg border-0 rounded-4">

                <!-- ==========================
                        Header
                =========================== -->

                <div class="card-header bg-primary text-white">

                    <h3 class="mb-0">

                        <i class="bi bi-house-add-fill me-2"></i>

                        Add New Property

                    </h3>

                </div>


                <div class="card-body p-4">

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
                            Validation Errors
                    =========================== -->

                    @if($errors->any())

                        <div class="alert alert-danger" role="alert">

                            <strong>

                                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                                Please fix the following errors:

                            </strong>

                            <ul class="mb-0 mt-2">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <!-- ==========================
                            Property Form
                    =========================== -->

                    <form
                        action="{{ route('properties.store') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf


                        <div class="row">

                            <!-- ==========================
                                    Basic Information
                            =========================== -->

                            <div class="col-12">

                                <h5 class="fw-bold text-primary mb-3">

                                    <i class="bi bi-info-circle me-2"></i>

                                    Basic Property Information

                                </h5>

                                <hr>

                            </div>


                            <!-- Property Title -->

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Property Title

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    value="{{ old('title') }}"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Enter Property Title"
                                    maxlength="255"
                                    required>

                                @error('title')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Property Type -->

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Property Type

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="property_type"
                                    class="form-select @error('property_type') is-invalid @enderror"
                                    required>

                                    <option value="">

                                        Select Property Type

                                    </option>

                                    <option
                                        value="Apartment"
                                        {{ old('property_type') === 'Apartment' ? 'selected' : '' }}>

                                        Apartment

                                    </option>

                                    <option
                                        value="House"
                                        {{ old('property_type') === 'House' ? 'selected' : '' }}>

                                        House

                                    </option>

                                    <option
                                        value="Villa"
                                        {{ old('property_type') === 'Villa' ? 'selected' : '' }}>

                                        Villa

                                    </option>

                                    <option
                                        value="PG"
                                        {{ old('property_type') === 'PG' ? 'selected' : '' }}>

                                        PG

                                    </option>

                                    <option
                                        value="Office"
                                        {{ old('property_type') === 'Office' ? 'selected' : '' }}>

                                        Office

                                    </option>

                                    <option
                                        value="Commercial"
                                        {{ old('property_type') === 'Commercial' ? 'selected' : '' }}>

                                        Commercial

                                    </option>

                                </select>

                                @error('property_type')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Purpose -->

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Purpose

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="purpose"
                                    class="form-select @error('purpose') is-invalid @enderror"
                                    required>

                                    <option value="">

                                        Select Purpose

                                    </option>

                                    <option
                                        value="Rent"
                                        {{ old('purpose') === 'Rent' ? 'selected' : '' }}>

                                        Rent

                                    </option>

                                    <option
                                        value="Sale"
                                        {{ old('purpose') === 'Sale' ? 'selected' : '' }}>

                                        Sale

                                    </option>

                                </select>

                                @error('purpose')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Price -->

                            <div class="col-md-3 mb-4">

                                <label class="form-label fw-semibold">

                                    Price (₹)

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="number"
                                    name="price"
                                    value="{{ old('price') }}"
                                    class="form-control @error('price') is-invalid @enderror"
                                    min="0"
                                    step="0.01"
                                    placeholder="5000"
                                    required>

                                @error('price')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Deposit -->

                            <div class="col-md-3 mb-4">

                                <label class="form-label fw-semibold">

                                    Security Deposit

                                </label>

                                <input
                                    type="number"
                                    name="deposit"
                                    value="{{ old('deposit') }}"
                                    class="form-control @error('deposit') is-invalid @enderror"
                                    min="0"
                                    step="0.01"
                                    placeholder="10000">

                                @error('deposit')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Bedrooms -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Bedrooms

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="number"
                                    name="bedrooms"
                                    value="{{ old('bedrooms') }}"
                                    class="form-control @error('bedrooms') is-invalid @enderror"
                                    min="0"
                                    placeholder="2"
                                    required>

                                @error('bedrooms')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Bathrooms -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Bathrooms

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="number"
                                    name="bathrooms"
                                    value="{{ old('bathrooms') }}"
                                    class="form-control @error('bathrooms') is-invalid @enderror"
                                    min="0"
                                    placeholder="2"
                                    required>

                                @error('bathrooms')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- ==========================
                                    Property Features
                            =========================== -->

                            <div class="col-12 mt-2">

                                <h5 class="fw-bold text-primary mb-3">

                                    <i class="bi bi-house-gear me-2"></i>

                                    Property Features

                                </h5>

                                <hr>

                            </div>


                            <!-- Balconies -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Balconies

                                </label>

                                <input
                                    type="number"
                                    name="balconies"
                                    value="{{ old('balconies') }}"
                                    min="0"
                                    class="form-control @error('balconies') is-invalid @enderror"
                                    placeholder="Number of balconies">

                                @error('balconies')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Area -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Area (Sq. Ft.)

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="number"
                                    name="area"
                                    value="{{ old('area') }}"
                                    min="1"
                                    step="0.01"
                                    class="form-control @error('area') is-invalid @enderror"
                                    placeholder="1200"
                                    required>

                                @error('area')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Furnishing -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Furnishing

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="furnishing"
                                    class="form-select @error('furnishing') is-invalid @enderror"
                                    required>

                                    <option value="">

                                        Select Furnishing

                                    </option>

                                    <option
                                        value="Fully Furnished"
                                        {{ old('furnishing') === 'Fully Furnished' ? 'selected' : '' }}>

                                        Fully Furnished

                                    </option>

                                    <option
                                        value="Semi Furnished"
                                        {{ old('furnishing') === 'Semi Furnished' ? 'selected' : '' }}>

                                        Semi Furnished

                                    </option>

                                    <option
                                        value="Unfurnished"
                                        {{ old('furnishing') === 'Unfurnished' ? 'selected' : '' }}>

                                        Unfurnished

                                    </option>

                                </select>

                                @error('furnishing')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Parking -->

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Parking

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="parking"
                                    class="form-select @error('parking') is-invalid @enderror"
                                    required>

                                    <option value="">

                                        Select Parking Availability

                                    </option>

                                    <option
                                        value="1"
                                        {{ old('parking') === '1' ? 'selected' : '' }}>

                                        Available

                                    </option>

                                    <option
                                        value="0"
                                        {{ old('parking') === '0' ? 'selected' : '' }}>

                                        Not Available

                                    </option>

                                </select>

                                @error('parking')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- ==========================
                                    Location Information
                            =========================== -->

                            <div class="col-12 mt-2">

                                <h5 class="fw-bold text-primary mb-3">

                                    <i class="bi bi-geo-alt-fill me-2"></i>

                                    Location Information

                                </h5>

                                <hr>

                            </div>


                            <!-- Address -->

                            <div class="col-12 mb-4">

                                <label class="form-label fw-semibold">

                                    Address

                                    <span class="text-danger">*</span>

                                </label>

                                <textarea
                                    name="address"
                                    rows="3"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Enter Complete Address"
                                    maxlength="500"
                                    required>{{ old('address') }}</textarea>

                                @error('address')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- City -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    City

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    value="{{ old('city') }}"
                                    class="form-control @error('city') is-invalid @enderror"
                                    placeholder="Enter City"
                                    maxlength="100"
                                    required>

                                @error('city')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- State -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    State

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="state"
                                    value="{{ old('state') }}"
                                    class="form-control @error('state') is-invalid @enderror"
                                    placeholder="Enter State"
                                    maxlength="100"
                                    required>

                                @error('state')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Pincode -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Pincode

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="pincode"
                                    value="{{ old('pincode') }}"
                                    class="form-control @error('pincode') is-invalid @enderror"
                                    placeholder="Enter 6-digit Pincode"
                                    maxlength="6"
                                    minlength="6"
                                    pattern="[0-9]{6}"
                                    inputmode="numeric"
                                    required>

                                @error('pincode')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- Description -->

                            <div class="col-12 mb-4">

                                <label class="form-label fw-semibold">

                                    Property Description

                                    <span class="text-danger">*</span>

                                </label>

                                <textarea
                                    name="description"
                                    rows="6"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Describe your property..."
                                    minlength="20"
                                    maxlength="5000"
                                    required>{{ old('description') }}</textarea>

                                <div class="form-text">

                                    Minimum 20 characters and maximum 5000 characters.

                                </div>

                                @error('description')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- ==========================
                                    Property Image
                            =========================== -->

                            <div class="col-md-6 mb-4">

                                <label
                                    class="form-label fw-semibold"
                                    for="image">

                                    Property Image

                                </label>

                                <input
                                    type="file"
                                    name="image"
                                    id="image"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                    class="form-control @error('image') is-invalid @enderror">

                                <div class="form-text">

                                    JPG, JPEG or PNG only. Maximum size: 2 MB.

                                </div>

                                @error('image')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror


                                <!-- Image Preview -->

                                <div class="mt-3">

                                    <div
                                        id="imagePreviewContainer"
                                        class="border rounded p-2 text-center bg-light"
                                        style="min-height:180px;">

                                        <div
                                            id="noImageText"
                                            class="d-flex align-items-center justify-content-center"
                                            style="height:160px;">

                                            <div>

                                                <i class="bi bi-image fs-1 text-secondary"></i>

                                                <p class="text-muted mb-0">

                                                    Image Preview

                                                </p>

                                            </div>

                                        </div>

                                        <img
                                            id="imagePreview"
                                            src=""
                                            alt="Image Preview"
                                            class="img-fluid rounded"
                                            style="max-height:180px; display:none;">

                                    </div>

                                </div>

                            </div>


                            <!-- ==========================
                                    Property Status
                            =========================== -->

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Property Status

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    required>

                                    <option value="">

                                        Select Status

                                    </option>

                                    <option
                                        value="Available"
                                        {{ old('status', 'Available') === 'Available' ? 'selected' : '' }}>

                                        Available

                                    </option>

                                    <option
                                        value="Rented"
                                        {{ old('status') === 'Rented' ? 'selected' : '' }}>

                                        Rented

                                    </option>

                                </select>

                                @error('status')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>


                            <!-- ==========================
                                    Buttons
                            =========================== -->

                            <div class="col-12">

                                <hr>

                                <div class="d-flex justify-content-between flex-wrap gap-2">

                                    <a
                                        href="{{ route('properties.index') }}"
                                        class="btn btn-secondary">

                                        <i class="bi bi-arrow-left me-2"></i>

                                        Back

                                    </a>


                                    <div>

                                        <button
                                            type="reset"
                                            class="btn btn-outline-danger me-2">

                                            <i class="bi bi-arrow-clockwise me-2"></i>

                                            Reset

                                        </button>


                                        <button
                                            type="submit"
                                            class="btn btn-primary">

                                            <i class="bi bi-check-circle me-2"></i>

                                            Save Property

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- ==========================
        Image Preview Script
=========================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('image');

    const imagePreview = document.getElementById('imagePreview');

    const noImageText = document.getElementById('noImageText');


    if (!imageInput) {

        return;

    }


    imageInput.addEventListener('change', function (event) {

        const file = event.target.files[0];


        if (!file) {

            imagePreview.src = '';

            imagePreview.style.display = 'none';

            noImageText.style.display = 'flex';

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Client-side File Type Validation
        |--------------------------------------------------------------------------
        */

        const allowedTypes = [
            'image/jpeg',
            'image/png'
        ];


        if (!allowedTypes.includes(file.type)) {

            alert(
                'Please select a JPG, JPEG or PNG image.'
            );

            imageInput.value = '';

            imagePreview.src = '';

            imagePreview.style.display = 'none';

            noImageText.style.display = 'flex';

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Client-side File Size Validation
        |--------------------------------------------------------------------------
        */

        const maxSize = 2 * 1024 * 1024;


        if (file.size > maxSize) {

            alert(
                'Image size must not exceed 2 MB.'
            );

            imageInput.value = '';

            imagePreview.src = '';

            imagePreview.style.display = 'none';

            noImageText.style.display = 'flex';

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Show Preview
        |--------------------------------------------------------------------------
        */

        const reader = new FileReader();


        reader.onload = function (e) {

            imagePreview.src = e.target.result;

            imagePreview.style.display = 'inline-block';

            noImageText.style.display = 'none';

        };


        reader.readAsDataURL(file);

    });


    /*
    |--------------------------------------------------------------------------
    | Reset Image Preview
    |--------------------------------------------------------------------------
    */

    const form = imageInput.closest('form');


    if (form) {

        form.addEventListener('reset', function () {

            setTimeout(function () {

                imagePreview.src = '';

                imagePreview.style.display = 'none';

                noImageText.style.display = 'flex';

            }, 50);

        });

    }

});

</script>

@endsection