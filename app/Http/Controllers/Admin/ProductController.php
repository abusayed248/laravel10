<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Pickup;
use App\Models\Product;
use App\Models\Category;
use App\Models\Childcat;
use App\Models\Warehouse;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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

        $products = Product::with('category', 'subcat', 'childcat', 'brand')->latest('id');

        if ($keywords) {
            $keywords = '%'.$keywords.'%';
            $products = $products->where('p_name', 'like', $keywords)
                        ->where('p_code', 'like', $keywords)
                        ->where('regular_price', 'like', $keywords)
                        ->orWhere('stock_qty', 'like', $keywords)
                        ->orWhere('date_time', 'like', $keywords)
                        ->paginate($per_page);
            return view('admin.product.index', compact('products'));
        }
        $products = $products->paginate($per_page);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands     = Brand::all();
        $warehouses = Warehouse::all();
        $pickups    = Pickup::all();
        return view('admin.product.create', compact('categories','brands','warehouses','pickups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'p_name' => 'required',
                'p_code' => 'required',
                'warehouse_id' => 'required',
                'pickup_id' => 'required',
                'unit' => 'required',
                'size' => 'required',
                'tags' => 'nullable',
                'purchage_price' => 'required|numeric',
                'regular_price' => 'required|numeric',
                'discount_price' => 'nullable|numeric',
                'colors' => 'required',
                'description' => 'required',
                'stock_qty' => 'required|numeric',
                'thumbnail' => 'required|image',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $subcat = Subcategory::where('id', $request->subcat_id)->first();

            $product = new Product;
            $product->p_name = $request->p_name;
            $product->p_slug = Str::slug($request->p_name, '-');
            $product->p_code = $request->p_code;
            $product->cat_id = $subcat->cat_id;
            $product->admin_id = Auth::id();
            $product->subcat_id      = $request->subcat_id;
            $product->childcat_id    = $request->childcat_id;
            $product->brand_id       = $request->brand_id;
            $product->warehouse_id   = $request->warehouse_id;
            $product->pickup_id      = $request->pickup_id;
            $product->unit           = $request->unit;
            $product->purchage_price = $request->purchage_price;
            $product->regular_price  = $request->regular_price;
            $product->discount_price = $request->discount_price;
            $product->video          = $request->video;
            $product->stock_qty      = $request->stock_qty;
            $product->description    = $request->description;
            $product->slider         = $request->slider?:0;
            $product->featured       = $request->featured?:0;
            $product->today_deal     = $request->today_deal?:0;
            $product->trendy         = $request->trendy?:0;
            $product->status         = $request->status?:0;
            $product->date_time      = date('Y-m-d H:i:s');

            foreach ($request->colors as $color) {
                $product->colors = $color;
            }

            foreach ($request->size as $size) {
                $product->size = $size;
            }

            foreach ($request->tags as $tag) {
                $product->tags = $tag;
            }

            $logo = $request->file('thumbnail');
            $slug = Str::slug($request->p_name, '-');
            if($logo){
                $extension = $logo->getClientOriginalExtension();
                $fileNameToStore = $slug.'_'.time().'.'.$extension; // Filename to store
                $logo->storeAs('public/products/thumbnail',$fileNameToStore); // Upload Image

                $product->thumbnail = asset('products/thumbnail/'.$fileNameToStore);
            }

            //multiple images
            $images = array();
            if($request->hasFile('images')){
               foreach ($request->file('images') as $key => $image) {
                   $imageName= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                   $image->storeAs('public/products/images',$imageName); 
                   array_push($images, $imageName);
               }
               $product->images = json_encode($images);
            }

            $product->save(); 

            toast('Store successfully','success');
            Toastr::success('Store successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.product.index');
            
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function getChildcat($id)
    {
        $data = Childcat::where('subcat_id', $id)->get();
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $childcats = Childcat::where('subcat_id', $product->subcat_id)->get();
        $brands     = Brand::all();
        $warehouses = Warehouse::all();
        $pickups    = Pickup::all();
        return view('admin.product.edit', compact('product','categories','childcats','brands','warehouses','pickups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
         DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'p_name' => 'required',
                'p_code' => 'required',
                'warehouse_id' => 'required',
                'pickup_id' => 'required',
                'unit' => 'required',
                'size' => 'required',
                'tags' => 'nullable',
                'purchage_price' => 'required|numeric',
                'regular_price' => 'required|numeric',
                'discount_price' => 'nullable|numeric',
                'colors' => 'required',
                'description' => 'required',
                'stock_qty' => 'required|numeric',
                'thumbnail' => 'nullable|image',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $subcat = Subcategory::where('id', $request->subcat_id)->first();

            $product->p_name = $request->p_name;
            $product->p_slug = Str::slug($request->p_name, '-');
            $product->p_code = $request->p_code;
            $product->cat_id = $subcat->cat_id;
            $product->admin_id = Auth::id();
            $product->subcat_id      = $request->subcat_id;
            $product->childcat_id    = $request->childcat_id;
            $product->brand_id       = $request->brand_id;
            $product->warehouse_id   = $request->warehouse_id;
            $product->pickup_id      = $request->pickup_id;
            $product->unit           = $request->unit;
            $product->purchage_price = $request->purchage_price;
            $product->regular_price  = $request->regular_price;
            $product->discount_price = $request->discount_price;
            $product->video          = $request->video;
            $product->stock_qty      = $request->stock_qty;
            $product->description    = $request->description;
            $product->slider         = $request->slider?:0;
            $product->featured       = $request->featured?:0;
            $product->today_deal     = $request->today_deal?:0;
            $product->trendy         = $request->trendy?:0;
            $product->status         = $request->status?:0;
            $product->date_time      = date('Y-m-d H:i:s');

            foreach ($request->colors as $color) {
                $product->colors = $color;
            }

            foreach ($request->size as $size) {
                $product->size = $size;
            }

            foreach ($request->tags as $tag) {
                $product->tags = $tag;
            }

            $logo = $request->file('thumbnail');
            $slug = Str::slug($request->p_name, '-');
            if($logo){
                if ($request->old_thumbnail) {
                    Storage::disk('public')->delete($request->old_thumbnail);
                }
                $extension = $logo->getClientOriginalExtension();
                $fileNameToStore = $slug.'_'.time().'.'.$extension; // Filename to store
                $logo->storeAs('public/products/thumbnail',$fileNameToStore); // Upload Image

                $product->thumbnail = asset('products/thumbnail/'.$fileNameToStore);
            }

            //__multiple image update__//
            $old_images = $request->has('old_images');
            if($old_images){
                $images = $request->old_images;
                $product->images = json_encode($images);
            }else{
                $images = array();
                $product->images = json_encode($images); 
            }

            if($request->hasFile('images')){
                foreach ($request->file('images') as $key => $image) {
                   $imageName= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                   $image->storeAs('public/products/images',$imageName); 
                   array_push($images, $imageName);
               }
               $product->images = json_encode($images);
            }

            $product->save(); 

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            if($product->thumbnail){
                Storage::disk('public')->delete($product->thumbnail);
            }

            if ($product->images) {
                $images = json_decode($product->images, true);
                foreach($images as $image){
                   $image_path = '/products/images/'.$image;
                   Storage::disk('public')->delete($image_path);
                }
            }
            
            $product->delete();
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


    // status active
    public function statusActive(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->status = 1;
            $product->save();
            toast('Slider now Active','success');
            Toastr::success('Slider now Active', '', ["positionClass" => "toast-top-center"]);
            DB::commit();
            return redirect()->back();
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // status inActive
    public function statusInactive(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->status = 0;
            $product->save();
            toast('Slider now Inactive','success');
            Toastr::success('Slider now Inactive', '', ["positionClass" => "toast-top-center"]);
            DB::commit();
            return redirect()->back();
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
