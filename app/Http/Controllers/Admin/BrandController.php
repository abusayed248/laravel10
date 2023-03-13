<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use File;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keywords = $request->keyword;
        $per_page = $request->per_page?:10;

        $brands = Brand::latest('id');

        if ($keywords) {
            $keywords = '%'.$keywords.'%';
            $brands = $brands->where('brand_name', 'like', $keywords)->paginate($per_page);
            return view('admin.brand.index', compact('brands'));
        }
        $brands = $brands->paginate($per_page);
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'brand_name' => 'required|unique:brands|max:25',
                'brand_logo' => 'required|image',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $brand = new Brand;
            $brand->brand_name = $request->brand_name;
            $brand->brand_slug = Str::slug($request->brand_name, '-');
            $brand->status = $request->status;

            $logo = $request->file('brand_logo');
            $slug = Str::slug($request->brand_name, '-');
            if($logo){

                //Storage::delete('/public/avatars/'.$user->avatar);
                $extension = $logo->getClientOriginalExtension();
                $fileNameToStore = $slug.'_'.time().'.'.$extension; // Filename to store
                $logo->storeAs('public/brands',$fileNameToStore); // Upload Image

                $brand->brand_logo = asset('brands/'.$fileNameToStore) ;
                $brand->save(); 
            }
            $brand->save(); 

            toast('Store successfully','success');
            Toastr::success('Store successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.brand.index');
            
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'brand_name' => 'required|max:25',
                'brand_logo' => 'nullable|image',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $brand->brand_name = $request->brand_name;
            $brand->brand_slug = Str::slug($request->brand_name, '-');
            $brand->status = $request->status;

            $logo = $request->file('brand_logo');
            $slug = Str::slug($request->brand_name, '-');
            if($logo){
                if ($request->old_logo) {
                    Storage::disk('public')->delete($request->old_logo);
                }
                
                $extension = $logo->getClientOriginalExtension();
                $fileNameToStore = $slug.'_'.time().'.'.$extension; // Filename to store
                $logo->storeAs('public/brands',$fileNameToStore); // Upload Image

                $brand->brand_logo = asset('brands/'.$fileNameToStore) ;
                $brand->save(); 
            }
            $brand->save(); 

            toast('Updated successfully','success');
            Toastr::success('Updated successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.brand.index');
            
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        DB::beginTransaction();
        try {
            if ($brand->brand_logo) {
                Storage::disk('public')->delete($brand->brand_logo);
            }

            $brand->delete();
            toast('Deleted successfully','success');
            Toastr::success('Deleted successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->back();
            
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    //active brand
    public function active($id)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::where('id', $id)->first();
            $brand->status = 1;
            $brand->save();
            toast('Brand activate successfully','success');
            Toastr::success('Brand activate', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->back();
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    //inactive brand
    public function inActive($id)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::where('id', $id)->first();
            $brand->status = 0;
            $brand->save();
            toast('Brand Inactivate successfully','success');
            Toastr::success('Brand activate', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->back();
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
