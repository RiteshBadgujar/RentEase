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
     * Display all publicly available properties.
     *
     * Public users can only see:
     * - Available
     * - Rented
     *
     * Pending properties are hidden from public browsing.
     */
    public function index(Request $request)
    {
        $query = Property::with('user')
            ->whereIn('status', [
                'Available',
                'Rented',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Search Filters
        |--------------------------------------------------------------------------
        */

        if ($request->filled('title')) {
            $query->where(
                'title',
                'like',
                '%' . $request->title . '%'
            );
        }

        if ($request->filled('city')) {
            $query->where(
                'city',
                'like',
                '%' . $request->city . '%'
            );
        }

        if ($request->filled('property_type')) {
            $query->where(
                'property_type',
                $request->property_type
            );
        }

        if ($request->filled('purpose')) {
            $query->where(
                'purpose',
                $request->purpose
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status') &&
            in_array(
                $request->status,
                [
                    'Available',
                    'Rented',
                ],
                true
            )
        ) {
            $query->where(
                'status',
                $request->status
            );
        }

        if ($request->filled('min_price')) {
            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        if ($request->filled('max_price')) {
            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        if ($request->filled('bedrooms')) {
            $query->where(
                'bedrooms',
                $request->bedrooms
            );
        }

        if ($request->filled('bathrooms')) {
            $query->where(
                'bathrooms',
                $request->bathrooms
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($request->sort) {

            case 'price_low':

                $query->orderBy(
                    'price',
                    'asc'
                );

                break;

            case 'price_high':

                $query->orderBy(
                    'price',
                    'desc'
                );

                break;

            case 'oldest':

                $query->oldest();

                break;

            default:

                $query->latest();

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $properties = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'property.index',
            compact('properties')
        );
    }


    /**
     * Display properties owned by the authenticated landlord.
     *
     * Landlords can see their own:
     * - Available
     * - Rented
     * - Pending
     *
     * Pending properties are intentionally visible here because
     * the landlord should be able to see properties controlled
     * by the administrator.
     */
    public function myProperties(Request $request)
    {
        $this->authorizeLandlord();

        $query = Property::where(
            'user_id',
            auth()->id()
        );

        /*
        |--------------------------------------------------------------------------
        | Search Filters
        |--------------------------------------------------------------------------
        */

        if ($request->filled('title')) {
            $query->where(
                'title',
                'like',
                '%' . $request->title . '%'
            );
        }

        if ($request->filled('city')) {
            $query->where(
                'city',
                'like',
                '%' . $request->city . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status') &&
            in_array(
                $request->status,
                [
                    'Available',
                    'Rented',
                    'Pending',
                ],
                true
            )
        ) {
            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($request->sort) {

            case 'price_low':

                $query->orderBy(
                    'price',
                    'asc'
                );

                break;

            case 'price_high':

                $query->orderBy(
                    'price',
                    'desc'
                );

                break;

            case 'oldest':

                $query->oldest();

                break;

            default:

                $query->latest();

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $properties = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'property.my-properties',
            compact('properties')
        );
    }


    /**
     * Show create property form.
     *
     * Only landlords can create properties.
     */
    public function create()
    {
        $this->authorizeLandlord();

        return view('property.create');
    }


    /**
     * Generate a unique property slug.
     */
    private function generateSlug(
        string $title,
        ?int $ignoreId = null
    ): string {

        $baseSlug = Str::slug($title);

        if ($baseSlug === '') {
            $baseSlug = 'property';
        }

        $slug = $baseSlug;

        $counter = 1;

        while (
            Property::where(
                'slug',
                $slug
            )
                ->when(
                    $ignoreId,
                    fn ($query) =>
                        $query->where(
                            'id',
                            '!=',
                            $ignoreId
                        )
                )
                ->exists()
        ) {

            $counter++;

            $slug =
                $baseSlug .
                '-' .
                $counter;
        }

        return $slug;
    }


    /**
     * Store a newly created property.
     *
     * Only landlords can create properties.
     */
    public function store(Request $request)
    {
        $this->authorizeLandlord();

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Store Image
        |--------------------------------------------------------------------------
        */

        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store(
                    'properties',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Property
        |--------------------------------------------------------------------------
        */

        Property::create([

            'user_id' => auth()->id(),

            'title' => $validated['title'],

            'slug' => $this->generateSlug(
                $validated['title']
            ),

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
            ->route('properties.my')
            ->with(
                'success',
                'Property added successfully.'
            );
    }


    /**
     * Display the specified property.
     *
     * Pending properties:
     *
     * - Hidden from guests
     * - Hidden from tenants
     * - Visible to the property owner
     * - Visible to admins
     */
    public function show(Property $property)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Protect Pending Properties
        |--------------------------------------------------------------------------
        */

        if ($property->status === 'Pending') {

            $isOwner = $user &&
                $user->isLandlord() &&
                (int) $property->user_id === (int) $user->id;

            $isAdmin = $user &&
                $user->isAdmin();

            if (!$isOwner && !$isAdmin) {

                abort(
                    404,
                    'Property not found.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Load Property Owner
        |--------------------------------------------------------------------------
        */

        $property->load('user');

        /*
        |--------------------------------------------------------------------------
        | Wishlist Status
        |--------------------------------------------------------------------------
        */

        $isWishlisted = false;

        if (
            auth()->check() &&
            auth()->user()->isTenant()
        ) {

            $isWishlisted = Wishlist::where(
                'user_id',
                auth()->id()
            )
                ->where(
                    'property_id',
                    $property->id
                )
                ->exists();
        }

        /*
        |--------------------------------------------------------------------------
        | Related Available Properties
        |--------------------------------------------------------------------------
        */

        $relatedProperties = Property::where(
            'property_type',
            $property->property_type
        )
            ->where(
                'id',
                '!=',
                $property->id
            )
            ->where(
                'status',
                'Available'
            )
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
     *
     * Only the property owner who is a landlord
     * can edit the property.
     */
    public function edit(Property $property)
    {
        $this->authorizeOwner($property);

        return view(
            'property.edit',
            compact('property')
        );
    }


    /**
     * Update property.
     */
    public function update(
        Request $request,
        Property $property
    ) {

        $this->authorizeOwner($property);

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Existing Image
        |--------------------------------------------------------------------------
        */

        $oldImage = $property->image;

        $newImage = $oldImage;

        /*
        |--------------------------------------------------------------------------
        | Store New Image First
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $newImage = $request
                ->file('image')
                ->store(
                    'properties',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Property Slug
        |--------------------------------------------------------------------------
        */

        $slug = $property->slug;

        if ($property->title !== $validated['title']) {

            $slug = $this->generateSlug(
                $validated['title'],
                $property->id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Property
        |--------------------------------------------------------------------------
        */

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
        |--------------------------------------------------------------------------
        | Delete Old Image
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('image') &&
            $oldImage &&
            $oldImage !== $newImage &&
            Storage::disk('public')->exists($oldImage)
        ) {

            Storage::disk('public')->delete(
                $oldImage
            );
        }

        return redirect()
            ->route('properties.my')
            ->with(
                'success',
                'Property updated successfully.'
            );
    }


    /**
     * Delete property.
     *
     * Only the property owner can delete it.
     */
    public function destroy(Property $property)
    {
        $this->authorizeOwner($property);

        /*
        |--------------------------------------------------------------------------
        | Delete Property Image
        |--------------------------------------------------------------------------
        */

        if (
            $property->image &&
            Storage::disk('public')->exists(
                $property->image
            )
        ) {

            Storage::disk('public')->delete(
                $property->image
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Property
        |--------------------------------------------------------------------------
        */

        $property->delete();

        return redirect()
            ->route('properties.my')
            ->with(
                'success',
                'Property deleted successfully.'
            );
    }


    /**
     * Make sure the authenticated user is a landlord.
     */
    private function authorizeLandlord(): void
    {
        $user = auth()->user();

        if (
            !$user ||
            !$user->isLandlord()
        ) {

            abort(
                403,
                'Only landlords can manage properties.'
            );
        }
    }


    /**
     * Authorize property owner.
     */
    private function authorizeOwner(
        Property $property
    ): void {

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Landlord Check
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            !$user->isLandlord()
        ) {

            abort(
                403,
                'Only landlords can manage properties.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ownership Check
        |--------------------------------------------------------------------------
        */

        if (
            (int) $property->user_id !==
            (int) $user->id
        ) {

            abort(
                403,
                'Unauthorized Access.'
            );
        }
    }
}