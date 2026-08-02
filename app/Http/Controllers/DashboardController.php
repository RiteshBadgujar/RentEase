<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Property;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Property Statistics
        |--------------------------------------------------------------------------
        */

        $totalProperties = Property::count();

        $availableProperties = Property::where('status', 'Available')->count();

        $rentedProperties = Property::where('status', 'Rented')->count();

        $totalValue = Property::sum('price');

        /*
        |--------------------------------------------------------------------------
        | Enquiry Statistics
        |--------------------------------------------------------------------------
        */

        $totalEnquiries = Enquiry::where('receiver_id', auth()->id())->count();

        $pendingEnquiries = Enquiry::where('receiver_id', auth()->id())
            ->where('status', 'Pending')
            ->count();

        $repliedEnquiries = Enquiry::where('receiver_id', auth()->id())
            ->where('status', 'Replied')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Recent Properties
        |--------------------------------------------------------------------------
        */

        $recentProperties = Property::latest()
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

            'recentProperties'

        ));
    }
}