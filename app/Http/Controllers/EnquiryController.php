<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Notification;
use App\Models\Property;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Display enquiries according to the logged-in user's role.
     *
     * Landlord:
     *      Shows enquiries received from tenants.
     *
     * Tenant:
     *      Shows enquiries sent by the tenant.
     */
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Landlord Enquiries
        |--------------------------------------------------------------------------
        */

        if ($user->isLandlord()) {

            $enquiries = Enquiry::with([
                'property',
                'sender',
            ])
                ->where('receiver_id', $user->id)
                ->latest()
                ->paginate(10);

            return view(
                'enquiry.index',
                compact('enquiries')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Tenant Enquiries
        |--------------------------------------------------------------------------
        */

        if ($user->isTenant()) {

            $enquiries = Enquiry::with([
                'property',
                'receiver',
            ])
                ->where('sender_id', $user->id)
                ->latest()
                ->paginate(10);

            return view(
                'tenant-enquiry.index',
                compact('enquiries')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Admin / Invalid Role
        |--------------------------------------------------------------------------
        */

        abort(
            403,
            'You are not authorized to access enquiries.'
        );
    }


    /**
     * Store a newly created enquiry.
     *
     * Only tenants can send property enquiries.
     */
    public function store(
        Request $request,
        Property $property
    ) {
        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Tenant Authorization
        |--------------------------------------------------------------------------
        */

        if (!$user->isTenant()) {

            return back()->with(
                'error',
                'Only tenants can send property enquiries.'
            );
        }


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
            (int) $property->user_id ===
            (int) $user->id
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
                $user->id
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

            'sender_id' => $user->id,

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
                $user->name .
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
     * Update an enquiry.
     *
     * Only the landlord who received the enquiry
     * can change its status.
     *
     * Allowed flow:
     *
     * Pending → Replied
     * Pending → Closed
     * Replied → Closed
     */
    public function update(
        Request $request,
        Enquiry $enquiry
    ) {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if (
            (int) $enquiry->receiver_id !==
            (int) auth()->id()
        ) {

            abort(
                403,
                'Unauthorized Access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ensure Receiver Is Landlord
        |--------------------------------------------------------------------------
        */

        if (!auth()->user()->isLandlord()) {

            abort(
                403,
                'Only landlords can update enquiries.'
            );
        }


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


        $newStatus = $validated['status'];

        $currentStatus = $enquiry->status;


        /*
        |--------------------------------------------------------------------------
        | Prevent Same Status Update
        |--------------------------------------------------------------------------
        */

        if ($newStatus === $currentStatus) {

            return back()->with(
                'error',
                'The enquiry is already marked as ' .
                $currentStatus .
                '.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Allowed Status Transitions
        |--------------------------------------------------------------------------
        */

        $allowedTransitions = [

            'Pending' => [
                'Replied',
                'Closed',
            ],

            'Replied' => [
                'Closed',
            ],

            'Closed' => [],

        ];


        if (
            !in_array(
                $newStatus,
                $allowedTransitions[$currentStatus] ?? [],
                true
            )
        ) {

            return back()->with(
                'error',
                'This enquiry status cannot be changed from ' .
                $currentStatus .
                ' to ' .
                $newStatus .
                '.'
            );
        }


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
        | Load Property
        |--------------------------------------------------------------------------
        */

        $enquiry->loadMissing('property');


        /*
        |--------------------------------------------------------------------------
        | Notification Message
        |--------------------------------------------------------------------------
        */

        $statusMessage = match ($newStatus) {

            'Replied' =>
                'The landlord has replied to your property enquiry.',

            'Closed' =>
                'Your property enquiry has been closed by the landlord.',

            default =>
                'Your property enquiry status has been updated.',

        };


        /*
        |--------------------------------------------------------------------------
        | Notify Tenant
        |--------------------------------------------------------------------------
        */

        Notification::create([

            'user_id' => $enquiry->sender_id,

            'title' => 'Enquiry ' . $newStatus,

            'message' =>
                'Your enquiry for "' .
                ($enquiry->property->title ?? 'Property') .
                '" has been updated. ' .
                $statusMessage,

            'type' => 'Enquiry',

            /*
             * Tenant should be sent to their own enquiry history,
             * not the landlord's enquiry page.
             */
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
            'Enquiry status updated successfully.'
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
            (int) $enquiry->receiver_id !==
            (int) auth()->id()
        ) {

            abort(
                403,
                'Unauthorized Access.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ensure Receiver Is Landlord
        |--------------------------------------------------------------------------
        */

        if (!auth()->user()->isLandlord()) {

            abort(
                403,
                'Only landlords can delete enquiries.'
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