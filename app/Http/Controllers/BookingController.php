<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\Property;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display all booking requests for the logged-in landlord.
     */
    public function index()
    {
        $bookings = Booking::with([
                'property',
                'tenant',
            ])
            ->where('landlord_id', auth()->id())
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
    public function create()
    {
        return redirect()
            ->route('properties.index');
    }


    /**
     * Store a new booking request.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'property_id' => [
                'required',
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
        | Find Property
        |--------------------------------------------------------------------------
        */

        $property = Property::findOrFail(
            $validated['property_id']
        );


        /*
        |--------------------------------------------------------------------------
        | Prevent Booking Own Property
        |--------------------------------------------------------------------------
        */

        if ($property->user_id === auth()->id()) {

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
        | Prevent Duplicate Booking
        |--------------------------------------------------------------------------
        */

        $alreadyBooked = Booking::where(
                'property_id',
                $property->id
            )
            ->where(
                'tenant_id',
                auth()->id()
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


        if ($alreadyBooked) {

            return back()->with(
                'error',
                'You already requested a visit for this property at the selected date and time.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Booking
        |--------------------------------------------------------------------------
        */

        $booking = Booking::create([

            'property_id' => $property->id,

            'tenant_id' => auth()->id(),

            'landlord_id' => $property->user_id,

            'visit_date' => $validated['visit_date'],

            'visit_time' => $validated['visit_time'],

            'message' => $validated['message'] ?? null,

            'status' => 'Pending',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Notify Landlord
        |--------------------------------------------------------------------------
        */

        Notification::create([

            'user_id' => $property->user_id,

            'title' => 'New Booking Request',

            'message' =>
                auth()->user()->name .
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
    public function show(Booking $booking)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if (
            auth()->id() !== $booking->tenant_id &&
            auth()->id() !== $booking->landlord_id
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
    public function edit(Booking $booking)
    {
        return redirect()
            ->route('bookings.index');
    }


    /**
     * Update booking status.
     *
     * Only the landlord can change the booking status.
     */
    public function update(
        Request $request,
        Booking $booking
    ) {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if ($booking->landlord_id !== auth()->id()) {

            abort(
                403,
                'Unauthorized Access.'
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
        | Update Booking
        |--------------------------------------------------------------------------
        */

        $booking->update([

            'status' => $newStatus,

        ]);


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
                $booking->property->title .
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
    public function destroy(Booking $booking)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $userId = auth()->id();


        if (
            $userId !== $booking->tenant_id &&
            $userId !== $booking->landlord_id
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

        if ($userId === $booking->tenant_id) {

            if ($booking->status !== 'Pending') {

                return back()->with(
                    'error',
                    'Only pending bookings can be cancelled.'
                );
            }


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

        if ($userId === $booking->landlord_id) {

            if (!in_array(
                $booking->status,
                [
                    'Rejected',
                    'Completed',
                ],
                true
            )) {

                return back()->with(
                    'error',
                    'Only rejected or completed bookings can be deleted.'
                );
            }


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