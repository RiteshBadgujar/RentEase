@extends('layouts.master')

@section('title', 'RentEase | Find Your Dream Home')

@section('content')

<section class="hero-section">

    <div class="container">

        <div class="row align-items-center min-vh-100">

            <!-- Left Side -->
            <div class="col-lg-6">

                <span class="hero-badge">
                    🏠 Trusted Rental Platform
                </span>

                <h1 class="hero-title mt-4">
                    Find Your
                    <span>Dream Home</span>
                    With Ease
                </h1>

                <p class="hero-text">
                    Discover verified rental properties, trusted landlords,
                    and seamless booking experiences all in one place.
                </p>

                <!-- Search -->
                <form action="{{ route('properties.index') }}" method="GET">

                    <div class="search-box shadow-lg">

                        <div class="row g-2">

                            <div class="col-md-8">

                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    placeholder="Search city, apartment or locality">

                            </div>

                            <div class="col-md-4">

                                <button
                                    type="submit"
                                    class="btn btn-primary w-100">

                                    <i class="bi bi-search"></i>

                                    Search

                                </button>

                            </div>

                        </div>

                    </div>

                </form>

                <!-- Buttons -->
                <div class="mt-4 d-flex gap-3 flex-wrap">

                    <a href="{{ route('properties.index') }}"
                       class="btn btn-primary btn-lg">

                        <i class="bi bi-buildings me-2"></i>

                        Explore Properties

                    </a>

                    @guest

                        <a href="{{ route('register') }}"
                           class="btn btn-outline-primary btn-lg">

                            <i class="bi bi-person-plus me-2"></i>

                            Become a Landlord

                        </a>

                    @else

                        <a href="{{ route('properties.create') }}"
                           class="btn btn-outline-primary btn-lg">

                            <i class="bi bi-plus-circle me-2"></i>

                            Add Property

                        </a>

                    @endguest

                </div>

                <!-- Stats -->
                <div class="row mt-5">

                    <div class="col-4 text-center">

                        <h2>{{ number_format($totalProperties) }}+</h2>

                        <p>Properties</p>

                    </div>

                    <div class="col-4 text-center">

                        <h2>{{ number_format($totalUsers) }}+</h2>

                        <p>Users</p>

                    </div>

                    <div class="col-4 text-center">

                        <h2>{{ number_format($totalLandlords) }}+</h2>

                        <p>Landlords</p>

                    </div>

                </div>

            </div>
            <!-- End Left Side -->

            <!-- Right Side -->
            <div class="col-lg-6">

                <div class="hero-image-area">

                    <div class="glass-card card-one">

                        <h5>Luxury Apartment</h5>

                        <p>Nashik</p>

                        <strong>₹18,000 / month</strong>

                    </div>

                    <div class="glass-card card-two">

                        ⭐ 4.9 Rating

                    </div>

                    <div class="main-circle">

                        <i class="bi bi-buildings-fill"></i>

                    </div>

                </div>

            </div>
            <!-- End Right Side -->

        </div>

    </div>

</section>
   <!-- =========================
     Advanced Search Section
========================= -->

<section class="advanced-search">

    <div class="container">

        <form action="{{ route('properties.index') }}" method="GET">

            <div class="search-wrapper shadow-lg">

                <div class="row g-3 align-items-end">

                    <!-- Location -->
                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            <i class="bi bi-geo-alt-fill text-primary"></i>
                            Location
                        </label>

                        <select name="city" class="form-select">

                            <option value="">Select City</option>
                            <option value="Nashik">Nashik</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Pune">Pune</option>
                            <option value="Delhi">Delhi</option>

                        </select>

                    </div>

                    <!-- Property Type -->
                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            <i class="bi bi-house-door-fill text-primary"></i>
                            Property Type
                        </label>

                        <select name="property_type" class="form-select">

                            <option value="">Select Type</option>
                            <option value="Apartment">Apartment</option>
                            <option value="House">House</option>
                            <option value="Villa">Villa</option>
                            <option value="PG">PG</option>
                            <option value="Commercial">Commercial</option>

                        </select>

                    </div>

                    <!-- Budget -->
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Budget
                        </label>

                        <select name="max_price" class="form-select">

                            <option value="">Any Budget</option>
                            <option value="10000">₹10,000</option>
                            <option value="20000">₹20,000</option>
                            <option value="30000">₹30,000</option>
                            <option value="50000">₹50,000</option>

                        </select>

                    </div>

                    <!-- Bedrooms -->
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Bedrooms
                        </label>

                        <select name="bedrooms" class="form-select">

                            <option value="">Any</option>
                            <option value="1">1 BHK</option>
                            <option value="2">2 BHK</option>
                            <option value="3">3 BHK</option>
                            <option value="4">4+ BHK</option>

                        </select>

                    </div>

                    <!-- Search -->
                    <div class="col-lg-2">

                        <button type="submit" class="btn btn-primary w-100">

                            <i class="bi bi-search"></i>

                            Search

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</section>

