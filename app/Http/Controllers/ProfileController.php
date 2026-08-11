<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(
        ProfileUpdateRequest $request
    ): RedirectResponse {

        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Update User Information
        |--------------------------------------------------------------------------
        */

        $user->fill(
            $request->validated()
        );


        /*
        |--------------------------------------------------------------------------
        | Reset Email Verification
        |--------------------------------------------------------------------------
        |
        | If the email address changes, the user must verify
        | the new email address again.
        |
        */

        if ($user->isDirty('email')) {

            $user->email_verified_at = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Save User
        |--------------------------------------------------------------------------
        */

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return Redirect::route(
            'profile.edit'
        )->with(
            'status',
            'profile-updated'
        );
    }


    /**
     * Delete the user's account.
     */
    public function destroy(
        Request $request
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validate Current Password
        |--------------------------------------------------------------------------
        */

        $request->validateWithBag(
            'userDeletion',
            [
                'password' => [
                    'required',
                    'current_password',
                ],
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Get Authenticated User
        |--------------------------------------------------------------------------
        */

        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */

        Auth::logout();


        /*
        |--------------------------------------------------------------------------
        | Delete User
        |--------------------------------------------------------------------------
        |
        | Related records configured with cascadeOnDelete()
        | will also be removed by the database.
        |
        */

        $user->delete();


        /*
        |--------------------------------------------------------------------------
        | Invalidate Session
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return Redirect::to('/');
    }
}