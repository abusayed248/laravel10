<?php

namespace App\Http\Controllers\Admin;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
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

        $warehouses = Warehouse::latest('id');

        if ($keywords) {
            $keywords = '%'.$keywords.'%';
            $warehouses = $warehouses->where('warehouse_name', 'like', $keywords)
                        ->where('warehouse_address', 'like', $keywords)
                        ->where('warehouse_phone', 'like', $keywords)
                        ->paginate($per_page);
            return view('admin.collection.warehouse.index', compact('warehouses'));
        }
        $warehouses = $warehouses->paginate($per_page);
        return view('admin.collection.warehouse.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.collection.warehouse.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'warehouse_name' => 'required',
                'warehouse_phone' => 'required|unique:warehouses|regex:/(01)[0-9]/|numeric|digits:11',
                'warehouse_address' => 'required',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $warehouse = new Warehouse;
            $warehouse->warehouse_name = $request->warehouse_name;
            $warehouse->warehouse_phone = $request->warehouse_phone;
            $warehouse->warehouse_address = $request->warehouse_address;
            $warehouse->save(); 

            toast('Store successfully','success');
            Toastr::success('Store successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.warehouse.index');
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        return view('admin.collection.warehouse.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'warehouse_name' => 'required',
                'warehouse_phone' => 'required|regex:/(01)[0-9]/|numeric|digits:11',
                'warehouse_address' => 'required',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $warehouse->warehouse_name = $request->warehouse_name;
            $warehouse->warehouse_phone = $request->warehouse_phone;
            $warehouse->warehouse_address = $request->warehouse_address;
            $warehouse->save(); 

            toast('Updated successfully','success');
            Toastr::success('Updated successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.warehouse.index');
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        DB::beginTransaction();
        try {
            $warehouse->delete(); 

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
