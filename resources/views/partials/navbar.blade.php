<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3" id="mainNavbar">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold fs-3 text-primary" href="/">
            <i class="bi bi-buildings-fill"></i>
            RentEase
        </a>

        <!-- Mobile Button -->
        <button class="navbar-toggler border-0 shadow-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar">

            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbar">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Properties</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>

            </ul>

            <div class="d-flex align-items-center gap-3">

                <a href="#" class="text-dark fs-5">
                    <i class="bi bi-search"></i>
                </a>

                <a href="{{ route('login') }}" class="btn btn-outline-primary px-4">
                    Login
                </a>

                <a href="{{ route('register') }}" class="btn btn-primary px-4">
                    Register
                </a>

            </div>

        </div>

    </div>
</nav>