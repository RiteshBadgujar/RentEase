<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Notification;
use App\Models\Property;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Display all enquiries received by the logged-in landlord.
     */
    public function index()
    {
        $enquiries = Enquiry::with([
                'property',
                'sender',
            ])
            ->where(
                'receiver_id',
                auth()->id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'enquiry.index',
            compact('enquiries')
        );
    }


    /**
     * Store a newly created enquiry.
     */
    public function store(
        Request $request,
        Property $property
    ) {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'message' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Prevent Own Property Enquiry
        |--------------------------------------------------------------------------
        */

        if (
            $property->user_id === auth()->id()
        ) {

            return back()->with(
                'error',
                'You cannot send an enquiry for your own property.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Property Availability
        |--------------------------------------------------------------------------
        */

        if ($property->status !== 'Available') {

            return back()->with(
                'error',
                'This property is currently not available for enquiry.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Pending Enquiry
        |--------------------------------------------------------------------------
        */

        $alreadyEnquired = Enquiry::where(
                'property_id',
                $property->id
            )
            ->where(
                'sender_id',
                auth()->id()
            )
            ->where(
                'status',
                'Pending'
            )
            ->exists();


        if ($alreadyEnquired) {

            return back()->with(
                'error',
                'You already have a pending enquiry for this property.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Enquiry
        |--------------------------------------------------------------------------
        */

        $enquiry = Enquiry::create([

            'property_id' => $property->id,

            'sender_id' => auth()->id(),

            'receiver_id' => $property->user_id,

            'message' => $validated['message'],

            'status' => 'Pending',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Notify Landlord
        |--------------------------------------------------------------------------
        */

        Notification::create([

            'user_id' => $property->user_id,

            'title' => 'New Property Enquiry',

            'message' =>
                auth()->user()->name .
                ' sent an enquiry for "' .
                $property->title .
                '".',

            'type' => 'Enquiry',

            'url' => route(
                'enquiries.index'
            ),

            'is_read' => false,

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
     *
     * Only the landlord who received the enquiry
     * can delete it.
     */
    public function destroy(
        Enquiry $enquiry
    ) {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if (
            auth()->id() !== $enquiry->receiver_id
        ) {

            abort(
                403,
                'Unauthorized Access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Enquiry
        |--------------------------------------------------------------------------
        */

        $enquiry->delete();


        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('enquiries.index')
            ->with(
                'success',
                'Enquiry deleted successfully.'
            );
    }
}