<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Notification;
use App\Models\Property;

class DashboardController extends Controller
{
    /**
     * Display the Landlord Dashboard.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Current User
        |--------------------------------------------------------------------------
        */

        $userId = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | Property Statistics
        |--------------------------------------------------------------------------
        */

        $propertyStats = Property::where('user_id', $userId)
            ->selectRaw("
                COUNT(*) as total_properties,
                SUM(CASE WHEN status = 'Available' THEN 1 ELSE 0 END) as available_properties,
                SUM(CASE WHEN status = 'Rented' THEN 1 ELSE 0 END) as rented_properties,
                COALESCE(SUM(price), 0) as total_value
            ")
            ->first();

        $totalProperties = (int) $propertyStats->total_properties;

        $availableProperties = (int) $propertyStats->available_properties;

        $rentedProperties = (int) $propertyStats->rented_properties;

        $totalValue = (float) $propertyStats->total_value;

        /*
        |--------------------------------------------------------------------------
        | Booking Statistics
        |--------------------------------------------------------------------------
        */

        $bookingStats = Booking::where('landlord_id', $userId)
            ->selectRaw("
                COUNT(*) as total_bookings,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_bookings,
                SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved_bookings,
                SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_bookings
            ")
            ->first();

        $totalBookings = (int) $bookingStats->total_bookings;

        $pendingBookings = (int) $bookingStats->pending_bookings;

        $approvedBookings = (int) $bookingStats->approved_bookings;

        $completedBookings = (int) $bookingStats->completed_bookings;

        /*
        |--------------------------------------------------------------------------
        | Enquiry Statistics
        |--------------------------------------------------------------------------
        */

        $totalEnquiries = Enquiry::where(
            'receiver_id',
            $userId
        )->count();

        $pendingEnquiries = Enquiry::where(
            'receiver_id',
            $userId
        )
            ->where('status', 'Pending')
            ->count();

        $repliedEnquiries = Enquiry::where(
            'receiver_id',
            $userId
        )
            ->where('status', 'Replied')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Notification Statistics
        |--------------------------------------------------------------------------
        */

        $notificationStats = Notification::where(
            'user_id',
            $userId
        )
            ->selectRaw("
                COUNT(*) as total_notifications,
                SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) as unread_notifications,
                SUM(CASE WHEN is_read = 1 THEN 1 ELSE 0 END) as read_notifications
            ")
            ->first();

        $totalNotifications =
            (int) $notificationStats->total_notifications;

        $unreadNotifications =
            (int) $notificationStats->unread_notifications;

        $readNotifications =
            (int) $notificationStats->read_notifications;

        /*
        |--------------------------------------------------------------------------
        | Recent Properties
        |--------------------------------------------------------------------------
        */

        $recentProperties = Property::where(
            'user_id',
            $userId
        )
            ->latest()
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
            ->where('landlord_id', $userId)
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
            ->where('receiver_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Notifications
        |--------------------------------------------------------------------------
        */

        $recentNotifications = Notification::where(
            'user_id',
            $userId
        )
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard',
            compact(
                'totalProperties',
                'availableProperties',
                'rentedProperties',
                'totalValue',

                'totalBookings',
                'pendingBookings',
                'approvedBookings',
                'completedBookings',

                'totalEnquiries',
                'pendingEnquiries',
                'repliedEnquiries',

                'totalNotifications',
                'unreadNotifications',
                'readNotifications',

                'recentProperties',
                'recentBookings',
                'recentEnquiries',
                'recentNotifications'
            )
        );
    }
}