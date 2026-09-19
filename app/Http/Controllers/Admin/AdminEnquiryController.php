<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Enquiry;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminEnquiryController extends Controller
{
    /**
     * Display all enquiries.
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Enquiry Query
        |--------------------------------------------------------------------------
        */

        $query = Enquiry::with([
            'sender',
            'receiver',
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

                $q->whereHas('sender', function ($sender) use ($search) {

                    $sender->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    );

                })->orWhereHas('receiver', function ($receiver) use ($search) {

                    $receiver->where(
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
                    'in:Pending,Replied,Closed',
                ],
            ]);

            $query->where(
                'status',
                $request->input('status')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Enquiry List
        |--------------------------------------------------------------------------
        */

        $enquiries = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalEnquiries = Enquiry::count();

        $pendingEnquiries = Enquiry::where(
            'status',
            'Pending'
        )->count();

        $repliedEnquiries = Enquiry::where(
            'status',
            'Replied'
        )->count();

        $closedEnquiries = Enquiry::where(
            'status',
            'Closed'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.enquiries.index',
            compact(
                'enquiries',
                'totalEnquiries',
                'pendingEnquiries',
                'repliedEnquiries',
                'closedEnquiries'
            )
        );
    }

    /**
     * Enquiry creation is disabled for administrators.
     */
    public function create(): View
    {
        abort(404);
    }

    /**
     * Enquiry creation is disabled for administrators.
     */
    public function store(Request $request): RedirectResponse
    {
        abort(404);
    }

    /**
     * Display enquiry details.
     */
    public function show(Enquiry $enquiry): View
    {
        $enquiry->load([
            'sender',
            'receiver',
            'property',
        ]);

        return view(
            'admin.enquiries.show',
            compact('enquiry')
        );
    }

    /**
     * Show edit form.
     */
    public function edit(Enquiry $enquiry): View
    {
        return view(
            'admin.enquiries.edit',
            compact('enquiry')
        );
    }

    /**
     * Update enquiry status.
     */
    public function update(
        Request $request,
        Enquiry $enquiry
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'status' => [
                'required',
                'in:Pending,Replied,Closed',
            ],
        ]);

        $oldStatus = $enquiry->status;
        $newStatus = $validated['status'];

        /*
        |--------------------------------------------------------------------------
        | No Change
        |--------------------------------------------------------------------------
        */

        if ($oldStatus === $newStatus) {

            return redirect()
                ->route('admin.enquiries.index')
                ->with(
                    'success',
                    'Enquiry status is already ' . $newStatus . '.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Load Relationships
        |--------------------------------------------------------------------------
        */

        $enquiry->load([
            'sender',
            'property',
        ]);

        $propertyTitle = $enquiry->property?->title
            ?? 'the property';

        /*
        |--------------------------------------------------------------------------
        | Update + Activity Log + Notification
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $enquiry,
            $oldStatus,
            $newStatus,
            $propertyTitle
        ) {

            /*
            |--------------------------------------------------------------------------
            | Update Enquiry
            |--------------------------------------------------------------------------
            */

            $enquiry->update([
                'status' => $newStatus,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::create([
                'user_id' => auth()->id(),

                'module' => 'Enquiry',

                'action' => 'Updated',

                'description' =>
                    'Admin changed enquiry #' .
                    $enquiry->id .
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
            | Notify Enquiry Sender
            |--------------------------------------------------------------------------
            */

            if ($enquiry->sender_id) {

                Notification::create([
                    'user_id' => $enquiry->sender_id,

                    'title' => 'Enquiry Status Updated',

                    'message' =>
                        'Your enquiry for "' .
                        $propertyTitle .
                        '" has been changed from ' .
                        $oldStatus .
                        ' to ' .
                        $newStatus .
                        ' by an administrator.',

                    'type' => 'Enquiry',

                    'url' => route(
                        'properties.show',
                        $enquiry->property_id
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
            ->route('admin.enquiries.index')
            ->with(
                'success',
                'Enquiry status updated successfully.'
            );
    }

    /**
     * Delete enquiry.
     */
    public function destroy(
        Enquiry $enquiry
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Load Relationships
        |--------------------------------------------------------------------------
        */

        $enquiry->load([
            'property',
        ]);

        $enquiryId = $enquiry->id;

        $senderId = $enquiry->sender_id;

        $propertyTitle = $enquiry->property?->title
            ?? 'the property';

        /*
        |--------------------------------------------------------------------------
        | Delete + Activity Log
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $enquiry,
            $enquiryId,
            $propertyTitle
        ) {

            /*
            |--------------------------------------------------------------------------
            | Delete Enquiry
            |--------------------------------------------------------------------------
            */

            $enquiry->delete();

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::create([
                'user_id' => auth()->id(),

                'module' => 'Enquiry',

                'action' => 'Deleted',

                'description' =>
                    'Admin deleted enquiry #' .
                    $enquiryId .
                    ' for "' .
                    $propertyTitle .
                    '".',

                'ip_address' => request()->ip(),

                'browser' => request()->userAgent(),
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Notify Sender
        |--------------------------------------------------------------------------
        */

        if ($senderId) {

            Notification::create([
                'user_id' => $senderId,

                'title' => 'Enquiry Deleted',

                'message' =>
                    'Your enquiry for "' .
                    $propertyTitle .
                    '" was deleted by an administrator.',

                'type' => 'Enquiry',

                'url' => route(
                    'properties.index'
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
            ->route('admin.enquiries.index')
            ->with(
                'success',
                'Enquiry deleted successfully.'
            );
    }
}