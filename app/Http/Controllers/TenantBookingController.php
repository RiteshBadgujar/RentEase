<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class TenantBookingController extends Controller
{
    /**
     * Display all bookings created by the logged-in tenant.
     */
    public function index()
    {
        $bookings = Booking::with(['property', 'landlord'])
            ->where('tenant_id', auth()->id())
            ->latest()
            ->get();

        return view('tenant-bookings.index', compact('bookings'));
    }

    /**
     * Display a single booking.
     */
    public function show(Booking $booking)
    {
        if ($booking->tenant_id != auth()->id()) {
            abort(403);
        }

        return view('tenant-bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking.
     */
    public function destroy(Booking $booking)
    {
        if ($booking->tenant_id != auth()->id()) {
            abort(403);
        }

        if ($booking->status != 'Pending') {
            return back()->with(
                'error',
                'Only pending bookings can be cancelled.'
            );
        }

        $booking->delete();

        return back()->with(
            'success',
            'Booking cancelled successfully.'
        );
    }
}