<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminBookingController extends Controller
{
    /**
     * Display all bookings.
     */
    public function index(Request $request): View
    {
        $query = Booking::with([
            'tenant',
            'landlord',
            'property',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->input('search');

            $query->where(function ($q) use ($search) {

                $q->whereHas('tenant', function ($tenant) use ($search) {

                    $tenant->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    );

                })->orWhereHas('property', function ($property) use ($search) {

                    $property->where(
                        'title',
                        'like',
                        '%' . $search . '%'
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

            $request->validate([
                'status' => [
                    'nullable',
                    'in:Pending,Approved,Rejected,Completed',
                ],
            ]);

            $query->where(
                'status',
                $request->input('status')
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
     * Booking creation is disabled for administrators.
     */
    public function create(): View
    {
        abort(404);
    }

    /**
     * Booking creation is disabled for administrators.
     */
    public function store(Request $request): RedirectResponse
    {
        abort(404);
    }

    /**
     * Display booking details.
     */
    public function show(Booking $booking): View
    {
        $booking->load([
            'tenant',
            'landlord',
            'property',
        ]);

        return view(
            'admin.bookings.show',
            compact('booking')
        );
    }

    /**
     * Show booking edit form.
     */
    public function edit(Booking $booking): View
    {
        return view(
            'admin.bookings.edit',
            compact('booking')
        );
    }

    /**
     * Update booking status.
     *
     * Administrators can override the normal
     * booking status workflow.
     */
    public function update(
        Request $request,
        Booking $booking
    ): RedirectResponse {

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

        $oldStatus = $booking->status;
        $newStatus = $validated['status'];

        /*
        |--------------------------------------------------------------------------
        | No Status Change
        |--------------------------------------------------------------------------
        */

        if ($oldStatus === $newStatus) {

            return redirect()
                ->route('admin.bookings.index')
                ->with(
                    'success',
                    'Booking status is already ' . $newStatus . '.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Load Property Before Transaction
        |--------------------------------------------------------------------------
        */

        $booking->load([
            'property',
            'tenant',
        ]);

        $propertyTitle = $booking->property?->title
            ?? 'the property';

        /*
        |--------------------------------------------------------------------------
        | Update Booking + Activity Log
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $booking,
            $oldStatus,
            $newStatus,
            $propertyTitle
        ) {

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
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::create([
                'user_id' => auth()->id(),

                'module' => 'Booking',

                'action' => 'Updated',

                'description' =>
                    'Admin changed booking #' .
                    $booking->id .
                    ' status from ' .
                    $oldStatus .
                    ' to ' .
                    $newStatus .
                    ' for "' .
                    $propertyTitle .
                    '".',

                'ip_address' => request()->ip(),

                'browser' => request()->userAgent(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Tenant Notification
            |--------------------------------------------------------------------------
            */

            if ($booking->tenant_id) {

                Notification::create([
                    'user_id' => $booking->tenant_id,

                    'title' => 'Booking Status Updated',

                    'message' =>
                        'Your booking for "' .
                        $propertyTitle .
                        '" has been changed from ' .
                        $oldStatus .
                        ' to ' .
                        $newStatus .
                        ' by an administrator.',

                    'type' => 'Booking',

                    'url' => route(
                        'tenant.bookings.show',
                        $booking->id
                    ),

                    'is_read' => false,
                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.bookings.index')
            ->with(
                'success',
                'Booking status updated successfully.'
            );
    }

    /**
     * Delete booking.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Load Relationships Before Delete
        |--------------------------------------------------------------------------
        */

        $booking->load([
            'property',
        ]);

        $bookingId = $booking->id;

        $tenantId = $booking->tenant_id;

        $propertyTitle = $booking->property?->title
            ?? 'the property';

        /*
        |--------------------------------------------------------------------------
        | Delete Booking + Activity Log
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $booking,
            $bookingId,
            $propertyTitle
        ) {

            /*
            |--------------------------------------------------------------------------
            | Delete Booking
            |--------------------------------------------------------------------------
            */

            $booking->delete();

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::create([
                'user_id' => auth()->id(),

                'module' => 'Booking',

                'action' => 'Deleted',

                'description' =>
                    'Admin deleted booking #' .
                    $bookingId .
                    ' for "' .
                    $propertyTitle .
                    '".',

                'ip_address' => request()->ip(),

                'browser' => request()->userAgent(),
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Notify Tenant
        |--------------------------------------------------------------------------
        */

        if ($tenantId) {

            Notification::create([
                'user_id' => $tenantId,

                'title' => 'Booking Deleted',

                'message' =>
                    'Your booking for "' .
                    $propertyTitle .
                    '" was deleted by an administrator.',

                'type' => 'Booking',

                'url' => route(
                    'tenant.bookings.index'
                ),

                'is_read' => false,
            ]);
        }

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