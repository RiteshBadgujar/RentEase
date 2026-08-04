<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Notification;
use App\Models\Wishlist;

class AdminReportController extends Controller
{
    /**
     * Display Reports Dashboard.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalProperties = Property::count();

        $totalBookings = Booking::count();

        $totalEnquiries = Enquiry::count();

        $totalNotifications = Notification::count();

        $totalWishlist = Wishlist::count();

        /*
        |--------------------------------------------------------------------------
        | Recent Records
        |--------------------------------------------------------------------------
        */

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        $recentProperties = Property::latest()
            ->take(5)
            ->get();

        $recentBookings = Booking::with([
                'tenant',
                'property'
            ])
            ->latest()
            ->take(5)
            ->get();

        $recentEnquiries = Enquiry::with([
                'sender',
                'property'
            ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Booking Status
        |--------------------------------------------------------------------------
        */

        $pendingBookings = Booking::where(
            'status',
            'Pending'
        )->count();

        $approvedBookings = Booking::where(
            'status',
            'Approved'
        )->count();

        $completedBookings = Booking::where(
            'status',
            'Completed'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Property Status
        |--------------------------------------------------------------------------
        */

        $availableProperties = Property::where(
            'status',
            'Available'
        )->count();

        $rentedProperties = Property::where(
            'status',
            'Rented'
        )->count();

        return view(
            'admin.reports.index',
            compact(

                'totalUsers',

                'totalProperties',

                'totalBookings',

                'totalEnquiries',

                'totalNotifications',

                'totalWishlist',

                'pendingBookings',

                'approvedBookings',

                'completedBookings',

                'availableProperties',

                'rentedProperties',

                'recentUsers',

                'recentProperties',

                'recentBookings',

                'recentEnquiries'

            )
        );
    }
}