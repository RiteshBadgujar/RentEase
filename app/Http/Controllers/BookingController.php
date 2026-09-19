<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display all booking requests for the logged-in landlord.
     */
    public function index(): View
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Only Landlords Can Access Booking Requests
        |--------------------------------------------------------------------------
        */

        if (!$user->isLandlord()) {
            abort(403, 'Only landlords can access booking requests.');
        }

        /*
        |--------------------------------------------------------------------------
        | Get Landlord Bookings
        |--------------------------------------------------------------------------
        */

        $bookings = Booking::with([
                'property',
                'tenant',
            ])
            ->where('landlord_id', $user->id)
            ->latest()
            ->paginate(10);

        return view(
            'booking.index',
            compact('bookings')
        );
    }


    /**
     * Redirect create request.
     *
     * Booking creation is handled from the property details page.
     */
    public function create(): RedirectResponse
    {
        return redirect()
            ->route('properties.index');
    }


    /**
     * Store a new booking request.
     *
     * Only tenants can request a property visit.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Tenant Authorization
        |--------------------------------------------------------------------------
        */

        if (!$user->isTenant()) {
            return back()->with(
                'error',
                'Only tenants can request a property visit.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'property_id' => [
                'required',
                'integer',
                'exists:properties,id',
            ],

            'visit_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'visit_time' => [
                'required',
                'date_format:H:i',
            ],

            'message' => [
                'nullable',
                'string',
                'max:500',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Prevent Past Time for Today's Visit
        |--------------------------------------------------------------------------
        */

        if (
            $validated['visit_date'] === now()->toDateString() &&
            $validated['visit_time'] <= now()->format('H:i')
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Please select a future time for today.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Find Property
        |--------------------------------------------------------------------------
        */

        $property = Property::with('user')
            ->findOrFail(
                $validated['property_id']
            );


        /*
        |--------------------------------------------------------------------------
        | Prevent Booking Own Property
        |--------------------------------------------------------------------------
        */

        if (
            (int) $property->user_id ===
            (int) $user->id
        ) {
            return back()->with(
                'error',
                'You cannot book your own property.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Property Must Be Available
        |--------------------------------------------------------------------------
        */

        if ($property->status !== 'Available') {
            return back()->with(
                'error',
                'This property is currently not available for booking.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Property Owner Must Exist
        |--------------------------------------------------------------------------
        */

        if (!$property->user) {
            return back()->with(
                'error',
                'This property owner could not be found.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Booking By Same Tenant
        |--------------------------------------------------------------------------
        |
        | A tenant cannot create another Pending or Approved booking
        | for the same property, date and time.
        |
        */

        $tenantAlreadyBooked = Booking::where(
                'property_id',
                $property->id
            )
            ->where(
                'tenant_id',
                $user->id
            )
            ->where(
                'visit_date',
                $validated['visit_date']
            )
            ->where(
                'visit_time',
                $validated['visit_time']
            )
            ->whereIn(
                'status',
                [
                    'Pending',
                    'Approved',
                ]
            )
            ->exists();


        if ($tenantAlreadyBooked) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'You already have an active booking request for this property at the selected date and time.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Property Time-Slot Conflict
        |--------------------------------------------------------------------------
        |
        | A property can have only one active booking for the same
        | date and time.
        |
        | This prevents:
        |
        | Tenant A → Property X → 10:00 AM → Pending
        | Tenant B → Property X → 10:00 AM → Pending ❌
        |
        */

        $slotAlreadyBooked = Booking::where(
                'property_id',
                $property->id
            )
            ->where(
                'visit_date',
                $validated['visit_date']
            )
            ->where(
                'visit_time',
                $validated['visit_time']
            )
            ->whereIn(
                'status',
                [
                    'Pending',
                    'Approved',
                ]
            )
            ->exists();


        if ($slotAlreadyBooked) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'The selected visit time is already booked or awaiting approval. Please choose another time.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Booking
        |--------------------------------------------------------------------------
        */

        try {

            $booking = DB::transaction(function () use (
                $property,
                $user,
                $validated
            ) {

                /*
                |--------------------------------------------------------------------------
                | Re-check Slot Inside Transaction
                |--------------------------------------------------------------------------
                |
                | This protects the flow against another request arriving
                | between the first availability check and creation.
                |
                */

                $slotAlreadyBooked = Booking::where(
                        'property_id',
                        $property->id
                    )
                    ->where(
                        'visit_date',
                        $validated['visit_date']
                    )
                    ->where(
                        'visit_time',
                        $validated['visit_time']
                    )
                    ->whereIn(
                        'status',
                        [
                            'Pending',
                            'Approved',
                        ]
                    )
                    ->lockForUpdate()
                    ->exists();


                if ($slotAlreadyBooked) {
                    throw new \RuntimeException(
                        'BOOKING_SLOT_ALREADY_TAKEN'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Create Booking
                |--------------------------------------------------------------------------
                */

                return Booking::create([

                    'property_id' => $property->id,

                    'tenant_id' => $user->id,

                    'landlord_id' => $property->user_id,

                    'visit_date' => $validated['visit_date'],

                    'visit_time' => $validated['visit_time'],

                    'message' =>
                        $validated['message'] ?? null,

                    'status' => 'Pending',

                ]);
            });


        } catch (\RuntimeException $e) {

            /*
            |--------------------------------------------------------------------------
            | Booking Slot Conflict
            |--------------------------------------------------------------------------
            */

            if (
                $e->getMessage() ===
                'BOOKING_SLOT_ALREADY_TAKEN'
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'The selected visit time is already booked or awaiting approval. Please choose another time.'
                    );
            }

            throw $e;
        }


        /*
        |--------------------------------------------------------------------------
        | Notify Landlord
        |--------------------------------------------------------------------------
        */

        Notification::create([

            'user_id' => $property->user_id,

            'title' => 'New Booking Request',

            'message' =>
                $user->name .
                ' has requested a visit for "' .
                $property->title .
                '".',

            'type' => 'Booking',

            'url' => route(
                'bookings.show',
                $booking
            ),

            'is_read' => false,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Visit request submitted successfully.'
        );
    }


    /**
     * Display a booking.
     *
     * Both tenant and landlord can view the booking.
     */
    public function show(Booking $booking): View
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $userId = auth()->id();

        if (
            (int) $userId !==
                (int) $booking->tenant_id
            &&
            (int) $userId !==
                (int) $booking->landlord_id
        ) {
            abort(
                403,
                'Unauthorized Access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Load Relationships
        |--------------------------------------------------------------------------
        */

        $booking->load([
            'property',
            'tenant',
            'landlord',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'booking.show',
            compact('booking')
        );
    }


    /**
     * Redirect edit request.
     *
     * Booking editing is not supported.
     */
    public function edit(
        Booking $booking
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $userId = auth()->id();

        if (
            (int) $userId !==
                (int) $booking->tenant_id
            &&
            (int) $userId !==
                (int) $booking->landlord_id
        ) {
            abort(
                403,
                'Unauthorized Access.'
            );
        }


        return redirect()
            ->route('bookings.index');
    }


    /**
     * Update booking status.
     *
     * Only the landlord assigned to the booking
     * can change the booking status.
     */
    public function update(
        Request $request,
        Booking $booking
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Landlord Authorization
        |--------------------------------------------------------------------------
        */

        if (
            (int) $booking->landlord_id !==
            (int) auth()->id()
        ) {
            abort(
                403,
                'Unauthorized Access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ensure Logged-in User Is Landlord
        |--------------------------------------------------------------------------
        */

        if (!auth()->user()->isLandlord()) {
            abort(
                403,
                'Only landlords can update booking status.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'status' => [
                'required',
                'in:Pending,Approved,Rejected,Completed',
            ],

        ]);


        $newStatus = $validated['status'];

        $currentStatus = $booking->status;


        /*
        |--------------------------------------------------------------------------
        | Prevent Same Status Update
        |--------------------------------------------------------------------------
        */

        if ($newStatus === $currentStatus) {
            return back()->with(
                'error',
                'The booking is already marked as ' .
                $currentStatus .
                '.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Invalid Status Changes
        |--------------------------------------------------------------------------
        */

        $allowedTransitions = [

            'Pending' => [
                'Approved',
                'Rejected',
            ],

            'Approved' => [
                'Completed',
            ],

            'Rejected' => [],

            'Completed' => [],

        ];


        if (
            !in_array(
                $newStatus,
                $allowedTransitions[$currentStatus] ?? [],
                true
            )
        ) {
            return back()->with(
                'error',
                'This booking status cannot be changed from ' .
                $currentStatus .
                ' to ' .
                $newStatus .
                '.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Extra Approval Safety
        |--------------------------------------------------------------------------
        |
        | Before approving, make sure another active booking has not
        | already taken the same property slot.
        |
        */

        if ($newStatus === 'Approved') {

            $conflictingBooking = Booking::where(
                    'property_id',
                    $booking->property_id
                )
                ->where(
                    'visit_date',
                    $booking->visit_date
                )
                ->where(
                    'visit_time',
                    $booking->visit_time
                )
                ->whereIn(
                    'status',
                    [
                        'Approved',
                    ]
                )
                ->where(
                    'id',
                    '!=',
                    $booking->id
                )
                ->exists();


            if ($conflictingBooking) {
                return back()->with(
                    'error',
                    'This visit time has already been approved for another booking.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Property Must Still Be Available
            |--------------------------------------------------------------------------
            */

            $booking->load('property');

            if (
                !$booking->property ||
                $booking->property->status !== 'Available'
            ) {
                return back()->with(
                    'error',
                    'This property is no longer available.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Update Booking
        |--------------------------------------------------------------------------
        */

        $booking->update([

            'status' => $newStatus,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Load Property
        |--------------------------------------------------------------------------
        */

        $booking->load('property');


        /*
        |--------------------------------------------------------------------------
        | Notification Message
        |--------------------------------------------------------------------------
        */

        $statusMessage = match ($newStatus) {

            'Approved' =>
                'Your booking request has been approved.',

            'Rejected' =>
                'Your booking request has been rejected.',

            'Completed' =>
                'Your property visit has been marked as completed.',

            default =>
                'Your booking status has been updated.',

        };


        /*
        |--------------------------------------------------------------------------
        | Notify Tenant
        |--------------------------------------------------------------------------
        */

        Notification::create([

            'user_id' => $booking->tenant_id,

            'title' => 'Booking ' . $newStatus,

            'message' =>
                'Your booking for "' .
                ($booking->property?->title ?? 'the property') .
                '" has been updated. ' .
                $statusMessage,

            'type' => 'Booking',

            'url' => route(
                'bookings.show',
                $booking
            ),

            'is_read' => false,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Booking status updated successfully.'
        );
    }


    /**
     * Delete / cancel a booking.
     *
     * Tenant:
     * - Can cancel only Pending bookings.
     *
     * Landlord:
     * - Can delete only Rejected or Completed bookings.
     */
    public function destroy(
        Booking $booking
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Current User
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        $userId = $user->id;


        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if (
            (int) $userId !==
                (int) $booking->tenant_id
            &&
            (int) $userId !==
                (int) $booking->landlord_id
        ) {
            abort(
                403,
                'Unauthorized Access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Tenant Cancellation
        |--------------------------------------------------------------------------
        */

        if (
            (int) $userId ===
            (int) $booking->tenant_id
        ) {

            /*
            |--------------------------------------------------------------------------
            | Tenant Role Check
            |--------------------------------------------------------------------------
            */

            if (!$user->isTenant()) {
                abort(
                    403,
                    'Only tenants can cancel their booking requests.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Only Pending Can Be Cancelled
            |--------------------------------------------------------------------------
            */

            if ($booking->status !== 'Pending') {
                return back()->with(
                    'error',
                    'Only pending bookings can be cancelled.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Delete Booking
            |--------------------------------------------------------------------------
            */

            $booking->delete();


            return redirect()
                ->route('tenant.bookings.index')
                ->with(
                    'success',
                    'Booking cancelled successfully.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Landlord Deletion
        |--------------------------------------------------------------------------
        */

        if (
            (int) $userId ===
            (int) $booking->landlord_id
        ) {

            /*
            |--------------------------------------------------------------------------
            | Landlord Role Check
            |--------------------------------------------------------------------------
            */

            if (!$user->isLandlord()) {
                abort(
                    403,
                    'Only landlords can delete completed or rejected bookings.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Only Rejected / Completed Can Be Deleted
            |--------------------------------------------------------------------------
            */

            if (
                !in_array(
                    $booking->status,
                    [
                        'Rejected',
                        'Completed',
                    ],
                    true
                )
            ) {
                return back()->with(
                    'error',
                    'Only rejected or completed bookings can be deleted.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Delete Booking
            |--------------------------------------------------------------------------
            */

            $booking->delete();


            return redirect()
                ->route('bookings.index')
                ->with(
                    'success',
                    'Booking deleted successfully.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Fallback Authorization
        |--------------------------------------------------------------------------
        */

        abort(
            403,
            'Unauthorized Access.'
        );
    }
}