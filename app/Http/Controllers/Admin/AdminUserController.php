<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Notification;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display the Admin User Management page.
     */
    public function index(): View
    {
        $users = User::select([
            'id',
            'name',
            'email',
            'role',
            'created_at',
        ])
            ->latest()
            ->get();

        return view(
            'admin.users.index',
            compact('users')
        );
    }


    /**
     * Update the specified user.
     */
    public function update(
        Request $request,
        User $user
    ): RedirectResponse {

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],

            'role' => [
                'required',
                'in:admin,landlord,tenant',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Capture Old Values
        |--------------------------------------------------------------------------
        */

        $oldName = $user->name;
        $oldEmail = $user->email;
        $oldRole = $user->role;

        $newName = $validated['name'];
        $newEmail = $validated['email'];
        $newRole = $validated['role'];


        /*
        |--------------------------------------------------------------------------
        | Prevent Self Role Change
        |--------------------------------------------------------------------------
        */

        if (
            $user->id === auth()->id() &&
            $newRole !== 'admin'
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'You cannot remove your own administrator role.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Last Admin Role Change
        |--------------------------------------------------------------------------
        */

        if (
            $oldRole === 'admin' &&
            $newRole !== 'admin'
        ) {
            $adminCount = User::where(
                'role',
                'admin'
            )->count();

            if ($adminCount <= 1) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'The last administrator cannot be changed to another role.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Invalid Landlord Role Change
        |--------------------------------------------------------------------------
        |
        | A landlord who owns properties should remain a landlord.
        |
        */

        if (
            $oldRole === 'landlord' &&
            $newRole !== 'landlord'
        ) {
            $propertyCount = Property::where(
                'user_id',
                $user->id
            )->count();

            if ($propertyCount > 0) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'This landlord cannot change role because they still own properties.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Invalid Tenant Role Change
        |--------------------------------------------------------------------------
        |
        | Existing bookings and enquiries depend on the tenant role.
        |
        */

        if (
            $oldRole === 'tenant' &&
            $newRole !== 'tenant'
        ) {
            $bookingCount = Booking::where(
                'tenant_id',
                $user->id
            )->count();

            if ($bookingCount > 0) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'This tenant cannot change role because they have existing bookings.'
                    );
            }


            $enquiryCount = Enquiry::where(
                'sender_id',
                $user->id
            )->count();

            if ($enquiryCount > 0) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'This tenant cannot change role because they have existing enquiries.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Detect Actual Changes
        |--------------------------------------------------------------------------
        */

        $hasChanges =
            $oldName !== $newName ||
            $oldEmail !== $newEmail ||
            $oldRole !== $newRole;

        if (!$hasChanges) {
            return redirect()
                ->route('admin.users.index')
                ->with(
                    'success',
                    'No changes were made to the user.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Update User + Activity Log + Notification
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $user,
            $newName,
            $newEmail,
            $newRole,
            $oldName,
            $oldEmail,
            $oldRole
        ) {

            /*
            |--------------------------------------------------------------------------
            | Update User
            |--------------------------------------------------------------------------
            */

            $user->update([
                'name' => $newName,
                'email' => $newEmail,
                'role' => $newRole,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Build Change Description
            |--------------------------------------------------------------------------
            */

            $changes = [];

            if ($oldName !== $newName) {
                $changes[] =
                    'name from "' .
                    $oldName .
                    '" to "' .
                    $newName .
                    '"';
            }

            if ($oldEmail !== $newEmail) {
                $changes[] =
                    'email from "' .
                    $oldEmail .
                    '" to "' .
                    $newEmail .
                    '"';
            }

            if ($oldRole !== $newRole) {
                $changes[] =
                    'role from "' .
                    $oldRole .
                    '" to "' .
                    $newRole .
                    '"';
            }


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::create([
                'user_id' => auth()->id(),

                'module' => 'User',

                'action' => 'Updated',

                'description' =>
                    'Admin updated user #' .
                    $user->id .
                    ' (' .
                    $user->email .
                    '). Changed ' .
                    implode(', ', $changes) .
                    '.',

                'ip_address' => request()->ip(),

                'browser' => request()->userAgent(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Notify User
            |--------------------------------------------------------------------------
            */

            if ($user->id !== auth()->id()) {
                Notification::create([
                    'user_id' => $user->id,

                    'title' => 'Account Updated',

                    'message' =>
                        'Your RentEase account information was updated by an administrator.',

                    'type' => 'User',

                    'url' => route(
                        'profile.edit'
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
            ->route('admin.users.index')
            ->with(
                'success',
                'User updated successfully.'
            );
    }


    /**
     * Remove the specified user.
     */
    public function destroy(
        User $user
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Prevent Self Deletion
        |--------------------------------------------------------------------------
        */

        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'You cannot delete your own account.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Deleting Last Admin
        |--------------------------------------------------------------------------
        */

        if ($user->isAdmin()) {
            $adminCount = User::where(
                'role',
                'admin'
            )->count();

            if ($adminCount <= 1) {
                return back()->with(
                    'error',
                    'The last administrator account cannot be deleted.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Capture User Information
        |--------------------------------------------------------------------------
        */

        $userId = $user->id;
        $userName = $user->name;
        $userEmail = $user->email;
        $userRole = $user->role;


        /*
        |--------------------------------------------------------------------------
        | Delete User + Activity Log
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $user,
            $userId,
            $userEmail,
            $userRole
        ) {

            /*
            |--------------------------------------------------------------------------
            | Delete User
            |--------------------------------------------------------------------------
            */

            $user->delete();


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::create([
                'user_id' => auth()->id(),

                'module' => 'User',

                'action' => 'Deleted',

                'description' =>
                    'Admin deleted user #' .
                    $userId .
                    ' (' .
                    $userEmail .
                    ') with role "' .
                    $userRole .
                    '".',

                'ip_address' => request()->ip(),

                'browser' => request()->userAgent(),
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User "' .
                $userName .
                '" deleted successfully.'
            );
    }


    /**
     * User creation is disabled for administrators.
     */
    public function create(): View
    {
        abort(404);
    }


    /**
     * User creation is disabled for administrators.
     */
    public function store(Request $request): RedirectResponse
    {
        abort(404);
    }
}