<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hotel_name'    => 'required|string|max:255',
            'hotel_email'   => 'required|email',
            'hotel_phone'   => 'required|string|max:20',
            'hotel_address' => 'required|string',
            'hotel_logo'    => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'tax_rate'      => 'required|numeric|min:0|max:100',
            'check_in_time' => 'required|string',
            'check_out_time'=> 'required|string',
        ]);

        $keys = ['hotel_name','hotel_email','hotel_phone','hotel_address',
                 'hotel_tagline','tax_rate','check_in_time','check_out_time',
                 'facebook_url','instagram_url','twitter_url',
                 'google_maps_url','hotel_description'];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        if ($request->hasFile('hotel_logo')) {
            $old = Setting::get('hotel_logo');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('hotel_logo')->store('settings', 'public');
            Setting::set('hotel_logo', $path);
        }

        return back()->with('success', 'Settings saved successfully!');
    }
}
