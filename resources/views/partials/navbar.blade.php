<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3" id="mainNavbar">

    <div class="container">

        <!-- ==========================================================
             LOGO
        =========================================================== -->

        <a
            class="navbar-brand fw-bold fs-3 text-primary"
            href="{{ route('home') }}">

            <i class="bi bi-buildings-fill"></i>

            RentEase

        </a>


        <!-- ==========================================================
             MOBILE TOGGLE
        =========================================================== -->

        <button
            class="navbar-toggler border-0 shadow-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar"
            aria-controls="navbar"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>


        <div
            class="collapse navbar-collapse"
            id="navbar">


            <!-- ======================================================
                 LEFT MENU
            ======================================================= -->

            <ul class="navbar-nav mx-auto">

                <!-- Home -->

                <li class="nav-item">

                    <a
                        class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}"
                        href="{{ route('home') }}">

                        Home

                    </a>

                </li>


                <!-- Properties -->

                <li class="nav-item">

                    <a
                        class="nav-link {{ request()->routeIs('properties.*') ? 'active fw-bold' : '' }}"
                        href="{{ route('properties.index') }}">

                        Properties

                    </a>

                </li>


                <!-- About -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="#">

                        About

                    </a>

                </li>


                <!-- Contact -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="#">

                        Contact

                    </a>

                </li>

            </ul>


            <!-- ======================================================
                 RIGHT SIDE
            ======================================================= -->

            <div class="d-flex align-items-center gap-3">


                <!-- ==================================================
                     SEARCH
                =================================================== -->

                <a
                    href="{{ route('properties.index') }}"
                    class="text-dark fs-5"
                    title="Search Properties"
                    aria-label="Search Properties">

                    <i class="bi bi-search"></i>

                </a>


                <!-- ==================================================
                     GUEST
                =================================================== -->

                @guest

                    <a
                        href="{{ route('login') }}"
                        class="btn btn-outline-primary">

                        Login

                    </a>


                    <a
                        href="{{ route('register') }}"
                        class="btn btn-primary">

                        Register

                    </a>

                @endguest


                <!-- ==================================================
                     AUTHENTICATED USER
                =================================================== -->

                @auth


                    <!-- ==============================================
                         NOTIFICATIONS
                    =============================================== -->

                    <div class="dropdown">

                        <button
                            class="btn btn-light position-relative"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            title="Notifications">

                            <i class="bi bi-bell-fill fs-5"></i>


                            @if(($navbarUnreadCount ?? 0) > 0)

                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                                    {{ $navbarUnreadCount }}

                                    <span class="visually-hidden">
                                        unread notifications
                                    </span>

                                </span>

                            @endif

                        </button>


                        <ul
                            class="dropdown-menu dropdown-menu-end shadow"
                            style="width:350px;">


                            <li>

                                <h6 class="dropdown-header">

                                    Notifications

                                </h6>

                            </li>


                            @forelse(($navbarNotifications ?? collect()) as $notification)

                                <li>

                                    <a
                                        href="{{ route('notifications.show', $notification->id) }}"
                                        class="dropdown-item">

                                        <strong>

                                            {{ $notification->title }}

                                        </strong>


                                        <br>


                                        <small class="text-muted">

                                            {{ \Illuminate\Support\Str::limit($notification->message, 40) }}

                                        </small>


                                        <br>


                                        <small class="text-secondary">

                                            {{ $notification->created_at->diffForHumans() }}

                                        </small>

                                    </a>

                                </li>

                            @empty

                                <li>

                                    <span class="dropdown-item text-muted">

                                        No notifications

                                    </span>

                                </li>

                            @endforelse


                            <li>

                                <hr class="dropdown-divider">

                            </li>


                            <li>

                                <a
                                    class="dropdown-item text-center fw-bold"
                                    href="{{ route('notifications.index') }}">

                                    View All Notifications

                                </a>

                            </li>

                        </ul>

                    </div>


                    <!-- ==============================================
                         DASHBOARD
                    =============================================== -->

                    <a
                        href="{{ route('dashboard') }}"
                        class="btn btn-outline-success">

                        <i class="bi bi-speedometer2 me-1"></i>

                        Dashboard

                    </a>


                    <!-- ==============================================
                         USER MENU
                    =============================================== -->

                    <div class="dropdown">

                        <button
                            class="btn btn-primary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                            <i class="bi bi-person-circle me-1"></i>

                            {{ Auth::user()->name }}

                        </button>


                        <ul class="dropdown-menu dropdown-menu-end">


                            <!-- ======================================
                                 PROFILE
                            ======================================= -->

                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('profile.edit') }}">

                                    <i class="bi bi-person me-2"></i>

                                    Profile

                                </a>

                            </li>


                            <!-- ======================================
                                 TENANT MENU
                            ======================================= -->

                            @if(Auth::user()->isTenant())

                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('tenant.bookings.index') }}">

                                        <i class="bi bi-calendar-check me-2"></i>

                                        My Bookings

                                    </a>

                                </li>


                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('wishlist.index') }}">

                                        <i class="bi bi-heart me-2"></i>

                                        Wishlist

                                    </a>

                                </li>

                            @endif


                            <!-- ======================================
                                 LANDLORD MENU
                            ======================================= -->

                            @if(Auth::user()->isLandlord())

                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('properties.create') }}">

                                        <i class="bi bi-plus-circle me-2"></i>

                                        Add Property

                                    </a>

                                </li>


                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('properties.index') }}">

                                        <i class="bi bi-buildings me-2"></i>

                                        Manage Properties

                                    </a>

                                </li>


                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('bookings.index') }}">

                                        <i class="bi bi-calendar-check me-2"></i>

                                        Booking Requests

                                    </a>

                                </li>


                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('enquiries.index') }}">

                                        <i class="bi bi-chat-dots me-2"></i>

                                        Enquiries

                                    </a>

                                </li>

                            @endif


                            <!-- ======================================
                                 ADMIN MENU
                            ======================================= -->

                            @if(Auth::user()->isAdmin())

                                <li>

                                    <hr class="dropdown-divider">

                                </li>


                                <li>

                                    <a
                                        class="dropdown-item text-primary fw-semibold"
                                        href="{{ route('admin.dashboard') }}">

                                        <i class="bi bi-speedometer2 me-2"></i>

                                        Admin Panel

                                    </a>

                                </li>

                            @endif


                            <!-- ======================================
                                 COMMON NOTIFICATIONS
                            ======================================= -->

                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('notifications.index') }}">

                                    <i class="bi bi-bell me-2"></i>

                                    Notifications

                                </a>

                            </li>


                            <!-- ======================================
                                 DIVIDER
                            ======================================= -->

                            <li>

                                <hr class="dropdown-divider">

                            </li>


                            <!-- ======================================
                                 LOGOUT
                            ======================================= -->

                            <li>

                                <form
                                    method="POST"
                                    action="{{ route('logout') }}">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="dropdown-item text-danger">

                                        <i class="bi bi-box-arrow-right me-2"></i>

                                        Logout

                                    </button>

                                </form>

                            </li>

                        </ul>

                    </div>

                @endauth

            </div>

        </div>

    </div>

</nav>