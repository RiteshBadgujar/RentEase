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
    public function index()
    {
        $notifications = Notification::with('user')
            ->latest()
            ->paginate(10);

        return view(
            'admin.notifications.index',
            compact('notifications')
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
        $request->validate([

            'is_read' => 'required|boolean',

        ]);

        $notification->update([

            'is_read' => $request->is_read,

        ]);

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
        $notification->delete();

        return redirect()
            ->route('admin.notifications.index')
            ->with(
                'success',
                'Notification deleted successfully.'
            );
    }
}