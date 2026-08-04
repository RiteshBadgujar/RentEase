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
    public function index()
    {
        $enquiries = Enquiry::with([
            'sender',
            'receiver',
            'property'
        ])
        ->latest()
        ->paginate(10);

        return view('admin.enquiries.index', compact('enquiries'));
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

        return view('admin.enquiries.show', compact('enquiry'));
    }

    /**
     * Show edit form.
     */
    public function edit(Enquiry $enquiry)
    {
        return view('admin.enquiries.edit', compact('enquiry'));
    }

    /**
     * Update enquiry.
     */
    public function update(Request $request, Enquiry $enquiry)
    {
        $request->validate([
            'status' => 'required|in:Pending,Replied,Closed',
        ]);

        $enquiry->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.enquiries.index')
            ->with('success', 'Enquiry updated successfully.');
    }

    /**
     * Delete enquiry.
     */
    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return redirect()
            ->route('admin.enquiries.index')
            ->with('success', 'Enquiry deleted successfully.');
    }
}