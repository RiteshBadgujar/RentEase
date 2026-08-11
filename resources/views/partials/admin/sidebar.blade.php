<div class="text-center text-white py-4">

    <h3 class="fw-bold">

        RentEase

    </h3>

    <small>

        Admin Panel

    </small>

</div>

<hr class="text-secondary">

<ul class="nav flex-column">

    <li class="nav-item">

        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

            <i class="bi bi-speedometer2 me-2"></i>

            Dashboard

        </a>

    </li>

    <li class="nav-item">

        <a href="{{ route('admin.users.index') }}"
            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">

            <i class="bi bi-people me-2"></i>

            Users

        </a>

    </li>

    <li class="nav-item">

        <a href="{{ route('admin.properties.index') }}"
            class="nav-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
            <i class="bi bi-buildings me-2"></i>

            Properties

        </a>

    </li>

    <li class="nav-item">

        <a href="{{ route('admin.bookings.index') }}"
            class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check me-2"></i>

            Bookings

        </a>

    </li>

    <li class="nav-item">

        <a href="{{ route('admin.enquiries.index') }}"
            class="nav-link {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots me-2"></i>

            Enquiries

        </a>

    </li>

    <li class="nav-item">

        <a href="{{ route('admin.notifications.index') }}"
            class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
            <i class="bi bi-bell me-2"></i>

            Notifications

        </a>

    </li>

    <li class="nav-item">

        <a href="{{ route('admin.reports.index') }}"
            class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart me-2"></i>

            Reports

        </a>

    </li>

    <li class="nav-item">

        <a href="{{ route('admin.activity-logs.index') }}"
            class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history me-2"></i>

            Activity Logs

        </a>

    </li>

    <li class="nav-item">

        <a href="{{ route('admin.settings.index') }}"
            class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear me-2"></i>

            Settings

        </a>

    </li>

</ul>