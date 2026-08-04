<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Notification;
use App\Models\Property;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Property Statistics (Current Landlord)
        |--------------------------------------------------------------------------
        */

        $totalProperties = Property::where('user_id', auth()->id())
            ->count();

        $availableProperties = Property::where('user_id', auth()->id())
            ->where('status', 'Available')
            ->count();

        $rentedProperties = Property::where('user_id', auth()->id())
            ->where('status', 'Rented')
            ->count();

        $totalValue = Property::where('user_id', auth()->id())
            ->sum('price');

        /*
        |--------------------------------------------------------------------------
        | Enquiry Statistics
        |--------------------------------------------------------------------------
        */

        $totalEnquiries = Enquiry::where('receiver_id', auth()->id())
            ->count();

        $pendingEnquiries = Enquiry::where('receiver_id', auth()->id())
            ->pending()
            ->count();

        $repliedEnquiries = Enquiry::where('receiver_id', auth()->id())
            ->replied()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Notification Statistics
        |--------------------------------------------------------------------------
        */

        $totalNotifications = Notification::where('user_id', auth()->id())
            ->count();

        $unreadNotifications = Notification::where('user_id', auth()->id())
            ->unread()
            ->count();

        $readNotifications = Notification::where('user_id', auth()->id())
            ->read()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Recent Properties
        |--------------------------------------------------------------------------
        */

        $recentProperties = Property::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(

            'totalProperties',
            'availableProperties',
            'rentedProperties',
            'totalValue',

            'totalEnquiries',
            'pendingEnquiries',
            'repliedEnquiries',

            'totalNotifications',
            'unreadNotifications',
            'readNotifications',

            'recentProperties'

        ));
    }
}