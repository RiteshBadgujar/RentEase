<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    /**
     * Display the authenticated tenant's wishlist.
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Tenant Authorization
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        if (!$user || !$user->isTenant()) {
            abort(
                403,
                'Only tenants can access the wishlist.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Get Tenant Wishlist
        |--------------------------------------------------------------------------
        */

        $wishlists = Wishlist::with([
                'property.user'
            ])
            ->where(
                'user_id',
                $user->id
            )
            ->latest()
            ->paginate(10);


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'wishlist.index',
            compact('wishlists')
        );
    }


    /**
     * Add a property to the authenticated tenant's wishlist.
     */
    public function store(
        Property $property
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Tenant Authorization
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        if (!$user || !$user->isTenant()) {
            abort(
                403,
                'Only tenants can add properties to the wishlist.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Own Property Wishlist
        |--------------------------------------------------------------------------
        */

        if (
            (int) $property->user_id ===
            (int) $user->id
        ) {
            return back()->with(
                'error',
                'You cannot add your own property to the wishlist.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Property Must Be Available
        |--------------------------------------------------------------------------
        |
        | Pending and Rented properties should not be added to a
        | tenant's wishlist because they are not currently available.
        |
        */

        if ($property->status !== 'Available') {
            return back()->with(
                'error',
                'Only available properties can be added to the wishlist.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Wishlist
        |--------------------------------------------------------------------------
        |
        | firstOrCreate ensures that the same property is not added
        | multiple times for the same tenant.
        |
        */

        Wishlist::firstOrCreate([
            'user_id' => $user->id,
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
     * Remove a property from the authenticated tenant's wishlist.
     */
    public function destroy(
        Property $property
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Tenant Authorization
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        if (!$user || !$user->isTenant()) {
            abort(
                403,
                'Only tenants can manage the wishlist.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Remove Only Current Tenant's Wishlist Item
        |--------------------------------------------------------------------------
        */

        Wishlist::where(
                'user_id',
                $user->id
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