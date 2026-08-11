<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminActivityLogController extends Controller
{
    /**
     * Display all activity logs.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Activity Log Query
        |--------------------------------------------------------------------------
        */

        $query = ActivityLog::with('user')->latest();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('module', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($user) use ($search) {

                        $user->where('name', 'like', "%{$search}%");

                    });

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalLogs = ActivityLog::count();

        $todayLogs = ActivityLog::whereDate(
            'created_at',
            today()
        )->count();

        $activeUsers = ActivityLog::distinct('user_id')
            ->count('user_id');

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $activityLogs = $query
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.activity-logs.index',
            compact(
                'activityLogs',
                'totalLogs',
                'todayLogs',
                'activeUsers'
            )
        );
    }

    /**
     * Display activity details.
     */
    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');

        return view(
            'admin.activity-logs.show',
            compact('activityLog')
        );
    }

    /**
     * Delete activity log.
     */
    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return redirect()
            ->route('admin.activity-logs.index')
            ->with(
                'success',
                'Activity log deleted successfully.'
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
     * Not Used.
     */
    public function edit(ActivityLog $activityLog)
    {
        abort(404);
    }

    /**
     * Not Used.
     */
    public function update(Request $request, ActivityLog $activityLog)
    {
        abort(404);
    }
}