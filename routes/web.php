<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TenantBookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPropertyController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Property Management
    |--------------------------------------------------------------------------
    */

    Route::resource('properties', PropertyController::class);

    /*
    |--------------------------------------------------------------------------
    | Wishlist
    |--------------------------------------------------------------------------
    */

    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');

    Route::post('/wishlist/{property}', [WishlistController::class, 'store'])
        ->name('wishlist.store');

    Route::delete('/wishlist/{property}', [WishlistController::class, 'destroy'])
        ->name('wishlist.destroy');

    /*
    |--------------------------------------------------------------------------
    | Enquiry System
    |--------------------------------------------------------------------------
    */

    Route::get('/enquiries', [EnquiryController::class, 'index'])
        ->name('enquiries.index');

    Route::post('/properties/{property}/enquiry', [EnquiryController::class, 'store'])
        ->name('enquiries.store');

    Route::delete('/enquiries/{enquiry}', [EnquiryController::class, 'destroy'])
        ->name('enquiries.destroy');

    /*
    |--------------------------------------------------------------------------
    | Booking System
    |--------------------------------------------------------------------------
    */

    Route::get('/bookings', [BookingController::class, 'index'])
        ->name('bookings.index');

    Route::post('/properties/{property}/booking', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->name('bookings.show');

    Route::patch('/bookings/{booking}', [BookingController::class, 'update'])
        ->name('bookings.update');

    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])
        ->name('bookings.destroy');

    /*
    |--------------------------------------------------------------------------
    | Tenant Booking History
    |--------------------------------------------------------------------------
    */

    Route::get('/my-bookings', [TenantBookingController::class, 'index'])
        ->name('tenant.bookings.index');

    Route::get('/my-bookings/{booking}', [TenantBookingController::class, 'show'])
        ->name('tenant.bookings.show');

    Route::delete('/my-bookings/{booking}', [TenantBookingController::class, 'destroy'])
        ->name('tenant.bookings.destroy');

    /*
    |--------------------------------------------------------------------------
    | Notification System
    |--------------------------------------------------------------------------
    */

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])
        ->name('notifications.show');

    Route::patch('/notifications/{notification}', [NotificationController::class, 'update'])
        ->name('notifications.update');

    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');

    /*
    |--------------------------------------------------------------------------
    | User Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'admin',
])->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/', [AdminController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | User Management
        |--------------------------------------------------------------------------
        */

        Route::resource('users', AdminUserController::class)
            ->except([
                'create',
                'store'
            ]);

        /*
        |--------------------------------------------------------------------------
        | Property Management
        |--------------------------------------------------------------------------
        */

        Route::resource('properties', AdminPropertyController::class)
            ->except([
                'create',
                'store'
            ]);

    });

require __DIR__ . '/auth.php';