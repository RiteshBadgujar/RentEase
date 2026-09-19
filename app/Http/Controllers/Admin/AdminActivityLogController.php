<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminActivityLogController extends Controller
{
    /**
     * Display all activity logs.
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Activity Log Query
        |--------------------------------------------------------------------------
        */

        $query = ActivityLog::with('user')
            ->latest();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->input('search')
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'module',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'action',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'description',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhereHas('user', function ($user) use ($search) {

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

        $activeUsers = ActivityLog::whereNotNull(
            'user_id'
        )
        ->distinct()
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
     * Display activity log details.
     */
    public function show(
        ActivityLog $activityLog
    ): View {

        $activityLog->load('user');

        return view(
            'admin.activity-logs.show',
            compact('activityLog')
        );
    }

    /**
     * Delete activity log.
     *
     * Activity log deletion is intentionally not logged
     * to avoid creating a circular logging operation.
     */
    public function destroy(
        ActivityLog $activityLog
    ): RedirectResponse {

        $activityLog->delete();

        return redirect()
            ->route('admin.activity-logs.index')
            ->with(
                'success',
                'Activity log deleted successfully.'
            );
    }

    /**
     * Activity log creation is disabled.
     */
    public function create(): View
    {
        abort(404);
    }

    /**
     * Activity log creation is disabled.
     */
    public function store(Request $request): RedirectResponse
    {
        abort(404);
    }

    /**
     * Activity log editing is disabled.
     */
    public function edit(
        ActivityLog $activityLog
    ): View {

        abort(404);
    }

    /**
     * Activity log updating is disabled.
     */
    public function update(
        Request $request,
        ActivityLog $activityLog
    ): RedirectResponse {

        abort(404);
    }
}