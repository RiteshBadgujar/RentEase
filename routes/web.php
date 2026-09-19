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
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminEnquiryController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminActivityLogController;
use App\Http\Controllers\Admin\AdminSettingController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| Public Property Browsing
|--------------------------------------------------------------------------
|
| Guests and authenticated users can:
|
| - View property listing
| - View property details
|
*/

Route::get('/properties', [PropertyController::class, 'index'])
    ->name('properties.index');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
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
    |
    | Landlord:
    | - View own properties
    | - Add property
    | - Edit property
    | - Delete property
    |
    */

    Route::get('/my-properties', [PropertyController::class, 'myProperties'])
        ->name('properties.my');

    Route::get('/properties/create', [PropertyController::class, 'create'])
        ->name('properties.create');

    Route::post('/properties', [PropertyController::class, 'store'])
        ->name('properties.store');

    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])
        ->name('properties.edit');

    Route::match(
        ['put', 'patch'],
        '/properties/{property}',
        [PropertyController::class, 'update']
    )->name('properties.update');

    Route::delete(
        '/properties/{property}',
        [PropertyController::class, 'destroy']
    )->name('properties.destroy');


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
    |
    | Tenant:
    | - Send enquiry
    | - View sent enquiries
    |
    | Landlord:
    | - View received enquiries
    | - Change enquiry status
    | - Delete enquiry
    |
    | The controller decides which view to display based
    | on the authenticated user's role.
    |
    */

    Route::get('/enquiries', [EnquiryController::class, 'index'])
        ->name('enquiries.index');

    Route::post(
        '/properties/{property}/enquiry',
        [EnquiryController::class, 'store']
    )->name('enquiries.store');

    Route::patch(
        '/enquiries/{enquiry}',
        [EnquiryController::class, 'update']
    )->name('enquiries.update');

    Route::delete(
        '/enquiries/{enquiry}',
        [EnquiryController::class, 'destroy']
    )->name('enquiries.destroy');


    /*
    |--------------------------------------------------------------------------
    | Booking System
    |--------------------------------------------------------------------------
    |
    | Tenant:
    | - Request property visit
    |
    | Landlord:
    | - View bookings
    | - Approve / reject / complete bookings
    |
    */

    Route::get('/bookings', [BookingController::class, 'index'])
        ->name('bookings.index');

    Route::post(
        '/properties/{property}/booking',
        [BookingController::class, 'store']
    )->name('bookings.store');

    Route::get(
        '/bookings/{booking}',
        [BookingController::class, 'show']
    )->name('bookings.show');

    Route::patch(
        '/bookings/{booking}',
        [BookingController::class, 'update']
    )->name('bookings.update');

    Route::delete(
        '/bookings/{booking}',
        [BookingController::class, 'destroy']
    )->name('bookings.destroy');


    /*
    |--------------------------------------------------------------------------
    | Tenant Booking History
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/my-bookings',
        [TenantBookingController::class, 'index']
    )->name('tenant.bookings.index');

    Route::get(
        '/my-bookings/{booking}',
        [TenantBookingController::class, 'show']
    )->name('tenant.bookings.show');

    Route::delete(
        '/my-bookings/{booking}',
        [TenantBookingController::class, 'destroy']
    )->name('tenant.bookings.destroy');


    /*
    |--------------------------------------------------------------------------
    | Notification System
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/notifications',
        [NotificationController::class, 'index']
    )->name('notifications.index');

    Route::get(
        '/notifications/{notification}',
        [NotificationController::class, 'show']
    )->name('notifications.show');

    Route::patch(
        '/notifications/{notification}',
        [NotificationController::class, 'update']
    )->name('notifications.update');

    Route::delete(
        '/notifications/{notification}',
        [NotificationController::class, 'destroy']
    )->name('notifications.destroy');


    /*
    |--------------------------------------------------------------------------
    | User Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Property Details
|--------------------------------------------------------------------------
|
| This route is intentionally placed AFTER:
|
| /properties/create
| /properties/{property}/edit
|
| so "create" and "edit" are not treated as property parameters.
|
*/

Route::get(
    '/properties/{property}',
    [PropertyController::class, 'show']
)->name('properties.show');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Every route below requires:
|
| 1. Authentication
| 2. Admin role
|
*/

Route::middleware([
    'auth',
    'admin',
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/',
            [AdminController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | User Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'users',
            AdminUserController::class
        )->except([
            'create',
            'store',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Property Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'properties',
            AdminPropertyController::class
        )->except([
            'create',
            'store',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Booking Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'bookings',
            AdminBookingController::class
        )->except([
            'create',
            'store',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Enquiry Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'enquiries',
            AdminEnquiryController::class
        )->except([
            'create',
            'store',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Notification Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'notifications',
            AdminNotificationController::class
        )->except([
            'create',
            'store',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reports',
            [AdminReportController::class, 'index']
        )->name('reports.index');


        /*
        |--------------------------------------------------------------------------
        | Activity Logs
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'activity-logs',
            AdminActivityLogController::class
        )->except([
            'create',
            'store',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/settings',
            [AdminSettingController::class, 'index']
        )->name('settings.index');

        Route::put(
            '/settings',
            [AdminSettingController::class, 'update']
        )->name('settings.update');
    });


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';