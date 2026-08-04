<footer class="footer-section mt-5 bg-dark text-light py-5">

    <div class="container">

        <div class="row gy-5">

            <!-- About -->
            <div class="col-lg-4">

                <h3 class="fw-bold text-white">

                    <i class="bi bi-buildings-fill me-2"></i>

                    RentEase

                </h3>

                <p class="mt-3">

                    RentEase is a modern House Rental Management System
                    that helps tenants discover rental properties and
                    enables landlords to manage properties, enquiries,
                    bookings and notifications efficiently.

                </p>

            </div>

            <!-- Quick Links -->
            <div class="col-lg-2">

                <h5 class="text-white">

                    Quick Links

                </h5>

                <ul class="list-unstyled mt-3">

                    <li class="mb-2">

                        <a href="{{ route('home') }}">

                            Home

                        </a>

                    </li>

                    <li class="mb-2">

                        <a href="{{ route('properties.index') }}">

                            Properties

                        </a>

                    </li>

                    @auth

                        <li class="mb-2">

                            <a href="{{ route('dashboard') }}">

                                Dashboard

                            </a>

                        </li>

                        <li class="mb-2">

                            <a href="{{ route('wishlist.index') }}">

                                Wishlist

                            </a>

                        </li>

                        <li class="mb-2">

                            <a href="{{ route('tenant.bookings.index') }}">

                                My Bookings

                            </a>

                        </li>

                        <li class="mb-2">

                            <a href="{{ route('notifications.index') }}">

                                Notifications

                            </a>

                        </li>

                    @endauth

                </ul>

            </div>

            <!-- Services -->
            <div class="col-lg-3">

                <h5 class="text-white">

                    Services

                </h5>

                <ul class="list-unstyled mt-3">

                    <li class="mb-2">

                        Property Listing

                    </li>

                    <li class="mb-2">

                        Booking Management

                    </li>

                    <li class="mb-2">

                        Wishlist Management

                    </li>

                    <li class="mb-2">

                        Enquiry System

                    </li>

                    <li class="mb-2">

                        Notification System

                    </li>

                </ul>

            </div>

            <!-- Contact -->
            <div class="col-lg-3">

                <h5 class="text-white">

                    Contact Us

                </h5>

                <p class="mt-3">

                    <i class="bi bi-geo-alt-fill me-2"></i>

                    Nashik, Maharashtra, India

                </p>

                <p>

                    <a
                        href="mailto:support@rentease.com"
                        class="text-light text-decoration-none">

                        <i class="bi bi-envelope-fill me-2"></i>

                        support@rentease.com

                    </a>

                </p>

                <p>

                    <a
                        href="tel:+910000000000"
                        class="text-light text-decoration-none">

                        <i class="bi bi-telephone-fill me-2"></i>

                        +91 XXXXX XXXXX

                    </a>

                </p>

                <div class="d-flex gap-3 mt-4">

                    <a
                        href="https://facebook.com"
                        target="_blank"
                        rel="noopener"
                        class="text-light fs-4">

                        <i class="bi bi-facebook"></i>

                    </a>

                    <a
                        href="https://instagram.com"
                        target="_blank"
                        rel="noopener"
                        class="text-light fs-4">

                        <i class="bi bi-instagram"></i>

                    </a>

                    <a
                        href="https://x.com"
                        target="_blank"
                        rel="noopener"
                        class="text-light fs-4">

                        <i class="bi bi-twitter-x"></i>

                    </a>

                    <a
                        href="https://linkedin.com"
                        target="_blank"
                        rel="noopener"
                        class="text-light fs-4">

                        <i class="bi bi-linkedin"></i>

                    </a>

                </div>

            </div>

        </div>

        <hr class="border-secondary my-4">

        <div class="row align-items-center">

            <div class="col-md-6">

                <p class="mb-0">

                    © {{ date('Y') }} <strong>RentEase</strong>. All Rights Reserved.

                </p>

            </div>

            <div class="col-md-6 text-md-end">

                <p class="mb-0">

                    Developed with ❤️ using Laravel 12 & Bootstrap 5

                </p>

            </div>

        </div>

    </div>

</footer>