<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $settings=Setting::first();
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('admin.settings.settings',compact('categories','settings'));
    }

    public function term_condition()
    {
        $term_condition=request('term_condition');
        Setting::where('deleted_at',NULL)->update(['term_condition'=>$term_condition]);
        return back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'banner' => 'image|mimes:jpeg,png,jpg',
            'email' => 'required|email',
        ]);

        $settings = Setting::first();

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $bannerPath = $banner->store('certificate');
            $settings->certificate = $bannerPath;
        }

        $settings->email = $request->input('email');
        $settings->save();

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
