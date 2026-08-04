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
    public function index(Request $request)
    {
        $query = Property::with('user');

        // Search by Property Title
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Search by City
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Filter by Property Type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Filter by Purpose
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // Minimum Price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // Maximum Price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        // Bedrooms
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', $request->bedrooms);
        }
        // Bathrooms
        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', $request->bathrooms);
        }

        // Sorting
        if ($request->filled('sort')) {

            switch ($request->sort) {

                case 'price_low':
                    $query->orderBy('price');
                    break;

                case 'price_high':
                    $query->orderByDesc('price');
                    break;

                case 'oldest':
                    $query->oldest();
                    break;

                default:
                    $query->latest();
                    break;
            }

        } else {

            $query->latest();

        }

        $properties = $query
            ->paginate(10)
            ->withQueryString();

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
    /**
     * Generate unique property slug.
     */
    private function generateSlug($title)
    {
        $slug = Str::slug($title);

        $count = Property::where('slug', 'LIKE', "{$slug}%")->count();

        return $count
            ? "{$slug}-" . ($count + 1)
            : $slug;
    }
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

            'slug' => $this->generateSlug($request->title),

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
        $isWishlisted = false;

        if (auth()->check()) {

            $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                ->where('property_id', $property->id)
                ->exists();

        }

        return view('property.show', compact(
            'property',
            'isWishlisted'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        if ($property->user_id !== auth()->id()) {

            abort(403, 'Unauthorized Access.');

        }

        return view('property.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        if ($property->user_id !== auth()->id()) {

            abort(403, 'Unauthorized Access.');

        }
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

     $request->validate([

    'title' => 'required|string|max:255',

    'property_type' => 'required|string|max:100',

    'purpose' => 'required|string|max:100',

    'price' => 'required|numeric|min:0',

    'deposit' => 'nullable|numeric|min:0',

    'bedrooms' => 'required|integer|min:0',

    'bathrooms' => 'required|integer|min:0',

    'balconies' => 'nullable|integer|min:0',

    'area' => 'required|numeric|min:1',

    'furnishing' => 'required|string|max:100',

    'parking' => 'required|boolean',

    'address' => 'required|string|max:500',

    'city' => 'required|string|max:100',

    'state' => 'required|string|max:100',

    'pincode' => 'required|digits:6',

    'description' => 'required|string|min:20|max:5000',

    'status' => 'required|in:Available,Rented',

    'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

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
        if ($property->user_id !== auth()->id()) {

            abort(403, 'Unauthorized Access.');

        }

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