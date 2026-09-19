<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class AdminSettingController extends Controller
{
    /**
     * Display Settings Page.
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Get Existing Settings
        |--------------------------------------------------------------------------
        */

        $setting = Setting::first();

        /*
        |--------------------------------------------------------------------------
        | Create Default Settings
        |--------------------------------------------------------------------------
        */

        if (!$setting) {
            $setting = Setting::create([
                'website_name' => 'RentEase',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.settings.index',
            compact('setting')
        );
    }


    /**
     * Update Settings.
     */
    public function update(
        Request $request
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'website_name' => [
                'required',
                'string',
                'max:255',
            ],

            'contact_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'contact_phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'footer_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'facebook' => [
                'nullable',
                'url',
                'max:500',
            ],

            'instagram' => [
                'nullable',
                'url',
                'max:500',
            ],

            'linkedin' => [
                'nullable',
                'url',
                'max:500',
            ],

            'twitter' => [
                'nullable',
                'url',
                'max:500',
            ],

            /*
            |--------------------------------------------------------------------------
            | Logo
            |--------------------------------------------------------------------------
            |
            | SVG is intentionally not allowed.
            |
            */

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | Favicon
            |--------------------------------------------------------------------------
            */

            'favicon' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,ico',
                'max:1024',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Settings
        |--------------------------------------------------------------------------
        */

        $setting = Setting::firstOrCreate(
            [
                'id' => 1,
            ],
            [
                'website_name' => 'RentEase',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Store Old File Paths
        |--------------------------------------------------------------------------
        */

        $oldLogo = $setting->logo;
        $oldFavicon = $setting->favicon;

        $newLogo = null;
        $newFavicon = null;


        /*
        |--------------------------------------------------------------------------
        | Upload + Database Update
        |--------------------------------------------------------------------------
        */

        try {

            /*
            |--------------------------------------------------------------------------
            | Upload New Logo
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('logo')) {

                $newLogo = $request
                    ->file('logo')
                    ->store('settings', 'public');
            }


            /*
            |--------------------------------------------------------------------------
            | Upload New Favicon
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('favicon')) {

                $newFavicon = $request
                    ->file('favicon')
                    ->store('settings', 'public');
            }


            /*
            |--------------------------------------------------------------------------
            | Update Settings + Activity Log
            |--------------------------------------------------------------------------
            */

            DB::transaction(function () use (
                $setting,
                $validated,
                $newLogo,
                $newFavicon
            ) {

                /*
                |--------------------------------------------------------------------------
                | Basic Settings
                |--------------------------------------------------------------------------
                */

                $setting->website_name =
                    $validated['website_name'];

                $setting->contact_email =
                    $validated['contact_email'] ?? null;

                $setting->contact_phone =
                    $validated['contact_phone'] ?? null;

                $setting->address =
                    $validated['address'] ?? null;

                $setting->footer_text =
                    $validated['footer_text'] ?? null;

                $setting->facebook =
                    $validated['facebook'] ?? null;

                $setting->instagram =
                    $validated['instagram'] ?? null;

                $setting->linkedin =
                    $validated['linkedin'] ?? null;

                $setting->twitter =
                    $validated['twitter'] ?? null;


                /*
                |--------------------------------------------------------------------------
                | New Logo
                |--------------------------------------------------------------------------
                */

                if ($newLogo !== null) {
                    $setting->logo = $newLogo;
                }


                /*
                |--------------------------------------------------------------------------
                | New Favicon
                |--------------------------------------------------------------------------
                */

                if ($newFavicon !== null) {
                    $setting->favicon = $newFavicon;
                }


                /*
                |--------------------------------------------------------------------------
                | Save
                |--------------------------------------------------------------------------
                */

                $setting->save();


                /*
                |--------------------------------------------------------------------------
                | Activity Log
                |--------------------------------------------------------------------------
                */

                ActivityLog::create([
                    'user_id' => auth()->id(),

                    'module' => 'Settings',

                    'action' => 'Updated',

                    'description' =>
                        'Admin updated RentEase system settings.',

                    'ip_address' => request()->ip(),

                    'browser' => request()->userAgent(),
                ]);
            });

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Database Update Failed
            |--------------------------------------------------------------------------
            |
            | Only clean up files that were uploaded during this request.
            |
            */

            if (
                $newLogo !== null &&
                Storage::disk('public')->exists($newLogo)
            ) {
                Storage::disk('public')->delete($newLogo);
            }

            if (
                $newFavicon !== null &&
                Storage::disk('public')->exists($newFavicon)
            ) {
                Storage::disk('public')->delete($newFavicon);
            }


            /*
            |--------------------------------------------------------------------------
            | Return Error
            |--------------------------------------------------------------------------
            */

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Settings could not be updated. Please try again.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Old Logo
        |--------------------------------------------------------------------------
        |
        | This happens AFTER the database transaction succeeds.
        | Failure here must NOT delete the new file or roll back
        | the database update.
        |
        */

        if (
            $newLogo !== null &&
            !empty($oldLogo) &&
            $oldLogo !== $newLogo &&
            Storage::disk('public')->exists($oldLogo)
        ) {
            try {
                Storage::disk('public')->delete($oldLogo);
            } catch (Throwable $e) {
                report($e);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Old Favicon
        |--------------------------------------------------------------------------
        */

        if (
            $newFavicon !== null &&
            !empty($oldFavicon) &&
            $oldFavicon !== $newFavicon &&
            Storage::disk('public')->exists($oldFavicon)
        ) {
            try {
                Storage::disk('public')->delete($oldFavicon);
            } catch (Throwable $e) {
                report($e);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.settings.index')
            ->with(
                'success',
                'Settings updated successfully.'
            );
    }
}