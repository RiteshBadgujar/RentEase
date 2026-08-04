<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    /**
     * Display all bookings.
     */
    public function index()
    {
        $bookings = Booking::with([
            'tenant',
            'landlord',
            'property'
        ])
        ->latest()
        ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
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
     * Display booking details.
     */
    public function show(Booking $booking)
    {
        $booking->load([
            'tenant',
            'landlord',
            'property'
        ]);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show edit form.
     */
    public function edit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    /**
     * Update booking.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected,Completed',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Delete booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}