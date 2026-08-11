<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    /**
     * Display Settings Page.
     */
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {

            $setting = Setting::create([

                'website_name' => 'RentEase',

            ]);

        }

        return view(
            'admin.settings.index',
            compact('setting')
        );
    }

    /**
     * Update Settings.
     */
    public function update(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'website_name' => 'required|string|max:255',

            'contact_email' => 'nullable|email',

            'contact_phone' => 'nullable|string|max:20',

            'address' => 'nullable|string',

            'footer_text' => 'nullable|string|max:255',

            'facebook' => 'nullable|url',

            'instagram' => 'nullable|url',

            'linkedin' => 'nullable|url',

            'twitter' => 'nullable|url',

            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',

            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,ico|max:1024',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Get Settings
        |--------------------------------------------------------------------------
        */

        $setting = Setting::firstOrCreate([

            'id' => 1

        ], [

            'website_name' => 'RentEase'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Logo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {

            if (!empty($setting->logo)) {

                Storage::disk('public')->delete($setting->logo);

            }

            $setting->logo = $request
                ->file('logo')
                ->store('settings', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Favicon
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('favicon')) {

            if (!empty($setting->favicon)) {

                Storage::disk('public')->delete($setting->favicon);

            }

            $setting->favicon = $request
                ->file('favicon')
                ->store('settings', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update Fields
        |--------------------------------------------------------------------------
        */

        $setting->website_name = $request->website_name;

        $setting->contact_email = $request->contact_email;

        $setting->contact_phone = $request->contact_phone;

        $setting->address = $request->address;

        $setting->footer_text = $request->footer_text;

        $setting->facebook = $request->facebook;

        $setting->instagram = $request->instagram;

        $setting->linkedin = $request->linkedin;

        $setting->twitter = $request->twitter;

        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        $setting->save();

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