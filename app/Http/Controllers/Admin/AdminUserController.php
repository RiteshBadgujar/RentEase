<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | User Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalAdmins = User::where('role', 'admin')
            ->count();

        $totalLandlords = User::where('role', 'landlord')
            ->count();

        $totalTenants = User::where('role', 'tenant')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Property Statistics
        |--------------------------------------------------------------------------
        */

        $totalProperties = Property::count();

        $availableProperties = Property::where(
            'status',
            'Available'
        )->count();

        $rentedProperties = Property::where(
            'status',
            'Rented'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Booking Statistics
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

        $completedBookings = Booking::where(
            'status',
            'Completed'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Enquiry Statistics
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

        /*
        |--------------------------------------------------------------------------
        | Notification Statistics
        |--------------------------------------------------------------------------
        */

        $totalNotifications = Notification::count();

        $unreadNotifications = Notification::where(
            'is_read',
            false
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Recent Users
        |--------------------------------------------------------------------------
        */

        $recentUsers = User::select(
                'id',
                'name',
                'email',
                'role',
                'created_at'
            )
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Properties
        |--------------------------------------------------------------------------
        */

        $recentProperties = Property::with('user')
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Bookings
        |--------------------------------------------------------------------------
        */

        $recentBookings = Booking::with([
                'tenant:id,name',
                'property:id,title'
            ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return Dashboard View
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact(

            'totalUsers',

            'totalAdmins',

            'totalLandlords',

            'totalTenants',

            'totalProperties',

            'availableProperties',

            'rentedProperties',

            'totalBookings',

            'pendingBookings',

            'approvedBookings',

            'completedBookings',

            'totalEnquiries',

            'pendingEnquiries',

            'repliedEnquiries',

            'totalNotifications',

            'unreadNotifications',

            'recentUsers',

            'recentProperties',

            'recentBookings'

        ));
    }
        /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],

            'role' => 'required|in:admin,landlord,tenant',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        $user->update([

            'name' => $request->name,

            'email' => $request->email,

            'role' => $request->role,

        ]);

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
    public function destroy(User $user)
    {
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
        | Delete User
        |--------------------------------------------------------------------------
        */

        $user->delete();

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User deleted successfully.'
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
}