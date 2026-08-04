<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // User must be logged in
        if (!auth()->check()) {

            return redirect()
                ->route('login');

        }

        // User must be an admin
        if (!auth()->user()->isAdmin()) {

            return redirect()
                ->route('home')
                ->with(
                    'error',
                    'You are not authorized to access the Admin Panel.'
                );

        }

        return $next($request);
    }
}