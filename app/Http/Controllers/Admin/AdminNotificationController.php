<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminNotificationController extends Controller
{
    /**
     * Display all notifications.
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Notification Query
        |--------------------------------------------------------------------------
        */

        $query = Notification::with('user');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->input('search');

            $query->where(function ($q) use ($search) {

                $q->whereHas('user', function ($user) use ($search) {

                    $user->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'email',
                        'like',
                        '%' . $search . '%'
                    );

                })
                ->orWhere(
                    'title',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'message',
                    'like',
                    '%' . $search . '%'
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Read / Unread Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('is_read')) {

            $request->validate([
                'is_read' => [
                    'required',
                    'in:0,1',
                ],
            ]);

            $query->where(
                'is_read',
                (int) $request->input('is_read')
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
     * Notification creation is disabled for administrators.
     */
    public function create(): View
    {
        abort(404);
    }

    /**
     * Notification creation is disabled for administrators.
     */
    public function store(Request $request): RedirectResponse
    {
        abort(404);
    }

    /**
     * Display notification details.
     */
    public function show(Notification $notification): View
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
    public function edit(Notification $notification): View
    {
        return view(
            'admin.notifications.edit',
            compact('notification')
        );
    }

    /**
     * Update notification read status.
     */
    public function update(
        Request $request,
        Notification $notification
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'is_read' => [
                'required',
                'boolean',
            ],
        ]);

        $oldStatus = $notification->is_read;
        $newStatus = (bool) $validated['is_read'];

        /*
        |--------------------------------------------------------------------------
        | No Change
        |--------------------------------------------------------------------------
        */

        if ($oldStatus === $newStatus) {

            return redirect()
                ->route('admin.notifications.index')
                ->with(
                    'success',
                    'Notification status is already ' .
                    ($newStatus ? 'Read.' : 'Unread.')
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Update + Activity Log
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $notification,
            $oldStatus,
            $newStatus
        ) {

            /*
            |--------------------------------------------------------------------------
            | Update Notification
            |--------------------------------------------------------------------------
            */

            $notification->update([
                'is_read' => $newStatus,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::create([
                'user_id' => auth()->id(),

                'module' => 'Notification',

                'action' => 'Updated',

                'description' =>
                    'Admin changed notification #' .
                    $notification->id .
                    ' status from ' .
                    ($oldStatus ? 'Read' : 'Unread') .
                    ' to ' .
                    ($newStatus ? 'Read' : 'Unread') .
                    '.',

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
            ->route('admin.notifications.index')
            ->with(
                'success',
                'Notification updated successfully.'
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
        | Store Information Before Delete
        |--------------------------------------------------------------------------
        */

        $notificationId = $notification->id;

        $notificationTitle = $notification->title;

        /*
        |--------------------------------------------------------------------------
        | Delete + Activity Log
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $notification,
            $notificationId,
            $notificationTitle
        ) {

            /*
            |--------------------------------------------------------------------------
            | Delete Notification
            |--------------------------------------------------------------------------
            */

            $notification->delete();

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityLog::create([
                'user_id' => auth()->id(),

                'module' => 'Notification',

                'action' => 'Deleted',

                'description' =>
                    'Admin deleted notification #' .
                    $notificationId .
                    ' "' .
                    $notificationTitle .
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
            ->route('admin.notifications.index')
            ->with(
                'success',
                'Notification deleted successfully.'
            );
    }
}