<!-- =========================
     Featured Properties
========================= -->

<section class="featured-properties py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="section-badge">

                Featured Listings

            </span>

            <h2 class="section-title mt-3">

                Discover Your Perfect Rental

            </h2>

            <p class="section-subtitle">

                Explore premium rental properties verified by RentEase.

            </p>

        </div>

        <div class="row g-4">

            @forelse($featuredProperties as $property)

                <div class="col-lg-4 col-md-6">

                    <div class="property-card">

                        <div class="property-image">

                            @if($property->image)

                                <img
                                    src="{{ asset('uploads/properties/' . $property->image) }}"
                                    class="img-fluid"
                                    style="height:250px;width:100%;object-fit:cover;"
                                    alt="{{ $property->title }}">

                            @else

                                <img
                                    src="https://placehold.co/600x400?text=No+Image"
                                    class="img-fluid"
                                    style="height:250px;width:100%;object-fit:cover;"
                                    alt="No Image">

                            @endif

                            <span class="property-badge">

                                {{ $property->status }}

                            </span>

                        </div>

                        <div class="property-content">

                            <h4>

                                ₹{{ number_format($property->price) }}/Month

                            </h4>

                            <h5>

                                {{ $property->title }}

                            </h5>

                            <p>

                                <i class="bi bi-geo-alt-fill"></i>

                                {{ $property->city }}

                            </p>

                            <div class="property-info">

                                <span>

                                    <i class="bi bi-door-open"></i>

                                    {{ $property->bedrooms }} Beds

                                </span>

                                <span>

                                    <i class="bi bi-droplet"></i>

                                    {{ $property->bathrooms }} Baths

                                </span>

                                <span>

                                    <i class="bi bi-aspect-ratio"></i>

                                    {{ $property->area }} Sq.Ft.

                                </span>

                            </div>

                            <hr>

                            <a href="{{ route('properties.show', $property->id) }}"
                               class="btn btn-primary w-100">

                                View Details

                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center">

                    <h4>No Properties Available</h4>

                </div>

            @endforelse

        </div>

    </div>

</section>

    <!-- =========================
      Property Categories
========================= -->

<section class="categories py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="section-badge">Categories</span>

            <h2 class="section-title mt-3">

                Browse By Property Type

            </h2>

            <p class="section-subtitle">

                Find the perfect property that matches your lifestyle.

            </p>

        </div>

        @php

            use App\Models\Property;

            $categories = [

                [
                    'icon' => 'bi-buildings-fill',
                    'title' => 'Apartment'
                ],

                [
                    'icon' => 'bi-house-door-fill',
                    'title' => 'House'
                ],

                [
                    'icon' => 'bi-bank',
                    'title' => 'Villa'
                ],

                [
                    'icon' => 'bi-door-open-fill',
                    'title' => 'PG'
                ],

                [
                    'icon' => 'bi-building',
                    'title' => 'Office'
                ],

                [
                    'icon' => 'bi-shop',
                    'title' => 'Commercial'
                ]

            ];

        @endphp

        <div class="row g-4">

            @foreach($categories as $category)

                <div class="col-lg-4 col-md-6">

                    <div class="category-card text-center">

                        <div class="category-icon">

                            <i class="bi {{ $category['icon'] }}"></i>

                        </div>

                        <h4>

                            {{ $category['title'] }}

                        </h4>

                        <p>

                            {{ Property::where('property_type', $category['title'])->count() }}
                            Properties

                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

<!-- =========================
      Popular Cities
========================= -->

<section class="popular-cities py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="section-badge">

                Popular Cities

            </span>

            <h2 class="section-title">

                Top Rental Locations

            </h2>

        </div>

        @php

            $cities = Property::select('city')
                        ->distinct()
                        ->orderBy('city')
                        ->get();

        @endphp

        <div class="row g-4">

            @forelse($cities as $city)

                <div class="col-lg-4 col-md-6">

                    <div class="city-card">

                        <h3>

                            {{ $city->city }}

                        </h3>

                        <p>

                            {{ Property::where('city', $city->city)->count() }}
                            Properties Available

                        </p>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center">

                    <h4>

                        No Cities Available

                    </h4>

                </div>

            @endforelse

        </div>

    </div>

</section>