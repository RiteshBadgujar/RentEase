<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display the authenticated user's wishlist.
     */
    public function index()
    {
        $wishlists = Wishlist::with('property')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Add a property to the authenticated user's wishlist.
     */
    public function store(Property $property)
    {
        Wishlist::firstOrCreate([
            'user_id'     => auth()->id(),
            'property_id' => $property->id,
        ]);

        return back()->with(
            'success',
            'Property added to wishlist successfully.'
        );
    }

    /**
     * Remove a property from the authenticated user's wishlist.
     */
    public function destroy(Property $property)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('property_id', $property->id)
            ->delete();

        return back()->with(
            'success',
            'Property removed from wishlist successfully.'
        );
    }
}