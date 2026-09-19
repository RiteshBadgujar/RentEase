<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            // Default values for guests
            $navbarNotifications = collect();
            $navbarUnreadCount = 0;

            // Load notifications only for authenticated users
            if (auth()->check()) {

                $userId = auth()->id();

                $navbarNotifications = Notification::query()
                    ->where('user_id', $userId)
                    ->latest()
                    ->take(5)
                    ->get();

                $navbarUnreadCount = Notification::query()
                    ->where('user_id', $userId)
                    ->unread()
                    ->count();
            }

            $view->with([
                'navbarNotifications' => $navbarNotifications,
                'navbarUnreadCount' => $navbarUnreadCount,
            ]);
        });
    }
}