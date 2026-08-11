<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    /**
     * Display the authenticated user's wishlist.
     */
    public function index()
    {
        $wishlists = Wishlist::with([
                'property.user'
            ])
            ->where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'wishlist.index',
            compact('wishlists')
        );
    }

    /**
     * Add a property to the authenticated user's wishlist.
     */
    public function store(Property $property)
    {
        /*
        |--------------------------------------------------------------------------
        | Prevent Own Property Wishlist
        |--------------------------------------------------------------------------
        */

        if ($property->user_id == auth()->id()) {

            return back()->with(
                'error',
                'You cannot add your own property to the wishlist.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Add to Wishlist
        |--------------------------------------------------------------------------
        */

        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'property_id' => $property->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

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
        /*
        |--------------------------------------------------------------------------
        | Remove Only Current User's Wishlist Item
        |--------------------------------------------------------------------------
        */

        Wishlist::where(
                'user_id',
                auth()->id()
            )
            ->where(
                'property_id',
                $property->id
            )
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Property removed from wishlist successfully.'
        );
    }
}