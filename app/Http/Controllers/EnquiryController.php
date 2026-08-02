<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Property;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Display all enquiries received by the logged-in landlord.
     */
    public function index()
    {
        $enquiries = Enquiry::with(['property', 'sender'])
            ->where('receiver_id', auth()->id())
            ->latest()
            ->get();

        return view('enquiry.index', compact('enquiries'));
    }

    /**
     * Store a newly created enquiry.
     */
    public function store(Request $request, Property $property)
    {
        // User cannot send enquiry to own property
        if ($property->user_id == auth()->id()) {

            return back()->with(
                'error',
                'You cannot send an enquiry for your own property.'
            );
        }

        // Validate request
        $request->validate([
            'message' => 'required|string|min:10|max:1000',
        ]);

        // Save enquiry
        Enquiry::create([

            'property_id' => $property->id,

            'sender_id' => auth()->id(),

            'receiver_id' => $property->user_id,

            'message' => $request->message,

            'status' => 'Pending',

        ]);

        return back()->with(
            'success',
            'Your enquiry has been sent successfully.'
        );
    }

    /**
     * Delete an enquiry.
     */
    public function destroy(Enquiry $enquiry)
    {
        // Only the receiver can delete the enquiry
        if ($enquiry->receiver_id != auth()->id()) {

            abort(403);
        }

        $enquiry->delete();

        return back()->with(
            'success',
            'Enquiry deleted successfully.'
        );
    }
}