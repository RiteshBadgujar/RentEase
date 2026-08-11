<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Notification;
use App\Models\Property;
use App\Models\User;
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
        | Overall Statistics
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
        | User Statistics
        |--------------------------------------------------------------------------
        */

        $totalAdmins = User::where('role', 'admin')->count();

        $totalLandlords = User::where('role', 'landlord')->count();

        $totalTenants = User::where('role', 'tenant')->count();

        /*
        |--------------------------------------------------------------------------
        | Property Statistics
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

        $pendingProperties = Property::where(
            'status',
            'Pending'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Booking Statistics
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

        $rejectedBookings = Booking::where(
            'status',
            'Rejected'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Enquiry Statistics
        |--------------------------------------------------------------------------
        */

        $pendingEnquiries = Enquiry::where(
            'status',
            'Pending'
        )->count();

        $repliedEnquiries = Enquiry::where(
            'status',
            'Replied'
        )->count();

        $closedEnquiries = Enquiry::where(
            'status',
            'Closed'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Notification Statistics
        |--------------------------------------------------------------------------
        */

        $readNotifications = Notification::where(
            'is_read',
            true
        )->count();

        $unreadNotifications = Notification::where(
            'is_read',
            false
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Recent Users
        |--------------------------------------------------------------------------
        */

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Properties
        |--------------------------------------------------------------------------
        */

        $recentProperties = Property::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Bookings
        |--------------------------------------------------------------------------
        */

        $recentBookings = Booking::with([
                'tenant',
                'property'
            ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Enquiries
        |--------------------------------------------------------------------------
        */

        $recentEnquiries = Enquiry::with([
                'sender',
                'property'
            ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.reports.index',
            compact(

                'totalUsers',
                'totalProperties',
                'totalBookings',
                'totalEnquiries',
                'totalNotifications',
                'totalWishlist',

                'totalAdmins',
                'totalLandlords',
                'totalTenants',

                'availableProperties',
                'rentedProperties',
                'pendingProperties',

                'pendingBookings',
                'approvedBookings',
                'completedBookings',
                'rejectedBookings',

                'pendingEnquiries',
                'repliedEnquiries',
                'closedEnquiries',

                'readNotifications',
                'unreadNotifications',

                'recentUsers',
                'recentProperties',
                'recentBookings',
                'recentEnquiries'
            )
        );
    }
}