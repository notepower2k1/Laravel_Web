<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\loginHistory;
use Carbon\Carbon;

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
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function authenticated(){

        if(Auth::user()->role == '1'){
            return redirect('admin/dashboard')->with('status','Welcome to Admin Dashboard');
        }
        else if(Auth::user()->role == '0')
        {
            return redirect('/')->with('status','Login sucessfully!!!');

        }
        else{
            return redirect('/');
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
     
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {

            if(Auth::user()->status == 0){
                Auth::logout();
                return redirect('login')->with('fail', 'Tài khoản của bạn đã bị khóa');
            }

            else{
                loginHistory::create([
                    'userID' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);
                $this->authenticated();
            }
          
        }
    
        return redirect('login')->with('fail', 'Tài khoản hoặc mật khẩu sai!!!');
    }
}
