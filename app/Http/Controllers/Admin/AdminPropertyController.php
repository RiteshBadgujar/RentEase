<?php

namespace App\Http\Controllers\Admin;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with('user');

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('city', 'like', '%' . $request->search . '%')
                    ->orWhere('address', 'like', '%' . $request->search . '%');

            });

        }

        if ($request->filled('property_type')) {

            $query->where(
                'property_type',
                $request->property_type
            );

        }

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        $properties = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

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

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(Property $property)
    {
        $property->load([
            'user',
            'bookings',
            'wishlists',
            'enquiries',
        ]);

        return view(
            'admin.properties.show',
            compact('property')
        );
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, Property $property)
    {
        $request->validate([

            'title' => 'required|string|max:255',

            'description' => 'required',

            'price' => 'required|numeric|min:0',

            'property_type' => 'required|string|max:100',

            'status' => 'required|in:Available,Rented,Pending',

            'address' => 'required|string|max:255',

            'city' => 'required|string|max:100',

        ]);

        $property->update([

            'title' => $request->title,

            'description' => $request->description,

            'price' => $request->price,

            'property_type' => $request->property_type,

            'status' => $request->status,

            'address' => $request->address,

            'city' => $request->city,

        ]);

        return redirect()
            ->route('admin.properties.index')
            ->with(
                'success',
                'Property updated successfully.'
            );
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()
            ->route('admin.properties.index')
            ->with(
                'success',
                'Property deleted successfully.'
            );
    }
}