<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Property;
use App\Models\Notification;
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
        /*
        |--------------------------------------------------------------------------
        | Prevent Own Property Enquiry
        |--------------------------------------------------------------------------
        */

        if ($property->user_id == auth()->id()) {

            return back()->with(
                'error',
                'You cannot send an enquiry for your own property.'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Pending Enquiry
        |--------------------------------------------------------------------------
        */

        $alreadyEnquired = Enquiry::where('property_id', $property->id)
            ->where('sender_id', auth()->id())
            ->where('status', 'Pending')
            ->exists();

        if ($alreadyEnquired) {

            return back()->with(
                'error',
                'You already have a pending enquiry for this property.'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'message' => 'required|string|min:10|max:1000',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Save Enquiry
        |--------------------------------------------------------------------------
        */

        Enquiry::create([

            'property_id' => $property->id,

            'sender_id' => auth()->id(),

            'receiver_id' => $property->user_id,

            'message' => $request->message,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Notify Landlord
        |--------------------------------------------------------------------------
        */

        Notification::create([

            'user_id' => $property->user_id,

            'title' => 'New Property Enquiry',

            'message' => auth()->user()->name .
                ' sent an enquiry for "' .
                $property->title .
                '".',

            'type' => 'Enquiry',

            'url' => route('enquiries.index'),

        ]);

        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

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
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if ($enquiry->receiver_id != auth()->id()) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | Delete Enquiry
        |--------------------------------------------------------------------------
        */

        $enquiry->delete();

        return back()->with(

            'success',

            'Enquiry deleted successfully.'

        );
    }
}