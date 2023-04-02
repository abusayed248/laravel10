<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()  
    {
        $setting = Setting::first();
        return view('admin.setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'currency' => 'required|max:1',
                'logo' => 'nullable|image',
                'favicon' => 'nullable|image',
                'phone_one' => 'required|regex:/(01)[0-9]/|numeric|digits:11',
                'phone_two' => 'required|regex:/(01)[0-9]/|numeric|digits:11',
                'main_email' => 'required|email',
                'support_email' => 'required|email',
                'address' => 'required',
                'facebook' => 'required|url',
                'twitter' => 'required|url',
                'linkedin' => 'required|url',
                'instagram' => 'required|url',
                'youtube' => 'required|url',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $setting->currency      = $request->currency;
            $setting->main_email    = $request->main_email;
            $setting->support_email = $request->support_email;
            $setting->phone_one     = $request->phone_one;
            $setting->phone_two     = $request->phone_two;
            $setting->address       = $request->address;
            $setting->facebook      = $request->facebook;
            $setting->twitter       = $request->twitter;
            $setting->instagram     = $request->instagram;
            $setting->linkedin      = $request->linkedin;
            $setting->youtube       = $request->youtube;

            $logo = $request->file('logo');
            $slug = Str::slug('Dp website main logo', '-');

            $favicon = $request->file('favicon');
            $favicon_slug = Str::slug('Dp website favicon', '-');

            if($logo){
                if ($request->old_logo) {
                    Storage::disk('public')->delete($request->old_logo);
                }
                
                $extension = $logo->getClientOriginalExtension();
                $fileNameToStore = $slug.'.'.$extension; // Filename to store
                $logo->storeAs('public/setting',$fileNameToStore); // Upload Image

                $setting->logo = asset('setting/'.$fileNameToStore);
                $setting->save(); 
            }

            if($favicon){
                if ($request->old_favicon) {
                    Storage::disk('public')->delete($request->old_favicon);
                }
                
                $extension = $favicon->getClientOriginalExtension();
                $fileNameToStore = $favicon_slug.'.'.$extension; // Filename to store
                $favicon->storeAs('public/setting',$fileNameToStore); // Upload Image

                $setting->favicon = asset('setting/'.$fileNameToStore);
                $setting->save(); 
            }
            $setting->save(); 

            toast('Updated successfully','success');
            Toastr::success('Updated successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->back();

        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
