<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
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

        $subcategories = Subcategory::with('category')->latest('id');

        if ($keywords) {
            $keywords = '%'.$keywords.'%';
            $subcategories = $subcategories->where('subcat_name', 'like', $keywords)->paginate($per_page);
            return view('admin.subcat.index', compact('subcategories'));
        }
        $subcategories = $subcategories->paginate($per_page);
        return view('admin.subcat.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcat.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'cat_id' => 'required',
                'subcat_name' => 'required|max:55',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            Subcategory::create([
                'cat_id' => $request->cat_id,
                'subcat_name' => $request->subcat_name,
                'subcat_slug' => Str::slug($request->subcat_name, '-'),
            ]);
            toast('Store successfully','success');
            Toastr::success('Store successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.subcategory.index');
            
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcat.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'cat_id' => 'required',
                'subcat_name' => 'required|max:55',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $subcategory->update([
                'cat_id' => $request->cat_id,
                'subcat_name' => $request->subcat_name,
                'subcat_slug' => Str::slug($request->subcat_name, '-'),
            ]);
            toast('Updated successfully','success');
            Toastr::success('Updated successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.subcategory.index');
            
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        DB::beginTransaction();
        try {

            $subcategory->delete();
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
}
