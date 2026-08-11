<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPropertyController extends Controller
{
    /**
     * Display all properties.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Property Query
        |--------------------------------------------------------------------------
        */

        $query = Property::with('user');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('city', 'like', '%' . $request->search . '%')
                    ->orWhere('address', 'like', '%' . $request->search . '%');

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Property Type Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('property_type')) {

            $query->where(
                'property_type',
                $request->property_type
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Properties
        |--------------------------------------------------------------------------
        */

        $properties = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $totalProperties = Property::count();

        $availableProperties = Property::where(
            'status',
            'Available'
        )->count();

        $rentedProperties = Property::where(
            'status',
            'Rented'
        )->count();

        $pendingProperties = Property::where(
            'status',
            'Pending'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.properties.index',
            compact(
                'properties',
                'totalProperties',
                'availableProperties',
                'rentedProperties',
                'pendingProperties'
            )
        );
    }

    /**
     * Not Used.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Not Used.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display Property Details.
     */
    public function show(Property $property)
    {
        $property->load([

            'user:id,name,email',

            'bookings',

            'wishlists',

            'enquiries'

        ]);

        return view(
            'admin.properties.show',
            compact('property')
        );
    }

    /**
     * Edit Property.
     */
    public function edit(Property $property)
    {
        return view(
            'admin.properties.edit',
            compact('property')
        );
    }

    /**
     * Update Property.
     */
    public function update(Request $request, Property $property)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'title'           => 'required|string|max:255',

            'description'     => 'required|string',

            'price'           => 'required|numeric|min:0',

            'property_type'   => 'required|string|max:100',

            'status'          => 'required|in:Available,Rented,Pending',

            'address'         => 'required|string|max:255',

            'city'            => 'required|string|max:100',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Property
        |--------------------------------------------------------------------------
        */

        $property->update([

            'title'           => $request->title,

            'description'     => $request->description,

            'price'           => $request->price,

            'property_type'   => $request->property_type,

            'status'          => $request->status,

            'address'         => $request->address,

            'city'            => $request->city,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.properties.index')
            ->with(
                'success',
                'Property updated successfully.'
            );
    }

    /**
     * Delete Property.
     */
    public function destroy(Property $property)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */

        if (
            !empty($property->image) &&
            Storage::disk('public')->exists($property->image)
        ) {

            Storage::disk('public')->delete($property->image);

        }

        /*
        |--------------------------------------------------------------------------
        | Delete Property
        |--------------------------------------------------------------------------
        */

        $property->delete();

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.properties.index')
            ->with(
                'success',
                'Property deleted successfully.'
            );
    }
}