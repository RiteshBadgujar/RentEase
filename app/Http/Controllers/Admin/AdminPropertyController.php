<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminPropertyController extends Controller
{
    /**
     * Display all properties.
     */
    public function index(Request $request): View
    {
        $query = Property::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('property_type')) {
            $query->where(
                'property_type',
                $request->input('property_type')
            );
        }

        if ($request->filled('status')) {
            $request->validate([
                'status' => [
                    'nullable',
                    'in:Available,Rented,Pending',
                ],
            ]);

            $query->where(
                'status',
                $request->input('status')
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

    /**
     * Property creation is disabled for administrators.
     */
    public function create(): View
    {
        abort(404);
    }

    /**
     * Property creation is disabled for administrators.
     */
    public function store(Request $request): RedirectResponse
    {
        abort(404);
    }

    /**
     * Display property details.
     */
    public function show(Property $property): View
    {
        $property->load([
            'user:id,name,email',
            'bookings',
            'wishlists',
            'enquiries',
        ]);

        return view(
            'admin.properties.show',
            compact('property')
        );
    }

    /**
     * Show edit form.
     */
    public function edit(Property $property): View
    {
        return view(
            'admin.properties.edit',
            compact('property')
        );
    }

    /**
     * Update property.
     */
    public function update(
        Request $request,
        Property $property
    ): RedirectResponse {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
                'min:20',
                'max:5000',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'property_type' => [
                'required',
                'string',
                'max:100',
            ],

            'status' => [
                'required',
                'in:Available,Rented,Pending',
            ],

            'address' => [
                'required',
                'string',
                'max:255',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ]);

        $oldStatus = $property->status;
        $oldTitle = $property->title;
        $oldImage = $property->image;
        $newImage = $oldImage;

        /*
        |--------------------------------------------------------------------------
        | Upload New Image
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
        | Update Database
        |--------------------------------------------------------------------------
        */

        try {
            DB::transaction(function () use (
                $property,
                $validated,
                $oldStatus,
                $oldTitle,
                $newImage
            ) {
                $property->update([
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                    'price' => $validated['price'],
                    'property_type' => $validated['property_type'],
                    'status' => $validated['status'],
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'image' => $newImage,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Activity Log
                |--------------------------------------------------------------------------
                */

                ActivityLog::create([
                    'user_id' => auth()->id(),

                    'module' => 'Property',

                    'action' => 'Updated',

                    'description' =>
                        'Admin updated property #' .
                        $property->id .
                        ' "' .
                        $oldTitle .
                        '". Status changed from ' .
                        $oldStatus .
                        ' to ' .
                        $property->status .
                        '.',

                    'ip_address' => request()->ip(),

                    'browser' => request()->userAgent(),
                ]);

                /*
                |--------------------------------------------------------------------------
                | Notify Landlord
                |--------------------------------------------------------------------------
                */

                if ($property->user_id) {
                    Notification::create([
                        'user_id' => $property->user_id,

                        'title' => 'Property Updated',

                        'message' =>
                            'Your property "' .
                            $property->title .
                            '" was updated by an administrator.',

                        'type' => 'Property',

                        'url' => route(
                            'properties.show',
                            $property->id
                        ),

                        'is_read' => false,
                    ]);
                }
            });
        } catch (\Throwable $e) {
            /*
            |--------------------------------------------------------------------------
            | Delete New Image If Database Update Fails
            |--------------------------------------------------------------------------
            */

            if (
                $newImage !== $oldImage &&
                Storage::disk('public')->exists($newImage)
            ) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Old Image After Successful Update
        |--------------------------------------------------------------------------
        */

        if (
            $newImage !== $oldImage &&
            $oldImage &&
            Storage::disk('public')->exists($oldImage)
        ) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route('admin.properties.index')
            ->with(
                'success',
                'Property updated successfully.'
            );
    }

    /**
     * Delete property.
     */
    public function destroy(
        Property $property
    ): RedirectResponse {
        $propertyId = $property->id;
        $propertyTitle = $property->title;
        $landlordId = $property->user_id;
        $imagePath = $property->image;

        DB::transaction(function () use (
            $property,
            $propertyId,
            $propertyTitle,
            $imagePath
        ) {
            $property->delete();

            ActivityLog::create([
                'user_id' => auth()->id(),

                'module' => 'Property',

                'action' => 'Deleted',

                'description' =>
                    'Admin deleted property #' .
                    $propertyId .
                    ' "' .
                    $propertyTitle .
                    '".',

                'ip_address' => request()->ip(),

                'browser' => request()->userAgent(),
            ]);

            if (
                !empty($imagePath) &&
                Storage::disk('public')->exists($imagePath)
            ) {
                Storage::disk('public')->delete($imagePath);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Notify Landlord
        |--------------------------------------------------------------------------
        */

        if ($landlordId) {
            Notification::create([
                'user_id' => $landlordId,

                'title' => 'Property Deleted',

                'message' =>
                    'Your property "' .
                    $propertyTitle .
                    '" was deleted by an administrator.',

                'type' => 'Property',

                'url' => route(
                    'properties.index'
                ),

                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('admin.properties.index')
            ->with(
                'success',
                'Property deleted successfully.'
            );
    }
}