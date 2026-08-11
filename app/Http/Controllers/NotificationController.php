<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the logged-in user.
     */
    public function index(): View
    {
        $notifications = Notification::where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }


    /**
     * Notifications are created automatically.
     */
    public function create(): RedirectResponse
    {
        return redirect()->back();
    }


    /**
     * Manual notification creation is disabled.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->back();
    }


    /**
     * Display a notification and mark it as read.
     */
    public function show(
        Notification $notification
    ): View {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorizeNotification($notification);


        /*
        |--------------------------------------------------------------------------
        | Mark As Read
        |--------------------------------------------------------------------------
        */

        $notification->markAsRead();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'notifications.show',
            compact('notification')
        );
    }


    /**
     * Notifications do not have an edit form.
     */
    public function edit(
        Notification $notification
    ): RedirectResponse {

        $this->authorizeNotification($notification);

        return redirect()->back();
    }


    /**
     * Mark notification as read.
     */
    public function update(
        Request $request,
        Notification $notification
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorizeNotification($notification);


        /*
        |--------------------------------------------------------------------------
        | Mark As Read
        |--------------------------------------------------------------------------
        */

        $notification->markAsRead();


        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Notification marked as read.'
        );
    }


    /**
     * Delete notification.
     */
    public function destroy(
        Notification $notification
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorizeNotification($notification);


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        $notification->delete();


        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('notifications.index')
            ->with(
                'success',
                'Notification deleted successfully.'
            );
    }


    /**
     * Ensure the notification belongs to the logged-in user.
     */
    private function authorizeNotification(
        Notification $notification
    ): void {

        if (
            $notification->user_id !== auth()->id()
        ) {
            abort(
                403,
                'Unauthorized Access.'
            );
        }
    }
}