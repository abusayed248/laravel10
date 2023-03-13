<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Childcat;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class ChildcatController extends Controller
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

        $childcats = Childcat::with('category', 'subcat')->latest('id');

        if ($keywords) {
            $keywords = '%'.$keywords.'%';
            $childcats = $childcats->where('childcat_name', 'like', $keywords)->paginate($per_page);
            return view('admin.childcat.index', compact('childcats'));
        }
        $childcats = $childcats->paginate($per_page);
        return view('admin.childcat.index', compact('childcats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.childcat.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'subcat_id' => 'required',
                'childcat_name' => 'required',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $subcat = Subcategory::where('id', $request->subcat_id)->first();

            Childcat::create([
                'cat_id' => $subcat->cat_id,
                'subcat_id' => $request->subcat_id,
                'childcat_name' => $request->childcat_name,
                'childcat_slug' => Str::slug($request->childcat_name, '-'),
            ]);
            toast('Store successfully','success');
            Toastr::success('Store successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.childcategory.index');
            
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Childcat $childcat)
    {
        $categories = Category::all();
        return view('admin.childcat.edit', compact('categories', 'childcat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Childcat $childcat)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'subcat_id' => 'required',
                'childcat_name' => 'required',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $subcat = Subcategory::where('id', $request->subcat_id)->first();

            $childcat->update([
                'cat_id' => $subcat->cat_id,
                'subcat_id' => $request->subcat_id,
                'childcat_name' => $request->childcat_name,
                'childcat_slug' => Str::slug($request->childcat_name, '-'),
            ]);
            toast('Updated successfully','success');
            Toastr::success('Updated successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.childcategory.index');
            
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Childcat $childcat)
    {
        DB::beginTransaction();
        try {

            $childcat->delete();
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
