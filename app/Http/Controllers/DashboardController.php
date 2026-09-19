<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Notification;
use App\Models\Property;

class DashboardController extends Controller
{
    /**
     * Display the dashboard according to the authenticated user's role.
     */
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Authentication Check
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | Role Based Dashboard Routing
        |--------------------------------------------------------------------------
        */

        // Admin
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Tenant
        if ($user->isTenant()) {
            return redirect()->route('tenant.bookings.index');
        }

        // Only landlords can continue to the landlord dashboard.
        if (!$user->isLandlord()) {
            abort(403, 'Invalid user role.');
        }

        /*
        |--------------------------------------------------------------------------
        | Landlord Dashboard
        |--------------------------------------------------------------------------
        */

        $userId = $user->id;

        /*
        |--------------------------------------------------------------------------
        | Property Statistics
        |--------------------------------------------------------------------------
        */

        $propertyStats = Property::where('user_id', $userId)
            ->selectRaw("
                COUNT(*) as total_properties,

                SUM(
                    CASE
                        WHEN status = 'Available'
                        THEN 1
                        ELSE 0
                    END
                ) as available_properties,

                SUM(
                    CASE
                        WHEN status = 'Rented'
                        THEN 1
                        ELSE 0
                    END
                ) as rented_properties,

                COALESCE(SUM(price), 0) as total_value
            ")
            ->first();

        $totalProperties =
            (int) ($propertyStats->total_properties ?? 0);

        $availableProperties =
            (int) ($propertyStats->available_properties ?? 0);

        $rentedProperties =
            (int) ($propertyStats->rented_properties ?? 0);

        $totalValue =
            (float) ($propertyStats->total_value ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Booking Statistics
        |--------------------------------------------------------------------------
        */

        $bookingStats = Booking::where('landlord_id', $userId)
            ->selectRaw("
                COUNT(*) as total_bookings,

                SUM(
                    CASE
                        WHEN status = 'Pending'
                        THEN 1
                        ELSE 0
                    END
                ) as pending_bookings,

                SUM(
                    CASE
                        WHEN status = 'Approved'
                        THEN 1
                        ELSE 0
                    END
                ) as approved_bookings,

                SUM(
                    CASE
                        WHEN status = 'Completed'
                        THEN 1
                        ELSE 0
                    END
                ) as completed_bookings
            ")
            ->first();

        $totalBookings =
            (int) ($bookingStats->total_bookings ?? 0);

        $pendingBookings =
            (int) ($bookingStats->pending_bookings ?? 0);

        $approvedBookings =
            (int) ($bookingStats->approved_bookings ?? 0);

        $completedBookings =
            (int) ($bookingStats->completed_bookings ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Enquiry Statistics
        |--------------------------------------------------------------------------
        */

        $enquiryQuery = Enquiry::where(
            'receiver_id',
            $userId
        );

        $totalEnquiries = (clone $enquiryQuery)->count();

        $pendingEnquiries = (clone $enquiryQuery)
            ->where('status', 'Pending')
            ->count();

        $repliedEnquiries = (clone $enquiryQuery)
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

                SUM(
                    CASE
                        WHEN is_read = 0
                        THEN 1
                        ELSE 0
                    END
                ) as unread_notifications,

                SUM(
                    CASE
                        WHEN is_read = 1
                        THEN 1
                        ELSE 0
                    END
                ) as read_notifications
            ")
            ->first();

        $totalNotifications =
            (int) ($notificationStats->total_notifications ?? 0);

        $unreadNotifications =
            (int) ($notificationStats->unread_notifications ?? 0);

        $readNotifications =
            (int) ($notificationStats->read_notifications ?? 0);

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
            'property',
        ])
            ->where(
                'landlord_id',
                $userId
            )
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
            'property',
        ])
            ->where(
                'receiver_id',
                $userId
            )
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
        | Return Landlord Dashboard
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