<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Property Status
        |--------------------------------------------------------------------------
        */

        $status = 'Available';

        /*
        |--------------------------------------------------------------------------
        | Hero Statistics
        |--------------------------------------------------------------------------
        */

        $totalProperties = Property::where('status', $status)
            ->count();

        $totalUsers = User::count();

        $totalLandlords = User::has('properties')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Featured Properties
        |--------------------------------------------------------------------------
        */

        $featuredProperties = Property::with('user')
            ->where('status', $status)
            ->latest()
            ->take(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Latest Properties
        |--------------------------------------------------------------------------
        */

        $latestProperties = Property::with('user')
            ->where('status', $status)
            ->latest()
            ->take(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Featured Landlords
        |--------------------------------------------------------------------------
        */

        $featuredLandlords = User::has('properties')
            ->withCount('properties')
            ->latest()
            ->take(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Property Category Counts
        |--------------------------------------------------------------------------
        */

        $categoryCounts = Property::where('status', $status)
            ->select('property_type')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('property_type')
            ->pluck('total', 'property_type');

        $categories = [

            [
                'icon'  => 'bi-buildings-fill',
                'title' => 'Apartment',
                'count' => $categoryCounts['Apartment'] ?? 0,
            ],

            [
                'icon'  => 'bi-house-door-fill',
                'title' => 'House',
                'count' => $categoryCounts['House'] ?? 0,
            ],

            [
                'icon'  => 'bi-bank',
                'title' => 'Villa',
                'count' => $categoryCounts['Villa'] ?? 0,
            ],

            [
                'icon'  => 'bi-door-open-fill',
                'title' => 'PG',
                'count' => $categoryCounts['PG'] ?? 0,
            ],

            [
                'icon'  => 'bi-building',
                'title' => 'Office',
                'count' => $categoryCounts['Office'] ?? 0,
            ],

            [
                'icon'  => 'bi-shop',
                'title' => 'Commercial',
                'count' => $categoryCounts['Commercial'] ?? 0,
            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | Popular Cities
        |--------------------------------------------------------------------------
        */

        $cities = Property::where('status', $status)
            ->select('city')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('city')
            ->orderByDesc('total')
            ->take(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view('home.index', compact(

            'totalProperties',
            'totalUsers',
            'totalLandlords',

            'featuredProperties',
            'latestProperties',

            'featuredLandlords',

            'categories',

            'cities'

        ));
    }
}