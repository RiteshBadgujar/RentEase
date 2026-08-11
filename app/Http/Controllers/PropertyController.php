<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display all properties.
     */
    public function index(Request $request)
    {
        $query = Property::with('user');

        // Search filters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', $request->bedrooms);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', $request->bathrooms);
        }

        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price', 'desc');
                break;

            case 'oldest':
                $query->oldest();
                break;

            default:
                $query->latest();
                break;
        }

        $properties = $query
            ->paginate(10)
            ->withQueryString();

        return view('property.index', compact('properties'));
    }

    /**
     * Show create property form.
     */
    public function create()
    {
        if (!auth()->user()->isLandlord()) {
            abort(403, 'Only landlords can add properties.');
        }

        return view('property.create');
    }

    /**
     * Generate a unique property slug.
     */
    private function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);

        if ($baseSlug === '') {
            $baseSlug = 'property';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Property::where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $counter++;
            $slug = $baseSlug . '-' . $counter;
        }

        return $slug;
    }

    /**
     * Store a newly created property.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isLandlord()) {
            abort(403, 'Only landlords can add properties.');
        }

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'property_type' => [
                'required',
                'string',
                'max:100',
            ],

            'purpose' => [
                'required',
                'string',
                'max:100',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'deposit' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'bedrooms' => [
                'required',
                'integer',
                'min:0',
            ],

            'bathrooms' => [
                'required',
                'integer',
                'min:0',
            ],

            'balconies' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'area' => [
                'required',
                'numeric',
                'min:1',
            ],

            'furnishing' => [
                'required',
                'string',
                'max:100',
            ],

            'parking' => [
                'nullable',
                'boolean',
            ],

            'address' => [
                'required',
                'string',
                'max:500',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'state' => [
                'required',
                'string',
                'max:100',
            ],

            'pincode' => [
                'required',
                'digits:6',
            ],

            'description' => [
                'required',
                'string',
                'min:20',
                'max:5000',
            ],

            // IMPORTANT:
            // Migration supports only Available and Rented.
            'status' => [
                'required',
                'in:Available,Rented',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(
                'properties',
                'public'
            );
        }

        Property::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => $this->generateSlug($validated['title']),
            'description' => $validated['description'],
            'property_type' => $validated['property_type'],
            'purpose' => $validated['purpose'],
            'price' => $validated['price'],
            'deposit' => $validated['deposit'] ?? null,
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'balconies' => $validated['balconies'] ?? 0,
            'area' => $validated['area'],
            'furnishing' => $validated['furnishing'],
            'parking' => $request->boolean('parking'),
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'image' => $imagePath,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property added successfully.');
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        $property->load('user');

        $isWishlisted = false;

        if (auth()->check()) {
            $isWishlisted = Wishlist::where('user_id', auth()->id())
                ->where('property_id', $property->id)
                ->exists();
        }

        $relatedProperties = Property::where(
            'property_type',
            $property->property_type
        )
            ->where('id', '!=', $property->id)
            ->where('status', 'Available')
            ->latest()
            ->take(4)
            ->get();

        return view(
            'property.show',
            compact(
                'property',
                'isWishlisted',
                'relatedProperties'
            )
        );
    }

    /**
     * Show edit form.
     */
    public function edit(Property $property)
    {
        $this->authorizeOwner($property);

        return view('property.edit', compact('property'));
    }

    /**
     * Update property.
     */
    public function update(Request $request, Property $property)
    {
        $this->authorizeOwner($property);

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'property_type' => [
                'required',
                'string',
                'max:100',
            ],

            'purpose' => [
                'required',
                'string',
                'max:100',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'deposit' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'bedrooms' => [
                'required',
                'integer',
                'min:0',
            ],

            'bathrooms' => [
                'required',
                'integer',
                'min:0',
            ],

            'balconies' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'area' => [
                'required',
                'numeric',
                'min:1',
            ],

            'furnishing' => [
                'required',
                'string',
                'max:100',
            ],

            'parking' => [
                'nullable',
                'boolean',
            ],

            'address' => [
                'required',
                'string',
                'max:500',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'state' => [
                'required',
                'string',
                'max:100',
            ],

            'pincode' => [
                'required',
                'digits:6',
            ],

            'description' => [
                'required',
                'string',
                'min:20',
                'max:5000',
            ],

            'status' => [
                'required',
                'in:Available,Rented',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ]);

        $oldImage = $property->image;
        $newImage = $oldImage;

        /*
         * Store the new image FIRST.
         * Only delete the old image after successful storage.
         */
        if ($request->hasFile('image')) {
            $newImage = $request->file('image')->store(
                'properties',
                'public'
            );
        }

        $slug = $property->slug;

        if ($property->title !== $validated['title']) {
            $slug = $this->generateSlug(
                $validated['title'],
                $property->id
            );
        }

        $property->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'property_type' => $validated['property_type'],
            'purpose' => $validated['purpose'],
            'price' => $validated['price'],
            'deposit' => $validated['deposit'] ?? null,
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'balconies' => $validated['balconies'] ?? 0,
            'area' => $validated['area'],
            'furnishing' => $validated['furnishing'],
            'parking' => $request->boolean('parking'),
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'status' => $validated['status'],
            'image' => $newImage,
        ]);

        /*
         * Delete old image only after successful update.
         */
        if (
            $request->hasFile('image') &&
            $oldImage &&
            $oldImage !== $newImage &&
            Storage::disk('public')->exists($oldImage)
        ) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Delete property.
     */
    public function destroy(Property $property)
    {
        $this->authorizeOwner($property);

        if (
            $property->image &&
            Storage::disk('public')->exists($property->image)
        ) {
            Storage::disk('public')->delete($property->image);
        }

        $property->delete();

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property deleted successfully.');
    }

    /**
     * Authorize property owner.
     */
    private function authorizeOwner(Property $property): void
    {
        $user = auth()->user();

        if (!$user || !$user->isLandlord()) {
            abort(403, 'Only landlords can manage properties.');
        }

        if ((int) $property->user_id !== (int) $user->id) {
            abort(403, 'Unauthorized Access.');
        }
    }
}