<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    /**
     * Display all notifications.
     */
    public function index(Request $request)
    {
        $query = Notification::with('user');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");

            })

            ->orWhere('title', 'like', "%{$search}%")

            ->orWhere('message', 'like', "%{$search}%");

        }

        /*
        |--------------------------------------------------------------------------
        | Read Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('is_read')) {

            $query->where(
                'is_read',
                $request->is_read
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        $notifications = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalNotifications = Notification::count();

        $readNotifications = Notification::where(
            'is_read',
            true
        )->count();

        $unreadNotifications = Notification::where(
            'is_read',
            false
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.notifications.index',
            compact(
                'notifications',
                'totalNotifications',
                'readNotifications',
                'unreadNotifications'
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
     * Display notification details.
     */
    public function show(Notification $notification)
    {
        $notification->load('user');

        return view(
            'admin.notifications.show',
            compact('notification')
        );
    }

    /**
     * Show edit form.
     */
    public function edit(Notification $notification)
    {
        return view(
            'admin.notifications.edit',
            compact('notification')
        );
    }

    /**
     * Update notification.
     */
    public function update(Request $request, Notification $notification)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'is_read' => 'required|boolean',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $notification->update([

            'is_read' => $request->is_read,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.notifications.index')
            ->with(
                'success',
                'Notification updated successfully.'
            );
    }

    /**
     * Delete notification.
     */
    public function destroy(Notification $notification)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        $notification->delete();

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.notifications.index')
            ->with(
                'success',
                'Notification deleted successfully.'
            );
    }
}