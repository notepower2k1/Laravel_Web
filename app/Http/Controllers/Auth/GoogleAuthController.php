<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    protected $redirectTo = '/';

    public function redirectTo()
    {
        return Session::get('backUrl') ? Session::get('backUrl') :   $this->redirectTo;
    }

    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function caLLBackGoogle(){
        try{

            $google_user = Socialite::driver('google')->user();

            $user = User::where('email','=',$google_user->getEmail())->first();

            if(!$user){
                return redirect('/login')->with('fail', "Email của bạn chưa được đăng ký");
            }
            else{
                
                if($user->email_verified_at == null){
                    $user->email_verified_at = Carbon::now()->toDateTimeString();
                    $user ->save();  
                }
                Auth::login($user);

                if(Auth::user()->role == '1'){
                    return redirect('/admin/dashboard');
                }
                else if(Auth::user()->role == '0')
                {  
                    return redirect (Session::get('backUrl') ? Session::get('backUrl') : $this->redirectTo);
                }
                else{
                    return redirect (Session::get('backUrl') ? Session::get('backUrl') : $this->redirectTo);
        
                }
            }
        }

        catch(\Throwable $th){
            dd("Something wrong! ". $th->getMessage());
        }
    }
}
