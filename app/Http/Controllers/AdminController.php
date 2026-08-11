<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Notification;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Admin Authorization
        |--------------------------------------------------------------------------
        */

        if (
            !auth()->check() ||
            auth()->user()->role !== 'admin'
        ) {
            abort(403, 'Unauthorized Access.');
        }


        /*
        |--------------------------------------------------------------------------
        | User Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalAdmins = User::where(
            'role',
            'admin'
        )->count();

        $totalLandlords = User::where(
            'role',
            'landlord'
        )->count();

        $totalTenants = User::where(
            'role',
            'tenant'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Property Statistics
        |--------------------------------------------------------------------------
        */

        $totalProperties = Property::count();

        $availableProperties = Property::where(
            'status',
            'Available'
        )->count();

        $rentedProperties = Property::where(
            'status',
            'Rented'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Booking Statistics
        |--------------------------------------------------------------------------
        */

        $totalBookings = Booking::count();

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
        | Enquiry Statistics
        |--------------------------------------------------------------------------
        */

        $totalEnquiries = Enquiry::count();

        $pendingEnquiries = Enquiry::where(
            'status',
            'Pending'
        )->count();

        $repliedEnquiries = Enquiry::where(
            'status',
            'Replied'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Notification Statistics
        |--------------------------------------------------------------------------
        */

        $totalNotifications = Notification::count();

        $unreadNotifications = Notification::where(
            'is_read',
            false
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Recent Users
        |--------------------------------------------------------------------------
        */

        $recentUsers = User::select([
                'id',
                'name',
                'email',
                'role',
                'created_at',
            ])
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Properties
        |--------------------------------------------------------------------------
        */

        $recentProperties = Property::with([
                'user',
            ])
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Bookings
        |--------------------------------------------------------------------------
        */

        $recentBookings = Booking::with([
                'tenant:id,name',
                'property:id,title',
            ])
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Monthly Booking Analytics
        |--------------------------------------------------------------------------
        */

        $monthlyBookings = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->groupBy(
                DB::raw('MONTH(created_at)')
            )
            ->orderBy(
                DB::raw('MONTH(created_at)')
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Activities
        |--------------------------------------------------------------------------
        */

        $recentActivities = ActivityLog::with([
                'user',
            ])
            ->latest()
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Notifications
        |--------------------------------------------------------------------------
        */

        $recentNotifications = Notification::latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return Admin Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'totalAdmins',
                'totalLandlords',
                'totalTenants',
                'totalProperties',
                'availableProperties',
                'rentedProperties',
                'totalBookings',
                'pendingBookings',
                'approvedBookings',
                'completedBookings',
                'totalEnquiries',
                'pendingEnquiries',
                'repliedEnquiries',
                'totalNotifications',
                'unreadNotifications',
                'recentUsers',
                'recentProperties',
                'recentBookings',
                'monthlyBookings',
                'recentActivities',
                'recentNotifications'
            )
        );
    }
}