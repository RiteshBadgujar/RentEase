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
        | Hero Statistics
        |--------------------------------------------------------------------------
        */

        $totalProperties = Property::where('status', 'Available')
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
            ->where('status', 'Available')
            ->latest()
            ->take(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Property Category Counts
        |--------------------------------------------------------------------------
        */

        $categoryCounts = Property::where('status', 'Available')
            ->select('property_type')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('property_type')
            ->pluck('total', 'property_type');

        $categories = [

            [
                'icon' => 'bi-buildings-fill',
                'title' => 'Apartment',
                'count' => $categoryCounts['Apartment'] ?? 0,
            ],

            [
                'icon' => 'bi-house-door-fill',
                'title' => 'House',
                'count' => $categoryCounts['House'] ?? 0,
            ],

            [
                'icon' => 'bi-bank',
                'title' => 'Villa',
                'count' => $categoryCounts['Villa'] ?? 0,
            ],

            [
                'icon' => 'bi-door-open-fill',
                'title' => 'PG',
                'count' => $categoryCounts['PG'] ?? 0,
            ],

            [
                'icon' => 'bi-building',
                'title' => 'Office',
                'count' => $categoryCounts['Office'] ?? 0,
            ],

            [
                'icon' => 'bi-shop',
                'title' => 'Commercial',
                'count' => $categoryCounts['Commercial'] ?? 0,
            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | Popular Cities
        |--------------------------------------------------------------------------
        */

        $cities = Property::where('status', 'Available')
            ->select('city')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('city')
            ->orderBy('city')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return Homepage
        |--------------------------------------------------------------------------
        */

        return view('home.index', compact(

            'totalProperties',
            'totalUsers',
            'totalLandlords',

            'featuredProperties',

            'categories',

            'cities'

        ));
    }
}