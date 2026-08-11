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
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Booking Query
        |--------------------------------------------------------------------------
        */

        $query = Booking::with([
            'tenant',
            'landlord',
            'property'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->whereHas('tenant', function ($tenant) use ($request) {

                    $tenant->where(
                        'name',
                        'like',
                        '%' . $request->search . '%'
                    );

                })

                ->orWhereHas('property', function ($property) use ($request) {

                    $property->where(
                        'title',
                        'like',
                        '%' . $request->search . '%'
                    );

                });

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Booking List
        |--------------------------------------------------------------------------
        */

        $bookings = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalBookings = Booking::count();

        $pendingBookings = Booking::where(
            'status',
            'Pending'
        )->count();

        $approvedBookings = Booking::where(
            'status',
            'Approved'
        )->count();

        $rejectedBookings = Booking::where(
            'status',
            'Rejected'
        )->count();

        $completedBookings = Booking::where(
            'status',
            'Completed'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.bookings.index',
            compact(
                'bookings',
                'totalBookings',
                'pendingBookings',
                'approvedBookings',
                'rejectedBookings',
                'completedBookings'
            )
        );
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
     * Display Booking Details.
     */
    public function show(Booking $booking)
    {
        $booking->load([
            'tenant',
            'landlord',
            'property'
        ]);

        return view(
            'admin.bookings.show',
            compact('booking')
        );
    }

    /**
     * Show Edit Form.
     */
    public function edit(Booking $booking)
    {
        return view(
            'admin.bookings.edit',
            compact('booking')
        );
    }

    /**
     * Update Booking.
     */
    public function update(Request $request, Booking $booking)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'status' => 'required|in:Pending,Approved,Rejected,Completed',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Booking
        |--------------------------------------------------------------------------
        */

        $booking->update([

            'status' => $request->status,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.bookings.index')
            ->with(
                'success',
                'Booking updated successfully.'
            );
    }

    /**
     * Delete Booking.
     */
    public function destroy(Booking $booking)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Booking
        |--------------------------------------------------------------------------
        */

        $booking->delete();

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.bookings.index')
            ->with(
                'success',
                'Booking deleted successfully.'
            );
    }
}