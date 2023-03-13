<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class PickupController extends Controller
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

        $pickups = Pickup::latest('id');

        if ($keywords) {
            $keywords = '%'.$keywords.'%';
            $pickups = $pickups->where('pickup_name', 'like', $keywords)
                        ->orWhere('pickup_phone', 'like', $keywords)
                        ->orWhere('pickup_address', 'like', $keywords)
                        ->paginate($per_page);
            return view('admin.collection.pickup.index', compact('pickups'));
        }
        $pickups = $pickups->paginate($per_page);
        return view('admin.collection.pickup.index', compact('pickups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.collection.pickup.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'pickup_name' => 'required',
                'pickup_phone' => 'required|regex:/(01)[0-9]/|numeric|digits:11',
                'pickup_address' => 'required',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $pickup = new Pickup;
            $pickup->pickup_name = $request->pickup_name;
            $pickup->pickup_phone = $request->pickup_phone;
            $pickup->pickup_address = $request->pickup_address;
            $pickup->save(); 

            toast('Store successfully','success');
            Toastr::success('Store successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.pickup.index');
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pickup $pickup)
    {
        return view('admin.collection.pickup.edit', compact('pickup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pickup $pickup)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make($request->all(), [
                'pickup_name' => 'required',
                'pickup_phone' => 'required|regex:/(01)[0-9]/|numeric|digits:11',
                'pickup_address' => 'required',
            ]);
            if($validate->fails()){
              return back()->withErrors($validate->errors())->withInput();
            }

            $pickup->pickup_name = $request->pickup_name;
            $pickup->pickup_phone = $request->pickup_phone;
            $pickup->pickup_address = $request->pickup_address;
            $pickup->save(); 

            toast('Updated successfully','success');
            Toastr::success('Updated successfully', '', ["positionClass" => "toast-top-center"]);

            DB::commit();
            return redirect()->route('admin.pickup.index');
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pickup $pickup)
    {
        DB::beginTransaction();
        try {
            $pickup->delete(); 

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
