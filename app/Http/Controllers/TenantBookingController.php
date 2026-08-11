<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class TenantBookingController extends Controller
{
    /**
     * Display all bookings created by the logged-in tenant.
     */
    public function index()
    {
        $bookings = Booking::with([
                'property',
                'landlord',
            ])
            ->where('tenant_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'tenant-bookings.index',
            compact('bookings')
        );
    }


    /**
     * Display a single booking.
     */
    public function show(Booking $booking)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if ($booking->tenant_id != auth()->id()) {

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
            'landlord',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'tenant-bookings.show',
            compact('booking')
        );
    }


    /**
     * Cancel a booking.
     *
     * Only Pending bookings can be cancelled by the tenant.
     */
    public function destroy(Booking $booking)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if ($booking->tenant_id != auth()->id()) {

            abort(
                403,
                'Unauthorized Access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Status Check
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


        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Booking cancelled successfully.'
        );
    }
}