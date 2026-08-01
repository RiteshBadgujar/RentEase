<div class="row">

    <!-- Property Title -->
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Property Title <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="title"
            value="{{ old('title', $property->title ?? '') }}"
            class="form-control @error('title') is-invalid @enderror"
            placeholder="Enter Property Title">

        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- Property Type -->
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Property Type <span class="text-danger">*</span>
        </label>

        <select
            name="property_type"
            class="form-select @error('property_type') is-invalid @enderror">

            <option value="">Select Property Type</option>

            <option value="Apartment"
                {{ old('property_type', $property->property_type ?? '') == 'Apartment' ? 'selected' : '' }}>
                Apartment
            </option>

            <option value="Villa"
                {{ old('property_type', $property->property_type ?? '') == 'Villa' ? 'selected' : '' }}>
                Villa
            </option>

            <option value="House"
                {{ old('property_type', $property->property_type ?? '') == 'House' ? 'selected' : '' }}>
                House
            </option>

            <option value="Office"
                {{ old('property_type', $property->property_type ?? '') == 'Office' ? 'selected' : '' }}>
                Office
            </option>

            <option value="Shop"
                {{ old('property_type', $property->property_type ?? '') == 'Shop' ? 'selected' : '' }}>
                Shop
            </option>

            <option value="Land"
                {{ old('property_type', $property->property_type ?? '') == 'Land' ? 'selected' : '' }}>
                Land
            </option>

        </select>

        @error('property_type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- Purpose -->
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Purpose <span class="text-danger">*</span>
        </label>

        <select
            name="purpose"
            class="form-select @error('purpose') is-invalid @enderror">

            <option value="">Select Purpose</option>

            <option value="Rent"
                {{ old('purpose', $property->purpose ?? '') == 'Rent' ? 'selected' : '' }}>
                Rent
            </option>

            <option value="Sale"
                {{ old('purpose', $property->purpose ?? '') == 'Sale' ? 'selected' : '' }}>
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
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Price (₹) <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            name="price"
            value="{{ old('price', $property->price ?? '') }}"
            class="form-control @error('price') is-invalid @enderror"
            placeholder="Enter Property Price">

        @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- Deposit -->
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Security Deposit
        </label>

        <input
            type="number"
            name="deposit"
            value="{{ old('deposit', $property->deposit ?? '') }}"
            class="form-control"
            placeholder="Enter Deposit Amount">

    </div>

    <!-- Bedrooms -->
    <div class="col-md-3 mb-3">

        <label class="form-label">
            Bedrooms
        </label>

        <input
            type="number"
            name="bedrooms"
            value="{{ old('bedrooms', $property->bedrooms ?? '') }}"
            class="form-control @error('bedrooms') is-invalid @enderror">

        @error('bedrooms')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- Bathrooms -->
    <div class="col-md-3 mb-3">

        <label class="form-label">
            Bathrooms
        </label>

        <input
            type="number"
            name="bathrooms"
            value="{{ old('bathrooms', $property->bathrooms ?? '') }}"
            class="form-control @error('bathrooms') is-invalid @enderror">

        @error('bathrooms')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>
        <!-- Balconies -->
    <div class="col-md-3 mb-3">

        <label class="form-label">
            Balconies
        </label>

        <input
            type="number"
            name="balconies"
            value="{{ old('balconies', $property->balconies ?? '') }}"
            class="form-control @error('balconies') is-invalid @enderror">

        @error('balconies')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- Area -->
    <div class="col-md-3 mb-3">

        <label class="form-label">
            Area (Sq. Ft.) <span class="text-danger">*</span>
        </label>

        <input
            type="number"
            name="area"
            value="{{ old('area', $property->area ?? '') }}"
            class="form-control @error('area') is-invalid @enderror"
            placeholder="1200">

        @error('area')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- Furnishing -->
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Furnishing <span class="text-danger">*</span>
        </label>

        <select
            name="furnishing"
            class="form-select @error('furnishing') is-invalid @enderror">

            <option value="">Select Furnishing</option>

            <option value="Fully Furnished"
                {{ old('furnishing', $property->furnishing ?? '') == 'Fully Furnished' ? 'selected' : '' }}>
                Fully Furnished
            </option>

            <option value="Semi Furnished"
                {{ old('furnishing', $property->furnishing ?? '') == 'Semi Furnished' ? 'selected' : '' }}>
                Semi Furnished
            </option>

            <option value="Unfurnished"
                {{ old('furnishing', $property->furnishing ?? '') == 'Unfurnished' ? 'selected' : '' }}>
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
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Parking Available <span class="text-danger">*</span>
        </label>

        <select
            name="parking"
            class="form-select @error('parking') is-invalid @enderror">

            <option value="">Select Parking</option>

            <option value="1"
                {{ old('parking', $property->parking ?? '') == '1' ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
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

    <!-- Address -->
    <div class="col-12 mb-3">

        <label class="form-label">
            Full Address <span class="text-danger">*</span>
        </label>

        <textarea
            name="address"
            rows="3"
            class="form-control @error('address') is-invalid @enderror"
            placeholder="Enter Full Address">{{ old('address', $property->address ?? '') }}</textarea>

        @error('address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- City -->
    <div class="col-md-4 mb-3">

        <label class="form-label">
            City <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="city"
            value="{{ old('city', $property->city ?? '') }}"
            class="form-control @error('city') is-invalid @enderror">

        @error('city')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- State -->
    <div class="col-md-4 mb-3">

        <label class="form-label">
            State <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="state"
            value="{{ old('state', $property->state ?? '') }}"
            class="form-control @error('state') is-invalid @enderror">

        @error('state')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- Pincode -->
    <div class="col-md-4 mb-3">

        <label class="form-label">
            Pincode <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="pincode"
            value="{{ old('pincode', $property->pincode ?? '') }}"
            class="form-control @error('pincode') is-invalid @enderror">

        @error('pincode')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

        <!-- Description -->
    <div class="col-12 mb-3">

        <label class="form-label">
            Property Description <span class="text-danger">*</span>
        </label>

        <textarea
            name="description"
            rows="5"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Enter Property Description">{{ old('description', $property->description ?? '') }}</textarea>

        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- Property Image -->
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Property Image
        </label>

        @if(isset($property) && $property->image)

            <div class="mb-3">

                <img
                    src="{{ asset('uploads/properties/'.$property->image) }}"
                    class="img-thumbnail"
                    width="180"
                    alt="{{ $property->title }}">

            </div>

        @endif

        <input
            type="file"
            name="image"
            class="form-control @error('image') is-invalid @enderror">

        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- Status -->
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Property Status <span class="text-danger">*</span>
        </label>

        <select
            name="status"
            class="form-select @error('status') is-invalid @enderror">

            <option value="">Select Status</option>

            <option value="Available"
                {{ old('status', $property->status ?? '') == 'Available' ? 'selected' : '' }}>
                Available
            </option>

            <option value="Rented"
                {{ old('status', $property->status ?? '') == 'Rented' ? 'selected' : '' }}>
                Rented
            </option>

        </select>

        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>

<hr class="my-4">

<div class="d-flex justify-content-end">

    <a href="{{ route('properties.index') }}"
       class="btn btn-secondary me-2">

        <i class="bi bi-arrow-left me-1"></i>

        Cancel

    </a>

    <button
        type="submit"
        class="btn btn-primary">

        <i class="bi bi-check-circle me-1"></i>

        {{ isset($property) ? 'Update Property' : 'Save Property' }}

    </button>

</div>