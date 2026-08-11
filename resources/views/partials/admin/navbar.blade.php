<nav class="navbar navbar-expand-lg topbar shadow-sm px-4 bg-white">

    <div class="container-fluid">

        <!-- Mobile Sidebar Toggle -->
        <button
            class="btn btn-primary d-lg-none me-3"
            id="menu-toggle"
            type="button">

            <i class="bi bi-list"></i>

        </button>

        <!-- Page Title -->
        <h4 class="fw-bold mb-0">

            @yield('title')

        </h4>

        <!-- Right Menu -->
        <div class="ms-auto d-flex align-items-center">

            <!-- Welcome User -->
            <span class="me-3 text-muted d-none d-md-inline">

                <i class="bi bi-person-circle me-1"></i>

                Welcome,

                <strong>{{ Auth::user()->name }}</strong>

            </span>

            <!-- Profile Dropdown -->
            <div class="dropdown">

                <button
                    class="btn btn-light border dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <i class="bi bi-person-fill"></i>

                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow">

                    <li>

                        <a
                            class="dropdown-item"
                            href="{{ route('profile.edit') }}">

                            <i class="bi bi-person me-2"></i>

                            My Profile

                        </a>

                    </li>

                    <li>

                        <hr class="dropdown-divider">

                    </li>

                    <li>

                        <form
                            action="{{ route('logout') }}"
                            method="POST">

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

        </div>

    </div>

</nav>