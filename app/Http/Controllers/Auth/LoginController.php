<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    // admin login
    public function adminLogin()
    {
        return view('auth.admin_login');
    }


    //login reuse
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            if (auth()->user()->is_admin == 1) {
                toast('You are logged in as a admin!','success');
                Toastr::success('You are logged in as a admin', '', ["positionClass" => "toast-top-center"]);
                return redirect()->route('admin.home');
            }else{
                return redirect()->route('home');
            }
        } else{
            Toastr::error('Email-Address And Password Are Wrong!', '', ["positionClass" => "toast-top-center"]);
            toast('Email-Address And Password Are Wrong!','error');
            return redirect()->back()->with('error','Email-Address And Password Are Wrong.');
        }
    }
}
