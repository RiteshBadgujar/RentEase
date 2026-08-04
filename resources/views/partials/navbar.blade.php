<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3" id="mainNavbar">

    <div class="container">

        <!-- Logo -->

        <a class="navbar-brand fw-bold fs-3 text-primary"
           href="{{ route('home') }}">

            <i class="bi bi-buildings-fill"></i>

            RentEase

        </a>

        <!-- Mobile Toggle -->

        <button
            class="navbar-toggler border-0 shadow-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbar">

            <!-- Left Menu -->

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">

                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}"
                       href="{{ route('home') }}">

                        Home

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link {{ request()->routeIs('properties.*') ? 'active fw-bold' : '' }}"
                       href="{{ route('properties.index') }}">

                        Properties

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link" href="#">

                        About

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link" href="#">

                        Contact

                    </a>

                </li>

            </ul>

            <div class="d-flex align-items-center gap-3">

                <!-- Search -->

                <a href="#"
                   class="text-dark fs-5"
                   title="Search">

                    <i class="bi bi-search"></i>

                </a>

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

                @auth

                    <!-- Notification -->

                    <div class="dropdown">

                        <button
                            class="btn btn-light position-relative"
                            data-bs-toggle="dropdown"
                            title="Notifications">

                            <i class="bi bi-bell-fill fs-5"></i>

                            @if($navbarUnreadCount > 0)

                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                                    {{ $navbarUnreadCount }}

                                </span>

                            @endif

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow"
                            style="width:350px;">

                            <li>

                                <h6 class="dropdown-header">

                                    Notifications

                                </h6>

                            </li>

                            @forelse($navbarNotifications as $notification)

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

                    <!-- Dashboard -->

                    <a
                        href="{{ route('dashboard') }}"
                        class="btn btn-outline-success">

                        Dashboard

                    </a>

                    <!-- User -->

                    <div class="dropdown">

                        <button
                            class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown">

                            {{ Auth::user()->name }}

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('profile.edit') }}">

                                    <i class="bi bi-person me-2"></i>

                                    Profile

                                </a>

                            </li>

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

                            <li>

                                <hr class="dropdown-divider">

                            </li>

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