@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <!-- ================================
        Hero Section
    ================================ -->

    <section class="bg-primary text-white py-5">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <h1 class="display-4 fw-bold mb-4">

                        Find Your Perfect Rental Property

                    </h1>

                    <p class="lead mb-4">

                        Browse apartments, villas, houses, offices and commercial
                        properties across your favourite cities.

                    </p>

                    <div class="row text-center mt-5">

                        <div class="col-4">

                            <h2 class="fw-bold">

                                {{ $totalProperties }}

                            </h2>

                            <p class="mb-0">

                                Properties

                            </p>

                        </div>

                        <div class="col-4">

                            <h2 class="fw-bold">

                                {{ $totalUsers }}

                            </h2>

                            <p class="mb-0">

                                Users

                            </p>

                        </div>

                        <div class="col-4">

                            <h2 class="fw-bold">

                                {{ $totalLandlords }}

                            </h2>

                            <p class="mb-0">

                                Landlords

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-lg-6 text-center">

                    <img src="{{ asset('images/hero-house.png') }}" class="img-fluid" alt="Hero Image">

                </div>

            </div>

        </div>

    </section>

    <!-- ================================
        Property Search
    ================================ -->

    <section class="py-5 bg-light">

        <div class="container">

            <div class="card shadow border-0 rounded-4">

                <div class="card-body p-4">

                    <form action="{{ route('properties.index') }}" method="GET">

                        <div class="row g-3">

                            <div class="col-lg-4">

                                <input type="text" name="keyword" class="form-control" placeholder="Search property...">

                            </div>

                            <div class="col-lg-3">

                                <select name="city" class="form-select">

                                    <option value="">

                                        Select City

                                    </option>

                                    @foreach($cities as $city)

                                        <option value="{{ $city->city }}">

                                            {{ $city->city }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-lg-3">

                                <select name="property_type" class="form-select">

                                    <option value="">

                                        Property Type

                                    </option>

                                    @foreach($categories as $category)

                                        <option value="{{ $category['title'] }}">

                                            {{ $category['title'] }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-lg-2 d-grid">

                                <button class="btn btn-primary">

                                    <i class="bi bi-search me-2"></i>

                                    Search

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </section>
    <!-- =====================================
            Featured Properties
    ====================================== -->

    <section class="py-5">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="fw-bold">

                    Featured Properties

                </h2>

                <p class="text-muted">

                    Explore our latest available rental properties.

                </p>

            </div>

            <div class="row g-4">

                @forelse($featuredProperties as $property)

                    <div class="col-lg-4 col-md-6">

                        <div class="card shadow border-0 rounded-4 h-100">

                            @if($property->image)

                                <img src="{{ asset('storage/' . $property->image) }}" class="card-img-top"
                                    style="height:240px;object-fit:cover;" alt="{{ $property->title }}">

                            @else

                                <img src="https://placehold.co/600x400?text=No+Image" class="card-img-top"
                                    style="height:240px;object-fit:cover;" alt="No Image">

                            @endif

                            <div class="card-body d-flex flex-column">

                                <div class="d-flex justify-content-between align-items-center mb-2">

                                    <span class="badge bg-success">

                                        {{ $property->property_type }}

                                    </span>

                                    <span class="fw-bold text-primary">

                                        ₹{{ number_format($property->price) }}

                                    </span>

                                </div>

                                <h5 class="fw-bold">

                                    {{ $property->title }}

                                </h5>

                                <p class="text-muted mb-2">

                                    <i class="bi bi-geo-alt-fill me-1"></i>

                                    {{ $property->city }}

                                </p>

                                <p class="text-muted flex-grow-1">

                                    {{ \Illuminate\Support\Str::limit($property->description, 100) }}

                                </p>

                                <div class="mt-auto">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <small class="text-muted">

                                            Owner :

                                            {{ $property->user->name }}

                                        </small>

                                        <a href="{{ route('properties.show', $property) }}" class="btn btn-primary btn-sm">

                                            View Details

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="alert alert-info text-center">

                            No properties available.

                        </div>

                    </div>

                @endforelse

            </div>

            <div class="text-center mt-5">

                <a href="{{ route('properties.index') }}" class="btn btn-outline-primary btn-lg">

                    View All Properties

                </a>

            </div>

        </div>

    </section>
    <!-- =====================================
            Property Categories
    ====================================== -->

    <section class="py-5 bg-light">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="fw-bold">

                    Browse by Category

                </h2>

                <p class="text-muted">

                    Choose your preferred property type.

                </p>

            </div>

            <div class="row g-4">

                @forelse($categories as $category)

                    <div class="col-lg-4 col-md-6">

                        <div class="card border-0 shadow rounded-4 h-100">

                            <div class="card-body text-center py-5">

                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                    style="width:90px;height:90px;">

                                    <i class="bi {{ $category['icon'] }} text-primary" style="font-size:2.5rem;">
                                    </i>

                                </div>

                                <h4 class="fw-bold">

                                    {{ $category['title'] }}

                                </h4>

                                <p class="text-muted mb-4">

                                    {{ $category['count'] }}
                                    Properties Available

                                </p>

                                <a href="{{ route('properties.index', ['property_type' => $category['title']]) }}"
                                    class="btn btn-outline-primary rounded-pill">

                                    Browse Properties

                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="alert alert-info text-center">

                            No Categories Found.

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </section>
    <!-- =====================================
            Popular Cities
    ====================================== -->

    <section class="py-5">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="fw-bold">

                    Popular Cities

                </h2>

                <p class="text-muted">

                    Explore properties available in top cities.

                </p>

            </div>

            <div class="row g-4">

                @forelse($cities as $city)

                    <div class="col-lg-3 col-md-6">

                        <div class="card border-0 shadow rounded-4 h-100">

                            <div class="card-body text-center py-5">

                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                    style="width:90px;height:90px;">

                                    <i class="bi bi-geo-alt-fill text-success" style="font-size:2.5rem;">
                                    </i>

                                </div>

                                <h4 class="fw-bold">

                                    {{ $city->city }}

                                </h4>

                                <p class="text-muted">

                                    {{ $city->total }}
                                    Properties Available

                                </p>

                                <a href="{{ route('properties.index', ['city' => $city->city]) }}"
                                    class="btn btn-outline-success rounded-pill">

                                    View Properties

                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="alert alert-info text-center">

                            No Cities Found.

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </section>
    <!-- =====================================
            Why Choose RentEase
    ====================================== -->

    <section class="py-5 bg-light">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="fw-bold">

                    Why Choose RentEase?

                </h2>

                <p class="text-muted">

                    We make finding your dream property easy, secure and fast.

                </p>

            </div>

            <div class="row g-4">

                <div class="col-lg-3 col-md-6">

                    <div class="card border-0 shadow rounded-4 h-100">

                        <div class="card-body text-center py-4">

                            <i class="bi bi-house-check-fill display-4 text-primary mb-3"></i>

                            <h5 class="fw-bold">

                                Verified Properties

                            </h5>

                            <p class="text-muted">

                                Every property is reviewed before being published.

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="card border-0 shadow rounded-4 h-100">

                        <div class="card-body text-center py-4">

                            <i class="bi bi-shield-check display-4 text-success mb-3"></i>

                            <h5 class="fw-bold">

                                Secure Platform

                            </h5>

                            <p class="text-muted">

                                Safe communication between landlords and tenants.

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="card border-0 shadow rounded-4 h-100">

                        <div class="card-body text-center py-4">

                            <i class="bi bi-lightning-charge-fill display-4 text-warning mb-3"></i>

                            <h5 class="fw-bold">

                                Fast Booking

                            </h5>

                            <p class="text-muted">

                                Send booking requests within seconds.

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="card border-0 shadow rounded-4 h-100">

                        <div class="card-body text-center py-4">

                            <i class="bi bi-headset display-4 text-danger mb-3"></i>

                            <h5 class="fw-bold">

                                24×7 Support

                            </h5>

                            <p class="text-muted">

                                We're here whenever you need assistance.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- =====================================
            Call To Action
    ====================================== -->

    <section class="py-5 bg-primary text-white">

        <div class="container text-center">

            <h2 class="fw-bold mb-3">

                Ready to Find Your Dream Property?

            </h2>

            <p class="lead mb-4">

                Browse hundreds of verified rental properties across multiple cities.

            </p>

            <a href="{{ route('properties.index') }}" class="btn btn-light btn-lg me-3">

                <i class="bi bi-search me-2"></i>

                Browse Properties

            </a>

            @guest

                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">

                    <i class="bi bi-person-plus me-2"></i>

                    Register Now

                </a>

            @endguest

        </div>

    </section>

@endsection