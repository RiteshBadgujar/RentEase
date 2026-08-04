<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the logged-in user.
     */
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    /**
     * Redirect create request.
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store notification.
     * (Notifications are created automatically by the system.)
     */
    public function store(Request $request)
    {
        return redirect()->back();
    }

    /**
     * Display a notification and mark it as read.
     */
    public function show(Notification $notification)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if ($notification->user_id != auth()->id()) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | Mark Notification as Read
        |--------------------------------------------------------------------------
        */

        if (!$notification->is_read) {

            $notification->markAsRead();

        }

        return view(
            'notifications.show',
            compact('notification')
        );
    }

    /**
     * Redirect edit request.
     */
    public function edit(Notification $notification)
    {
        return redirect()->back();
    }

    /**
     * Mark notification as read.
     */
    public function update(Request $request, Notification $notification)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if ($notification->user_id != auth()->id()) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | Mark Notification as Read
        |--------------------------------------------------------------------------
        */

        if (!$notification->is_read) {

            $notification->markAsRead();

        }

        return back()->with(

            'success',

            'Notification marked as read.'

        );
    }

    /**
     * Delete notification.
     */
    public function destroy(Notification $notification)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        if ($notification->user_id != auth()->id()) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | Delete Notification
        |--------------------------------------------------------------------------
        */

        $notification->delete();

        return back()->with(

            'success',

            'Notification deleted successfully.'

        );
    }
}