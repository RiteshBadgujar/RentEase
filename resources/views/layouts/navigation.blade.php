<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <!-- Left Side -->
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">

                    <a href="{{ route('dashboard') }}">

                        <span class="text-2xl font-bold text-blue-600">

                            <i class="bi bi-buildings-fill"></i>

                            RentEase

                        </span>

                    </a>

                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:flex sm:items-center sm:space-x-6 sm:ms-8">

                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')">

                        Dashboard

                    </x-nav-link>

                    <x-nav-link
                        :href="route('properties.index')"
                        :active="request()->routeIs('properties.*')">

                        Properties

                    </x-nav-link>

                    <x-nav-link
                        :href="route('wishlist.index')"
                        :active="request()->routeIs('wishlist.*')">

                        Wishlist

                    </x-nav-link>

                    <x-nav-link
                        :href="route('tenant.bookings.index')"
                        :active="request()->routeIs('tenant.bookings.*')">

                        My Bookings

                    </x-nav-link>

                    <x-nav-link
                        :href="route('bookings.index')"
                        :active="request()->routeIs('bookings.*')">

                        Booking Requests

                    </x-nav-link>

                    <x-nav-link
                        :href="route('enquiries.index')"
                        :active="request()->routeIs('enquiries.*')">

                        Enquiries

                    </x-nav-link>

                </div>

            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">

                <a href="{{ route('notifications.index') }}"
                   class="text-gray-600 hover:text-blue-600">

                    <i class="bi bi-bell fs-5"></i>

                </a>

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 bg-white hover:text-blue-600">

                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">

                                <svg class="fill-current h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">

                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"/>

                                </svg>

                            </div>

                        </button>

                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">

                            Profile

                        </x-dropdown-link>

                        <form method="POST"
                              action="{{ route('logout') }}">

                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault();
                                         this.closest('form').submit();">

                                Log Out

                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            <!-- Mobile Button -->
            <div class="-me-2 flex items-center sm:hidden">

                <button @click="open=!open"
                    class="inline-flex items-center justify-center p-2 rounded-md">

                    ☰

                </button>

            </div>

        </div>

    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('properties.index')">
                Properties
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('wishlist.index')">
                Wishlist
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('tenant.bookings.index')">
                My Bookings
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('bookings.index')">
                Booking Requests
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('enquiries.index')">
                Enquiries
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('notifications.index')">
                Notifications
            </x-responsive-nav-link>

        </div>

        <div class="border-t border-gray-200 pt-4">

            <div class="px-4">

                <div class="font-medium">

                    {{ Auth::user()->name }}

                </div>

                <div class="text-sm text-gray-500">

                    {{ Auth::user()->email }}

                </div>

            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">

                    Profile

                </x-responsive-nav-link>

                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault();
                                 this.closest('form').submit();">

                        Log Out

                    </x-responsive-nav-link>

                </form>

            </div>

        </div>

    </div>

</nav>