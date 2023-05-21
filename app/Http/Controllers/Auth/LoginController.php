<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\loginHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

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
    protected $redirectTo = '/';

    public function redirectTo()
    {
        return Session::get('backUrl') ? Session::get('backUrl') :   $this->redirectTo;
    }

    public function authenticated(){

        if(Auth::user()->role == '1'){
            return redirect('admin/dashboard');
        }
        else if(Auth::user()->role == '0')
        {  
            return redirect (Session::get('backUrl') ? Session::get('backUrl') : $this->redirectTo);
        }
        else{
            return redirect (Session::get('backUrl') ? Session::get('backUrl') : $this->redirectTo);

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
        Session::put('backUrl', URL::previous());

    }


    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ],[
            'name.required' => 'Không thể để trống tên tài khoản',
            'password.required' => 'Không thê trống mật khẩu'
        ]);
     
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {

            if(Auth::user()->status == 0){
                Auth::logout();
                return redirect('login')->with('fail', 'Tài khoản của bạn đã bị khóa. Liên hệ quản trị viên để biết thêm chi tiết');
            }

            loginHistory::create([
                'userID' => Auth::user()->id,
                'created_at' => Carbon::now()
            ]);
            
            if(Auth::user()->role == '1'){
                return redirect('admin/dashboard');
            }
            else if(Auth::user()->role == '0')
            {  
                return redirect (Session::get('backUrl') ? Session::get('backUrl') : $this->redirectTo);
            }
            else{
                return redirect (Session::get('backUrl') ? Session::get('backUrl') : $this->redirectTo);
    
            }
        }
    
        return redirect('login')->with('fail', 'Tài khoản hoặc mật khẩu sai!!!');
    }
}
