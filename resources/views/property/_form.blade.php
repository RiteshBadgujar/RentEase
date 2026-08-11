<div class="row">

    {{-- =========================================================
         Basic Property Information
    ========================================================== --}}

    <div class="col-12">
        <h5 class="fw-bold text-primary mb-3">
            <i class="bi bi-info-circle me-2"></i>
            Basic Property Information
        </h5>
        <hr>
    </div>


    {{-- Property Title --}}
    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">
            Property Title
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="title"
            value="{{ old('title', $property->title ?? '') }}"
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


    {{-- Property Type --}}
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

            @foreach([
                'Apartment',
                'House',
                'Villa',
                'PG',
                'Office',
                'Commercial'
            ] as $type)

                <option
                    value="{{ $type }}"
                    {{ old('property_type', $property->property_type ?? '') === $type ? 'selected' : '' }}>

                    {{ $type }}

                </option>

            @endforeach

        </select>

        @error('property_type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Purpose --}}
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
                {{ old('purpose', $property->purpose ?? '') === 'Rent' ? 'selected' : '' }}>
                Rent
            </option>

            <option
                value="Sale"
                {{ old('purpose', $property->purpose ?? '') === 'Sale' ? 'selected' : '' }}>
                Sale
            </option>

        </select>

        @error('purpose')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Price --}}
    <div class="col-md-3 mb-4">

        <label class="form-label fw-semibold">
            Price (₹)
            <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            name="price"
            value="{{ old('price', $property->price ?? '') }}"
            class="form-control @error('price') is-invalid @enderror"
            placeholder="Enter Property Price"
            min="0"
            step="0.01"
            required>

        @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Security Deposit --}}
    <div class="col-md-3 mb-4">

        <label class="form-label fw-semibold">
            Security Deposit
        </label>

        <input
            type="number"
            name="deposit"
            value="{{ old('deposit', $property->deposit ?? '') }}"
            class="form-control @error('deposit') is-invalid @enderror"
            placeholder="Enter Deposit Amount"
            min="0"
            step="0.01">

        @error('deposit')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- =========================================================
         Property Features
    ========================================================== --}}

    <div class="col-12 mt-2">

        <h5 class="fw-bold text-primary mb-3">
            <i class="bi bi-house-gear me-2"></i>
            Property Features
        </h5>

        <hr>

    </div>


    {{-- Bedrooms --}}
    <div class="col-md-3 mb-4">

        <label class="form-label fw-semibold">
            Bedrooms
            <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            name="bedrooms"
            min="0"
            value="{{ old('bedrooms', $property->bedrooms ?? '') }}"
            class="form-control @error('bedrooms') is-invalid @enderror"
            placeholder="0"
            required>

        @error('bedrooms')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Bathrooms --}}
    <div class="col-md-3 mb-4">

        <label class="form-label fw-semibold">
            Bathrooms
            <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            name="bathrooms"
            min="0"
            value="{{ old('bathrooms', $property->bathrooms ?? '') }}"
            class="form-control @error('bathrooms') is-invalid @enderror"
            placeholder="0"
            required>

        @error('bathrooms')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Balconies --}}
    <div class="col-md-3 mb-4">

        <label class="form-label fw-semibold">
            Balconies
        </label>

        <input
            type="number"
            name="balconies"
            min="0"
            value="{{ old('balconies', $property->balconies ?? '') }}"
            class="form-control @error('balconies') is-invalid @enderror"
            placeholder="0">

        @error('balconies')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Area --}}
    <div class="col-md-3 mb-4">

        <label class="form-label fw-semibold">
            Area (Sq. Ft.)
            <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            name="area"
            min="1"
            step="0.01"
            value="{{ old('area', $property->area ?? '') }}"
            class="form-control @error('area') is-invalid @enderror"
            placeholder="1200"
            required>

        @error('area')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Furnishing --}}
    <div class="col-md-6 mb-4">

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

            @foreach([
                'Fully Furnished',
                'Semi Furnished',
                'Unfurnished'
            ] as $furnishing)

                <option
                    value="{{ $furnishing }}"
                    {{ old('furnishing', $property->furnishing ?? '') === $furnishing ? 'selected' : '' }}>

                    {{ $furnishing }}

                </option>

            @endforeach

        </select>

        @error('furnishing')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Parking --}}
    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">
            Parking Available
            <span class="text-danger">*</span>
        </label>

        <select
            name="parking"
            class="form-select @error('parking') is-invalid @enderror"
            required>

            <option value="">
                Select Parking
            </option>

            <option
                value="1"
                {{ old('parking', $property->parking ?? '') == '1' ? 'selected' : '' }}>
                Yes
            </option>

            <option
                value="0"
                {{ old('parking', $property->parking ?? '') == '0' ? 'selected' : '' }}>
                No
            </option>

        </select>

        @error('parking')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- =========================================================
         Location Information
    ========================================================== --}}

    <div class="col-12 mt-2">

        <h5 class="fw-bold text-primary mb-3">
            <i class="bi bi-geo-alt-fill me-2"></i>
            Location Information
        </h5>

        <hr>

    </div>


    {{-- Address --}}
    <div class="col-12 mb-4">

        <label class="form-label fw-semibold">
            Full Address
            <span class="text-danger">*</span>
        </label>

        <textarea
            name="address"
            rows="3"
            maxlength="500"
            class="form-control @error('address') is-invalid @enderror"
            placeholder="Enter Full Property Address"
            required>{{ old('address', $property->address ?? '') }}</textarea>

        @error('address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- City --}}
    <div class="col-md-4 mb-4">

        <label class="form-label fw-semibold">
            City
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="city"
            value="{{ old('city', $property->city ?? '') }}"
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


    {{-- State --}}
    <div class="col-md-4 mb-4">

        <label class="form-label fw-semibold">
            State
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="state"
            value="{{ old('state', $property->state ?? '') }}"
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


    {{-- Pincode --}}
    <div class="col-md-4 mb-4">

        <label class="form-label fw-semibold">
            Pincode
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="pincode"
            value="{{ old('pincode', $property->pincode ?? '') }}"
            class="form-control @error('pincode') is-invalid @enderror"
            placeholder="Enter 6-digit Pincode"
            maxlength="6"
            pattern="[0-9]{6}"
            inputmode="numeric"
            required>

        @error('pincode')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Description --}}
    <div class="col-12 mb-4">

        <label class="form-label fw-semibold">
            Property Description
            <span class="text-danger">*</span>
        </label>

        <textarea
            name="description"
            rows="6"
            minlength="20"
            maxlength="5000"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Describe your property in detail..."
            required>{{ old('description', $property->description ?? '') }}</textarea>

        <div class="form-text">
            Minimum 20 characters and maximum 5000 characters.
        </div>

        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- =========================================================
         Property Image
    ========================================================== --}}

    <div class="col-md-6 mb-4">

        <label
            class="form-label fw-semibold"
            for="image">

            Property Image

        </label>


        {{-- Existing Image --}}
        @if(isset($property) && $property->image)

            <div class="mb-3">

                <p class="text-muted mb-2">
                    Current Image:
                </p>

                <img
                    id="imagePreview"
                    src="{{ $property->image_url }}"
                    class="img-thumbnail rounded shadow"
                    style="max-width:220px; max-height:180px; object-fit:cover;"
                    alt="{{ $property->title }}">

            </div>

        @else

            {{-- New Image Preview --}}
            <div class="mb-3">

                <div
                    id="imagePreviewContainer"
                    class="border rounded bg-light d-flex align-items-center justify-content-center"
                    style="width:220px; height:150px;">

                    <div
                        id="noImageText"
                        class="text-center text-muted">

                        <i class="bi bi-image fs-1"></i>

                        <div>
                            Image Preview
                        </div>

                    </div>

                    <img
                        id="imagePreview"
                        src=""
                        class="img-thumbnail rounded shadow"
                        style="max-width:220px; max-height:180px; object-fit:cover; display:none;"
                        alt="Image Preview">

                </div>

            </div>

        @endif


        {{-- Image Input --}}
        <input
            id="image"
            type="file"
            name="image"
            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
            class="form-control @error('image') is-invalid @enderror">

        <div class="form-text">
            Optional. JPG, JPEG or PNG only. Maximum size: 2 MB.
        </div>

        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- =========================================================
         Property Status
    ========================================================== --}}

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

            {{-- IMPORTANT:
                 Database only supports Available and Rented.
                 Do NOT add Pending here. --}}

            <option
                value="Available"
                {{ old('status', $property->status ?? 'Available') === 'Available' ? 'selected' : '' }}>
                Available
            </option>

            <option
                value="Rented"
                {{ old('status', $property->status ?? '') === 'Rented' ? 'selected' : '' }}>
                Rented
            </option>

        </select>

        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- =========================================================
         Form Buttons
    ========================================================== --}}

    <div class="col-12">

        <hr class="my-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

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

                    {{ isset($property) ? 'Update Property' : 'Save Property' }}

                </button>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     Image Preview Script
========================================================== --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const noImageText = document.getElementById('noImageText');

    if (!imageInput || !imagePreview) {
        return;
    }

    imageInput.addEventListener('change', function (event) {

        const file = event.target.files[0];

        if (!file) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | File Type Validation
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

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | File Size Validation
        |--------------------------------------------------------------------------
        */

        const maxSize = 2 * 1024 * 1024;

        if (file.size > maxSize) {

            alert(
                'Image size must not exceed 2 MB.'
            );

            imageInput.value = '';

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Preview New Image
        |--------------------------------------------------------------------------
        */

        const reader = new FileReader();

        reader.onload = function (e) {

            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';

            if (noImageText) {
                noImageText.style.display = 'none';
            }
        };

        reader.readAsDataURL(file);

    });

});
</script>