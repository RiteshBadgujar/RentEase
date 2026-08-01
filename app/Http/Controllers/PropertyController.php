<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::latest()->paginate(10);

        return view('property.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('property.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'property_type' => 'required',
            'purpose' => 'required',
            'price' => 'required|numeric',
            'deposit' => 'nullable|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'balconies' => 'nullable|integer',
            'area' => 'required|numeric',
            'furnishing' => 'required',
            'parking' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $imageName = time() . '_' . $request->image->getClientOriginalName();

            $request->image->move(
                public_path('uploads/properties'),
                $imageName
            );
        }

        Property::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'property_type' => $request->property_type,
            'purpose' => $request->purpose,
            'price' => $request->price,
            'deposit' => $request->deposit,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'balconies' => $request->balconies,
            'area' => $request->area,
            'furnishing' => $request->furnishing,
            'parking' => $request->parking,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'image' => $imageName,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property Added Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return view('property.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        return view('property.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'required|max:255',
            'property_type' => 'required',
            'purpose' => 'required',
            'price' => 'required|numeric',
            'deposit' => 'nullable|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'balconies' => 'nullable|integer',
            'area' => 'required|numeric',
            'furnishing' => 'required',
            'parking' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = $property->image;

        if ($request->hasFile('image')) {

            if (
                $property->image &&
                file_exists(public_path('uploads/properties/' . $property->image))
            ) {
                unlink(public_path('uploads/properties/' . $property->image));
            }

            $imageName = time() . '_' . $request->image->getClientOriginalName();

            $request->image->move(
                public_path('uploads/properties'),
                $imageName
            );
        }

        $property->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'property_type' => $request->property_type,
            'purpose' => $request->purpose,
            'price' => $request->price,
            'deposit' => $request->deposit,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'balconies' => $request->balconies,
            'area' => $request->area,
            'furnishing' => $request->furnishing,
            'parking' => $request->parking,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'image' => $imageName,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        if (
            $property->image &&
            file_exists(public_path('uploads/properties/' . $property->image))
        ) {
            unlink(public_path('uploads/properties/' . $property->image));
        }

        $property->delete();

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property Deleted Successfully.');
    }
}