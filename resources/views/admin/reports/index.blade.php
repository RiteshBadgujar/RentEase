@extends('layouts.master')

@section('title', 'Reports & Analytics')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->

    <div class="mb-4">

        <h2 class="fw-bold">

            <i class="bi bi-bar-chart-fill text-primary me-2"></i>

            Reports & Analytics Dashboard

        </h2>

        <p class="text-muted">

            View complete system statistics and analytics.

        </p>

    </div>

    <!-- Statistics Cards -->

    <div class="row g-4">

        <div class="col-lg-2 col-md-4">

            <div class="card shadow border-0 text-center">

                <div class="card-body">

                    <h3 class="text-primary">{{ $totalUsers }}</h3>

                    <p class="mb-0">Users</p>

                </div>

            </div>

        </div>

        <div class="col-lg-2 col-md-4">

            <div class="card shadow border-0 text-center">

                <div class="card-body">

                    <h3 class="text-success">{{ $totalProperties }}</h3>

                    <p class="mb-0">Properties</p>

                </div>

            </div>

        </div>

        <div class="col-lg-2 col-md-4">

            <div class="card shadow border-0 text-center">

                <div class="card-body">

                    <h3 class="text-warning">{{ $totalBookings }}</h3>

                    <p class="mb-0">Bookings</p>

                </div>

            </div>

        </div>

        <div class="col-lg-2 col-md-4">

            <div class="card shadow border-0 text-center">

                <div class="card-body">

                    <h3 class="text-danger">{{ $totalEnquiries }}</h3>

                    <p class="mb-0">Enquiries</p>

                </div>

            </div>

        </div>

        <div class="col-lg-2 col-md-4">

            <div class="card shadow border-0 text-center">

                <div class="card-body">

                    <h3 class="text-info">{{ $totalNotifications }}</h3>

                    <p class="mb-0">Notifications</p>

                </div>

            </div>

        </div>

        <div class="col-lg-2 col-md-4">

            <div class="card shadow border-0 text-center">

                <div class="card-body">

                    <h3 class="text-secondary">{{ $totalWishlist }}</h3>

                    <p class="mb-0">Wishlist</p>

                </div>

            </div>

        </div>

    </div>

    <!-- Charts -->

    <div class="row mt-5">

        <div class="col-lg-6">

            <div class="card shadow border-0">

                <div class="card-header fw-bold">

                    Booking Status

                </div>

                <div class="card-body">

                    <canvas id="bookingChart"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card shadow border-0">

                <div class="card-header fw-bold">

                    Property Status

                </div>

                <div class="card-body">

                    <canvas id="propertyChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    <!-- Recent Users -->

    <div class="card shadow border-0 mt-5">

        <div class="card-header fw-bold">

            Recent Users

        </div>

        <div class="card-body">

            <table class="table table-hover">

                <thead>

                <tr>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Role</th>

                </tr>

                </thead>

                <tbody>

                @foreach($recentUsers as $user)

                    <tr>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>{{ ucfirst($user->role) }}</td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- ChartJS -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('bookingChart'),{

    type:'doughnut',

    data:{

        labels:['Pending','Approved','Completed'],

        datasets:[{

            data:[
                {{ $pendingBookings }},
                {{ $approvedBookings }},
                {{ $completedBookings }}
            ]
        }]
    }

});

new Chart(document.getElementById('propertyChart'),{

    type:'pie',

    data:{

        labels:['Available','Rented'],

        datasets:[{

            data:[
                {{ $availableProperties }},
                {{ $rentedProperties }}
            ]
        }]
    }

});

</script>

@endsection