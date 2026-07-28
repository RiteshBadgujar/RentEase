@extends('layouts.master')

@section('title','RentEase | Find Your Dream Home')

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

                <div class="search-box shadow-lg">

                    <div class="row g-2">

                        <div class="col-md-8">

                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search city, apartment or locality">

                        </div>

                        <div class="col-md-4">

                            <button class="btn btn-primary w-100">

                                <i class="bi bi-search"></i>

                                Search

                            </button>

                        </div>

                    </div>

                </div>

                <!-- Buttons -->

                <div class="mt-4 d-flex gap-3 flex-wrap">

                    <a href="#" class="btn btn-primary btn-lg">
                        Explore Properties
                    </a>

                    <a href="#" class="btn btn-outline-primary btn-lg">
                        Become a Landlord
                    </a>

                </div>

                <!-- Stats -->

                <div class="row mt-5">

                    <div class="col-4">

                        <h2>15K+</h2>

                        <p>Properties</p>

                    </div>

                    <div class="col-4">

                        <h2>8K+</h2>

                        <p>Tenants</p>

                    </div>

                    <div class="col-4">

                        <h2>500+</h2>

                        <p>Landlords</p>

                    </div>

                </div>

            </div>

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

        </div>

    </div>

</section>
<!-- Advanced Search Section -->

<section class="advanced-search">

    <div class="container">

        <div class="search-wrapper shadow-lg">

            <div class="row g-3 align-items-end">

                <div class="col-lg-3 col-md-6">

                    <label class="form-label fw-semibold">
                        <i class="bi bi-geo-alt-fill text-primary"></i>
                        Location
                    </label>

                    <select class="form-select">
                        <option>Select City</option>
                        <option>Nashik</option>
                        <option>Mumbai</option>
                        <option>Pune</option>
                        <option>Delhi</option>
                    </select>

                </div>

                <div class="col-lg-3 col-md-6">

                    <label class="form-label fw-semibold">
                        <i class="bi bi-house-door-fill text-primary"></i>
                        Property Type
                    </label>

                    <select class="form-select">
                        <option>Apartment</option>
                        <option>Villa</option>
                        <option>House</option>
                        <option>PG</option>
                    </select>

                </div>

                <div class="col-lg-2 col-md-6">

                    <label class="form-label fw-semibold">
                        Budget
                    </label>

                    <select class="form-select">
                        <option>$200 - $500</option>
                        <option>$500 - $800</option>
                        <option>$800 - $1200</option>
                    </select>

                </div>

                <div class="col-lg-2 col-md-6">

                    <label class="form-label fw-semibold">
                        Bedrooms
                    </label>

                    <select class="form-select">
                        <option>1 BHK</option>
                        <option>2 BHK</option>
                        <option>3 BHK</option>
                        <option>4 BHK</option>
                    </select>

                </div>

                <div class="col-lg-2">

                    <button class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                        Search
                    </button>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- =========================
     Featured Properties
========================= -->

<section class="featured-properties py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="section-badge">Featured Listings</span>

            <h2 class="section-title mt-3">
                Discover Your Perfect Rental
            </h2>

            <p class="section-subtitle">
                Explore premium rental properties verified by RentEase.
            </p>

        </div>

        <div class="row g-4">

            <!-- Property Card 1 -->

            <div class="col-lg-4 col-md-6">

                <div class="property-card">

                    <div class="property-image">

                        <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800"
                             class="img-fluid"
                             alt="Property">

                        <span class="property-badge">
                            Featured
                        </span>

                        <button class="favorite-btn">

                            <i class="bi bi-heart"></i>

                        </button>

                    </div>

                    <div class="property-content">

                        <h4>$1,200 / Month</h4>

                        <h5>Modern Family Apartment</h5>

                        <p>
                            <i class="bi bi-geo-alt-fill"></i>
                            Nashik, Maharashtra
                        </p>

                        <div class="property-info">

                            <span><i class="bi bi-door-open"></i> 3 Beds</span>

                            <span><i class="bi bi-droplet"></i> 2 Baths</span>

                            <span><i class="bi bi-aspect-ratio"></i> 1200 sqft</span>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">

                            <span>

                                ⭐ 4.9

                            </span>

                            <button class="btn btn-primary">

                                View Details

                            </button>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Duplicate this card for more properties -->

        </div>

    </div>

