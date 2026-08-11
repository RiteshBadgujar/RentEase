<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class AdminEnquiryController extends Controller
{
    /**
     * Display all enquiries.
     */
    public function index(Request $request)
    {
        $query = Enquiry::with([
            'sender',
            'receiver',
            'property'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas('sender', function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%");

                })

                ->orWhereHas('receiver', function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%");

                })

                ->orWhereHas('property', function ($q) use ($search) {

                    $q->where('title', 'like', "%{$search}%");

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
        | Enquiries List
        |--------------------------------------------------------------------------
        */

        $enquiries = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
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
     * Display enquiry details.
     */
    public function show(Enquiry $enquiry)
    {
        $enquiry->load([
            'sender',
            'receiver',
            'property'
        ]);

        return view(
            'admin.enquiries.show',
            compact('enquiry')
        );
    }

    /**
     * Show edit form.
     */
    public function edit(Enquiry $enquiry)
    {
        return view(
            'admin.enquiries.edit',
            compact('enquiry')
        );
    }

    /**
     * Update enquiry.
     */
    public function update(Request $request, Enquiry $enquiry)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'status' => 'required|in:Pending,Replied,Closed',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $enquiry->update([

            'status' => $request->status,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.enquiries.index')
            ->with(
                'success',
                'Enquiry updated successfully.'
            );
    }

    /**
     * Delete enquiry.
     */
    public function destroy(Enquiry $enquiry)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        $enquiry->delete();

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