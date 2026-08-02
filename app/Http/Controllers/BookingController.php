<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display all booking requests for the logged-in landlord.
     */
    public function index()
{
    $bookings = Booking::with(['property', 'tenant'])
        ->where('landlord_id', auth()->id())
        ->latest()
        ->get();

    return view('booking.index', compact('bookings'));
}

    /**
     * Redirect create request.
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a new booking request.
     */
    public function store(Request $request)
    {
        $request->validate([

            'property_id' => 'required|exists:properties,id',

            'visit_date' => 'required|date|after_or_equal:today',

            'visit_time' => 'required',

            'message' => 'nullable|string|max:500',

        ]);

        $property = Property::findOrFail($request->property_id);

        // Prevent landlord from booking own property
        if ($property->user_id == auth()->id()) {

            return back()->with(
                'error',
                'You cannot book your own property.'
            );

        }

        Booking::create([

            'property_id' => $property->id,

            'tenant_id' => auth()->id(),

            'landlord_id' => $property->user_id,

            'visit_date' => $request->visit_date,

            'visit_time' => $request->visit_time,

            'message' => $request->message,

            'status' => 'Pending',

        ]);

        return back()->with(
            'success',
            'Visit request sent successfully.'
        );
    }

    /**
     * Display a booking.
     */
    public function show(Booking $booking)
    {
        if (
            auth()->id() != $booking->tenant_id &&
            auth()->id() != $booking->landlord_id
        ) {

            abort(403);

        }

        return view('booking.show', compact('booking'));
    }

    /**
     * Redirect edit request.
     */
    public function edit(Booking $booking)
    {
        return redirect()->back();
    }

    /**
     * Update booking status.
     */
    public function update(Request $request, Booking $booking)
    {
        if ($booking->landlord_id != auth()->id()) {

            abort(403);

        }

        $request->validate([

            'status' => 'required|in:Pending,Approved,Rejected,Completed',

        ]);

        $booking->update([

            'status' => $request->status,

        ]);

        return back()->with(
            'success',
            'Booking status updated successfully.'
        );
    }

    /**
     * Delete a booking.
     */
    public function destroy(Booking $booking)
    {
        if (
            auth()->id() != $booking->tenant_id &&
            auth()->id() != $booking->landlord_id
        ) {

            abort(403);

        }

        $booking->delete();

        return back()->with(
            'success',
            'Booking deleted successfully.'
        );
    }
}