</section>
<section class="why-us py-5">

<div class="container">

<div class="text-center mb-5">

<span class="section-badge">Why Choose Us</span>

<h2 class="section-title mt-3">
Why RentEase?
</h2>

</div>

<div class="row g-4">

<div class="col-md-4">

<div class="feature-card">

<i class="bi bi-patch-check-fill"></i>

<h4>Verified Listings</h4>

<p>Every property is verified before publishing.</p>

</div>

</div>

<div class="col-md-4">

<div class="feature-card">

<i class="bi bi-shield-lock-fill"></i>

<h4>Secure Platform</h4>

<p>Safe login, bookings and communication.</p>

</div>

</div>

<div class="col-md-4">

<div class="feature-card">

<i class="bi bi-headset"></i>

<h4>24×7 Support</h4>

<p>Dedicated support whenever you need help.</p>

</div>

</div>

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

        <div class="row g-4">

            @php
                $categories = [
                    ['icon'=>'bi-buildings-fill','title'=>'Apartment','count'=>'320+'],
                    ['icon'=>'bi-house-door-fill','title'=>'House','count'=>'210+'],
                    ['icon'=>'bi-bank','title'=>'Villa','count'=>'95+'],
                    ['icon'=>'bi-door-open-fill','title'=>'PG','count'=>'180+'],
                    ['icon'=>'bi-building','title'=>'Office','count'=>'75+'],
                    ['icon'=>'bi-shop','title'=>'Commercial','count'=>'55+']
                ];
            @endphp

            @foreach($categories as $category)

            <div class="col-lg-4 col-md-6">

                <div class="category-card">

                    <div class="category-icon">

                        <i class="bi {{ $category['icon'] }}"></i>

                    </div>

                    <h4>{{ $category['title'] }}</h4>

                    <p>{{ $category['count'] }} Properties</p>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>
<section class="popular-cities py-5">

<div class="container">

<div class="text-center mb-5">

<span class="section-badge">Popular Cities</span>

<h2 class="section-title">
Top Rental Locations
</h2>

</div>

<div class="row g-4">

@foreach(['Nashik','Mumbai','Pune','Delhi','Bengaluru','Hyderabad'] as $city)

<div class="col-lg-4 col-md-6">

<div class="city-card">

<h3>{{ $city }}</h3>

<p>120+ Properties Available</p>

</div>

</div>

@endforeach

</div>

</div>

</section>
<section class="testimonials py-5">

<div class="container">

<div class="text-center mb-5">

<span class="section-badge">
Testimonials
</span>

<h2 class="section-title">
What Our Users Say
</h2>

</div>

<div class="row g-4">

@for($i=1;$i<=3;$i++)

<div class="col-lg-4">

<div class="testimonial-card">

<h5>★★★★★</h5>

<p>

RentEase helped me find a rental home quickly.
The interface is clean and easy to use.

</p>

<h6>Rahul Sharma</h6>

<small>Tenant</small>

</div>

</div>

@endfor

</div>

</div>

</section>
<section class="stats py-5 bg-primary text-white">

<div class="container">

<div class="row text-center">

<div class="col-md-3">

<h2>15K+</h2>

<p>Properties</p>

</div>

<div class="col-md-3">

<h2>8K+</h2>

<p>Tenants</p>

</div>

<div class="col-md-3">

<h2>500+</h2>

<p>Landlords</p>

</div>

<div class="col-md-3">

<h2>95%</h2>

<p>Satisfaction</p>

</div>

</div>

</div>

</section>
<section class="newsletter py-5">

<div class="container">

<div class="newsletter-box">

<div class="row align-items-center">

<div class="col-lg-6">

<h2>Subscribe To Our Newsletter</h2>

<p>Receive the latest property listings and rental updates.</p>

</div>

<div class="col-lg-6">

<form class="d-flex gap-2">

<input
type="email"
class="form-control"
placeholder="Enter your email">

<button class="btn btn-primary">

Subscribe

</button>

</form>

</div>

</div>

</div>

</div>

</section>
@endsection