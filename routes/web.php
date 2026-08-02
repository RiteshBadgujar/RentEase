<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\EnquiryController;

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

require __DIR__.'/auth.php';