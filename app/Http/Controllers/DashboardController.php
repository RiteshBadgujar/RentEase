<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProperties = Property::count();

        $availableProperties = Property::where('status', 'Available')->count();

        $rentedProperties = Property::where('status', 'Rented')->count();

        $totalValue = Property::sum('price');

        $recentProperties = Property::latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProperties',
            'availableProperties',
            'rentedProperties',
            'totalValue',
            'recentProperties'
        ));
    }
}